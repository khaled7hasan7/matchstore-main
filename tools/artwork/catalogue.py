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
    ('falak-basic',  'فلك بيسيك',   'Falak Basic',   'خط الأساسيات اليومية من فلك ستور'),
    ('urban-fit',    'أوربان فِت',  'Urban Fit',     'قصّات عصرية للحياة اليومية والرياضة'),
    ('orchid',       'أوركيد',      'Orchid',        'أزياء نسائية بلمسة أنيقة'),
    ('north-line',   'نورث لاين',   'North Line',    'ملابس شتوية وجاكيتات'),
    ('suha',         'سُهى',        'Suha',          'عبايات وأزياء محتشمة'),
    ('little-star',  'نجمة صغيرة',  'Little Star',   'كل ما يخص ملابس الأطفال'),
]

# (slug, category, brand, ar, en, shape, colors, sizes, price, discount, stock, ar-desc)
PRODUCTS = [
    # --- men ---
    # prices below are in JOD
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
     'jacket', ['grey', 'brown', 'black'], APPAREL_SIZES, 79.00, None, 18,
     'معطف صوف بطول متوسط وبطانة دافئة، مصمم للشتاء البارد.'),
    ('mens-polo-shirt', 'men', 'urban-fit', 'بولو بأكمام قصيرة', 'Short Sleeve Polo',
     'tshirt', ['navy', 'burgundy', 'white'], APPAREL_SIZES, 14.50, None, 60,
     'قميص بولو بياقة مضلّعة وخامة بيكيه، بين الرسمي والكاجوال.'),

    # --- women ---
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

    # --- modest ---
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

    # --- kids ---
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
     'jacket', ['sky', 'burgundy'], APPAREL_SIZES, 28.00, None, 26,
     'جاكيت شتوي بحشوة دافئة وسحّاب أمامي وقلنسوة، مقاوم للرذاذ.'),

    # --- sportswear ---
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
     'jacket', ['navy', 'black'], APPAREL_SIZES, 27.00, None, 40,
     'جاكيت رياضي خفيف بسحّاب كامل وجيوب جانبية.'),

    # --- shoes ---
    ('sneakers-daily', 'shoes', 'urban-fit', 'حذاء رياضي يومي', 'Daily Sneakers',
     'sneaker', ['white', 'black'], SHOE_SIZES, 32.00, 26.00, 48,
     'حذاء رياضي بنعل مطاطي مرن وبطانة داخلية مبطّنة، خفيف على القدم.'),
    ('sneakers-running', 'shoes', 'urban-fit', 'حذاء جري', 'Running Shoes',
     'sneaker', ['grey', 'navy'], SHOE_SIZES, 44.00, None, 30,
     'حذاء جري بنعل ماص للصدمات ووجه شبكي يسمح بمرور الهواء.'),
    ('shoes-classic-leather', 'shoes', 'north-line', 'حذاء جلد كلاسيكي', 'Classic Leather Shoes',
     'sneaker', ['brown', 'black'], SHOE_SIZES, 55.00, None, 22,
     'حذاء جلد طبيعي بتصميم كلاسيكي، مناسب للعمل والمناسبات الرسمية.'),

    # --- bags ---
    ('bag-tote', 'bags', 'orchid', 'حقيبة توت', 'Tote Bag',
     'bag', ['beige', 'black', 'brown'], ONE_SIZE, 21.00, None, 44,
     'حقيبة توت واسعة تتسع للحاسوب المحمول والأغراض اليومية.'),
    ('bag-backpack', 'bags', 'urban-fit', 'حقيبة ظهر', 'Backpack',
     'bag', ['black', 'navy', 'olive'], ONE_SIZE, 26.50, 21.90, 52,
     'حقيبة ظهر بجيب مبطّن للحاسوب وأحزمة كتف مريحة.'),
    ('bag-crossbody', 'bags', 'orchid', 'حقيبة كروس صغيرة', 'Small Crossbody Bag',
     'bag', ['burgundy', 'beige', 'black'], ONE_SIZE, 16.00, None, 58,
     'حقيبة كروس صغيرة بحزام قابل للتعديل، تكفي للأساسيات.'),

    # --- accessories ---
    ('cap-baseball', 'accessories', 'urban-fit', 'كاب رياضي', 'Baseball Cap',
     'cap', ['black', 'navy', 'olive'], ONE_SIZE, 6.90, None, 110,
     'كاب قطني بحزام خلفي قابل للتعديل، يناسب كل المقاسات.'),
    ('scarf-winter', 'accessories', 'north-line', 'وشاح شتوي', 'Winter Scarf',
     'scarf', ['grey', 'burgundy', 'brown'], ONE_SIZE, 9.50, 7.50, 76,
     'وشاح شتوي محبوك دافئ وناعم، لا يسبب حكة على الرقبة.'),
]


def emit_artwork():
    pairs = set()
    for p in PRODUCTS:
        shape, colors = p[5], p[6]
        for c in colors:
            pairs.add((shape, c))

    for shape, ckey in sorted(pairs):
        hexv = COLORS[ckey][2]
        write(f'{shape}-{ckey}.svg', product_image(shape, hexv, 'thumb'))

    # Category tiles: the garment on a tinted ground. Each silhouette sits in a
    # different band of the 600 box, so it is nudged onto the circle by hand.
    nudge = {
        'sneaker': (0, -92, 0.92), 'bag': (0, -14, 0.94), 'cap': (0, 34, 1.0),
        'scarf': (0, -12, 0.92), 'abaya': (0, -22, 0.9), 'dress': (0, -20, 0.9),
        'shirt': (0, -8, 0.94), 'tshirt': (0, 6, 0.98), 'hoodie': (0, -10, 0.94),
    }
    for slug, ar, en, shape, tint, desc in CATEGORIES:
        dx, dy, sc = nudge.get(shape, (0, 0, 1.0))
        cx = 300 - 300 * sc + dx
        cy = 300 - 300 * sc + dy
        body = (
            f'<circle cx="300" cy="300" r="235" fill="#ffffff" opacity="0.55"/>'
            f'<g transform="translate({cx},{cy}) scale({sc})">'
            + SHAPES[shape]('#ffffff', tint) + '</g>'
        )
        write(f'category-{slug}.svg', svg(600, 600, body, bg=tint))

    # Hero banners: wide, quiet, no text — the theme writes the copy on top.
    heroes = [
        ('banner-new-season', '#2b3a67', '#4d6295', ['dress', 'jacket', 'bag']),
        ('banner-sale',       '#7c2f3d', '#a8515f', ['tshirt', 'sneaker', 'cap']),
        ('banner-modest',     '#3f4a5a', '#67748a', ['abaya', 'scarf', 'dress']),
    ]
    for name, c1, c2, shapes in heroes:
        gid = name.replace('-', '')
        defs = (
            f'<linearGradient id="{gid}" x1="0" y1="0" x2="1" y2="1">'
            f'<stop offset="0" stop-color="{c1}"/><stop offset="1" stop-color="{c2}"/></linearGradient>'
        )
        body = f'<rect width="1600" height="700" fill="url(#{gid})"/>'
        body += '<circle cx="1320" cy="140" r="230" fill="#ffffff" opacity="0.07"/>'
        body += '<circle cx="200" cy="640" r="180" fill="#ffffff" opacity="0.06"/>'
        for i, shape in enumerate(shapes):
            x = 830 + i * 195
            body += (
                f'<g transform="translate({x},150) scale(0.62)" opacity="0.9">'
                + SHAPES[shape]('#ffffff', c1) + '</g>'
            )
        write(f'{name}.svg', svg(1600, 700, body, bg=c1, extra_defs=defs))

    promos = [
        ('promo-women', '#8d5a72', '#c08fa3', 'dress'),
        ('promo-men',   '#2b3a67', '#5f76ad', 'shirt'),
        ('promo-kids',  '#c98f4b', '#e6bb85', 'tshirt'),
    ]
    for name, c1, c2, shape in promos:
        gid = name.replace('-', '')
        defs = (
            f'<linearGradient id="{gid}" x1="0" y1="0" x2="1" y2="1">'
            f'<stop offset="0" stop-color="{c1}"/><stop offset="1" stop-color="{c2}"/></linearGradient>'
        )
        body = f'<rect width="900" height="700" fill="url(#{gid})"/>'
        body += '<circle cx="720" cy="120" r="180" fill="#ffffff" opacity="0.08"/>'
        body += f'<g transform="translate(300,60) scale(0.85)" opacity="0.92">{SHAPES[shape]("#ffffff", c1)}</g>'
        write(f'{name}.svg', svg(900, 700, body, bg=c1, extra_defs=defs))

    # Brand mark: an orbit — "فلك".
    # Brand blue on a light rim so the mark reads on the light storefront
    # header and on the dark admin panel alike.
    logo = (
        '<circle cx="150" cy="150" r="60" fill="#7FB3FF"/>'
        '<circle cx="150" cy="150" r="52" fill="#1F6FEB"/>'
        '<path d="M150 98 A52 52 0 0 1 150 202 A34 52 0 0 0 150 98 Z" fill="#9FC8FF" opacity="0.55"/>'
        '<ellipse cx="150" cy="150" rx="128" ry="52" fill="none" stroke="#7FB3FF" stroke-width="13" '
        'transform="rotate(-24 150 150)"/>'
        '<circle cx="258" cy="104" r="16" fill="#E9F1FF"/>'
    )
    # No background rect: the mark sits on the dark admin panel and on the
    # light storefront header alike.
    write('falak-logo.svg',
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" '
          'width="300" height="300" role="img">' + logo + '</svg>')

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
         'تشكيلة الخريف والشتاء من فلك ستور — قصّات جديدة وخامات أدفأ.',
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
