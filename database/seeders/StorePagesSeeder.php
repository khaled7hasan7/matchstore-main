<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Database\Seeder;

/**
 * The pages a customer looks for before ordering: who runs the shop, what
 * shipping costs, how to return something, and the questions the shop is
 * asked over and over.
 *
 * Runs after PageSeeder, which supplies the generic privacy and terms pages,
 * and replaces its placeholder "about us" with the shop's own.
 */
class StorePagesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $slug => $translations) {
            $page = Page::updateOrCreate(['slug' => $slug], ['status' => true]);

            foreach ($translations as $language => $content) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_code' => $language],
                    ['title' => $content['title'], 'content' => $content['body']]
                );
            }
        }
    }

    /** @return array<string,array<string,array{title:string,body:string}>> */
    private function pages(): array
    {
        return [
            'about-us' => [
                'ar' => ['title' => 'من نحن', 'body' => <<<'HTML'
<h2>Falak Store</h2>
<p>متجر ملابس عربي يبيع الملابس الرجالية والنسائية وملابس الأطفال، إضافة إلى الأحذية والحقائب والإكسسوارات والأزياء المحتشمة. نبيع داخل الأردن وفلسطين، والأسعار بالدينار الأردني.</p>

<h3>لماذا نحن</h3>
<ul>
    <li><strong>خامات نختارها بأنفسنا:</strong> قطن يتنفّس، صوف لا يسبب حكة، وأقمشة لا تفقد شكلها بعد الغسيل.</li>
    <li><strong>مقاسات واضحة:</strong> كل قطعة معروضة بمقاساتها وألوانها المتوفرة فعلياً — لا تطلب مقاساً غير موجود.</li>
    <li><strong>الدفع عند الاستلام:</strong> تدفع حين تصلك القطعة بين يديك.</li>
    <li><strong>إرجاع خلال 14 يوماً:</strong> إن لم يناسبك المقاس، أعِده.</li>
</ul>

<h3>تواصل معنا</h3>
<p>للاستفسار عن طلب أو مقاس، راسلنا من <a href="/contact">صفحة التواصل</a> ونرد خلال يوم عمل.</p>
HTML],
                'en' => ['title' => 'About Us', 'body' => <<<'HTML'
<h2>Falak Store</h2>
<p>A clothing store for men, women and children, alongside shoes, bags, accessories and modest wear. We deliver across Jordan and Palestine, and price everything in Jordanian dinars.</p>

<h3>Why shop with us</h3>
<ul>
    <li><strong>Fabrics we choose ourselves:</strong> cotton that breathes, wool that does not itch, and cloth that keeps its shape after washing.</li>
    <li><strong>Honest sizing:</strong> every piece lists the sizes and colours actually in stock.</li>
    <li><strong>Cash on delivery:</strong> pay when the parcel is in your hands.</li>
    <li><strong>14-day returns:</strong> if the size is wrong, send it back.</li>
</ul>

<h3>Get in touch</h3>
<p>Questions about an order or a size? Write to us from the <a href="/contact">contact page</a> and we reply within one working day.</p>
HTML],
            ],

            'shipping-policy' => [
                'ar' => ['title' => 'الشحن والتوصيل', 'body' => <<<'HTML'
<h2>الشحن والتوصيل</h2>

<h3>المناطق التي نصل إليها</h3>
<p>نوصل إلى جميع محافظات الأردن وإلى مناطق الضفة الغربية. تُحسب كلفة الشحن تلقائياً حسب المنطقة التي تختارها عند إتمام الطلب، وتظهر لك قبل التأكيد — لا مفاجآت عند الاستلام.</p>

<h3>مدة التوصيل</h3>
<ul>
    <li><strong>عمّان والزرقاء:</strong> من يوم إلى يومي عمل.</li>
    <li><strong>باقي محافظات الأردن:</strong> من يومين إلى ثلاثة أيام عمل.</li>
    <li><strong>فلسطين:</strong> من ثلاثة إلى خمسة أيام عمل، وقد تطول حسب المعابر.</li>
</ul>
<p>المدة المتوقعة لمنطقتك تظهر لك في صفحة الدفع عند اختيارها.</p>

<h3>الدفع</h3>
<p>الدفع عند الاستلام متاح على كل الطلبات. جهّز المبلغ نقداً لمندوب التوصيل.</p>

<h3>تتبّع الطلب</h3>
<p>يصلك بريد تأكيد فور إنشاء الطلب، ثم نتواصل معك هاتفياً قبل التوصيل. يمكنك متابعة حالة طلبك من صفحة <a href="/customer/orders">طلباتي</a> إن كان لديك حساب.</p>
HTML],
                'en' => ['title' => 'Shipping & Delivery', 'body' => <<<'HTML'
<h2>Shipping &amp; Delivery</h2>

<h3>Where we deliver</h3>
<p>We deliver to every governorate in Jordan and to the West Bank. Shipping is calculated from the region you pick at checkout and shown before you confirm — nothing is added on the doorstep.</p>

<h3>Delivery times</h3>
<ul>
    <li><strong>Amman and Zarqa:</strong> 1–2 working days.</li>
    <li><strong>Rest of Jordan:</strong> 2–3 working days.</li>
    <li><strong>Palestine:</strong> 3–5 working days, longer if crossings are slow.</li>
</ul>
<p>The estimate for your region is shown at checkout once you select it.</p>

<h3>Payment</h3>
<p>Cash on delivery is available on every order. Please have the amount ready for the courier.</p>

<h3>Tracking</h3>
<p>You get a confirmation email as soon as the order is placed, and we call before delivery. If you have an account you can follow the order from <a href="/customer/orders">My Orders</a>.</p>
HTML],
            ],

            'returns-policy' => [
                'ar' => ['title' => 'الاستبدال والإرجاع', 'body' => <<<'HTML'
<h2>الاستبدال والإرجاع</h2>

<h3>المدة</h3>
<p>لديك <strong>14 يوماً</strong> من تاريخ الاستلام لإرجاع أي قطعة أو استبدالها بمقاس آخر.</p>

<h3>شروط القبول</h3>
<ul>
    <li>القطعة لم تُستعمل ولم تُغسل، وبطاقتها الأصلية ما زالت مثبّتة.</li>
    <li>مرفقة بفاتورة الطلب أو رقمه.</li>
    <li>بحالتها الأصلية وبتغليفها.</li>
</ul>

<h3>قطع لا تُرجع</h3>
<p>لأسباب صحية لا نستقبل إرجاع <strong>الملابس الداخلية والجوارب</strong> بعد فتح تغليفها.</p>

<h3>كيف تُرجع قطعة</h3>
<ol>
    <li>راسلنا من <a href="/contact">صفحة التواصل</a> مع رقم الطلب وسبب الإرجاع.</li>
    <li>نرتّب مع المندوب موعد استلام القطعة منك.</li>
    <li>بعد فحصها نعيد المبلغ خلال 3 إلى 7 أيام عمل، أو نرسل المقاس البديل.</li>
</ol>

<h3>كلفة الإرجاع</h3>
<p>إن كان الخطأ منّا — قطعة خاطئة أو بها عيب — نتحمّل كلفة الإرجاع كاملة. أما إن كان الإرجاع لتغيير الرأي أو المقاس فتُخصم أجرة التوصيل من المبلغ المُعاد.</p>
HTML],
                'en' => ['title' => 'Returns & Exchanges', 'body' => <<<'HTML'
<h2>Returns &amp; Exchanges</h2>

<h3>How long you have</h3>
<p>You have <strong>14 days</strong> from delivery to return an item or exchange it for another size.</p>

<h3>Condition</h3>
<ul>
    <li>Unworn and unwashed, with the original tag still attached.</li>
    <li>Accompanied by the invoice or the order number.</li>
    <li>In its original packaging.</li>
</ul>

<h3>What we cannot take back</h3>
<p>For hygiene reasons we do not accept returns of <strong>underwear or socks</strong> once the packaging is opened.</p>

<h3>How to return</h3>
<ol>
    <li>Write to us from the <a href="/contact">contact page</a> with your order number and the reason.</li>
    <li>We arrange a pickup with the courier.</li>
    <li>Once checked, we refund within 3–7 working days, or send the replacement size.</li>
</ol>

<h3>Who pays</h3>
<p>If the mistake is ours — wrong item or a fault — we cover the return in full. For a change of mind or size, the delivery fee is deducted from the refund.</p>
HTML],
            ],

            'faq' => [
                'ar' => ['title' => 'الأسئلة الشائعة', 'body' => <<<'HTML'
<h2>الأسئلة الشائعة</h2>

<h3>كيف أعرف مقاسي؟</h3>
<p>كل قطعة معروضة بمقاساتها المتوفرة (S · M · L · XL، وللأحذية 40–43). إن كنت بين مقاسين اختر الأكبر، وإن لم يناسبك استبدله خلال 14 يوماً.</p>

<h3>هل الأسعار شاملة الشحن؟</h3>
<p>لا. السعر المعروض للقطعة فقط، وتُضاف كلفة الشحن حسب منطقتك وتظهر لك قبل تأكيد الطلب.</p>

<h3>كيف أستخدم كود الخصم؟</h3>
<p>أدخل الكود في صفحة السلة قبل الانتقال إلى الدفع، وسيظهر الخصم مباشرة في الإجمالي.</p>

<h3>هل يمكنني الدفع ببطاقة؟</h3>
<p>حالياً الدفع عند الاستلام فقط. سنضيف الدفع الإلكتروني قريباً.</p>

<h3>هل ألوان الصور مطابقة للواقع؟</h3>
<p>نحرص على ذلك، لكن اختلاف شاشات العرض قد يغيّر درجة اللون قليلاً. إن اختلف اللون عمّا توقّعت، الإرجاع متاح خلال 14 يوماً.</p>

<h3>كم يبقى المنتج محجوزاً في السلة؟</h3>
<p>لا تُحجز الكمية إلا عند تأكيد الطلب. القطع المطلوبة كثيراً قد تنفد قبل إتمامك الشراء.</p>

<h3>هل أحتاج حساباً للشراء؟</h3>
<p>لا، يمكنك الطلب كزائر. الحساب يفيدك في متابعة طلباتك وحفظ عناوينك وقائمة أمنياتك.</p>
HTML],
                'en' => ['title' => 'FAQ', 'body' => <<<'HTML'
<h2>Frequently Asked Questions</h2>

<h3>How do I find my size?</h3>
<p>Every item lists the sizes in stock (S · M · L · XL, and 40–43 for shoes). Between two sizes, take the larger one — and if it does not fit, exchange it within 14 days.</p>

<h3>Do prices include shipping?</h3>
<p>No. The listed price is for the item; shipping is added according to your region and shown before you confirm.</p>

<h3>How do I use a discount code?</h3>
<p>Enter it on the cart page before going to checkout. The discount appears in the total straight away.</p>

<h3>Can I pay by card?</h3>
<p>Cash on delivery only for now. Card payment is coming.</p>

<h3>Are the colours accurate?</h3>
<p>We try, but screens differ and a shade can look slightly off. If the colour is not what you expected, returns are open for 14 days.</p>

<h3>Is an item held for me in the cart?</h3>
<p>Stock is only reserved when the order is confirmed. Popular pieces can sell out while an item sits in a cart.</p>

<h3>Do I need an account?</h3>
<p>No, you can order as a guest. An account lets you follow orders, save addresses and keep a wishlist.</p>
HTML],
            ],
        ];
    }
}
