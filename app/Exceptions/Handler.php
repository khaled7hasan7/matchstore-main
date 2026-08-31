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
                'التطبيق يعمل، لكنه لا يستطيع الوصول إلى قاعدة البيانات.',
                [
                    'تأكد من ضبط <code>DB_PASSWORD</code> في متغيّرات بيئة المشروع لبيئة Production.',
                    'بقيّة بيانات الاتصال مضبوطة في المستودع — عدّلها في <code>bootstrap/deployment-env.php</code> إن تغيّرت.',
                    'أعد النشر بعد أي تعديل على المتغيّرات.',
                ],
                '<strong>Database unreachable.</strong> Set <code>DB_PASSWORD</code> in the project\'s '
                .'environment variables for Production, then redeploy. The remaining connection '
                .'details live in <code>bootstrap/deployment-env.php</code>.',
                'المحرّك المستخدم حالياً: <code>'.e((string) config('database.default')).'</code>'
                .' — التشخيص: '.$this->connectionFailureReason($e)
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

        $sqlState = $this->sqlState($e);

        // Class 08: connection exceptions. 28xxx: authentication rejected.
        // 3D000: the named database does not exist.
        if (str_starts_with($sqlState, '08') || str_starts_with($sqlState, '28') || $sqlState === '3D000') {
            return true;
        }

        // MySQL reports these as HY000 with the driver code in the message.
        return (bool) preg_match(
            '/Connection refused|could not connect|could not translate host name|Connection timed out|'
            .'No such file or directory|server closed the connection|could not find driver|'
            .'\b(2002|2003|2005|2006)\b/i',
            $e->getMessage()
        );
    }

    /**
     * A human-readable category for the failure. Deliberately derived from the
     * driver's own signals so it never echoes a host, user or password back to
     * the visitor.
     */
    protected function connectionFailureReason(Throwable $e): string
    {
        $sqlState = $this->sqlState($e);
        $message = $e->getMessage();

        $matches = static fn (string $needle): bool => stripos($message, $needle) !== false;

        if ($matches('could not find driver')) {
            return 'امتداد قاعدة البيانات غير متوفر في بيئة التشغيل.';
        }

        if (str_starts_with($sqlState, '28') || $matches('password authentication failed') || $matches('Access denied')) {
            return 'رُفضت بيانات الدخول — راجع <code>DB_PASSWORD</code> (بلا ترميز) و<code>DB_USERNAME</code>.';
        }

        if ($sqlState === '3D000' || $matches('does not exist')) {
            return 'قاعدة البيانات المذكورة غير موجودة — راجع <code>DB_DATABASE</code>.';
        }

        if ($matches('could not translate host name') || $matches('Name or service not known') || $matches('getaddrinfo')) {
            return 'تعذّر العثور على الخادم — راجع <code>DB_HOST</code>.';
        }

        if ($matches('timed out') || $matches('timeout')) {
            return 'انتهت مهلة الاتصال — تحقق من <code>DB_HOST</code> و<code>DB_PORT</code> (استخدم Session Pooler على 5432).';
        }

        if ($matches('no password supplied')) {
            return 'لم تُرسَل كلمة مرور — أضف <code>DB_PASSWORD</code> في متغيّرات البيئة.';
        }

        return 'رُفض الاتصال بالخادم — راجع <code>DB_HOST</code> و<code>DB_PORT</code>.';
    }

    /**
     * The SQLSTATE for a database error. PDO's pgsql driver puts its own
     * numeric code in getCode() and only spells the SQLSTATE out in the
     * message, so read the message first.
     */
    protected function sqlState(Throwable $e): string
    {
        if (preg_match('/SQLSTATE\[([0-9A-Za-z]{5})\]/', $e->getMessage(), $matches) === 1) {
            return $matches[1];
        }

        return (string) $e->getCode();
    }
}
