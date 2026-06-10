<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define demo products with stock images from Unsplash
        $products = [
            // Electronics Category (ID: 1)
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'wireless-bluetooth-headphones',
                'translations' => [
                    'en' => [
                        'name' => 'Wireless Bluetooth Headphones',
                        'description' => 'Premium wireless headphones with active noise cancellation, 30-hour battery life, and crystal-clear sound quality. Perfect for music lovers and professionals.',
                        'short_description' => 'Premium wireless headphones with ANC',
                        'tags' => 'headphones, wireless, bluetooth, audio',
                    ],
                    'ar' => [
                        'name' => 'سماعات رأس بلوتوث لاسلكية',
                        'description' => 'سماعات لاسلكية متميزة مع إلغاء الضوضاء النشط، وعمر بطارية 30 ساعة، وجودة صوت واضحة تمامًا. مثالية لمحبي الموسيقى والمحترفين.',
                        'short_description' => 'سماعات لاسلكية متميزة مع إلغاء الضوضاء',
                        'tags' => 'سماعات، لاسلكي، بلوتوث، صوت',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 299.99,
                        'discount_price' => 249.99,
                        'stock' => 50,
                        'SKU' => 'WBH-001-BLK',
                        'weight' => 0.25,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => '4k-smart-tv-55-inch',
                'translations' => [
                    'en' => [
                        'name' => '55" 4K Ultra HD Smart TV',
                        'description' => 'Experience stunning 4K resolution with HDR support, built-in streaming apps, and voice control. Transform your living room into a home theater.',
                        'short_description' => '55" 4K Smart TV with HDR',
                        'tags' => 'tv, 4k, smart tv, electronics',
                    ],
                    'ar' => [
                        'name' => 'تلفزيون ذكي 55 بوصة بدقة 4K',
                        'description' => 'استمتع بدقة 4K المذهلة مع دعم HDR وتطبيقات البث المدمجة والتحكم الصوتي. حوّل غرفة معيشتك إلى مسرح منزلي.',
                        'short_description' => 'تلفزيون ذكي 55 بوصة بدقة 4K مع HDR',
                        'tags' => 'تلفزيون، 4k، تلفزيون ذكي، إلكترونيات',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 799.99,
                        'discount_price' => 699.99,
                        'stock' => 25,
                        'SKU' => 'TV-55-4K-001',
                        'weight' => 15.5,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'gaming-laptop-rtx-3060',
                'translations' => [
                    'en' => [
                        'name' => 'Gaming Laptop RTX 3060',
                        'description' => 'High-performance gaming laptop with NVIDIA RTX 3060, Intel i7 processor, 16GB RAM, and 512GB SSD. Dominate every game with stunning graphics.',
                        'short_description' => 'Gaming laptop with RTX 3060 graphics',
                        'tags' => 'laptop, gaming, rtx, computer',
                    ],
                    'ar' => [
                        'name' => 'لابتوب ألعاب RTX 3060',
                        'description' => 'لابتوب ألعاب عالي الأداء مع NVIDIA RTX 3060 ومعالج Intel i7 وذاكرة 16 جيجابايت وقرص SSD 512 جيجابايت. سيطر على كل لعبة برسومات مذهلة.',
                        'short_description' => 'لابتوب ألعاب مع بطاقة RTX 3060',
                        'tags' => 'لابتوب، ألعاب، rtx، كمبيوتر',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 1499.99,
                        'discount_price' => 1299.99,
                        'stock' => 15,
                        'SKU' => 'LAP-GAM-RTX3060',
                        'weight' => 2.5,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'mechanical-gaming-keyboard-rgb',
                'translations' => [
                    'en' => [
                        'name' => 'Mechanical Gaming Keyboard RGB',
                        'description' => 'Professional mechanical keyboard with customizable RGB lighting, tactile switches, and programmable keys. Built for gamers and typists who demand precision.',
                        'short_description' => 'RGB mechanical keyboard for gaming',
                        'tags' => 'keyboard, gaming, mechanical, rgb',
                    ],
                    'ar' => [
                        'name' => 'لوحة مفاتيح ألعاب ميكانيكية RGB',
                        'description' => 'لوحة مفاتيح ميكانيكية احترافية مع إضاءة RGB قابلة للتخصيص ومفاتيح لمسية ومفاتيح قابلة للبرمجة. مصممة للاعبين والكتاب الذين يطلبون الدقة.',
                        'short_description' => 'لوحة مفاتيح ميكانيكية RGB للألعاب',
                        'tags' => 'لوحة مفاتيح، ألعاب، ميكانيكية، rgb',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 129.99,
                        'discount_price' => 99.99,
                        'stock' => 40,
                        'SKU' => 'KB-MECH-RGB-001',
                        'weight' => 1.2,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'wireless-gaming-mouse',
                'translations' => [
                    'en' => [
                        'name' => 'Wireless Gaming Mouse',
                        'description' => 'Ultra-responsive wireless gaming mouse with 16000 DPI sensor, customizable buttons, and 80-hour battery life. Zero lag, maximum performance.',
                        'short_description' => 'Wireless gaming mouse 16000 DPI',
                        'tags' => 'mouse, gaming, wireless, accessories',
                    ],
                    'ar' => [
                        'name' => 'ماوس ألعاب لاسلكي',
                        'description' => 'ماوس ألعاب لاسلكي فائق الاستجابة مع مستشعر 16000 DPI وأزرار قابلة للتخصيص وعمر بطارية 80 ساعة. بدون تأخير، أقصى أداء.',
                        'short_description' => 'ماوس ألعاب لاسلكي 16000 DPI',
                        'tags' => 'ماوس، ألعاب، لاسلكي، إكسسوارات',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 89.99,
                        'discount_price' => 69.99,
                        'stock' => 60,
                        'SKU' => 'MOUSE-WL-GAM-001',
                        'weight' => 0.15,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80', 'type' => 'slide'],
                ],
            ],

            // Smartphones Category (ID: 3)
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 3,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'flagship-smartphone-pro-max',
                'translations' => [
                    'en' => [
                        'name' => 'Flagship Smartphone Pro Max',
                        'description' => 'Latest flagship smartphone with 6.7" AMOLED display, triple camera system, 5G connectivity, and all-day battery life. The ultimate smartphone experience.',
                        'short_description' => 'Flagship phone with triple camera',
                        'tags' => 'smartphone, 5g, camera, flagship',
                    ],
                    'ar' => [
                        'name' => 'هاتف ذكي رائد برو ماكس',
                        'description' => 'أحدث هاتف ذكي رائد بشاشة AMOLED 6.7 بوصة ونظام كاميرا ثلاثي واتصال 5G وبطارية تدوم طوال اليوم. تجربة الهاتف الذكي المثالية.',
                        'short_description' => 'هاتف رائد مع كاميرا ثلاثية',
                        'tags' => 'هاتف ذكي، 5g، كاميرا، رائد',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 1199.99,
                        'discount_price' => 1099.99,
                        'stock' => 30,
                        'SKU' => 'PHONE-FLAGSHIP-001',
                        'weight' => 0.22,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 3,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'mid-range-5g-smartphone',
                'translations' => [
                    'en' => [
                        'name' => 'Mid-Range 5G Smartphone',
                        'description' => 'Affordable 5G smartphone with excellent camera, fast processor, and long battery life. Premium features without the premium price.',
                        'short_description' => 'Affordable 5G smartphone',
                        'tags' => 'smartphone, 5g, mid-range, affordable',
                    ],
                    'ar' => [
                        'name' => 'هاتف ذكي 5G متوسط المدى',
                        'description' => 'هاتف ذكي 5G بأسعار معقولة مع كاميرا ممتازة ومعالج سريع وعمر بطارية طويل. ميزات متميزة بدون سعر متميز.',
                        'short_description' => 'هاتف ذكي 5G بأسعار معقولة',
                        'tags' => 'هاتف ذكي، 5g، متوسط المدى، معقول',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 499.99,
                        'discount_price' => 449.99,
                        'stock' => 50,
                        'SKU' => 'PHONE-MID-5G-001',
                        'weight' => 0.19,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1591122947157-26bad3a117d2?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 3,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'budget-smartphone-dual-sim',
                'translations' => [
                    'en' => [
                        'name' => 'Budget Smartphone Dual SIM',
                        'description' => 'Great value smartphone with dual SIM support, HD+ display, and reliable performance for everyday tasks. Perfect for your first smartphone.',
                        'short_description' => 'Budget dual SIM smartphone',
                        'tags' => 'smartphone, budget, dual sim, affordable',
                    ],
                    'ar' => [
                        'name' => 'هاتف ذكي اقتصادي بشريحتين',
                        'description' => 'هاتف ذكي بقيمة رائعة مع دعم شريحتين وشاشة HD+ وأداء موثوق للمهام اليومية. مثالي لهاتفك الذكي الأول.',
                        'short_description' => 'هاتف ذكي اقتصادي بشريحتين',
                        'tags' => 'هاتف ذكي، اقتصادي، شريحتين، معقول',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 199.99,
                        'discount_price' => 179.99,
                        'stock' => 70,
                        'SKU' => 'PHONE-BUDGET-DS-001',
                        'weight' => 0.17,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=800&q=80', 'type' => 'slide'],
                ],
            ],

            // Fashion Category (ID: 2)
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 2,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'mens-leather-jacket-black',
                'translations' => [
                    'en' => [
                        'name' => 'Men\'s Leather Jacket - Black',
                        'description' => 'Classic genuine leather jacket with modern fit. Soft, durable, and stylish. Perfect for any season and occasion.',
                        'short_description' => 'Genuine leather jacket for men',
                        'tags' => 'jacket, leather, mens fashion, outerwear',
                    ],
                    'ar' => [
                        'name' => 'سترة جلدية رجالية - أسود',
                        'description' => 'سترة جلدية أصلية كلاسيكية بقصة عصرية. ناعمة ومتينة وأنيقة. مثالية لأي موسم ومناسبة.',
                        'short_description' => 'سترة جلدية أصلية للرجال',
                        'tags' => 'سترة، جلد، أزياء رجالية، ملابس خارجية',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 349.99,
                        'discount_price' => 279.99,
                        'stock' => 35,
                        'SKU' => 'JACKET-LEAT-MEN-BLK',
                        'weight' => 1.5,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1520975954732-35dd22299614?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 2,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'womens-summer-dress-floral',
                'translations' => [
                    'en' => [
                        'name' => 'Women\'s Summer Dress - Floral',
                        'description' => 'Beautiful floral print summer dress in lightweight, breathable fabric. Comfortable and elegant for warm weather.',
                        'short_description' => 'Floral summer dress for women',
                        'tags' => 'dress, summer, floral, womens fashion',
                    ],
                    'ar' => [
                        'name' => 'فستان صيفي نسائي - زهور',
                        'description' => 'فستان صيفي جميل بطبعة زهور في قماش خفيف الوزن وقابل للتنفس. مريح وأنيق للطقس الدافئ.',
                        'short_description' => 'فستان صيفي بطبعة زهور للنساء',
                        'tags' => 'فستان، صيف، زهور، أزياء نسائية',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 79.99,
                        'discount_price' => 59.99,
                        'stock' => 45,
                        'SKU' => 'DRESS-SUM-WOM-FLR',
                        'weight' => 0.3,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 2,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'mens-slim-fit-jeans-blue',
                'translations' => [
                    'en' => [
                        'name' => 'Men\'s Slim Fit Jeans - Blue',
                        'description' => 'Classic slim fit jeans in premium denim. Comfortable stretch fabric with modern styling. A wardrobe essential.',
                        'short_description' => 'Slim fit denim jeans for men',
                        'tags' => 'jeans, denim, mens fashion, pants',
                    ],
                    'ar' => [
                        'name' => 'جينز رجالي ضيق - أزرق',
                        'description' => 'جينز ضيق كلاسيكي في الدنيم الفاخر. قماش مرن ومريح مع تصميم عصري. ضروري لخزانة الملابس.',
                        'short_description' => 'جينز دنيم ضيق للرجال',
                        'tags' => 'جينز، دنيم، أزياء رجالية، بناطيل',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 89.99,
                        'discount_price' => 69.99,
                        'stock' => 55,
                        'SKU' => 'JEANS-SLIM-MEN-BLU',
                        'weight' => 0.6,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 2,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'womens-designer-handbag',
                'translations' => [
                    'en' => [
                        'name' => 'Women\'s Designer Handbag',
                        'description' => 'Elegant designer handbag in premium leather with gold hardware. Spacious interior with multiple compartments. Luxury meets functionality.',
                        'short_description' => 'Premium designer leather handbag',
                        'tags' => 'handbag, designer, leather, accessories',
                    ],
                    'ar' => [
                        'name' => 'حقيبة يد نسائية من المصمم',
                        'description' => 'حقيبة يد أنيقة من المصمم في الجلد الفاخر مع إكسسوارات ذهبية. داخلية واسعة مع أقسام متعددة. الفخامة تلتقي بالوظيفة.',
                        'short_description' => 'حقيبة يد جلدية فاخرة من المصمم',
                        'tags' => 'حقيبة يد، مصمم، جلد، إكسسوارات',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 449.99,
                        'discount_price' => 379.99,
                        'stock' => 20,
                        'SKU' => 'BAG-DES-WOM-001',
                        'weight' => 0.8,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1564422170194-896b89110ef8?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 2,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'mens-running-sneakers',
                'translations' => [
                    'en' => [
                        'name' => 'Men\'s Running Sneakers',
                        'description' => 'High-performance running shoes with advanced cushioning and breathable mesh upper. Lightweight design for maximum comfort and speed.',
                        'short_description' => 'Performance running shoes',
                        'tags' => 'sneakers, running, athletic, footwear',
                    ],
                    'ar' => [
                        'name' => 'حذاء رياضي رجالي للجري',
                        'description' => 'أحذية جري عالية الأداء مع توسيد متقدم وجزء علوي شبكي قابل للتنفس. تصميم خفيف الوزن لأقصى راحة وسرعة.',
                        'short_description' => 'أحذية جري عالية الأداء',
                        'tags' => 'حذاء رياضي، جري، رياضي، أحذية',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 149.99,
                        'discount_price' => 119.99,
                        'stock' => 40,
                        'SKU' => 'SHOE-RUN-MEN-001',
                        'weight' => 0.5,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&q=80', 'type' => 'slide'],
                ],
            ],

            // T-Shirts Category (ID: 4)
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 4,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'basic-cotton-tshirt-white',
                'translations' => [
                    'en' => [
                        'name' => 'Basic Cotton T-Shirt - White',
                        'description' => 'Essential 100% cotton t-shirt in classic white. Soft, comfortable, and versatile. Perfect for layering or wearing on its own.',
                        'short_description' => '100% cotton basic white tee',
                        'tags' => 't-shirt, cotton, basic, casual',
                    ],
                    'ar' => [
                        'name' => 'تيشرت قطني أساسي - أبيض',
                        'description' => 'تيشرت قطني 100٪ أساسي باللون الأبيض الكلاسيكي. ناعم ومريح ومتعدد الاستخدامات. مثالي للطبقات أو ارتدائه بمفرده.',
                        'short_description' => 'تيشرت أبيض أساسي قطني 100٪',
                        'tags' => 'تيشرت، قطن، أساسي، كاجوال',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 19.99,
                        'discount_price' => 14.99,
                        'stock' => 100,
                        'SKU' => 'TSHIRT-COT-WHT-001',
                        'weight' => 0.2,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 4,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'graphic-print-tshirt-black',
                'translations' => [
                    'en' => [
                        'name' => 'Graphic Print T-Shirt - Black',
                        'description' => 'Stylish graphic print t-shirt with unique design. Made from soft cotton blend. Express yourself with bold graphics.',
                        'short_description' => 'Graphic print cotton blend tee',
                        'tags' => 't-shirt, graphic, print, streetwear',
                    ],
                    'ar' => [
                        'name' => 'تيشرت بطبعة رسومية - أسود',
                        'description' => 'تيشرت أنيق بطبعة رسومية بتصميم فريد. مصنوع من مزيج القطن الناعم. عبر عن نفسك برسومات جريئة.',
                        'short_description' => 'تيشرت بطبعة رسومية من مزيج القطن',
                        'tags' => 'تيشرت، رسومي، طباعة، ستريت وير',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 29.99,
                        'discount_price' => 24.99,
                        'stock' => 75,
                        'SKU' => 'TSHIRT-GRA-BLK-001',
                        'weight' => 0.22,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 4,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'v-neck-tshirt-navy-blue',
                'translations' => [
                    'en' => [
                        'name' => 'V-Neck T-Shirt - Navy Blue',
                        'description' => 'Classic v-neck t-shirt in navy blue. Premium cotton with a flattering fit. A wardrobe staple for any occasion.',
                        'short_description' => 'Navy blue v-neck cotton tee',
                        'tags' => 't-shirt, v-neck, cotton, casual',
                    ],
                    'ar' => [
                        'name' => 'تيشرت رقبة V - أزرق داكن',
                        'description' => 'تيشرت كلاسيكي برقبة V باللون الأزرق الداكن. قطن فاخر بقصة جذابة. عنصر أساسي في خزانة الملابس لأي مناسبة.',
                        'short_description' => 'تيشرت قطني برقبة V أزرق داكن',
                        'tags' => 'تيشرت، رقبة V، قطن، كاجوال',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 24.99,
                        'discount_price' => 19.99,
                        'stock' => 85,
                        'SKU' => 'TSHIRT-VNECK-NAV-001',
                        'weight' => 0.21,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 4,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'polo-tshirt-red',
                'translations' => [
                    'en' => [
                        'name' => 'Polo T-Shirt - Red',
                        'description' => 'Smart casual polo t-shirt in vibrant red. Breathable pique fabric with classic collar. Perfect for semi-formal occasions.',
                        'short_description' => 'Red polo shirt with collar',
                        'tags' => 't-shirt, polo, smart casual, collared',
                    ],
                    'ar' => [
                        'name' => 'تيشرت بولو - أحمر',
                        'description' => 'تيشرت بولو كاجوال ذكي باللون الأحمر الحيوي. قماش بيكيه قابل للتنفس مع ياقة كلاسيكية. مثالي للمناسبات شبه الرسمية.',
                        'short_description' => 'قميص بولو أحمر بياقة',
                        'tags' => 'تيشرت، بولو، كاجوال ذكي، بياقة',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 39.99,
                        'discount_price' => 34.99,
                        'stock' => 50,
                        'SKU' => 'TSHIRT-POLO-RED-001',
                        'weight' => 0.25,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 4,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'long-sleeve-tshirt-gray',
                'translations' => [
                    'en' => [
                        'name' => 'Long Sleeve T-Shirt - Gray',
                        'description' => 'Comfortable long sleeve t-shirt in heather gray. Perfect for layering or wearing alone. Soft fabric that gets better with every wash.',
                        'short_description' => 'Gray long sleeve cotton tee',
                        'tags' => 't-shirt, long sleeve, gray, layering',
                    ],
                    'ar' => [
                        'name' => 'تيشرت بأكمام طويلة - رمادي',
                        'description' => 'تيشرت مريح بأكمام طويلة باللون الرمادي الداكن. مثالي للطبقات أو ارتدائه بمفرده. قماش ناعم يتحسن مع كل غسلة.',
                        'short_description' => 'تيشرت قطني رمادي بأكمام طويلة',
                        'tags' => 'تيشرت، أكمام طويلة، رمادي، طبقات',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 34.99,
                        'discount_price' => 29.99,
                        'stock' => 60,
                        'SKU' => 'TSHIRT-LS-GRAY-001',
                        'weight' => 0.28,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1618517351616-38fb9c5210c6?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?w=800&q=80', 'type' => 'slide'],
                ],
            ],

            // Additional Electronics
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'portable-bluetooth-speaker',
                'translations' => [
                    'en' => [
                        'name' => 'Portable Bluetooth Speaker',
                        'description' => 'Waterproof portable speaker with 360° sound, 20-hour battery life, and deep bass. Perfect for outdoor adventures and parties.',
                        'short_description' => 'Waterproof portable speaker',
                        'tags' => 'speaker, bluetooth, portable, audio',
                    ],
                    'ar' => [
                        'name' => 'سماعة بلوتوث محمولة',
                        'description' => 'سماعة محمولة مقاومة للماء مع صوت 360 درجة وعمر بطارية 20 ساعة وصوت جهير عميق. مثالية للمغامرات الخارجية والحفلات.',
                        'short_description' => 'سماعة محمولة مقاومة للماء',
                        'tags' => 'سماعة، بلوتوث، محمول، صوت',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 79.99,
                        'discount_price' => 59.99,
                        'stock' => 45,
                        'SKU' => 'SPEAK-BT-PORT-001',
                        'weight' => 0.6,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'smart-watch-fitness-tracker',
                'translations' => [
                    'en' => [
                        'name' => 'Smart Watch Fitness Tracker',
                        'description' => 'Advanced fitness smartwatch with heart rate monitor, GPS, sleep tracking, and 7-day battery life. Your health companion on your wrist.',
                        'short_description' => 'Fitness smartwatch with GPS',
                        'tags' => 'smartwatch, fitness, tracker, wearable',
                    ],
                    'ar' => [
                        'name' => 'ساعة ذكية لتتبع اللياقة البدنية',
                        'description' => 'ساعة ذكية للياقة البدنية متقدمة مع مراقب معدل ضربات القلب و GPS وتتبع النوم وعمر بطارية 7 أيام. رفيق صحتك على معصمك.',
                        'short_description' => 'ساعة ذكية للياقة مع GPS',
                        'tags' => 'ساعة ذكية، لياقة، تتبع، يمكن ارتداؤها',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 249.99,
                        'discount_price' => 199.99,
                        'stock' => 30,
                        'SKU' => 'WATCH-SMART-FIT-001',
                        'weight' => 0.08,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1523395243481-163f8f6155ab?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'wireless-earbuds-pro',
                'translations' => [
                    'en' => [
                        'name' => 'Wireless Earbuds Pro',
                        'description' => 'Premium wireless earbuds with active noise cancellation, transparency mode, and 24-hour battery with charging case. Exceptional sound quality.',
                        'short_description' => 'Premium earbuds with ANC',
                        'tags' => 'earbuds, wireless, audio, anc',
                    ],
                    'ar' => [
                        'name' => 'سماعات أذن لاسلكية برو',
                        'description' => 'سماعات أذن لاسلكية متميزة مع إلغاء الضوضاء النشط ووضع الشفافية وبطارية 24 ساعة مع علبة الشحن. جودة صوت استثنائية.',
                        'short_description' => 'سماعات أذن متميزة مع إلغاء الضوضاء',
                        'tags' => 'سماعات أذن، لاسلكي، صوت، إلغاء ضوضاء',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 199.99,
                        'discount_price' => 169.99,
                        'stock' => 55,
                        'SKU' => 'EARB-WL-PRO-001',
                        'weight' => 0.05,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1606220838315-056192d5e927?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'tablet-10-inch-android',
                'translations' => [
                    'en' => [
                        'name' => '10" Android Tablet',
                        'description' => 'Powerful 10-inch Android tablet with high-resolution display, 6GB RAM, and 128GB storage. Perfect for entertainment and productivity.',
                        'short_description' => '10" tablet with 128GB storage',
                        'tags' => 'tablet, android, electronics, productivity',
                    ],
                    'ar' => [
                        'name' => 'تابلت أندرويد 10 بوصة',
                        'description' => 'تابلت أندرويد قوي 10 بوصة بشاشة عالية الدقة و 6 جيجابايت رام و 128 جيجابايت تخزين. مثالي للترفيه والإنتاجية.',
                        'short_description' => 'تابلت 10 بوصة بسعة 128 جيجابايت',
                        'tags' => 'تابلت، أندرويد، إلكترونيات، إنتاجية',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 349.99,
                        'discount_price' => 299.99,
                        'stock' => 35,
                        'SKU' => 'TAB-AND-10-128',
                        'weight' => 0.5,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80', 'type' => 'slide'],
                ],
            ],
            [
                'shop_id' => 1,
                'vendor_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'physical',
                'status' => 1,
                'slug' => 'portable-power-bank-20000mah',
                'translations' => [
                    'en' => [
                        'name' => 'Portable Power Bank 20000mAh',
                        'description' => 'High-capacity power bank with 20000mAh battery, dual USB ports, and fast charging. Never run out of battery again.',
                        'short_description' => '20000mAh fast charging power bank',
                        'tags' => 'power bank, charger, portable, battery',
                    ],
                    'ar' => [
                        'name' => 'بنك طاقة محمول 20000 ملي أمبير',
                        'description' => 'بنك طاقة عالي السعة مع بطارية 20000 ملي أمبير ومنفذي USB والشحن السريع. لا تنفد بطاريتك أبدًا مرة أخرى.',
                        'short_description' => 'بنك طاقة شحن سريع 20000 ملي أمبير',
                        'tags' => 'بنك طاقة، شاحن، محمول، بطارية',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 49.99,
                        'discount_price' => 39.99,
                        'stock' => 80,
                        'SKU' => 'PWR-BNK-20K-001',
                        'weight' => 0.4,
                        'is_primary' => true,
                    ],
                ],
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800&q=80', 'type' => 'thumb'],
                    ['url' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=800&q=80', 'type' => 'slide'],
                ],
            ],
        ];

        // Insert products into database
        foreach ($products as $productData) {
            // Create the product
            $product = Product::create([
                'shop_id' => $productData['shop_id'],
                'vendor_id' => $productData['vendor_id'],
                'slug' => $productData['slug'],
                'category_id' => $productData['category_id'],
                'brand_id' => $productData['brand_id'],
                'product_type' => $productData['product_type'],
                'status' => $productData['status'],
            ]);

            // Create translations
            foreach ($productData['translations'] as $langCode => $translation) {
                ProductTranslation::create([
                    'product_id' => $product->id,
                    'language_code' => $langCode,
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                    'short_description' => $translation['short_description'],
                    'tags' => $translation['tags'],
                ]);
            }

            // Create variants
            foreach ($productData['variants'] as $variantData) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_slug' => $product->slug . '-variant-' . Str::random(4),
                    'price' => $variantData['price'],
                    'discount_price' => $variantData['discount_price'] ?? null,
                    'stock' => $variantData['stock'],
                    'SKU' => $variantData['SKU'],
                    'weight' => $variantData['weight'] ?? null,
                    'is_primary' => $variantData['is_primary'] ?? false,
                ]);
            }

            // Create product images
            foreach ($productData['images'] as $imageData) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'name' => $product->slug . '-' . $imageData['type'],
                    'image_url' => $imageData['url'],
                    'type' => $imageData['type'],
                ]);
            }
        }

        $this->command->info('Demo products seeded successfully with stock images!');
    }
}
