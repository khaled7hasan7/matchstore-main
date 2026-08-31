<?php

namespace Tests\Feature;

use App\Exceptions\Handler;
use PDOException;
use ReflectionMethod;
use RuntimeException;
use Tests\TestCase;

/**
 * A misconfigured deployment must name its own problem. These are the exact
 * driver messages seen while reproducing the Vercel deployment locally.
 */
class DatabaseDiagnosisTest extends TestCase
{
    protected function call_(string $method, \Throwable $e): mixed
    {
        $handler = $this->app->make(Handler::class);
        $reflection = new ReflectionMethod($handler, $method);
        $reflection->setAccessible(true);

        return $reflection->invoke($handler, $e);
    }

    public static function connectionFailures(): array
    {
        return [
            'server refused' => [
                'SQLSTATE[HY000] [2002] Connection refused',
                'رُفض الاتصال',
            ],
            'password rejected' => [
                'SQLSTATE[08006] [7] connection to server at "db", port 5432 failed: FATAL:  password authentication failed for user "postgres"',
                'رُفضت بيانات الدخول',
            ],
            'host not found' => [
                'SQLSTATE[08006] [7] could not translate host name "nope.invalid" to address',
                'تعذّر العثور على الخادم',
            ],
            'database missing' => [
                'SQLSTATE[08006] [7] connection to server failed: FATAL:  database "nope" does not exist',
                'غير موجودة',
            ],
            'driver missing' => [
                'could not find driver',
                'امتداد قاعدة البيانات',
            ],
        ];
    }

    /** @dataProvider connectionFailures */
    public function test_connection_failures_are_recognised_and_explained(string $message, string $expected): void
    {
        $exception = new PDOException($message);

        $this->assertTrue(
            $this->call_('isDatabaseUnreachable', $exception),
            "Should be treated as a configuration failure: {$message}"
        );

        $this->assertStringContainsString(
            $expected,
            $this->call_('connectionFailureReason', $exception)
        );
    }

    public function test_ordinary_failures_are_left_alone(): void
    {
        // A genuine bug must keep surfacing as a normal error, not as a
        // "check your database settings" page.
        $this->assertFalse($this->call_('isDatabaseUnreachable', new RuntimeException('Something broke')));
        $this->assertFalse($this->call_('isDatabaseUnreachable', new PDOException(
            'SQLSTATE[42P01]: Undefined table: 7 ERROR:  relation "widgets" does not exist'
        )));
    }
}
