"""Falak Store catalogue: writes the artwork and the PHP catalogue file."""
import sys, pathlib
sys.path.insert(0, str(pathlib.Path(__file__).parent))
from garments import *

COLORS = {
    'black':    ('أسود',   'Black',    '#1f2024'),
    'white':    ('أبيض',   'White',    '#f0efeb'),
    'navy':     ('كحلي',   'Navy',     '#26355f'),
    'beige':    ('بيج',    'Beige',    '#d7c3a3'),
    'olive':    ('زيتي',   'Olive',    '#6d7350'),
    'burgundy': ('عنّابي', 'Maroon',  '#7c2f3d'),
    'grey':     ('رمادي',  'Grey',     '#9aa0a6'),
    'sky':      ('سماوي',  'SkyBlue', '#8db9dd'),
    'pink':     ('وردي',   'Pink',     '#dfa2b3'),
    'brown':    ('بني',    'Brown',    '#6f4e37'),
}

APPAREL_SIZES = [('S', 'S'), ('M', 'M'), ('L', 'L'), ('XL', 'XL')]
SHOE_SIZES = [('40', '40'), ('41', '41'), ('42', '42'), ('43', '43')]
ONE_SIZE = [('مقاس واحد', 'One Size')]

CATEGORIES = [
    ('men',         'ملابس رجالية',    'Men',          'shirt',    '#2b3a67', 'قمصان وتيشيرتات وبناطيل رجالية'),
    ('women',       'ملابس نسائية',    'Women',        'dress',    '#8d5a72', 'فساتين وبلوزات وتنانير'),
    ('modest',      'أزياء محتشمة',    'Modest Wear',  'abaya',    '#3f4a5a', 'عبايات وطرح وأزياء محتشمة'),
    ('kids',        'ملابس أطفال',     'Kids',         'tshirt',   '#c98f4b', 'ملابس مريحة للأولاد والبنات'),
    ('sportswear',  'ملابس رياضية',    'Sportswear',   'hoodie',   '#2f6b5f', 'هوديات وبناطيل رياضية'),
    ('shoes',       'أحذية',           'Shoes',        'sneaker',  '#5a4632', 'أحذية رياضية وكلاسيكية'),
    ('bags',        'حقائب',           'Bags',         'bag',      '#7b4b3a', 'حقائب يد وظهر وسفر'),
    ('accessories', 'إكسسوارات',       'Accessories',  'scarf',    '#4a5240', 'قبعات وأوشحة وأحزمة'),
]

BRANDS = [
    ('falak-basic',  'فلك بيسيك',   'Falak Basic',   'خط الأساسيات اليومية من Falak Store'),
    ('urban-fit',    'أوربان فِت',  'Urban Fit',     'قصّات عصرية للحياة اليومية والرياضة'),
    ('orchid',       'أوركيد',      'Orchid',        'أزياء نسائية بلمسة أنيقة'),
    ('north-line',   'نورث لاين',   'North Line',    'ملابس شتوية وجاكيتات'),
    ('suha',         'سُهى',        'Suha',          'عبايات وأزياء محتشمة'),
    ('little-star',  'نجمة صغيرة',  'Little Star',   'كل ما يخص ملابس الأطفال'),
]

# (slug, category, brand, ar, en, shape, colors, sizes, price, discount, stock, ar-desc)

COUPONS = [
    ('WELCOME10', 'percentage', 10, 365, 'خصم 10% على أول طلب'),
    ('FALAK15',   'percentage', 15, 90,  'خصم 15% على تشكيلة الموسم'),
    ('SAVE5',     'fixed',      5,  180, 'خصم 5 دنانير على الطلبات'),
    ('WINTER20',  'percentage', 20, 120, 'خصم 20% على الملابس الشتوية'),
]

PRODUCTS = [
    # ---------------------------------------------------------------- men
    ('mens-oxford-shirt', 'men', 'falak-basic', 'قميص أوكسفورد كلاسيكي', 'Classic Oxford Shirt',
     'shirt', ['white', 'navy', 'sky'], APPAREL_SIZES, 19.90, None, 40,
     'قميص أوكسفورد قطن 100% بقصّة مستقيمة، مناسب للعمل والمناسبات اليومية.'),
    ('mens-cotton-tee', 'men', 'falak-basic', 'تيشيرت قطن سادة', 'Plain Cotton T-Shirt',
     'tshirt', ['black', 'white', 'olive', 'grey'], APPAREL_SIZES, 7.50, 5.90, 120,
     'تيشيرت قطن مفرّد بياقة دائرية، خامة تتنفّس ولا تنكمش بعد الغسيل.'),
    ('mens-chino-trousers', 'men', 'falak-basic', 'بنطال شينو', 'Chino Trousers',
     'trousers', ['beige', 'navy', 'olive'], APPAREL_SIZES, 24.00, None, 55,
     'بنطال شينو بقصّة سليم، قماش قطني مرن مريح طوال اليوم.'),
    ('mens-denim-jacket', 'men', 'north-line', 'جاكيت جينز', 'Denim Jacket',
     'jacket', ['navy', 'black'], APPAREL_SIZES, 39.00, 32.00, 25,
     'جاكيت جينز بأزرار معدنية وجيوب أمامية، قطعة تدوم لسنوات.'),
    ('mens-wool-coat', 'men', 'north-line', 'معطف صوف شتوي', 'Wool Winter Coat',
     'jacket', ['grey', 'brown', 'black'], APPAREL_SIZES, 79.00, 64.00, 18,
     'معطف صوف بطول متوسط وبطانة دافئة، مصمم للشتاء البارد.'),
    ('mens-polo-shirt', 'men', 'urban-fit', 'بولو بأكمام قصيرة', 'Short Sleeve Polo',
     'tshirt', ['navy', 'burgundy', 'white'], APPAREL_SIZES, 14.50, None, 60,
     'قميص بولو بياقة مضلّعة وخامة بيكيه، بين الرسمي والكاجوال.'),
    ('mens-knit-sweater', 'men', 'north-line', 'كنزة صوف', 'Wool Sweater',
     'sweater', ['navy', 'grey', 'burgundy'], APPAREL_SIZES, 27.00, 21.50, 42,
     'كنزة صوف محبوكة بياقة دائرية وأساور مضلّعة، دافئة بلا ثقل.'),
    ('mens-flannel-shirt', 'men', 'north-line', 'قميص فلانيل', 'Flannel Shirt',
     'shirt', ['burgundy', 'olive', 'grey'], APPAREL_SIZES, 22.00, None, 38,
     'قميص فلانيل قطني ناعم الملمس، مثالي للطقس البارد فوق تيشيرت.'),
    ('mens-linen-shirt', 'men', 'falak-basic', 'قميص كتّان صيفي', 'Linen Summer Shirt',
     'shirt', ['white', 'beige', 'sky'], APPAREL_SIZES, 21.00, 16.90, 44,
     'قميص كتّان خفيف يسمح بمرور الهواء، الخيار الأول في حرّ الصيف.'),
    ('mens-cargo-shorts', 'men', 'urban-fit', 'شورت كارجو', 'Cargo Shorts',
     'shorts', ['olive', 'beige', 'black'], APPAREL_SIZES, 16.00, None, 52,
     'شورت كارجو بجيوب جانبية وخصر مرن، عملي في الرحلات والصيف.'),
    ('mens-slim-jeans', 'men', 'falak-basic', 'جينز سليم', 'Slim Fit Jeans',
     'trousers', ['navy', 'black', 'grey'], APPAREL_SIZES, 26.50, 21.00, 48,
     'جينز بقصّة سليم وقماش مرن يحافظ على شكله بعد الغسيل.'),
    ('mens-bomber-jacket', 'men', 'urban-fit', 'جاكيت بومبر', 'Bomber Jacket',
     'jacket', ['black', 'olive'], APPAREL_SIZES, 42.00, None, 22,
     'جاكيت بومبر خفيف بأساور مضلّعة وسحّاب كامل، يناسب الربيع والخريف.'),

    # ---------------------------------------------------------------- women
    ('womens-midi-dress', 'women', 'orchid', 'فستان ميدي', 'Midi Dress',
     'dress', ['burgundy', 'navy', 'olive'], APPAREL_SIZES, 42.00, 34.00, 30,
     'فستان ميدي بقصّة انسيابية وحزام خصر، مناسب للمناسبات والعمل.'),
    ('womens-summer-dress', 'women', 'orchid', 'فستان صيفي', 'Summer Dress',
     'dress', ['sky', 'pink', 'white'], APPAREL_SIZES, 29.90, None, 38,
     'فستان صيفي خفيف من الفيسكوز، بارد ومريح في الأجواء الحارة.'),
    ('womens-knit-blouse', 'women', 'orchid', 'بلوزة تريكو', 'Knit Blouse',
     'tshirt', ['beige', 'pink', 'grey'], APPAREL_SIZES, 17.50, None, 45,
     'بلوزة تريكو ناعمة بأكمام طويلة، سهلة التنسيق مع الجينز والتنانير.'),
    ('womens-wide-trousers', 'women', 'orchid', 'بنطال واسع', 'Wide Leg Trousers',
     'trousers', ['black', 'beige'], APPAREL_SIZES, 26.00, None, 34,
     'بنطال بقصّة واسعة وخصر عالٍ، يعطي إطلالة أنيقة ومريحة.'),
    ('womens-trench-coat', 'women', 'north-line', 'معطف ترنش', 'Trench Coat',
     'jacket', ['beige', 'black'], APPAREL_SIZES, 68.00, 55.00, 16,
     'معطف ترنش كلاسيكي بحزام خصر وياقة عريضة، قطعة لا تخرج عن الموضة.'),
    ('womens-midi-skirt', 'women', 'orchid', 'تنورة ميدي', 'Midi Skirt',
     'skirt', ['black', 'burgundy', 'beige'], APPAREL_SIZES, 23.00, 18.50, 40,
     'تنورة ميدي بقصّة A وخصر عالٍ، تناسب العمل والمناسبات.'),
    ('womens-pleated-skirt', 'women', 'orchid', 'تنورة بليسيه', 'Pleated Skirt',
     'skirt', ['navy', 'olive', 'pink'], APPAREL_SIZES, 25.00, None, 32,
     'تنورة بليسيه بطيّات ثابتة لا تفقد شكلها، حركة ناعمة مع المشي.'),
    ('womens-cardigan', 'women', 'orchid', 'كارديجان طويل', 'Long Cardigan',
     'sweater', ['beige', 'grey', 'burgundy'], APPAREL_SIZES, 28.00, 22.90, 36,
     'كارديجان طويل مفتوح من الأمام، طبقة دافئة فوق أي إطلالة.'),
    ('womens-satin-blouse', 'women', 'orchid', 'بلوزة ساتان', 'Satin Blouse',
     'shirt', ['pink', 'navy', 'white'], APPAREL_SIZES, 24.50, None, 30,
     'بلوزة ساتان بلمعة خفيفة وأزرار مخفية، أنيقة للسهرات.'),
    ('womens-mom-jeans', 'women', 'falak-basic', 'جينز مام', 'Mom Jeans',
     'trousers', ['navy', 'sky'], APPAREL_SIZES, 27.50, 22.00, 38,
     'جينز بخصر عالٍ وقصّة مستقيمة مريحة، من كلاسيكيات خزانة الملابس.'),
    ('womens-maxi-dress', 'women', 'orchid', 'فستان ماكسي', 'Maxi Dress',
     'dress', ['navy', 'burgundy', 'grey'], APPAREL_SIZES, 39.00, None, 26,
     'فستان ماكسي طويل بأكمام واسعة، خامة تنسدل بشكل جميل.'),
    ('womens-oversize-tee', 'women', 'urban-fit', 'تيشيرت أوفرسايز', 'Oversize T-Shirt',
     'tshirt', ['white', 'black', 'pink', 'sky'], APPAREL_SIZES, 9.50, 7.50, 85,
     'تيشيرت أوفرسايز قطني بقصّة فضفاضة، مريح للبيت والخروج.'),

    # ---------------------------------------------------------------- modest
    ('abaya-classic-black', 'modest', 'suha', 'عباية كلاسيكية', 'Classic Abaya',
     'abaya', ['black'], APPAREL_SIZES, 45.00, None, 50,
     'عباية سوداء بقصّة مستقيمة من قماش الكريب، خفيفة وغير شفافة.'),
    ('abaya-embroidered', 'modest', 'suha', 'عباية مطرّزة', 'Embroidered Abaya',
     'abaya', ['black', 'navy'], APPAREL_SIZES, 62.00, 52.00, 28,
     'عباية بتطريز يدوي على الأكمام والصدر، لإطلالة مناسبة للمناسبات.'),
    ('modest-long-dress', 'modest', 'suha', 'فستان طويل محتشم', 'Modest Maxi Dress',
     'dress', ['olive', 'burgundy', 'navy'], APPAREL_SIZES, 38.00, None, 32,
     'فستان طويل بأكمام كاملة وقصّة واسعة، محتشم ومريح.'),
    ('hijab-scarf-set', 'modest', 'suha', 'طرحة قطن', 'Cotton Hijab',
     'scarf', ['black', 'beige', 'pink', 'grey'], ONE_SIZE, 5.50, None, 150,
     'طرحة قطن ناعمة لا تنزلق، متوفرة بألوان أساسية تناسب كل الإطلالات.'),
    ('abaya-everyday', 'modest', 'suha', 'عباية يومية', 'Everyday Abaya',
     'abaya', ['black', 'grey'], APPAREL_SIZES, 36.00, 29.00, 44,
     'عباية يومية بخامة لا تتجعّد، عملية للدوام والتسوّق.'),
    ('modest-tunic', 'modest', 'suha', 'تونيك طويل', 'Long Tunic',
     'sweater', ['beige', 'olive', 'navy'], APPAREL_SIZES, 21.00, None, 40,
     'تونيك طويل يغطي حتى منتصف الفخذ، ينسّق مع البناطيل الواسعة.'),
    ('modest-wide-trousers', 'modest', 'suha', 'بنطال واسع محتشم', 'Modest Wide Trousers',
     'trousers', ['black', 'navy', 'beige'], APPAREL_SIZES, 22.50, 18.00, 46,
     'بنطال واسع بخصر مطاطي وقماش لا يشفّ، مريح تحت العباية أو التونيك.'),
    ('hijab-chiffon', 'modest', 'suha', 'طرحة شيفون', 'Chiffon Hijab',
     'scarf', ['pink', 'sky', 'white', 'burgundy'], ONE_SIZE, 6.90, None, 120,
     'طرحة شيفون خفيفة بحواف مخيّطة، انسدال ناعم ولمعة هادئة.'),

    # ---------------------------------------------------------------- kids
    ('kids-tshirt-pack', 'kids', 'little-star', 'تيشيرت أطفال', 'Kids T-Shirt',
     'tshirt', ['sky', 'pink', 'white'], APPAREL_SIZES, 6.50, None, 90,
     'تيشيرت قطن للأطفال بألوان مبهجة، خامة آمنة على البشرة الحساسة.'),
    ('kids-hoodie', 'kids', 'little-star', 'هودي أطفال', 'Kids Hoodie',
     'hoodie', ['navy', 'burgundy', 'grey'], APPAREL_SIZES, 13.90, 10.90, 60,
     'هودي أطفال ببطانة قطنية دافئة وجيب أمامي كبير.'),
    ('kids-jeans', 'kids', 'little-star', 'بنطال جينز أطفال', 'Kids Jeans',
     'trousers', ['navy', 'black'], APPAREL_SIZES, 12.00, None, 70,
     'بنطال جينز مرن بخصر قابل للتعديل، يتحمّل حركة الأطفال ولعبهم.'),
    ('kids-winter-jacket', 'kids', 'north-line', 'جاكيت أطفال شتوي', 'Kids Winter Jacket',
     'jacket', ['sky', 'burgundy'], APPAREL_SIZES, 28.00, 22.50, 26,
     'جاكيت شتوي بحشوة دافئة وسحّاب أمامي وقلنسوة، مقاوم للرذاذ.'),
    ('kids-dress', 'kids', 'little-star', 'فستان بناتي', 'Girls Dress',
     'dress', ['pink', 'sky', 'white'], APPAREL_SIZES, 14.50, None, 48,
     'فستان بناتي قطني بقصّة واسعة، مريح للّعب والمناسبات معاً.'),
    ('kids-sweater', 'kids', 'little-star', 'كنزة أطفال', 'Kids Sweater',
     'sweater', ['burgundy', 'olive', 'grey'], APPAREL_SIZES, 15.00, 11.90, 55,
     'كنزة أطفال محبوكة لا تسبب حكة، دافئة لأيام المدرسة.'),
    ('kids-shorts', 'kids', 'little-star', 'شورت أطفال', 'Kids Shorts',
     'shorts', ['navy', 'olive', 'sky'], APPAREL_SIZES, 8.50, None, 80,
     'شورت أطفال قطني بخصر مطاطي، خفيف ويجفّ بسرعة.'),
    ('kids-skirt', 'kids', 'little-star', 'تنورة بناتي', 'Girls Skirt',
     'skirt', ['pink', 'navy'], APPAREL_SIZES, 10.90, None, 52,
     'تنورة بناتي بطيّات وخصر مطاطي مريح.'),

    # ---------------------------------------------------------------- sportswear
    ('sport-hoodie', 'sportswear', 'urban-fit', 'هودي رياضي', 'Sport Hoodie',
     'hoodie', ['black', 'grey', 'olive'], APPAREL_SIZES, 22.00, 18.50, 65,
     'هودي رياضي بخامة تمتص العرق، مناسب للتمرين وللخروج اليومي.'),
    ('sport-joggers', 'sportswear', 'urban-fit', 'بنطال جوجر', 'Jogger Pants',
     'trousers', ['black', 'grey', 'navy'], APPAREL_SIZES, 19.00, None, 72,
     'بنطال جوجر بخصر مطاطي وأساور عند الكاحل، مرن في الحركة.'),
    ('sport-training-tee', 'sportswear', 'urban-fit', 'تيشيرت تدريب', 'Training Tee',
     'tshirt', ['black', 'sky', 'olive'], APPAREL_SIZES, 11.50, None, 85,
     'تيشيرت تدريب سريع الجفاف بتقنية تهوية عند الظهر.'),
    ('sport-track-jacket', 'sportswear', 'urban-fit', 'جاكيت رياضي', 'Track Jacket',
     'jacket', ['navy', 'black'], APPAREL_SIZES, 27.00, 21.90, 40,
     'جاكيت رياضي خفيف بسحّاب كامل وجيوب جانبية.'),
    ('sport-shorts', 'sportswear', 'urban-fit', 'شورت رياضي', 'Training Shorts',
     'shorts', ['black', 'navy', 'grey'], APPAREL_SIZES, 12.50, 9.90, 90,
     'شورت رياضي خفيف بجيب جانبي ورباط خصر، لا يعيق الحركة.'),
    ('sport-sweatshirt', 'sportswear', 'urban-fit', 'سويت شيرت', 'Sweatshirt',
     'sweater', ['grey', 'black', 'olive'], APPAREL_SIZES, 20.00, None, 58,
     'سويت شيرت بقصّة عادية وبطانة ناعمة من الداخل.'),
    ('sport-compression-tee', 'sportswear', 'urban-fit', 'تيشيرت ضاغط', 'Compression Tee',
     'tshirt', ['black', 'navy'], APPAREL_SIZES, 14.00, None, 62,
     'تيشيرت ضاغط يدعم العضلات أثناء التمرين ويجفّ سريعاً.'),
    ('sport-leggings', 'sportswear', 'urban-fit', 'ليقنز رياضي', 'Sport Leggings',
     'trousers', ['black', 'grey', 'burgundy'], APPAREL_SIZES, 17.50, 13.90, 68,
     'ليقنز رياضي بخصر عالٍ وقماش مرن غير شفّاف.'),

    # ---------------------------------------------------------------- shoes
    ('sneakers-daily', 'shoes', 'urban-fit', 'حذاء رياضي يومي', 'Daily Sneakers',
     'sneaker', ['white', 'black'], SHOE_SIZES, 32.00, 26.00, 48,
     'حذاء رياضي بنعل مطاطي مرن وبطانة داخلية مبطّنة، خفيف على القدم.'),
    ('sneakers-running', 'shoes', 'urban-fit', 'حذاء جري', 'Running Shoes',
     'sneaker', ['grey', 'navy'], SHOE_SIZES, 44.00, None, 30,
     'حذاء جري بنعل ماص للصدمات ووجه شبكي يسمح بمرور الهواء.'),
    ('shoes-classic-leather', 'shoes', 'north-line', 'حذاء جلد كلاسيكي', 'Classic Leather Shoes',
     'sneaker', ['brown', 'black'], SHOE_SIZES, 55.00, 45.00, 22,
     'حذاء جلد طبيعي بتصميم كلاسيكي، مناسب للعمل والمناسبات الرسمية.'),
    ('shoes-canvas', 'shoes', 'falak-basic', 'حذاء كانفاس', 'Canvas Shoes',
     'sneaker', ['white', 'navy', 'olive'], SHOE_SIZES, 19.90, None, 64,
     'حذاء كانفاس خفيف بنعل مطاطي، بسيط ويناسب كل الإطلالات الكاجوال.'),
    ('shoes-womens-flat', 'shoes', 'orchid', 'حذاء نسائي مسطّح', 'Women Flat Shoes',
     'sneaker', ['beige', 'black', 'pink'], SHOE_SIZES, 24.00, 19.00, 40,
     'حذاء نسائي مسطّح ببطانة ناعمة، مريح للمشي الطويل.'),
    ('shoes-kids-sneakers', 'shoes', 'little-star', 'حذاء أطفال رياضي', 'Kids Sneakers',
     'sneaker', ['sky', 'white', 'pink'], SHOE_SIZES, 18.00, None, 56,
     'حذاء أطفال بلاصق سهل الارتداء ونعل مرن يتبع حركة القدم.'),

    # ---------------------------------------------------------------- bags
    ('bag-tote', 'bags', 'orchid', 'حقيبة توت', 'Tote Bag',
     'bag', ['beige', 'black', 'brown'], ONE_SIZE, 21.00, None, 44,
     'حقيبة توت واسعة تتسع للحاسوب المحمول والأغراض اليومية.'),
    ('bag-backpack', 'bags', 'urban-fit', 'حقيبة ظهر', 'Backpack',
     'bag', ['black', 'navy', 'olive'], ONE_SIZE, 26.50, 21.90, 52,
     'حقيبة ظهر بجيب مبطّن للحاسوب وأحزمة كتف مريحة.'),
    ('bag-crossbody', 'bags', 'orchid', 'حقيبة كروس صغيرة', 'Small Crossbody Bag',
     'bag', ['burgundy', 'beige', 'black'], ONE_SIZE, 16.00, None, 58,
     'حقيبة كروس صغيرة بحزام قابل للتعديل، تكفي للأساسيات.'),
    ('bag-travel', 'bags', 'north-line', 'حقيبة سفر', 'Travel Duffel',
     'bag', ['black', 'brown'], ONE_SIZE, 38.00, 31.00, 24,
     'حقيبة سفر بقماش مقاوم للماء وحزام كتف، تكفي لعطلة قصيرة.'),
    ('bag-laptop', 'bags', 'urban-fit', 'حقيبة لابتوب', 'Laptop Sleeve',
     'bag', ['grey', 'navy', 'black'], ONE_SIZE, 14.50, None, 66,
     'حقيبة لابتوب مبطّنة حتى 15 بوصة، رفيعة تدخل داخل حقيبة الظهر.'),

    # ---------------------------------------------------------------- accessories
    ('cap-baseball', 'accessories', 'urban-fit', 'كاب رياضي', 'Baseball Cap',
     'cap', ['black', 'navy', 'olive'], ONE_SIZE, 6.90, None, 110,
     'كاب قطني بحزام خلفي قابل للتعديل، يناسب كل المقاسات.'),
    ('scarf-winter', 'accessories', 'north-line', 'وشاح شتوي', 'Winter Scarf',
     'scarf', ['grey', 'burgundy', 'brown'], ONE_SIZE, 9.50, 7.50, 76,
     'وشاح شتوي محبوك دافئ وناعم، لا يسبب حكة على الرقبة.'),
    ('cap-bucket', 'accessories', 'urban-fit', 'قبعة باكيت', 'Bucket Hat',
     'cap', ['beige', 'black', 'olive'], ONE_SIZE, 8.50, None, 84,
     'قبعة باكيت قطنية بحواف عريضة تحمي من الشمس.'),
    ('scarf-silk', 'accessories', 'orchid', 'وشاح حريري', 'Silk Scarf',
     'scarf', ['pink', 'navy', 'burgundy'], ONE_SIZE, 12.00, 9.50, 58,
     'وشاح حريري بملمس بارد ولمعة هادئة، ينسّق على الرقبة أو الحقيبة.'),
    ('cap-knit-beanie', 'accessories', 'north-line', 'قبعة صوف', 'Knit Beanie',
     'cap', ['grey', 'black', 'burgundy'], ONE_SIZE, 7.50, None, 92,
     'قبعة صوف محبوكة تغطي الأذنين، خفيفة ودافئة.'),
]


def emit_artwork():
    """Every image the storefront shows, drawn from the lists above."""
    OUT.mkdir(parents=True, exist_ok=True)

    pairs = sorted({(p[5], c) for p in PRODUCTS for c in p[6]})
    for i, (shape, ckey) in enumerate(pairs):
        (OUT / f'{shape}-{ckey}.svg').write_text(
            product(shape, COLORS[ckey][2], uid=f'p{i}'), encoding='utf-8')

    for slug, ar, en, shape, tint, desc in CATEGORIES:
        (OUT / f'category-{slug}.svg').write_text(
            tile(shape, tint, uid='c' + slug[:3]), encoding='utf-8')

    for name, shapes in [
        ('banner-new-season', ['dress', 'jacket', 'bag']),
        ('banner-sale', ['tshirt', 'sneaker', 'cap']),
        ('banner-modest', ['abaya', 'scarf', 'dress']),
    ]:
        (OUT / f'{name}.svg').write_text(banner(name, shapes), encoding='utf-8')

    for name, c1, c2, shape in [
        ('promo-women', '#5d2b46', '#b06a8c', 'dress'),
        ('promo-men', '#071229', '#2f5fae', 'shirt'),
        ('promo-kids', '#8a5320', '#e0a95f', 'tshirt'),
    ]:
        (OUT / f'{name}.svg').write_text(promo(name, shape, c1, c2), encoding='utf-8')

    # The brand mark, on no background so it reads on light and dark alike.
    mark = (
        '<circle cx="150" cy="150" r="60" fill="#7FB3FF"/>'
        '<circle cx="150" cy="150" r="52" fill="#1F6FEB"/>'
        '<path d="M150 98 A52 52 0 0 1 150 202 A34 52 0 0 0 150 98 Z" fill="#9FC8FF" opacity="0.55"/>'
        '<ellipse cx="150" cy="150" rx="128" ry="52" fill="none" stroke="#7FB3FF" stroke-width="13" '
        'transform="rotate(-24 150 150)"/>'
        '<circle cx="258" cy="104" r="16" fill="#E9F1FF"/>'
    )
    (OUT / 'falak-logo.svg').write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" width="300" height="300" '
        f'role="img">{mark}</svg>', encoding='utf-8')

    return len(list(OUT.glob('*.svg')))


def php_value(v):
    if v is None:
        return 'null'
    if isinstance(v, bool):
        return 'true' if v else 'false'
    if isinstance(v, (int, float)):
        return repr(v)
    return "'" + str(v).replace('\\', '\\\\').replace("'", "\\'") + "'"


def emit_php():
    L = []
    A = L.append
    A('<?php')
    A('')
    A('/**')
    A(' * The Falak Store catalogue: colours, sizes, categories, house labels and')
    A(' * every product with the artwork that ships in public/images/catalog.')
    A(' *')
    A(' * Kept as data rather than seeder code so the shop owner can edit a price,')
    A(' * a description or a stock level without reading a line of PHP.')
    A(' */')
    A('return [')

    A('    // key => [Arabic name, English name, hex used by the artwork]')
    A('    \'colors\' => [')
    for k, (ar, en, hexv) in COLORS.items():
        A(f"        '{k}' => ['ar' => {php_value(ar)}, 'en' => {php_value(en)}, 'hex' => '{hexv}'],")
    A('    ],')

    A('    \'categories\' => [')
    for slug, ar, en, shape, tint, desc in CATEGORIES:
        A('        [')
        A(f"            'slug' => '{slug}', 'ar' => {php_value(ar)}, 'en' => {php_value(en)},")
        A(f"            'description' => {php_value(desc)},")
        A(f"            'image' => '/images/catalog/category-{slug}.svg',")
        A('        ],')
    A('    ],')

    A('    \'brands\' => [')
    for slug, ar, en, desc in BRANDS:
        A('        [')
        A(f"            'slug' => '{slug}', 'ar' => {php_value(ar)}, 'en' => {php_value(en)},")
        A(f"            'description' => {php_value(desc)},")
        A('        ],')
    A('    ],')

    A('    \'products\' => [')
    for (slug, cat, brand, ar, en, shape, colors, sizes, price, discount, stock, desc) in PRODUCTS:
        A('        [')
        A(f"            'slug' => '{slug}',")
        A(f"            'category' => '{cat}', 'brand' => '{brand}',")
        A(f"            'ar' => {php_value(ar)}, 'en' => {php_value(en)},")
        A(f"            'description' => {php_value(desc)},")
        A(f"            'price' => {price:.2f}, 'discount_price' => {('null' if discount is None else f'{discount:.2f}')}, 'stock' => {stock},")
        A(f"            'shape' => '{shape}',")
        A(f"            'colors' => [{', '.join(php_value(c) for c in colors)}],")
        A(f"            'sizes' => [{', '.join(php_value(s[0]) + ' => ' + php_value(s[1]) for s in sizes)}],")
        A('        ],')
    A('    ],')

    A('    \'banners\' => [')
    banners = [
        ('banner-new-season', 'موسم جديد وصل', 'New Season Has Landed',
         'تشكيلة الخريف والشتاء من Falak Store — قصّات جديدة وخامات أدفأ.',
         'The autumn and winter collection from Falak Store.'),
        ('banner-sale', 'خصومات حتى 30%', 'Up to 30% Off',
         'اختر من القطع المخفّضة قبل نفاد المقاسات.',
         'Shop the reduced pieces before the sizes run out.'),
        ('banner-modest', 'أزياء محتشمة', 'Modest Wear',
         'عبايات وطرح وفساتين طويلة بخامات مريحة.',
         'Abayas, hijabs and maxi dresses in comfortable fabrics.'),
    ]
    for name, tar, ten, dar, den in banners:
        A('        [')
        A(f"            'key' => '{name}',")
        A(f"            'ar' => ['title' => {php_value(tar)}, 'description' => {php_value(dar)}],")
        A(f"            'en' => ['title' => {php_value(ten)}, 'description' => {php_value(den)}],")
        A(f"            'image' => '/images/catalog/{name}.svg',")
        A('        ],')
    A('    ],')

    A('    \'promo_cards\' => [')
    promos = [
        ('promo-women', 'large', 1, 'جديد', 'New', 'أناقة نسائية لكل يوم', 'Everyday Elegance',
         'تسوّقي الآن', 'Shop Women', '/shop?category[]=women'),
        ('promo-men', 'small', 2, 'الأكثر مبيعاً', 'Best Sellers', 'أساسيات الرجل', "Men's Essentials",
         'تسوّق الآن', 'Shop Men', '/shop?category[]=men'),
        ('promo-kids', 'small', 3, 'عرض', 'Offer', 'ملابس أطفال مريحة', 'Comfy Kids Wear',
         'اكتشف', 'Discover', '/shop?category[]=kids'),
    ]
    for key, size, order, bar, ben, tar, ten, btnar, btnen, url in promos:
        A('        [')
        A(f"            'key' => '{key}', 'size' => '{size}', 'order' => {order},")
        A(f"            'ar' => ['badge_text' => {php_value(bar)}, 'title' => {php_value(tar)}, 'button_text' => {php_value(btnar)}],")
        A(f"            'en' => ['badge_text' => {php_value(ben)}, 'title' => {php_value(ten)}, 'button_text' => {php_value(btnen)}],")
        A(f"            'button_url' => {php_value(url)},")
        A(f"            'image' => '/images/catalog/{key}.svg',")
        A('        ],')
    A('    ],')
    A('    \'coupons\' => [')
    for code, kind, value, days, label in COUPONS:
        A('        [')
        A(f"            'code' => '{code}', 'type' => '{kind}', 'discount' => {value},")
        A(f"            'valid_days' => {days}, 'label' => {php_value(label)},")
        A('        ],')
    A('    ],')
    A('];')
    A('')

    out = pathlib.Path('database/data/falak-catalog.php')
    out.parent.mkdir(parents=True, exist_ok=True)
    out.write_text('\n'.join(L), encoding='utf-8')
    return out, len(PRODUCTS)


if __name__ == '__main__':
    n = emit_artwork()
    path, count = emit_php()
    print(f'svg files: {n}')
    print(f'php catalogue: {path} ({count} products)')
