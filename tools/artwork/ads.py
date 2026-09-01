"""Ready-to-post ad creatives for Falak Store.

Three sizes: a square post, a vertical story, and a wide link preview. Text
is real SVG text so the same file can be re-typed for a new campaign without
redrawing anything.
"""
import sys, pathlib
sys.path.insert(0, str(pathlib.Path(__file__).parent))
import garments as art2

AR = "'IBM Plex Sans Arabic','Noto Sans Arabic','Segoe UI',Tahoma,sans-serif"
LAT = "'Space Grotesk','Poppins',system-ui,sans-serif"

DEEP, MID, BRAND, LIGHT, GOLD = '#050B18', '#0F2A5C', '#1F6FEB', '#7FB3FF', '#E9F1FF'


def logo(x, y, s):
    """The orbit mark, scaled and placed."""
    return (
        f'<g transform="translate({x},{y}) scale({s})">'
        f'<circle cx="150" cy="150" r="60" fill="{LIGHT}"/>'
        f'<circle cx="150" cy="150" r="52" fill="{BRAND}"/>'
        f'<path d="M150 98 A52 52 0 0 1 150 202 A34 52 0 0 0 150 98 Z" fill="#9FC8FF" opacity="0.55"/>'
        f'<ellipse cx="150" cy="150" rx="128" ry="52" fill="none" stroke="{LIGHT}" stroke-width="13" '
        f'transform="rotate(-24 150 150)"/>'
        f'<circle cx="258" cy="104" r="16" fill="{GOLD}"/>'
        f'</g>'
    )


def _bg(w, h, uid):
    return (
        f'<defs>{art2.BLUR}{art2.fabric_defs(uid, "#eef3fb")}'
        f'<linearGradient id="ad{uid}" x1="0" y1="0" x2="0.7" y2="1">'
        f'<stop offset="0" stop-color="{DEEP}"/><stop offset="0.5" stop-color="{MID}"/>'
        f'<stop offset="1" stop-color="{BRAND}"/></linearGradient>'
        f'<radialGradient id="gl{uid}" cx="0.5" cy="0.5" r="0.5">'
        f'<stop offset="0" stop-color="{LIGHT}" stop-opacity="0.45"/>'
        f'<stop offset="1" stop-color="{LIGHT}" stop-opacity="0"/></radialGradient>'
        f'<linearGradient id="fade{uid}" x1="0" y1="0" x2="0" y2="1">'
        f'<stop offset="0" stop-color="{DEEP}" stop-opacity="0"/>'
        f'<stop offset="1" stop-color="{DEEP}" stop-opacity="0.85"/></linearGradient></defs>'
        f'<rect width="{w}" height="{h}" fill="url(#ad{uid})"/>'
        f'<ellipse cx="{w * 0.8}" cy="{h * 0.12}" rx="{w * 0.5}" ry="{h * 0.35}" fill="url(#gl{uid})"/>'
        f'<circle cx="{w * 0.1}" cy="{h * 0.95}" r="{w * 0.28}" fill="#ffffff" opacity="0.04"/>'
    )


def _garments(uid, items):
    """items: (shape, x, y, scale)"""
    out = ''
    for shape, x, y, sc in items:
        out += (f'<g transform="translate({x},{y}) scale({sc})" opacity="0.97">'
                f'{art2.SHAPES[shape](uid, "#eef3fb")}</g>')
    return out


def _text(x, y, txt, size, weight=700, fill='#ffffff', align='center', font=AR, spacing=None, opacity=1):
    """align is where the text sits relative to x: 'right', 'center' or 'left'.

    Under direction="rtl" the SVG anchors invert — text-anchor="end" puts the
    logical end (the left edge) at x — so the mapping is spelled out here
    rather than at every call site.
    """
    anchor = {'right': 'start', 'center': 'middle', 'left': 'end'}[align]
    ls = f' letter-spacing="{spacing}"' if spacing else ''
    return (f'<text x="{x}" y="{y}" font-family="{font}" font-size="{size}" font-weight="{weight}" '
            f'fill="{fill}" text-anchor="{anchor}" direction="rtl"{ls} opacity="{opacity}">{txt}</text>')


def _pill(cx, cy, w, h, label, size=44):
    return (f'<rect x="{cx - w / 2}" y="{cy - h / 2}" width="{w}" height="{h}" rx="{h / 2}" fill="#ffffff"/>'
            f'{_text(cx, cy + size * 0.36, label, size, 700, DEEP)}')


def square(w=1080, h=1080):
    uid = 'sq'
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" width="{w}" height="{h}">'
        + _bg(w, h, uid)
        + _garments(uid, [('dress', -60, 110, 0.44), ('jacket', 170, 140, 0.42), ('sneaker', 258, 320, 0.38)])
        + f'<rect y="{h * 0.5}" width="{w}" height="{h * 0.5}" fill="url(#fade{uid})"/>'
        + logo(w - 236, 54, 0.58)
        + _text(w - 64, 686, 'فلك ستور', 100, 700, '#ffffff', 'right')
        + _text(w - 64, 758, 'ملابس رجالية ونسائية وأطفال', 42, 500, '#CFE0FF', 'right')
        + _text(w - 64, 858, 'خصومات حتى 30%', 62, 700, GOLD, 'right')
        + _text(w - 64, 914, 'توصيل داخل الأردن وفلسطين · الدفع عند الاستلام', 31, 400, '#B9D2F7', 'right')
        + _pill(w - 202, 968, 276, 76, 'تسوّق الآن')
        + f'<text x="64" y="976" font-family="{LAT}" font-size="28" font-weight="500" fill="#8FB6EE" '
          f'letter-spacing="4">falakstore</text>'
        + '</svg>'
    )


def story(w=1080, h=1920):
    uid = 'st'
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" width="{w}" height="{h}">'
        + _bg(w, h, uid)
        + _garments(uid, [('abaya', 40, 480, 0.58), ('shirt', 400, 560, 0.52), ('bag', 210, 980, 0.44)])
        + f'<rect y="{h * 0.58}" width="{w}" height="{h * 0.42}" fill="url(#fade{uid})"/>'
        + logo(w / 2 - 105, 150, 0.7)
        + _text(w / 2, 500, 'فلك ستور', 108, 700, '#ffffff', 'center')
        + _text(w / 2, 578, 'أزياء لكل يوم', 46, 500, '#CFE0FF')
        + _text(w / 2, 1500, 'تشكيلة الموسم الجديد', 76, 700)
        + _text(w / 2, 1580, 'قمصان · فساتين · عبايات · أحذية · حقائب', 38, 400, '#B9D2F7')
        + _text(w / 2, 1682, 'خصومات حتى 30%', 62, 700, GOLD)
        + _pill(w / 2, 1742, 340, 92, 'تسوّق الآن', 48)
        + _text(w / 2, 1846, 'توصيل داخل الأردن وفلسطين · الدفع عند الاستلام', 30, 400, '#8FB6EE')
        + '</svg>'
    )


def wide(w=1200, h=630):
    uid = 'wd'
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" width="{w}" height="{h}">'
        + _bg(w, h, uid)
        + _garments(uid, [('tshirt', -110, -60, 0.34), ('trousers', 60, -110, 0.30), ('cap', 210, 60, 0.30)])
        + logo(64, 56, 0.38)
        + _text(w - 64, 244, 'فلك ستور', 84, 700, '#ffffff', 'right')
        + _text(w - 64, 306, 'ملابس رجالية ونسائية وأطفال · أحذية وحقائب', 32, 500, '#CFE0FF', 'right')
        + _text(w - 64, 388, 'خصومات حتى 30% · توصيل داخل الأردن وفلسطين', 30, 400, GOLD, 'right')
        + _pill(w - 200, 476, 268, 72, 'تسوّق الآن', 38)
        + '</svg>'
    )
