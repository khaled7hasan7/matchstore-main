<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

/**
 * Runs the migrations and seeders from inside the running site.
 *
 * The deployment build is the natural place for this, but it only works if
 * the build image happens to have a PHP binary — and when it does not, the
 * database is simply never updated. The function always has PHP and a proven
 * connection, so this is the path that cannot silently do nothing.
 *
 * Gated on SETUP_TOKEN: without it the route reports 404, so an unconfigured
 * deployment does not advertise that it exists.
 */
class SetupController extends Controller
{
    public function __invoke(): Response
    {
        $expected = (string) env('SETUP_TOKEN', '');

        if ($expected === '' || ! hash_equals($expected, (string) request()->query('token', ''))) {
            abort(404);
        }

        // Seeding is idempotent, but it is still a write: never on a GET that
        // something could prefetch.
        if (! request()->isMethod('post')) {
            return response($this->confirmationForm(), 200)
                ->header('Content-Type', 'text/html; charset=utf-8');
        }

        @set_time_limit(0);

        $options = ['--no-interaction' => true];

        if ($email = env('ADMIN_EMAIL')) {
            $options['--admin'] = $email;

            if ($password = env('ADMIN_PASSWORD')) {
                $options['--password'] = $password;
            }
        }

        $status = Artisan::call('falak:setup', $options);
        $output = Artisan::output();

        // The password is passed in, never generated, but make certain a
        // response can never carry one back.
        if ($password = env('ADMIN_PASSWORD')) {
            $output = str_replace($password, '********', $output);
        }

        return response(
            ($status === 0 ? "OK\n\n" : "FAILED\n\n").$output,
            $status === 0 ? 200 : 500
        )->header('Content-Type', 'text/plain; charset=utf-8');
    }

    private function confirmationForm(): string
    {
        $token = e((string) request()->query('token'));

        return <<<HTML
<!doctype html>
<html lang="ar" dir="rtl"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1"><title>تهيئة المتجر</title>
<style>
body{margin:0;min-height:100vh;display:grid;place-items:center;background:#0b1220;
font-family:system-ui,'Segoe UI',Tahoma,sans-serif;color:#e9f1ff}
.card{background:#12203c;border:1px solid #24365c;border-radius:16px;padding:32px;max-width:520px}
h1{margin:0 0 12px;font-size:22px}p{margin:0 0 20px;line-height:1.8;color:#b9d2f7}
button{background:#1F6FEB;color:#fff;border:0;border-radius:10px;padding:12px 24px;
font-size:15px;font-weight:600;cursor:pointer}
</style></head><body>
<form class="card" method="post">
<h1>تهيئة قاعدة البيانات</h1>
<p>سينفّذ الترحيلات ويزرع بيانات المتجر. الأمر آمن للتكرار ولا يحذف طلباً
أو مراجعة أو أي شيء أنشأه عميل.</p>
<input type="hidden" name="token" value="{$token}">
<button type="submit">نفّذ الآن</button>
</form></body></html>
HTML;
    }
}
