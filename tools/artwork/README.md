# Artwork

Every image the store ships is generated here: the product illustrations in
`public/images/catalog`, the category tiles, the hero banners and promo
cards, and the ad creatives in `public/images/ads`.

They are generated rather than photographed because the serverless host has a
read-only filesystem and no image CDN is configured by default — an image
that is not in the repository is an image the store cannot show. Replace them
with real photographs whenever you have them: change `image_url` from the
admin panel, or upload to Supabase Storage (`php artisan falak:storage`).

| File | What it draws |
|---|---|
| `garments.py` | The garments themselves — silhouettes, fabric shading, seams, hardware |
| `catalogue.py` | The catalogue: colours, sizes, products. Writes `database/data/falak-catalog.php` and every product image |
| `ads.py` | Social ad creatives — square post, story, link preview |

Run from the project root:

```bash
python3 tools/artwork/catalogue.py     # products, tiles, banners, promos, and the catalogue file
python3 - <<'PY'                       # ads
import sys, pathlib; sys.path.insert(0, 'tools/artwork')
import ads
out = pathlib.Path('public/images/ads')
(out/'falak-ad-square.svg').write_text(ads.square(), encoding='utf-8')
(out/'falak-ad-story.svg').write_text(ads.story(), encoding='utf-8')
(out/'falak-ad-wide.svg').write_text(ads.wide(), encoding='utf-8')
PY
```

The `.png` copies of the ads are what you upload to Instagram or Facebook;
they are rendered from the `.svg` with a headless browser at the exact size
each platform expects (1080×1080, 1080×1920, 1200×630).
