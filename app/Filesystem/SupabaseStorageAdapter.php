<?php

namespace App\Filesystem;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use League\Flysystem\Config;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToWriteFile;

/**
 * Supabase Storage over its REST API.
 *
 * Written against the REST endpoints rather than the S3-compatible ones so
 * the application needs no AWS SDK: the host runs on a read-only filesystem
 * where uploads must go somewhere else, and that should not cost a dependency
 * the size of the AWS SDK to arrange.
 *
 * @see https://supabase.com/docs/reference/api/storage
 */
class SupabaseStorageAdapter implements FilesystemAdapter
{
    public function __construct(
        private readonly string $bucket,
        private readonly string $key,
        private readonly string $endpoint,
        private readonly ?Client $client = null,
    ) {
    }

    /** Public URL of an object, for a bucket marked public. */
    public function publicUrl(string $path): string
    {
        return $this->endpoint.'/object/public/'.$this->bucket.'/'.$this->encode($path);
    }

    public function fileExists(string $path): bool
    {
        try {
            $response = $this->request('HEAD', $this->objectUrl($path), throw: false);
        } catch (GuzzleException $e) {
            throw UnableToCheckExistence::forLocation($path, $e);
        }

        return $response < 400;
    }

    public function directoryExists(string $path): bool
    {
        // Storage has no directories; a prefix "exists" when something is under it.
        foreach ($this->listContents($path, false) as $ignored) {
            return true;
        }

        return false;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        try {
            // upsert so re-uploading the same key replaces it instead of 409ing
            $this->request('POST', $this->objectUrl($path), [
                'body' => $contents,
                'headers' => [
                    'Content-Type' => $config->get('mimetype') ?: $this->guessMimeType($path),
                    'x-upsert' => 'true',
                ],
            ]);
        } catch (GuzzleException $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->write($path, stream_get_contents($contents), $config);
    }

    public function read(string $path): string
    {
        try {
            return (string) $this->client()->request('GET', $this->objectUrl($path), [
                'headers' => $this->headers(),
            ])->getBody();
        } catch (GuzzleException $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function readStream(string $path)
    {
        $stream = fopen('php://temp', 'w+b');
        fwrite($stream, $this->read($path));
        rewind($stream);

        return $stream;
    }

    public function delete(string $path): void
    {
        try {
            $this->request('DELETE', $this->objectUrl($path), throw: false);
        } catch (GuzzleException $e) {
            throw UnableToDeleteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function deleteDirectory(string $path): void
    {
        foreach ($this->listContents($path, true) as $item) {
            if ($item instanceof FileAttributes) {
                $this->delete($item->path());
            }
        }
    }

    public function createDirectory(string $path, Config $config): void
    {
        // Nothing to do: prefixes come into being with the first object.
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // Visibility is a property of the bucket, not of a single object.
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, visibility: 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes($path, mimeType: $this->metadata($path)['mimetype'] ?? $this->guessMimeType($path));
    }

    public function lastModified(string $path): FileAttributes
    {
        $updated = $this->metadata($path)['updated_at'] ?? null;

        return new FileAttributes($path, lastModified: $updated ? strtotime($updated) : null);
    }

    public function fileSize(string $path): FileAttributes
    {
        $size = $this->metadata($path)['size'] ?? null;

        if ($size === null) {
            throw UnableToRetrieveMetadata::fileSize($path);
        }

        return new FileAttributes($path, fileSize: (int) $size);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        $prefix = trim($path, '/');
        $offset = 0;

        do {
            try {
                $body = (string) $this->client()->request('POST', $this->endpoint.'/object/list/'.$this->bucket, [
                    'headers' => $this->headers() + ['Content-Type' => 'application/json'],
                    'body' => json_encode([
                        'prefix' => $prefix === '' ? '' : $prefix.'/',
                        'limit' => 100,
                        'offset' => $offset,
                    ]),
                ])->getBody();
            } catch (GuzzleException $e) {
                return;
            }

            $items = json_decode($body, true) ?: [];

            foreach ($items as $item) {
                $itemPath = ltrim($prefix.'/'.$item['name'], '/');

                // A row with no id is a folder placeholder, not an object.
                if (($item['id'] ?? null) === null) {
                    yield new DirectoryAttributes($itemPath);

                    if ($deep) {
                        yield from $this->listContents($itemPath, true);
                    }

                    continue;
                }

                yield new FileAttributes(
                    $itemPath,
                    fileSize: $item['metadata']['size'] ?? null,
                    mimeType: $item['metadata']['mimetype'] ?? null,
                );
            }

            $offset += count($items);
        } while (count($items) === 100);
    }

    public function move(string $source, string $destination, Config $config): void
    {
        try {
            $this->request('POST', $this->endpoint.'/object/move', [
                'headers' => $this->headers() + ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'bucketId' => $this->bucket,
                    'sourceKey' => $source,
                    'destinationKey' => $destination,
                ]),
            ]);
        } catch (GuzzleException $e) {
            throw UnableToMoveFile::fromLocationTo($source, $destination, $e);
        }
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $this->request('POST', $this->endpoint.'/object/copy', [
                'headers' => $this->headers() + ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'bucketId' => $this->bucket,
                    'sourceKey' => $source,
                    'destinationKey' => $destination,
                ]),
            ]);
        } catch (GuzzleException $e) {
            throw UnableToCopyFile::fromLocationTo($source, $destination, $e);
        }
    }

    /** @return array<string,mixed> */
    private function metadata(string $path): array
    {
        try {
            $body = (string) $this->client()->request('POST', $this->endpoint.'/object/list/'.$this->bucket, [
                'headers' => $this->headers() + ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'prefix' => trim(dirname($path), '/.'),
                    'search' => basename($path),
                    'limit' => 1,
                ]),
            ])->getBody();
        } catch (GuzzleException $e) {
            return [];
        }

        $item = (json_decode($body, true) ?: [])[0] ?? [];

        return ($item['metadata'] ?? []) + $item;
    }

    /** @param array<string,mixed> $options */
    private function request(string $method, string $url, array $options = [], bool $throw = true): int
    {
        $options['headers'] = ($options['headers'] ?? []) + $this->headers();
        $options['http_errors'] = $throw;

        return $this->client()->request($method, $url, $options)->getStatusCode();
    }

    /** @return array<string,string> */
    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->key,
            'apikey' => $this->key,
        ];
    }

    private function objectUrl(string $path): string
    {
        return $this->endpoint.'/object/'.$this->bucket.'/'.$this->encode($path);
    }

    /** Percent-encode each segment but keep the slashes between them. */
    private function encode(string $path): string
    {
        return implode('/', array_map('rawurlencode', explode('/', trim($path, '/'))));
    }

    private function guessMimeType(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'avif' => 'image/avif',
            'pdf' => 'application/pdf',
            default => 'application/octet-stream',
        };
    }

    private function client(): Client
    {
        return $this->client ?? new Client(['timeout' => 30]);
    }
}
