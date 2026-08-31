<?php

namespace Tests\Feature;

use App\Filesystem\SupabaseStorageAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

/**
 * Uploads have nowhere to go on the read-only serverless host, so this disk
 * is what makes the admin panel able to accept a product photograph at all.
 */
class SupabaseStorageTest extends TestCase
{
    /** @var array<int,array<string,mixed>> */
    private array $sent = [];

    private function adapter(array $responses): SupabaseStorageAdapter
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->sent));

        return new SupabaseStorageAdapter(
            'falak',
            'service-key',
            'https://project.supabase.co/storage/v1',
            new Client(['handler' => $stack]),
        );
    }

    private function lastRequest(): RequestInterface
    {
        return end($this->sent)['request'];
    }

    public function test_writing_posts_the_file_to_the_bucket(): void
    {
        $adapter = $this->adapter([new Response(200, [], '{"Key":"falak/products/shirt.png"}')]);

        $adapter->write('products/shirt.png', 'binary-content', new Config);

        $request = $this->lastRequest();
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame(
            'https://project.supabase.co/storage/v1/object/falak/products/shirt.png',
            (string) $request->getUri()
        );
        $this->assertSame('binary-content', (string) $request->getBody());
        $this->assertSame('image/png', $request->getHeaderLine('Content-Type'));
        // Without upsert, re-uploading the same key is rejected with a 409.
        $this->assertSame('true', $request->getHeaderLine('x-upsert'));
        $this->assertSame('Bearer service-key', $request->getHeaderLine('Authorization'));
    }

    public function test_it_labels_svg_artwork_correctly(): void
    {
        $adapter = $this->adapter([new Response(200, [], '{}')]);

        $adapter->write('catalog/tshirt-black.svg', '<svg/>', new Config);

        // Served with the wrong type, the browser downloads it instead of drawing it.
        $this->assertSame('image/svg+xml', $this->lastRequest()->getHeaderLine('Content-Type'));
    }

    public function test_paths_with_spaces_and_arabic_are_encoded_per_segment(): void
    {
        $adapter = $this->adapter([new Response(200, [], '{}')]);

        $adapter->write('products/قميص أزرق.png', 'x', new Config);

        $uri = (string) $this->lastRequest()->getUri();
        $this->assertStringContainsString('/object/falak/products/', $uri, 'the slash between segments must survive');
        $this->assertStringNotContainsString(' ', $uri);
        $this->assertStringContainsString('%20', $uri);
    }

    public function test_the_public_url_points_at_the_public_object_route(): void
    {
        $adapter = $this->adapter([]);

        $this->assertSame(
            'https://project.supabase.co/storage/v1/object/public/falak/catalog/bag-black.svg',
            $adapter->publicUrl('catalog/bag-black.svg')
        );
    }

    public function test_missing_files_report_absent_rather_than_throwing(): void
    {
        $adapter = $this->adapter([new Response(404, [], '{"message":"not found"}')]);

        $this->assertFalse($adapter->fileExists('products/gone.png'));
    }

    public function test_existing_files_report_present(): void
    {
        $adapter = $this->adapter([new Response(200)]);

        $this->assertTrue($adapter->fileExists('products/here.png'));
    }

    public function test_the_disk_resolves_and_hands_out_public_urls(): void
    {
        config(['filesystems.disks.supabase' => [
            'driver' => 'supabase',
            'bucket' => 'falak',
            'key' => 'service-key',
            'endpoint' => 'https://project.supabase.co/storage/v1',
        ]]);

        $this->assertSame(
            'https://project.supabase.co/storage/v1/object/public/falak/products/shirt.png',
            Storage::disk('supabase')->url('products/shirt.png')
        );
    }

    public function test_store_image_asks_the_disk_where_an_upload_lives(): void
    {
        config([
            'filesystems.disks.public' => [
                'driver' => 'supabase',
                'bucket' => 'falak',
                'key' => 'service-key',
                'endpoint' => 'https://project.supabase.co/storage/v1',
            ],
        ]);
        Storage::forgetDisk('public');

        $this->assertSame(
            'https://project.supabase.co/storage/v1/object/public/falak/products/shirt.png',
            store_image('products/shirt.png')
        );

        // Absolute URLs and shipped assets must still pass through untouched.
        $this->assertSame('https://cdn.example/x.png', store_image('https://cdn.example/x.png'));
        $this->assertStringEndsWith('/images/catalog/tshirt-black.svg', store_image('/images/catalog/tshirt-black.svg'));
    }
}
