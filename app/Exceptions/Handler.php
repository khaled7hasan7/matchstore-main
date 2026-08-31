<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use PDOException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // A deployment that cannot reach its database answers every request
        // with an anonymous 500. Say what is actually wrong instead — naming
        // the variables to check, never their values.
        $this->renderable(function (Throwable $e, Request $request) {
            if (config('app.debug') || ! $this->isDatabaseUnreachable($e)) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The application cannot reach its database.',
                ], 503);
            }

            $notice = require base_path('bootstrap/setup-notice.php');

            return response($notice(
                'تعذّر الاتصال بقاعدة البيانات',
                'التطبيق يعمل، لكنه لا يستطيع الوصول إلى قاعدة البيانات. غالباً متغيّرات الاتصال ناقصة أو غير صحيحة.',
                [
                    'تأكد من ضبط <code>DB_CONNECTION</code> (مثلاً <code>pgsql</code>) — إن غاب يحاول التطبيق الاتصال بـ MySQL محلي.',
                    'راجع <code>DB_HOST</code> و<code>DB_PORT</code> و<code>DB_DATABASE</code> و<code>DB_USERNAME</code> و<code>DB_PASSWORD</code>.',
                    'تأكد من تفعيل المتغيّرات لبيئة Production، ثم أعد النشر.',
                ],
                '<strong>Database unreachable.</strong> Check <code>DB_CONNECTION</code> (it falls back to '
                .'MySQL on localhost when unset), plus <code>DB_HOST</code>, <code>DB_PORT</code>, '
                .'<code>DB_DATABASE</code>, <code>DB_USERNAME</code> and <code>DB_PASSWORD</code>. '
                .'Set them for Production, then redeploy.'
            ), 503);
        });
    }

    /**
     * Whether the failure is the database being unreachable (a configuration
     * problem) rather than a bad query (a code problem).
     */
    protected function isDatabaseUnreachable(Throwable $e): bool
    {
        if (! $e instanceof PDOException) {
            return false;
        }

        $sqlState = (string) $e->getCode();

        // Class 08: connection exceptions. 28xxx: authentication rejected.
        // 3D000: the named database does not exist.
        if (str_starts_with($sqlState, '08') || str_starts_with($sqlState, '28') || $sqlState === '3D000') {
            return true;
        }

        // MySQL reports these as HY000 with the driver code in the message.
        return (bool) preg_match(
            '/Connection refused|could not connect|could not translate host name|Connection timed out|'
            .'No such file or directory|server closed the connection|\b(2002|2003|2005|2006)\b/i',
            $e->getMessage()
        );
    }
}
