<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IbnTaymiyyahBookstoreSeeder extends Seeder
{
    /**
     * Convert the generic demo store into "مكتبة ابن تيمية" book store.
     */
    public function run(): void
    {
        $shopId = (int) (DB::table('shops')->min('id') ?? 1);
        $vendorId = (int) (DB::table('vendors')->min('id') ?? 1);

        $this->clearStoreContent();
        $this->updateSiteSettings();

        $categories = $this->seedCategories();
        $publishers = $this->seedPublishers();
        $this->seedBooks($shopId, $vendorId, $categories, $publishers);

        // Reset cached site settings so the new name/language/currency take effect.
        \Illuminate\Support\Facades\Cache::forget('site_settings');

        $this->command->info('مكتبة ابن تيمية: تم تجهيز البيانات بنجاح.');
    }

    private function clearStoreContent(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ([
            'product_variant_attribute_values',
            'product_attribute_values',
            'product_images',
            'product_variants',
            'product_translations',
            'product_reviews',
            'wishlists',
            'products',
            'category_translations',
            'categories',
            'brand_translations',
            'brands',
        ] as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->delete();
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function updateSiteSettings(): void
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        $settings->fill([
            'site_name' => 'مكتبة ابن تيمية',
            'tagline' => 'كتب العقيدة والفقه والتفسير والحديث',
            'meta_title' => 'مكتبة ابن تيمية - لبيع الكتب الشرعية',
            'meta_description' => 'مكتبة ابن تيمية لبيع الكتب الشرعية في العقيدة والفقه والزهد والتفسير والمصاحف والحديث والسيرة.',
            'meta_keywords' => 'كتب إسلامية, العقيدة, الفقه, التفسير, الحديث, المصاحف, مكتبة ابن تيمية',
            'contact_email' => 'info@ibntaymiyyah-library.com',
            'footer_text' => '© '.date('Y').' مكتبة ابن تيمية. جميع الحقوق محفوظة.',
            'default_currency' => 'JOD',
            'default_language' => 'ar',
        ]);
        $settings->save();
    }

    /**
     * @return array<string,int> slug => category id
     */
    private function seedCategories(): array
    {
        $languages = Language::where('active', 1)->pluck('code')->toArray();
        $catImage = 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&q=80';

        $categories = [
            ['slug' => 'aqeedah', 'en' => 'Aqeedah (Creed)', 'ar' => 'العقيدة', 'desc_ar' => 'كتب العقيدة والتوحيد'],
            ['slug' => 'fiqh', 'en' => 'Fiqh (Jurisprudence)', 'ar' => 'الفقه', 'desc_ar' => 'كتب الفقه وأحكامه'],
            ['slug' => 'tafsir', 'en' => 'Tafsir', 'ar' => 'التفسير', 'desc_ar' => 'كتب تفسير القرآن الكريم'],
            ['slug' => 'hadith', 'en' => 'Hadith', 'ar' => 'الحديث', 'desc_ar' => 'كتب الحديث الشريف وشروحه'],
            ['slug' => 'zuhd', 'en' => 'Zuhd & Spirituality', 'ar' => 'الزهد والرقائق', 'desc_ar' => 'كتب الزهد والرقائق وتزكية النفس'],
            ['slug' => 'mushaf', 'en' => 'Mushaf (Qurans)', 'ar' => 'المصاحف', 'desc_ar' => 'المصاحف الشريفة بمختلف الروايات والطبعات'],
            ['slug' => 'seerah', 'en' => 'Seerah & History', 'ar' => 'السيرة والتاريخ', 'desc_ar' => 'كتب السيرة النبوية والتاريخ الإسلامي'],
            ['slug' => 'arabic-language', 'en' => 'Arabic Language', 'ar' => 'اللغة العربية', 'desc_ar' => 'كتب النحو والصرف واللغة'],
        ];

        $map = [];
        foreach ($categories as $c) {
            $category = Category::firstOrCreate(
                ['slug' => $c['slug']],
                ['parent_category_id' => null, 'status' => true]
            );
            foreach ($languages as $lang) {
                $category->translations()->updateOrCreate(
                    ['language_code' => $lang],
                    [
                        'name' => $lang === 'ar' ? $c['ar'] : $c['en'],
                        'description' => $lang === 'ar' ? $c['desc_ar'] : $c['en'],
                        'image_url' => $catImage,
                    ]
                );
            }
            $map[$c['slug']] = $category->id;
        }

        return $map;
    }

    /**
     * @return array<string,int> slug => brand id
     */
    private function seedPublishers(): array
    {
        $publishers = [
            ['slug' => 'dar-ibn-aljawzi', 'ar' => 'دار ابن الجوزي', 'en' => 'Dar Ibn Al-Jawzi'],
            ['slug' => 'dar-taybah', 'ar' => 'دار طيبة', 'en' => 'Dar Taybah'],
            ['slug' => 'dar-ibn-katheer', 'ar' => 'دار ابن كثير', 'en' => 'Dar Ibn Katheer'],
            ['slug' => 'mujamma-king-fahd', 'ar' => 'مجمع الملك فهد', 'en' => 'King Fahd Complex'],
            ['slug' => 'dar-alsalam', 'ar' => 'دار السلام', 'en' => 'Dar As-Salam'],
        ];

        $map = [];
        foreach ($publishers as $p) {
            $brand = Brand::firstOrCreate(['slug' => $p['slug']], ['status' => true]);
            foreach (['ar' => $p['ar'], 'en' => $p['en']] as $locale => $name) {
                $brand->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $name, 'description' => $name]
                );
            }
            $map[$p['slug']] = $brand->id;
        }

        return $map;
    }

    private function seedBooks(int $shopId, int $vendorId, array $cat, array $pub): void
    {
        // Cover images (reused) — generic book/Quran imagery.
        $cover = 'https://images.unsplash.com/photo-1601370690183-1c7796ecec61?w=800&q=80';
        $quranCover = 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=800&q=80';

        $books = [
            // العقيدة
            ['cat' => 'aqeedah', 'pub' => 'dar-ibn-aljawzi', 'ar' => 'العقيدة الواسطية', 'en' => 'Al-Aqeedah Al-Wasitiyyah', 'author' => 'شيخ الإسلام ابن تيمية', 'price' => 5.50, 'stock' => 40],
            ['cat' => 'aqeedah', 'pub' => 'dar-taybah', 'ar' => 'كتاب التوحيد', 'en' => 'Kitab At-Tawheed', 'author' => 'محمد بن عبد الوهاب', 'price' => 4.00, 'stock' => 60],
            ['cat' => 'aqeedah', 'pub' => 'dar-ibn-katheer', 'ar' => 'شرح العقيدة الطحاوية', 'en' => 'Sharh Al-Aqeedah At-Tahawiyyah', 'author' => 'ابن أبي العز الحنفي', 'price' => 12.00, 'stock' => 25],

            // الفقه
            ['cat' => 'fiqh', 'pub' => 'dar-ibn-katheer', 'ar' => 'بلوغ المرام من أدلة الأحكام', 'en' => 'Bulugh Al-Maram', 'author' => 'الحافظ ابن حجر العسقلاني', 'price' => 7.50, 'stock' => 35],
            ['cat' => 'fiqh', 'pub' => 'dar-alsalam', 'ar' => 'الفقه الميسر', 'en' => 'Al-Fiqh Al-Muyassar', 'author' => 'نخبة من العلماء', 'price' => 9.00, 'stock' => 30],
            ['cat' => 'fiqh', 'pub' => 'dar-ibn-aljawzi', 'ar' => 'زاد المعاد في هدي خير العباد', 'en' => 'Zad Al-Maad', 'author' => 'ابن قيم الجوزية', 'price' => 18.00, 'stock' => 20],

            // التفسير
            ['cat' => 'tafsir', 'pub' => 'dar-taybah', 'ar' => 'تفسير القرآن العظيم (تفسير ابن كثير)', 'en' => 'Tafsir Ibn Katheer', 'author' => 'الحافظ ابن كثير', 'price' => 35.00, 'stock' => 15],
            ['cat' => 'tafsir', 'pub' => 'dar-ibn-aljawzi', 'ar' => 'تيسير الكريم الرحمن (تفسير السعدي)', 'en' => 'Tafsir As-Saadi', 'author' => 'عبد الرحمن بن ناصر السعدي', 'price' => 14.00, 'stock' => 28],
            ['cat' => 'tafsir', 'pub' => 'dar-alsalam', 'ar' => 'تفسير الجلالين', 'en' => 'Tafsir Al-Jalalayn', 'author' => 'جلال الدين المحلي والسيوطي', 'price' => 6.00, 'stock' => 32],

            // الحديث
            ['cat' => 'hadith', 'pub' => 'dar-taybah', 'ar' => 'صحيح البخاري', 'en' => 'Sahih Al-Bukhari', 'author' => 'الإمام محمد بن إسماعيل البخاري', 'price' => 28.00, 'stock' => 18],
            ['cat' => 'hadith', 'pub' => 'dar-taybah', 'ar' => 'صحيح مسلم', 'en' => 'Sahih Muslim', 'author' => 'الإمام مسلم بن الحجاج', 'price' => 26.00, 'stock' => 18],
            ['cat' => 'hadith', 'pub' => 'dar-ibn-katheer', 'ar' => 'رياض الصالحين', 'en' => 'Riyadh As-Saliheen', 'author' => 'الإمام النووي', 'price' => 8.00, 'stock' => 45],

            // الزهد والرقائق
            ['cat' => 'zuhd', 'pub' => 'dar-ibn-aljawzi', 'ar' => 'مدارج السالكين', 'en' => 'Madarij As-Salikeen', 'author' => 'ابن قيم الجوزية', 'price' => 16.00, 'stock' => 22],
            ['cat' => 'zuhd', 'pub' => 'dar-alsalam', 'ar' => 'الفوائد', 'en' => 'Al-Fawaid', 'author' => 'ابن قيم الجوزية', 'price' => 5.00, 'stock' => 38],
            ['cat' => 'zuhd', 'pub' => 'dar-taybah', 'ar' => 'الزهد', 'en' => 'Az-Zuhd', 'author' => 'الإمام أحمد بن حنبل', 'price' => 10.00, 'stock' => 24],

            // المصاحف
            ['cat' => 'mushaf', 'pub' => 'mujamma-king-fahd', 'ar' => 'مصحف المدينة المنورة (برواية حفص)', 'en' => 'Madinah Mushaf (Hafs)', 'author' => 'مجمع الملك فهد', 'price' => 6.00, 'stock' => 100, 'quran' => true],
            ['cat' => 'mushaf', 'pub' => 'dar-taybah', 'ar' => 'مصحف التجويد الملون', 'en' => 'Color-coded Tajweed Mushaf', 'author' => 'دار طيبة', 'price' => 9.50, 'stock' => 70, 'quran' => true],
            ['cat' => 'mushaf', 'pub' => 'dar-alsalam', 'ar' => 'مصحف الحفّاظ', 'en' => 'Huffaz Mushaf', 'author' => 'دار السلام', 'price' => 7.00, 'stock' => 80, 'quran' => true],

            // السيرة والتاريخ
            ['cat' => 'seerah', 'pub' => 'dar-alsalam', 'ar' => 'الرحيق المختوم', 'en' => 'Ar-Raheeq Al-Makhtum', 'author' => 'صفي الرحمن المباركفوري', 'price' => 11.00, 'stock' => 33],
            ['cat' => 'seerah', 'pub' => 'dar-ibn-katheer', 'ar' => 'البداية والنهاية', 'en' => 'Al-Bidayah wan-Nihayah', 'author' => 'الحافظ ابن كثير', 'price' => 40.00, 'stock' => 12],

            // اللغة العربية
            ['cat' => 'arabic-language', 'pub' => 'dar-ibn-aljawzi', 'ar' => 'متن الآجرومية', 'en' => 'Matn Al-Ajurrumiyyah', 'author' => 'ابن آجروم الصنهاجي', 'price' => 3.00, 'stock' => 55],
            ['cat' => 'arabic-language', 'pub' => 'dar-alsalam', 'ar' => 'شرح ابن عقيل على ألفية ابن مالك', 'en' => 'Sharh Ibn Aqeel', 'author' => 'بهاء الدين ابن عقيل', 'price' => 15.00, 'stock' => 20],
        ];

        $i = 0;
        foreach ($books as $b) {
            $i++;
            $slug = Str::slug($b['en']).'-'.$i;
            $product = Product::create([
                'shop_id' => $shopId,
                'vendor_id' => $vendorId,
                'category_id' => $cat[$b['cat']],
                'brand_id' => $pub[$b['pub']],
                'product_type' => 'physical',
                'status' => 1,
                'slug' => $slug,
            ]);

            // Arabic translation
            ProductTranslation::create([
                'product_id' => $product->id,
                'language_code' => 'ar',
                'name' => $b['ar'],
                'description' => 'كتاب «'.$b['ar'].'» للمؤلف '.$b['author'].'. طبعة دار النشر بجودة عالية وورق فاخر.',
                'short_description' => 'المؤلف: '.$b['author'],
                'tags' => 'كتب إسلامية, '.$b['ar'],
            ]);
            // English translation
            ProductTranslation::create([
                'product_id' => $product->id,
                'language_code' => 'en',
                'name' => $b['en'],
                'description' => '"'.$b['en'].'" by '.$b['author'].'. High quality print edition.',
                'short_description' => 'Author: '.$b['author'],
                'tags' => 'islamic books, '.$b['en'],
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'variant_slug' => $slug.'-'.Str::random(4),
                'price' => $b['price'],
                'discount_price' => null,
                'stock' => $b['stock'],
                'SKU' => 'BK-'.str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'weight' => 0.5,
                'is_primary' => true,
            ]);

            $img = !empty($b['quran']) ? $quranCover : $cover;
            ProductImage::create([
                'product_id' => $product->id,
                'name' => $slug.'-thumb',
                'image_url' => $img,
                'type' => 'thumb',
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'name' => $slug.'-slide',
                'image_url' => $img,
                'type' => 'slide',
            ]);
        }
    }
}
