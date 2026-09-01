# تشغيل المتجر على جهازك

المتجر يعمل محلياً بقاعدة **SQLite** — ملف واحد، بلا خادم قواعد بيانات تُثبّته
أو تشغّله، وبلا أي علاقة بـSupabase أو بالموقع المنشور.

## أمر واحد

```bash
git clone https://github.com/khaled7hasan7/matchstore-main.git
cd matchstore-main
bash scripts/run-local.sh
```

على **Windows** شغّله من **Git Bash** (يأتي مع Git) بالأمر نفسه.

السكربت يتكفّل بكل شيء: يفحص إصدار PHP وامتداداته، ينزّل الاعتماديات، ينشئ
`.env`، يولّد مفتاح التطبيق، ينشئ ملف القاعدة، يبني المتجر، وينشئ حساب المدير.
ثم يطبع:

```
Storefront   http://127.0.0.1:8000
Dashboard    http://127.0.0.1:8000/admin/login
Email        admin@falakstore.local
Password     falak12345
```

لبريد ومرور من اختيارك:

```bash
ADMIN_EMAIL="you@example.com" ADMIN_PASSWORD="your-password" bash scripts/run-local.sh
```

## ما يلزم قبل ذلك

| الأداة | الإصدار | التحقق |
|---|---|---|
| PHP | 8.1+ | `php -v` |
| Composer | أي إصدار | `composer -V` |

وامتدادات PHP: `pdo_sqlite` · `mbstring` · `openssl` · `fileinfo` · `curl`.
السكربت يفحصها ويطبع أمر التثبيت المناسب لنظامك إن نقص شيء.

على Windows تُفعَّل بإزالة الفاصلة المنقوطة من أسطر `extension=` في `php.ini`.

## يدوياً، إن فضّلت

```bash
composer install
cp .env.example .env          # ثم اضبط DB_CONNECTION=sqlite واحذف باقي أسطر DB_
php artisan key:generate
touch database/database.sqlite
php artisan falak:setup --admin="you@example.com"
php artisan serve
```

## أسئلة سريعة

**أريد البدء من الصفر:** احذف `database/database.sqlite` وأعد تشغيل السكربت.

**إعادة التشغيل تحذف بياناتي؟** لا. السيدرز جميعاً idempotent، ولا تُحذف
منتجات أو طلبات أو مراجعات أنشأها أحد.

**رسائل البريد؟** تُكتب في `storage/logs/laravel.log` بدل إرسالها — لا تحتاج
خادم SMTP للتجربة.

**الصور؟** مشحونة مع المستودع في `public/images/catalog`. لا تحتاج إنترنت.
