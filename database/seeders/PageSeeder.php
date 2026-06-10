<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About Us Page
        $aboutPage = Page::updateOrCreate(
            ['slug' => 'about-us'],
            ['status' => true]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'language_code' => 'en'
            ],
            [
                'title' => 'About Us',
                'content' => '<div class="about-us-content">
    <h2>Welcome to MatchStore by Match Systems</h2>
    <p>MatchStore is your premier online shopping destination, offering a curated selection of high-quality products across multiple categories. Powered by Match Systems, we combine cutting-edge technology with exceptional customer service to deliver an unparalleled shopping experience.</p>

    <h3>Our Story</h3>
    <p>Founded with a vision to revolutionize online retail, MatchStore emerged from Match Systems\' commitment to innovation and customer satisfaction. We understand that modern consumers demand convenience, quality, and reliability – and we\'re here to deliver all three.</p>

    <h3>What We Offer</h3>
    <ul>
        <li><strong>Wide Product Selection:</strong> From electronics to fashion, home goods to lifestyle products, we offer an extensive range carefully selected to meet your needs.</li>
        <li><strong>Quality Assurance:</strong> Every product in our catalog undergoes rigorous quality checks to ensure you receive only the best.</li>
        <li><strong>Competitive Pricing:</strong> We work directly with manufacturers and trusted suppliers to bring you competitive prices without compromising on quality.</li>
        <li><strong>Fast & Reliable Shipping:</strong> With our strategic shipping network covering Jordan and Palestine, we ensure your orders arrive quickly and safely.</li>
        <li><strong>Secure Shopping:</strong> Your privacy and security are our top priorities. We use industry-leading encryption and security measures to protect your data.</li>
    </ul>

    <h3>Our Commitment</h3>
    <p>At MatchStore, customer satisfaction isn\'t just a goal – it\'s our foundation. We\'re committed to:</p>
    <ul>
        <li>Providing exceptional 24/7 customer support</li>
        <li>Maintaining transparent pricing with no hidden fees</li>
        <li>Offering hassle-free returns and exchanges</li>
        <li>Continuously improving our platform based on your feedback</li>
        <li>Supporting local communities in Jordan and Palestine</li>
    </ul>

    <h3>Match Systems Technology</h3>
    <p>Powered by Match Systems, MatchStore leverages advanced e-commerce technology to provide you with a seamless shopping experience. Our platform features intelligent search, personalized recommendations, secure payment processing, and real-time order tracking – all designed to make your shopping journey effortless.</p>

    <h3>Our Vision</h3>
    <p>We envision a future where online shopping is not just convenient, but truly delightful. By combining technology, quality products, and genuine care for our customers, we\'re building more than just a store – we\'re creating a shopping community you can trust.</p>

    <h3>Contact Us</h3>
    <p>Have questions or feedback? We\'d love to hear from you! Our customer support team is available 24/7 to assist you with any inquiries, concerns, or suggestions.</p>

    <p class="text-center mt-5"><strong>Thank you for choosing MatchStore – Where Quality Meets Convenience</strong></p>
</div>',
                'image_url' => null
            ]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'language_code' => 'ar'
            ],
            [
                'title' => 'من نحن',
                'content' => '<div class="about-us-content">
    <h2>مرحباً بك في MatchStore من Match Systems</h2>
    <p>MatchStore هي وجهتك الأولى للتسوق عبر الإنترنت، حيث نقدم مجموعة مختارة من المنتجات عالية الجودة عبر فئات متعددة. بدعم من Match Systems، نجمع بين التكنولوجيا المتطورة وخدمة العملاء الاستثنائية لتقديم تجربة تسوق لا مثيل لها.</p>

    <h3>قصتنا</h3>
    <p>تأسست MatchStore برؤية ثورية لتجارة التجزئة عبر الإنترنت، وانبثقت من التزام Match Systems بالابتكار ورضا العملاء. نحن ندرك أن المستهلكين العصريين يطالبون بالراحة والجودة والموثوقية – ونحن هنا لتقديم الثلاثة جميعاً.</p>

    <h3>ما نقدمه</h3>
    <ul>
        <li><strong>تشكيلة واسعة من المنتجات:</strong> من الإلكترونيات إلى الأزياء، من المنتجات المنزلية إلى منتجات نمط الحياة، نقدم مجموعة واسعة تم اختيارها بعناية لتلبية احتياجاتك.</li>
        <li><strong>ضمان الجودة:</strong> كل منتج في كتالوجنا يخضع لفحوصات جودة صارمة لضمان حصولك على الأفضل فقط.</li>
        <li><strong>أسعار تنافسية:</strong> نعمل مباشرة مع الشركات المصنعة والموردين الموثوقين لنقدم لك أسعاراً تنافسية دون المساس بالجودة.</li>
        <li><strong>شحن سريع وموثوق:</strong> مع شبكة الشحن الاستراتيجية التي تغطي الأردن وفلسطين، نضمن وصول طلباتك بسرعة وأمان.</li>
        <li><strong>تسوق آمن:</strong> خصوصيتك وأمانك هما أولوياتنا القصوى. نستخدم تشفيراً وإجراءات أمنية رائدة في الصناعة لحماية بياناتك.</li>
    </ul>

    <h3>التزامنا</h3>
    <p>في MatchStore، رضا العملاء ليس مجرد هدف – إنه أساسنا. نحن ملتزمون بـ:</p>
    <ul>
        <li>تقديم دعم عملاء استثنائي على مدار الساعة طوال أيام الأسبوع</li>
        <li>الحفاظ على تسعير شفاف بدون رسوم مخفية</li>
        <li>تقديم عمليات إرجاع واستبدال خالية من المتاعب</li>
        <li>التحسين المستمر لمنصتنا بناءً على ملاحظاتك</li>
        <li>دعم المجتمعات المحلية في الأردن وفلسطين</li>
    </ul>

    <h3>تكنولوجيا Match Systems</h3>
    <p>بدعم من Match Systems، تستفيد MatchStore من تكنولوجيا التجارة الإلكترونية المتقدمة لتزويدك بتجربة تسوق سلسة. تتميز منصتنا بالبحث الذكي والتوصيات الشخصية ومعالجة الدفع الآمنة وتتبع الطلبات في الوقت الفعلي – كل ذلك مصمم لجعل رحلة التسوق الخاصة بك سهلة.</p>

    <h3>رؤيتنا</h3>
    <p>نتصور مستقبلاً حيث لا يكون التسوق عبر الإنترنت مريحاً فحسب، بل ممتعاً حقاً. من خلال الجمع بين التكنولوجيا والمنتجات عالية الجودة والاهتمام الحقيقي بعملائنا، نبني أكثر من مجرد متجر – نحن نخلق مجتمع تسوق يمكنك الوثوق به.</p>

    <h3>اتصل بنا</h3>
    <p>لديك أسئلة أو ملاحظات؟ نود أن نسمع منك! فريق دعم العملاء لدينا متاح على مدار الساعة طوال أيام الأسبوع لمساعدتك في أي استفسارات أو مخاوف أو اقتراحات.</p>

    <p class="text-center mt-5"><strong>شكراً لاختيارك MatchStore – حيث تلتقي الجودة بالراحة</strong></p>
</div>',
                'image_url' => null
            ]
        );

        // Privacy Policy Page
        $privacyPage = Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            ['status' => true]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $privacyPage->id,
                'language_code' => 'en'
            ],
            [
                'title' => 'Privacy Policy',
                'content' => '<div class="privacy-policy-content">
    <p><em>Last Updated: December 31, 2025</em></p>

    <h2>Privacy Policy</h2>
    <p>At MatchStore, operated by Match Systems, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>

    <h3>1. Information We Collect</h3>

    <h4>1.1 Personal Information</h4>
    <p>We collect information that you provide directly to us, including:</p>
    <ul>
        <li>Name and contact information (email address, phone number, shipping address)</li>
        <li>Account credentials (username and password)</li>
        <li>Payment information (credit card details, billing address)</li>
        <li>Purchase history and preferences</li>
        <li>Communication preferences</li>
        <li>Customer service correspondence</li>
    </ul>

    <h4>1.2 Automatically Collected Information</h4>
    <p>When you access our website, we automatically collect certain information, including:</p>
    <ul>
        <li>Device information (IP address, browser type, operating system)</li>
        <li>Usage data (pages visited, time spent, links clicked)</li>
        <li>Cookies and similar tracking technologies</li>
        <li>Location data (with your permission)</li>
    </ul>

    <h3>2. How We Use Your Information</h3>
    <p>We use the collected information for various purposes:</p>
    <ul>
        <li>Processing and fulfilling your orders</li>
        <li>Managing your account and providing customer support</li>
        <li>Sending order confirmations and shipping updates</li>
        <li>Personalizing your shopping experience</li>
        <li>Improving our website and services</li>
        <li>Sending marketing communications (with your consent)</li>
        <li>Preventing fraud and ensuring security</li>
        <li>Complying with legal obligations</li>
    </ul>

    <h3>3. Information Sharing and Disclosure</h3>
    <p>We do not sell your personal information. We may share your information with:</p>
    <ul>
        <li><strong>Service Providers:</strong> Third-party vendors who assist with payment processing, shipping, email delivery, and analytics</li>
        <li><strong>Business Partners:</strong> Trusted partners who help us operate our business</li>
        <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
        <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
    </ul>

    <h3>4. Data Security</h3>
    <p>We implement industry-standard security measures to protect your personal information:</p>
    <ul>
        <li>SSL/TLS encryption for data transmission</li>
        <li>Secure payment processing through trusted providers</li>
        <li>Regular security audits and updates</li>
        <li>Access controls and authentication measures</li>
        <li>Employee training on data protection</li>
    </ul>

    <h3>5. Your Rights and Choices</h3>
    <p>You have the following rights regarding your personal information:</p>
    <ul>
        <li><strong>Access:</strong> Request access to your personal data</li>
        <li><strong>Correction:</strong> Update or correct inaccurate information</li>
        <li><strong>Deletion:</strong> Request deletion of your personal data</li>
        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
        <li><strong>Data Portability:</strong> Request a copy of your data in a portable format</li>
    </ul>

    <h3>6. Cookies and Tracking Technologies</h3>
    <p>We use cookies and similar technologies to enhance your experience. You can control cookie preferences through your browser settings. Note that disabling cookies may affect website functionality.</p>

    <h3>7. Children\'s Privacy</h3>
    <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please contact us immediately.</p>

    <h3>8. International Data Transfers</h3>
    <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your data during such transfers.</p>

    <h3>9. Data Retention</h3>
    <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this policy, comply with legal obligations, resolve disputes, and enforce our agreements.</p>

    <h3>10. Changes to This Privacy Policy</h3>
    <p>We may update this Privacy Policy periodically. We will notify you of any material changes by posting the new policy on our website and updating the "Last Updated" date.</p>

    <h3>11. Contact Us</h3>
    <p>If you have questions or concerns about this Privacy Policy or our data practices, please contact us:</p>
    <ul>
        <li>Email: privacy@matchstore.com</li>
        <li>Phone: Available 24/7 through our customer support</li>
    </ul>

    <p class="mt-4"><strong>By using MatchStore, you acknowledge that you have read and understood this Privacy Policy and agree to its terms.</strong></p>
</div>',
                'image_url' => null
            ]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $privacyPage->id,
                'language_code' => 'ar'
            ],
            [
                'title' => 'سياسة الخصوصية',
                'content' => '<div class="privacy-policy-content">
    <p><em>آخر تحديث: 31 ديسمبر 2025</em></p>

    <h2>سياسة الخصوصية</h2>
    <p>في MatchStore، التي تديرها Match Systems، نلتزم بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك واستخدامها والإفصاح عنها وحمايتها عند زيارة موقعنا واستخدام خدماتنا.</p>

    <h3>1. المعلومات التي نجمعها</h3>

    <h4>1.1 المعلومات الشخصية</h4>
    <p>نجمع المعلومات التي تقدمها لنا مباشرةً، بما في ذلك:</p>
    <ul>
        <li>الاسم ومعلومات الاتصال (عنوان البريد الإلكتروني، رقم الهاتف، عنوان الشحن)</li>
        <li>بيانات اعتماد الحساب (اسم المستخدم وكلمة المرور)</li>
        <li>معلومات الدفع (تفاصيل بطاقة الائتمان، عنوان الفواتير)</li>
        <li>سجل الشراء والتفضيلات</li>
        <li>تفضيلات الاتصال</li>
        <li>مراسلات خدمة العملاء</li>
    </ul>

    <h4>1.2 المعلومات المجمعة تلقائياً</h4>
    <p>عند دخولك إلى موقعنا، نجمع تلقائياً معلومات معينة، بما في ذلك:</p>
    <ul>
        <li>معلومات الجهاز (عنوان IP، نوع المتصفح، نظام التشغيل)</li>
        <li>بيانات الاستخدام (الصفحات التي تمت زيارتها، الوقت المستغرق، الروابط المنقر عليها)</li>
        <li>ملفات تعريف الارتباط وتقنيات التتبع المماثلة</li>
        <li>بيانات الموقع (بإذنك)</li>
    </ul>

    <h3>2. كيف نستخدم معلوماتك</h3>
    <p>نستخدم المعلومات المجمعة لأغراض مختلفة:</p>
    <ul>
        <li>معالجة وتنفيذ طلباتك</li>
        <li>إدارة حسابك وتقديم دعم العملاء</li>
        <li>إرسال تأكيدات الطلب وتحديثات الشحن</li>
        <li>تخصيص تجربة التسوق الخاصة بك</li>
        <li>تحسين موقعنا وخدماتنا</li>
        <li>إرسال اتصالات تسويقية (بموافقتك)</li>
        <li>منع الاحتيال وضمان الأمان</li>
        <li>الامتثال للالتزامات القانونية</li>
    </ul>

    <h3>3. مشاركة المعلومات والإفصاح عنها</h3>
    <p>نحن لا نبيع معلوماتك الشخصية. قد نشارك معلوماتك مع:</p>
    <ul>
        <li><strong>مقدمو الخدمات:</strong> البائعون الخارجيون الذين يساعدون في معالجة الدفع والشحن وتسليم البريد الإلكتروني والتحليلات</li>
        <li><strong>شركاء الأعمال:</strong> الشركاء الموثوقون الذين يساعدوننا في تشغيل أعمالنا</li>
        <li><strong>المتطلبات القانونية:</strong> عندما يتطلب القانون ذلك أو لحماية حقوقنا</li>
        <li><strong>عمليات نقل الأعمال:</strong> فيما يتعلق بالاندماج أو الاستحواذ أو بيع الأصول</li>
    </ul>

    <h3>4. أمان البيانات</h3>
    <p>نطبق إجراءات أمنية متوافقة مع معايير الصناعة لحماية معلوماتك الشخصية:</p>
    <ul>
        <li>تشفير SSL/TLS لنقل البيانات</li>
        <li>معالجة الدفع الآمنة من خلال مزودي خدمة موثوقين</li>
        <li>عمليات تدقيق وتحديثات أمنية منتظمة</li>
        <li>ضوابط الوصول وإجراءات المصادقة</li>
        <li>تدريب الموظفين على حماية البيانات</li>
    </ul>

    <h3>5. حقوقك وخياراتك</h3>
    <p>لديك الحقوق التالية فيما يتعلق بمعلوماتك الشخصية:</p>
    <ul>
        <li><strong>الوصول:</strong> طلب الوصول إلى بياناتك الشخصية</li>
        <li><strong>التصحيح:</strong> تحديث أو تصحيح المعلومات غير الدقيقة</li>
        <li><strong>الحذف:</strong> طلب حذف بياناتك الشخصية</li>
        <li><strong>إلغاء الاشتراك:</strong> إلغاء الاشتراك في الاتصالات التسويقية</li>
        <li><strong>قابلية نقل البيانات:</strong> طلب نسخة من بياناتك بتنسيق قابل للنقل</li>
    </ul>

    <h3>6. ملفات تعريف الارتباط وتقنيات التتبع</h3>
    <p>نستخدم ملفات تعريف الارتباط وتقنيات مماثلة لتحسين تجربتك. يمكنك التحكم في تفضيلات ملفات تعريف الارتباط من خلال إعدادات المتصفح. لاحظ أن تعطيل ملفات تعريف الارتباط قد يؤثر على وظائف الموقع.</p>

    <h3>7. خصوصية الأطفال</h3>
    <p>خدماتنا غير موجهة للأفراد الذين تقل أعمارهم عن 18 عاماً. نحن لا نجمع عن قصد معلومات شخصية من الأطفال. إذا كنت تعتقد أننا جمعنا معلومات من طفل، فيرجى الاتصال بنا فوراً.</p>

    <h3>8. نقل البيانات الدولية</h3>
    <p>قد يتم نقل معلوماتك ومعالجتها في بلدان غير بلد إقامتك. نضمن وجود ضمانات مناسبة لحماية بياناتك أثناء هذه النقل.</p>

    <h3>9. الاحتفاظ بالبيانات</h3>
    <p>نحتفظ بمعلوماتك الشخصية طالما كان ذلك ضرورياً لتحقيق الأغراض الموضحة في هذه السياسة، والامتثال للالتزامات القانونية، وحل النزاعات، وإنفاذ اتفاقياتنا.</p>

    <h3>10. التغييرات على سياسة الخصوصية هذه</h3>
    <p>قد نقوم بتحديث سياسة الخصوصية هذه بشكل دوري. سنخطرك بأي تغييرات جوهرية عن طريق نشر السياسة الجديدة على موقعنا وتحديث تاريخ "آخر تحديث".</p>

    <h3>11. اتصل بنا</h3>
    <p>إذا كانت لديك أسئلة أو مخاوف بشأن سياسة الخصوصية هذه أو ممارسات البيانات لدينا، يرجى الاتصال بنا:</p>
    <ul>
        <li>البريد الإلكتروني: privacy@matchstore.com</li>
        <li>الهاتف: متاح على مدار الساعة طوال أيام الأسبوع من خلال دعم العملاء لدينا</li>
    </ul>

    <p class="mt-4"><strong>باستخدام MatchStore، فإنك تقر بأنك قرأت وفهمت سياسة الخصوصية هذه وتوافق على شروطها.</strong></p>
</div>',
                'image_url' => null
            ]
        );

        // Terms of Service Page
        $termsPage = Page::updateOrCreate(
            ['slug' => 'terms-of-service'],
            ['status' => true]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $termsPage->id,
                'language_code' => 'en'
            ],
            [
                'title' => 'Terms of Service',
                'content' => '<div class="terms-of-service-content">
    <p><em>Last Updated: December 31, 2025</em></p>

    <h2>Terms of Service</h2>
    <p>Welcome to MatchStore, operated by Match Systems. By accessing or using our website and services, you agree to be bound by these Terms of Service. Please read them carefully.</p>

    <h3>1. Acceptance of Terms</h3>
    <p>By creating an account, placing an order, or using any part of our services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our Privacy Policy. If you do not agree, please do not use our services.</p>

    <h3>2. Eligibility</h3>
    <p>You must be at least 18 years old to use our services. By using MatchStore, you represent and warrant that you meet this age requirement and have the legal capacity to enter into binding contracts.</p>

    <h3>3. Account Registration</h3>
    <ul>
        <li>You must provide accurate, current, and complete information during registration</li>
        <li>You are responsible for maintaining the confidentiality of your account credentials</li>
        <li>You are responsible for all activities that occur under your account</li>
        <li>You must notify us immediately of any unauthorized use of your account</li>
        <li>We reserve the right to suspend or terminate accounts that violate these terms</li>
    </ul>

    <h3>4. Products and Pricing</h3>
    <ul>
        <li>All products are subject to availability</li>
        <li>We reserve the right to limit quantities purchased per person or order</li>
        <li>Prices are displayed in USD and are subject to change without notice</li>
        <li>We strive for accuracy in product descriptions and pricing, but errors may occur</li>
        <li>We reserve the right to refuse or cancel orders for products with pricing errors</li>
        <li>Promotional offers are subject to specific terms and conditions</li>
    </ul>

    <h3>5. Orders and Payment</h3>
    <ul>
        <li>Placing an order constitutes an offer to purchase products</li>
        <li>We reserve the right to accept or decline your order</li>
        <li>Payment must be received before order processing</li>
        <li>We accept major credit cards and approved payment methods</li>
        <li>All payments are processed securely through trusted payment gateways</li>
        <li>You are responsible for any applicable taxes and fees</li>
    </ul>

    <h3>6. Shipping and Delivery</h3>
    <ul>
        <li>We currently ship to Jordan and Palestine</li>
        <li>Delivery times are estimates and not guaranteed</li>
        <li>Shipping costs are calculated based on destination and weight</li>
        <li>Risk of loss and title pass to you upon delivery to the carrier</li>
        <li>You must inspect shipments upon receipt and report damages within 48 hours</li>
        <li>Delays due to customs, weather, or carrier issues are beyond our control</li>
    </ul>

    <h3>7. Returns and Refunds</h3>
    <ul>
        <li>We offer a 30-day return policy for most products</li>
        <li>Products must be unused, in original packaging, and in resalable condition</li>
        <li>Certain items (personal care, intimate items, custom products) are non-returnable</li>
        <li>Return shipping costs are the customer\'s responsibility unless the item is defective</li>
        <li>Refunds are processed within 7-10 business days after receiving returned items</li>
        <li>Original shipping charges are non-refundable</li>
    </ul>

    <h3>8. Warranties and Disclaimers</h3>
    <p>Products are covered by manufacturer warranties where applicable. MatchStore makes no additional warranties beyond those provided by manufacturers. TO THE FULLEST EXTENT PERMITTED BY LAW, OUR SERVICES ARE PROVIDED "AS IS" WITHOUT WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED.</p>

    <h3>9. Limitation of Liability</h3>
    <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, MATCHSTORE AND MATCH SYSTEMS SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, OR ANY LOSS OF PROFITS OR REVENUES, WHETHER INCURRED DIRECTLY OR INDIRECTLY.</p>

    <h3>10. Intellectual Property</h3>
    <ul>
        <li>All content on MatchStore (logos, text, images, graphics) is owned by Match Systems or its licensors</li>
        <li>You may not copy, reproduce, distribute, or create derivative works without permission</li>
        <li>Product images and descriptions are protected by copyright and trademark laws</li>
        <li>Unauthorized use of our intellectual property may result in legal action</li>
    </ul>

    <h3>11. User Conduct</h3>
    <p>You agree not to:</p>
    <ul>
        <li>Use our services for any illegal or unauthorized purpose</li>
        <li>Violate any local, national, or international laws</li>
        <li>Infringe upon the rights of others</li>
        <li>Transmit viruses, malware, or harmful code</li>
        <li>Attempt to gain unauthorized access to our systems</li>
        <li>Interfere with the proper functioning of our website</li>
        <li>Engage in fraudulent activities or impersonate others</li>
    </ul>

    <h3>12. Reviews and User Content</h3>
    <ul>
        <li>You may submit product reviews and ratings</li>
        <li>Content must be truthful, relevant, and not offensive</li>
        <li>By submitting content, you grant us a perpetual, royalty-free license to use it</li>
        <li>We reserve the right to remove content that violates our policies</li>
        <li>We are not responsible for user-generated content</li>
    </ul>

    <h3>13. Privacy and Data Protection</h3>
    <p>Your use of our services is also governed by our Privacy Policy, which is incorporated into these Terms by reference. Please review our Privacy Policy to understand our data practices.</p>

    <h3>14. Modifications to Terms</h3>
    <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately upon posting. Your continued use of our services after changes constitutes acceptance of the modified terms.</p>

    <h3>15. Termination</h3>
    <p>We may terminate or suspend your access to our services at any time, without prior notice, for any reason, including breach of these Terms. Upon termination, your right to use our services will immediately cease.</p>

    <h3>16. Governing Law and Dispute Resolution</h3>
    <p>These Terms shall be governed by and construed in accordance with the laws of Jordan. Any disputes arising from these Terms or your use of our services shall be resolved through binding arbitration or in the competent courts of Jordan.</p>

    <h3>17. Severability</h3>
    <p>If any provision of these Terms is found to be invalid or unenforceable, the remaining provisions shall continue in full force and effect.</p>

    <h3>18. Contact Information</h3>
    <p>For questions about these Terms of Service, please contact us:</p>
    <ul>
        <li>Email: legal@matchstore.com</li>
        <li>Customer Support: Available 24/7</li>
    </ul>

    <p class="mt-4"><strong>By using MatchStore, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</strong></p>
</div>',
                'image_url' => null
            ]
        );

        PageTranslation::updateOrCreate(
            [
                'page_id' => $termsPage->id,
                'language_code' => 'ar'
            ],
            [
                'title' => 'شروط الخدمة',
                'content' => '<div class="terms-of-service-content">
    <p><em>آخر تحديث: 31 ديسمبر 2025</em></p>

    <h2>شروط الخدمة</h2>
    <p>مرحباً بك في MatchStore، التي تديرها Match Systems. من خلال الوصول إلى موقعنا أو استخدام خدماتنا، فإنك توافق على الالتزام بشروط الخدمة هذه. يرجى قراءتها بعناية.</p>

    <h3>1. قبول الشروط</h3>
    <p>من خلال إنشاء حساب، أو تقديم طلب، أو استخدام أي جزء من خدماتنا، فإنك تقر بأنك قرأت وفهمت ووافقت على الالتزام بشروط الخدمة هذه وسياسة الخصوصية الخاصة بنا. إذا كنت لا توافق، فيرجى عدم استخدام خدماتنا.</p>

    <h3>2. الأهلية</h3>
    <p>يجب أن يكون عمرك 18 عاماً على الأقل لاستخدام خدماتنا. باستخدام MatchStore، فإنك تقر وتضمن أنك تستوفي متطلبات العمر هذه ولديك الأهلية القانونية للدخول في عقود ملزمة.</p>

    <h3>3. تسجيل الحساب</h3>
    <ul>
        <li>يجب عليك تقديم معلومات دقيقة وحالية وكاملة أثناء التسجيل</li>
        <li>أنت مسؤول عن الحفاظ على سرية بيانات اعتماد حسابك</li>
        <li>أنت مسؤول عن جميع الأنشطة التي تحدث تحت حسابك</li>
        <li>يجب عليك إخطارنا فوراً بأي استخدام غير مصرح به لحسابك</li>
        <li>نحتفظ بالحق في تعليق أو إنهاء الحسابات التي تنتهك هذه الشروط</li>
    </ul>

    <h3>4. المنتجات والأسعار</h3>
    <ul>
        <li>جميع المنتجات خاضعة للتوافر</li>
        <li>نحتفظ بالحق في تحديد الكميات المشتراة لكل شخص أو طلب</li>
        <li>الأسعار معروضة بالدولار الأمريكي وقابلة للتغيير دون إشعار</li>
        <li>نسعى للدقة في أوصاف المنتجات والأسعار، لكن قد تحدث أخطاء</li>
        <li>نحتفظ بالحق في رفض أو إلغاء الطلبات للمنتجات ذات أخطاء التسعير</li>
        <li>العروض الترويجية تخضع لشروط وأحكام محددة</li>
    </ul>

    <h3>5. الطلبات والدفع</h3>
    <ul>
        <li>يشكل تقديم طلب عرضاً لشراء المنتجات</li>
        <li>نحتفظ بالحق في قبول أو رفض طلبك</li>
        <li>يجب استلام الدفع قبل معالجة الطلب</li>
        <li>نقبل بطاقات الائتمان الرئيسية وطرق الدفع المعتمدة</li>
        <li>تتم معالجة جميع المدفوعات بشكل آمن من خلال بوابات دفع موثوقة</li>
        <li>أنت مسؤول عن أي ضرائب ورسوم قابلة للتطبيق</li>
    </ul>

    <h3>6. الشحن والتوصيل</h3>
    <ul>
        <li>نشحن حالياً إلى الأردن وفلسطين</li>
        <li>أوقات التسليم تقديرية وغير مضمونة</li>
        <li>يتم حساب تكاليف الشحن بناءً على الوجهة والوزن</li>
        <li>تنتقل مخاطر الخسارة والملكية إليك عند التسليم للناقل</li>
        <li>يجب عليك فحص الشحنات عند الاستلام والإبلاغ عن الأضرار في غضون 48 ساعة</li>
        <li>التأخيرات الناتجة عن الجمارك أو الطقس أو مشاكل الناقل خارجة عن سيطرتنا</li>
    </ul>

    <h3>7. الإرجاع والاسترداد</h3>
    <ul>
        <li>نقدم سياسة إرجاع لمدة 30 يوماً لمعظم المنتجات</li>
        <li>يجب أن تكون المنتجات غير مستخدمة، في عبوتها الأصلية، وفي حالة قابلة لإعادة البيع</li>
        <li>بعض العناصر (العناية الشخصية، العناصر الحميمية، المنتجات المخصصة) غير قابلة للإرجاع</li>
        <li>تكاليف شحن الإرجاع هي مسؤولية العميل ما لم يكن المنتج معيباً</li>
        <li>يتم معالجة المبالغ المستردة في غضون 7-10 أيام عمل بعد استلام العناصر المرتجعة</li>
        <li>رسوم الشحن الأصلية غير قابلة للاسترداد</li>
    </ul>

    <h3>8. الضمانات وإخلاء المسؤولية</h3>
    <p>المنتجات مشمولة بضمانات الشركة المصنعة حيثما ينطبق ذلك. لا تقدم MatchStore ضمانات إضافية تتجاوز تلك التي يقدمها المصنعون. إلى أقصى حد يسمح به القانون، يتم توفير خدماتنا "كما هي" دون ضمانات من أي نوع، صريحة أو ضمنية.</p>

    <h3>9. تحديد المسؤولية</h3>
    <p>إلى الحد الأقصى الذي يسمح به القانون، لن تكون MATCHSTORE و MATCH SYSTEMS مسؤولتين عن أي أضرار غير مباشرة أو عرضية أو خاصة أو تبعية أو عقابية، أو أي خسارة في الأرباح أو الإيرادات، سواء تم تكبدها مباشرة أو بشكل غير مباشر.</p>

    <h3>10. الملكية الفكرية</h3>
    <ul>
        <li>جميع المحتويات على MatchStore (الشعارات، النصوص، الصور، الرسومات) مملوكة لـ Match Systems أو مرخصيها</li>
        <li>لا يجوز لك نسخ أو إعادة إنتاج أو توزيع أو إنشاء أعمال مشتقة دون إذن</li>
        <li>صور المنتجات وأوصافها محمية بموجب قوانين حقوق النشر والعلامات التجارية</li>
        <li>الاستخدام غير المصرح به لملكيتنا الفكرية قد يؤدي إلى اتخاذ إجراءات قانونية</li>
    </ul>

    <h3>11. سلوك المستخدم</h3>
    <p>توافق على عدم:</p>
    <ul>
        <li>استخدام خدماتنا لأي غرض غير قانوني أو غير مصرح به</li>
        <li>انتهاك أي قوانين محلية أو وطنية أو دولية</li>
        <li>التعدي على حقوق الآخرين</li>
        <li>إرسال فيروسات أو برامج ضارة أو رموز ضارة</li>
        <li>محاولة الوصول غير المصرح به إلى أنظمتنا</li>
        <li>التدخل في الأداء السليم لموقعنا</li>
        <li>الانخراط في أنشطة احتيالية أو انتحال شخصية الآخرين</li>
    </ul>

    <h3>12. المراجعات ومحتوى المستخدم</h3>
    <ul>
        <li>يمكنك تقديم مراجعات وتقييمات للمنتجات</li>
        <li>يجب أن يكون المحتوى صادقاً وذا صلة وغير مسيء</li>
        <li>من خلال تقديم المحتوى، فإنك تمنحنا ترخيصاً دائماً وخالياً من حقوق الملكية لاستخدامه</li>
        <li>نحتفظ بالحق في إزالة المحتوى الذي يخالف سياساتنا</li>
        <li>نحن غير مسؤولين عن المحتوى الذي ينشئه المستخدمون</li>
    </ul>

    <h3>13. الخصوصية وحماية البيانات</h3>
    <p>يخضع استخدامك لخدماتنا أيضاً لسياسة الخصوصية الخاصة بنا، والتي تم دمجها في هذه الشروط بالإشارة. يرجى مراجعة سياسة الخصوصية لفهم ممارسات البيانات لدينا.</p>

    <h3>14. التعديلات على الشروط</h3>
    <p>نحتفظ بالحق في تعديل شروط الخدمة هذه في أي وقت. ستكون التغييرات سارية فوراً عند النشر. يشكل استمرارك في استخدام خدماتنا بعد التغييرات قبولاً للشروط المعدلة.</p>

    <h3>15. الإنهاء</h3>
    <p>يجوز لنا إنهاء أو تعليق وصولك إلى خدماتنا في أي وقت، دون إشعار مسبق، لأي سبب، بما في ذلك انتهاك هذه الشروط. عند الإنهاء، سينتهي حقك في استخدام خدماتنا فوراً.</p>

    <h3>16. القانون الحاكم وحل النزاعات</h3>
    <p>تخضع هذه الشروط وتفسر وفقاً لقوانين الأردن. يتم حل أي نزاعات ناشئة عن هذه الشروط أو استخدامك لخدماتنا من خلال التحكيم الملزم أو في المحاكم المختصة في الأردن.</p>

    <h3>17. الانفصال</h3>
    <p>إذا تبين أن أي حكم من هذه الشروط غير صالح أو غير قابل للتنفيذ، فستستمر الأحكام المتبقية سارية المفعول بالكامل.</p>

    <h3>18. معلومات الاتصال</h3>
    <p>للأسئلة حول شروط الخدمة هذه، يرجى الاتصال بنا:</p>
    <ul>
        <li>البريد الإلكتروني: legal@matchstore.com</li>
        <li>دعم العملاء: متاح على مدار الساعة طوال أيام الأسبوع</li>
    </ul>

    <p class="mt-4"><strong>باستخدام MatchStore، فإنك تقر بأنك قرأت وفهمت ووافقت على الالتزام بشروط الخدمة هذه.</strong></p>
</div>',
                'image_url' => null
            ]
        );
    }
}
