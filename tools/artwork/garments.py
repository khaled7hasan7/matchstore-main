"""Falak Store artwork, second pass.

Editorial flat-lay product illustrations: a studio backdrop, fabric rendered
with directional light, folds, seams and the hardware that tells one garment
from another. 900x1200 so the cards read as a fashion store rather than a
grid of squares.
"""
import pathlib

W, H = 900, 1200
OUT = pathlib.Path('public/images/catalog')


# ---------------------------------------------------------------- colour
def _rgb(h):
    h = h.lstrip('#')
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def _hex(t):
    return '#%02x%02x%02x' % tuple(max(0, min(255, int(round(c)))) for c in t)


def shade(h, f):
    """f<1 darkens, f>1 lightens toward white."""
    r, g, b = _rgb(h)
    if f <= 1:
        return _hex((r * f, g * f, b * f))
    k = f - 1
    return _hex((r + (255 - r) * k, g + (255 - g) * k, b + (255 - b) * k))


def mix(h, other, k):
    a, b = _rgb(h), _rgb(other)
    return _hex(tuple(a[i] + (b[i] - a[i]) * k for i in range(3)))


# ---------------------------------------------------------------- pieces
def fabric_defs(uid, c):
    """A cloth gradient lit from upper-left, plus a soft ground shadow."""
    return (
        f'<linearGradient id="f{uid}" x1="0.1" y1="0" x2="0.9" y2="1">'
        f'<stop offset="0" stop-color="{shade(c, 1.16)}"/>'
        f'<stop offset="0.45" stop-color="{c}"/>'
        f'<stop offset="1" stop-color="{shade(c, 0.82)}"/>'
        f'</linearGradient>'
        f'<linearGradient id="r{uid}" x1="0" y1="0" x2="0" y2="1">'
        f'<stop offset="0" stop-color="{shade(c, 0.9)}"/>'
        f'<stop offset="1" stop-color="{shade(c, 0.7)}"/>'
        f'</linearGradient>'
        f'<radialGradient id="sh{uid}" cx="0.5" cy="0.5" r="0.5">'
        f'<stop offset="0" stop-color="#0b1220" stop-opacity="0.20"/>'
        f'<stop offset="1" stop-color="#0b1220" stop-opacity="0"/>'
        f'</radialGradient>'
    )


BLUR = '<filter id="soft" x="-30%" y="-30%" width="160%" height="160%">' \
       '<feGaussianBlur stdDeviation="70"/></filter>'

BACKDROP = (
    '<linearGradient id="bg" x1="0" y1="0" x2="0.3" y2="1">'
    '<stop offset="0" stop-color="#ffffff"/>'
    '<stop offset="0.55" stop-color="#f5f3ef"/>'
    '<stop offset="1" stop-color="#e9e5df"/>'
    '</linearGradient>'
    '<radialGradient id="vig" cx="0.5" cy="0.42" r="0.75">'
    '<stop offset="0.55" stop-color="#000000" stop-opacity="0"/>'
    '<stop offset="1" stop-color="#000000" stop-opacity="0.07"/>'
    '</radialGradient>'
)


def seam(d, c, width=3, dash='14 11'):
    return (f'<path d="{d}" fill="none" stroke="{shade(c, 0.62)}" stroke-width="{width}" '
            f'stroke-dasharray="{dash}" stroke-linecap="round" opacity="0.75"/>')


def fold(d, c, o=0.20):
    return f'<path d="{d}" fill="{shade(c, 0.55)}" opacity="{o}"/>'


def gleam(d, o=0.30):
    return f'<path d="{d}" fill="#ffffff" opacity="{o}"/>'


def volume(uid):
    """A soft highlight and shadow across the cloth, clipped to its outline.

    Hard-edged highlight paths read as printed stripes rather than as light,
    so the shaping is done with blurred ellipses instead.
    """
    return (
        f'<g clip-path="url(#clip{uid})">'
        f'<ellipse cx="370" cy="430" rx="180" ry="420" fill="#ffffff" opacity="0.22" filter="url(#soft)"/>'
        f'<ellipse cx="640" cy="760" rx="180" ry="440" fill="#0b1220" opacity="0.13" filter="url(#soft)"/>'
        f'</g>'
    )


def edge(c):
    return shade(c, 0.55)


# ---------------------------------------------------------------- garments
BODY = {
    'tshirt': 'M370 258 Q450 320 530 258 L602 274 L696 356 L650 456 L572 414 L580 800 Q450 830 320 800 L328 414 L250 456 L204 356 L298 274 Z',
    'shirt': 'M372 250 L450 302 L528 250 L602 272 L698 356 L652 458 L572 416 L578 812 L322 812 L328 416 L248 458 L202 356 L298 272 Z',
    'hoodie': 'M366 268 Q450 352 534 268 L610 288 L712 376 L662 480 L580 436 L586 826 L314 826 L320 436 L238 480 L188 376 L290 288 Z',
    'jacket': 'M368 250 L450 336 L532 250 L606 272 L706 358 L656 462 L576 420 L582 824 L318 824 L324 420 L244 462 L194 358 L294 272 Z',
    'trousers': 'M304 262 L596 262 L616 436 L582 1062 L486 1062 L450 648 L414 1062 L318 1062 L284 436 Z',
    'dress': 'M358 256 Q450 314 542 256 L570 286 L584 508 Q664 774 712 1052 Q450 1114 188 1052 Q236 774 316 508 L330 286 Z',
    'abaya': 'M356 242 L450 210 L544 242 L604 306 L648 704 L598 716 L606 1090 Q450 1136 294 1090 L302 716 L252 704 L296 306 Z',
    'scarf': 'M280 296 Q450 214 620 296 L642 400 Q450 322 258 400 Z M322 384 L578 384 L566 1030 L334 1030 Z',
    'cap': 'M236 706 Q236 402 450 402 Q664 402 664 706 Z M236 706 Q160 712 150 760 Q144 802 204 804 L696 804 Q756 802 750 760 Q740 712 664 706 Z',
    'bag': 'M262 468 L638 468 L662 500 L636 930 Q450 962 264 930 L238 500 Z',
    'sneaker': 'M164 862 Q166 632 322 596 Q424 574 476 656 L560 730 Q662 762 748 790 Q800 806 802 862 Z',
}

FIT = {
    # (dx, dy, scale) — fills the frame without cropping, garment optically centred
    'tshirt': (0, 92, 1.35), 'shirt': (0, 86, 1.34), 'hoodie': (0, 78, 1.30),
    'jacket': (0, 80, 1.31), 'trousers': (0, -40, 1.06), 'dress': (0, -66, 1.02),
    'abaya': (0, -52, 0.98), 'scarf': (0, -48, 1.05), 'cap': (0, 4, 1.70),
    'bag': (0, -24, 1.34), 'sneaker': (-42, -222, 1.26),
}

def tshirt(uid, c):
    e = edge(c)
    body = BODY['tshirt']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<path d="M370 258 Q450 320 530 258 Q450 288 370 258 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        + fold('M336 430 L330 796 L306 792 L312 428 Z', c, 0.13)
        + fold('M566 430 L574 796 L594 792 L590 428 Z', c, 0.09)
        + seam('M328 414 L320 800', c) + seam('M572 414 L580 800', c)
        + seam('M320 800 Q450 830 580 800', c, 3, '16 12')
        + seam('M250 456 L204 356', c, 3, '10 9') + seam('M650 456 L696 356', c, 3, '10 9')
    )


def shirt(uid, c):
    e = edge(c)
    body = BODY['shirt']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<path d="M372 250 L450 302 L400 330 L356 274 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        f'<path d="M528 250 L450 302 L500 330 L544 274 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        + f'<rect x="426" y="302" width="48" height="510" fill="{shade(c, 1.06)}" stroke="{e}" stroke-width="3"/>'
        + ''.join(f'<circle cx="450" cy="{y}" r="8" fill="{shade(c, 1.32)}" stroke="{e}" stroke-width="2.5"/>'
                  for y in range(356, 800, 74))
        + f'<path d="M340 396 L406 396 L406 462 L373 480 L340 462 Z" fill="none" stroke="{e}" stroke-width="3.5"/>'
        + f'<path d="M248 458 L202 356 L238 334 L286 434 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + f'<path d="M652 458 L698 356 L662 334 L614 434 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + fold('M340 430 L334 808 L310 806 L316 428 Z', c, 0.11)
    )


def hoodie(uid, c):
    e = edge(c)
    body = BODY['hoodie']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<path d="M330 300 Q340 186 450 182 Q560 186 570 300 Q510 344 450 344 Q390 344 330 300 Z" '
        f'fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        f'<path d="M366 268 Q450 352 534 268" fill="none" stroke="{e}" stroke-width="4"/>'
        f'<path d="M372 246 Q450 316 528 246" fill="none" stroke="{e}" stroke-width="3" opacity="0.6"/>'
        f'<path d="M404 300 Q398 372 394 430" fill="none" stroke="{shade(c, 1.5)}" stroke-width="9" stroke-linecap="round"/>'
        f'<path d="M496 300 Q502 372 506 430" fill="none" stroke="{shade(c, 1.5)}" stroke-width="9" stroke-linecap="round"/>'
        f'<circle cx="394" cy="436" r="10" fill="{shade(c, 0.5)}"/><circle cx="506" cy="436" r="10" fill="{shade(c, 0.5)}"/>'
        + f'<path d="M334 610 L566 610 L550 736 L350 736 Z" fill="{shade(c, 0.93)}" stroke="{e}" stroke-width="3.5"/>'
        + f'<rect x="314" y="776" width="272" height="50" rx="7" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + ''.join(f'<line x1="{x}" y1="780" x2="{x}" y2="822" stroke="{e}" stroke-width="2" opacity="0.35"/>'
                  for x in range(330, 586, 20))
        + fold('M338 452 L332 772 L308 770 L314 450 Z', c, 0.11)
    )


def jacket(uid, c):
    e = edge(c)
    body = BODY['jacket']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<path d="M368 250 L450 336 L404 372 L348 280 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        f'<path d="M532 250 L450 336 L496 372 L552 280 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        + f'<line x1="450" y1="336" x2="450" y2="822" stroke="{shade(c, 0.45)}" stroke-width="9"/>'
        + ''.join(f'<line x1="442" y1="{y}" x2="458" y2="{y}" stroke="{shade(c, 1.4)}" stroke-width="2.5" opacity="0.8"/>'
                  for y in range(352, 820, 26))
        + f'<rect x="437" y="348" width="26" height="40" rx="7" fill="{shade(c, 1.5)}" stroke="{e}" stroke-width="2.5"/>'
        + f'<path d="M340 640 L412 640" stroke="{e}" stroke-width="7" stroke-linecap="round"/>'
        + f'<path d="M488 640 L560 640" stroke="{e}" stroke-width="7" stroke-linecap="round"/>'
        + f'<path d="M244 462 L194 358 L230 336 L278 438 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + f'<path d="M656 462 L706 358 L670 336 L622 438 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + fold('M342 440 L336 820 L312 818 L318 438 Z', c, 0.11)
    )


def trousers(uid, c):
    e = edge(c)
    body = BODY['trousers']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<rect x="300" y="258" width="300" height="60" rx="6" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        + ''.join(f'<rect x="{x}" y="252" width="13" height="72" rx="4" fill="{shade(c, 0.8)}" stroke="{e}" stroke-width="2"/>'
                  for x in (334, 443, 552))
        + f'<circle cx="450" cy="288" r="9" fill="{shade(c, 1.35)}" stroke="{e}" stroke-width="2.5"/>'
        + f'<path d="M450 320 Q470 384 462 448" fill="none" stroke="{e}" stroke-width="3.5" stroke-dasharray="12 9"/>'
        + f'<path d="M302 336 Q350 382 372 336" fill="none" stroke="{e}" stroke-width="3.5"/>'
        + f'<path d="M598 336 Q550 382 528 336" fill="none" stroke="{e}" stroke-width="3.5"/>'
        + fold('M352 452 L374 1056 L336 1058 L318 450 Z', c, 0.12)
        + fold('M544 452 L580 1056 L544 1058 L524 450 Z', c, 0.08)
        + seam('M318 1062 L284 436', c, 3, '16 12') + seam('M582 1062 L616 436', c, 3, '16 12')
    )


def dress(uid, c):
    e = edge(c)
    body = BODY['dress']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<path d="M358 256 Q450 314 542 256 Q450 286 358 256 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="3.5"/>'
        + f'<path d="M316 508 Q450 552 584 508" fill="none" stroke="{e}" stroke-width="4"/>'
        + f'<path d="M320 526 Q450 570 580 526" fill="none" stroke="{shade(c, 1.3)}" stroke-width="2.5" stroke-dasharray="12 10"/>'
        + f'<g clip-path="url(#clip{uid})">'
        + ''.join(fold(f'M{x} 530 Q{x - 14} 800 {x - 34} 1080 L{x - 70} 1080 Q{x - 46} 796 {x - 32} 528 Z', c, 0.09)
                  for x in (400, 470, 540, 610))
        + '</g>'
        + seam('M188 1052 Q450 1114 712 1052', c, 3, '18 13')
    )


def abaya(uid, c):
    e = edge(c)
    body = BODY['abaya']
    return (
        f'<path d="{body}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        f'<line x1="450" y1="222" x2="450" y2="1112" stroke="{e}" stroke-width="4"/>'
        + f'<path d="M450 250 Q468 640 458 1108" fill="none" stroke="{shade(c, 1.35)}" stroke-width="2.5" stroke-dasharray="14 12"/>'
        + f'<path d="M302 716 L252 704" stroke="{e}" stroke-width="4"/>'
        + f'<path d="M598 716 L648 704" stroke="{e}" stroke-width="4"/>'
        + ''.join(f'<circle cx="{x}" cy="1046" r="6" fill="{shade(c, 1.5)}" opacity="0.6"/>'
                  for x in range(316, 600, 38))
        + f'<path d="M300 1010 Q450 1054 600 1010" fill="none" stroke="{shade(c, 1.45)}" stroke-width="3" opacity="0.55"/>'
        + fold('M368 330 L340 1078 L300 1072 L330 328 Z', c, 0.10)
    )


def scarf(uid, c):
    e = edge(c)
    return (
        # the loop around the neck
        f'<path d="M280 296 Q450 214 620 296 L642 400 Q450 322 258 400 Z" '
        f'fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        # one wide panel hanging from it, folded back on itself
        + f'<path d="M322 384 L578 384 L566 1030 L334 1030 Z" fill="url(#f{uid})" stroke="{e}" stroke-width="4"/>'
        + f'<path d="M448 384 L578 384 L566 1030 L452 1030 Z" fill="{shade(c, 0.88)}" stroke="{e}" stroke-width="3"/>'
        + f'<line x1="450" y1="384" x2="452" y2="1030" stroke="{e}" stroke-width="3" opacity="0.6"/>'
        + f'<g clip-path="url(#clip{uid})">'
        + ''.join(fold(f'M322 {y} L578 {y - 14} L578 {y + 18} L322 {y + 32} Z', c, 0.09)
                  for y in (500, 660, 820, 950))
        + '</g>'
        + ''.join(f'<line x1="{x}" y1="1028" x2="{x}" y2="1074" stroke="{shade(c, 0.7)}" stroke-width="5" stroke-linecap="round"/>'
                  for x in range(342, 570, 22))
    )


def cap(uid, c):
    e = edge(c)
    return (
        f'<path d="M236 706 Q236 402 450 402 Q664 402 664 706 Z" '
        f'fill="url(#f{uid})" stroke="{e}" stroke-width="4"/>'
        + ''.join(f'<path d="M450 404 Q{450 + dx} 538 {450 + dx * 2.1} 704" fill="none" '
                  f'stroke="{e}" stroke-width="3" opacity="0.6"/>' for dx in (-68, 68))
        + f'<circle cx="450" cy="408" r="14" fill="{shade(c, 0.72)}" stroke="{e}" stroke-width="3"/>'
        + f'<path d="M236 706 Q160 712 150 760 Q144 802 204 804 L696 804 Q756 802 750 760 '
          f'Q740 712 664 706 Z" fill="url(#r{uid})" stroke="{e}" stroke-width="4"/>'
        + f'<path d="M208 788 Q450 812 692 788" fill="none" stroke="{shade(c, 1.3)}" stroke-width="3" '
          f'stroke-dasharray="14 11" opacity="0.75"/>'
    )


def bag(uid, c):
    e = edge(c)
    return (
        f'<path d="M262 468 L638 468 L662 500 L636 930 Q450 962 264 930 L238 500 Z" '
        f'fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        + f'<path d="M340 468 V386 Q340 300 450 300 Q560 300 560 386 V468" fill="none" '
          f'stroke="{shade(c, 0.72)}" stroke-width="17" stroke-linecap="round"/>'
        + f'<path d="M340 468 V386 Q340 300 450 300 Q560 300 560 386 V468" fill="none" '
          f'stroke="{shade(c, 1.18)}" stroke-width="5" stroke-linecap="round" opacity="0.45"/>'
        + f'<rect x="312" y="606" width="276" height="182" rx="14" fill="{shade(c, 0.94)}" stroke="{e}" stroke-width="3.5"/>'
        + f'<line x1="312" y1="606" x2="588" y2="606" stroke="{shade(c, 0.5)}" stroke-width="8"/>'
        + f'<circle cx="588" cy="606" r="12" fill="{shade(c, 1.5)}" stroke="{e}" stroke-width="2.5"/>'
        + fold('M290 480 L286 926 L250 918 L252 476 Z', c, 0.11)
    )


def sneaker(uid, c):
    e = edge(c)
    return (
        f'<path d="{BODY["sneaker"]}" fill="url(#f{uid})" stroke="{e}" stroke-width="4" stroke-linejoin="round"/>'
        # heel counter and ankle collar
        + f'<path d="M164 862 Q166 660 268 610 Q300 690 296 862 Z" fill="{shade(c, 0.9)}" stroke="{e}" stroke-width="3.5"/>'
        # toe cap
        + f'<path d="M636 754 Q712 776 752 792 Q800 808 802 862 L640 862 Q632 802 636 754 Z" '
          f'fill="{shade(c, 0.9)}" stroke="{e}" stroke-width="3.5"/>'
        # tongue and laces across the instep
        + f'<path d="M348 646 Q420 606 470 660 L560 730 L492 782 L372 700 Z" '
          f'fill="{shade(c, 0.95)}" stroke="{e}" stroke-width="3"/>'
        + ''.join(f'<path d="M{362 + i * 48} 676 L{436 + i * 48} 726" stroke="{shade(c, 1.5)}" '
                  f'stroke-width="10" stroke-linecap="round"/>' for i in range(4))
        + ''.join(f'<circle cx="{358 + i * 48}" cy="{672 + i * 3}" r="6" fill="{shade(c, 0.45)}"/>' for i in range(4))
        + ''.join(f'<circle cx="{440 + i * 48}" cy="{730 + i * 3}" r="6" fill="{shade(c, 0.45)}"/>' for i in range(4))
        # midsole then outsole
        + f'<path d="M152 856 Q450 900 812 848 L812 908 Q450 962 152 916 Z" '
          f'fill="#f5f3ef" stroke="{shade(c, 0.6)}" stroke-width="4"/>'
        + f'<path d="M152 916 Q450 962 812 908 L812 940 Q450 994 152 948 Z" '
          f'fill="{shade(c, 0.5)}" stroke="{shade(c, 0.42)}" stroke-width="3"/>'
        + ''.join(f'<line x1="{x}" y1="{922 + (x - 200) // 22}" x2="{x}" y2="{958 + (x - 200) // 22}" '
                  f'stroke="{shade(c, 0.38)}" stroke-width="3" opacity="0.5"/>' for x in range(210, 790, 42))
    )


SHAPES = {
    'tshirt': tshirt, 'shirt': shirt, 'hoodie': hoodie, 'jacket': jacket,
    'trousers': trousers, 'dress': dress, 'abaya': abaya, 'scarf': scarf,
    'cap': cap, 'bag': bag, 'sneaker': sneaker,
}

# Where the ground shadow sits for each silhouette.
SHADOW = {
    'tshirt': (450, 962, 210, 34), 'shirt': (450, 968, 210, 34),
    'hoodie': (450, 972, 220, 34), 'jacket': (450, 970, 220, 34),
    'trousers': (450, 1094, 190, 30), 'dress': (450, 1076, 250, 36),
    'abaya': (450, 1116, 220, 32), 'scarf': (450, 1094, 170, 28),
    'cap': (450, 818, 300, 34), 'bag': (450, 962, 220, 32),
    'sneaker': (485, 962, 320, 28),
}


def product(shape, color, uid='a'):
    cx, cy, rx, ry = SHADOW[shape]
    dx, dy, sc = FIT.get(shape, (0, 0, 1.0))
    body = BODY[shape]
    tx = 450 - 450 * sc + dx
    ty = 600 - 600 * sc + dy

    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" width="{W}" height="{H}" role="img">'
        f'<defs>{BLUR}{BACKDROP}{fabric_defs(uid, color)}'
        f'<clipPath id="clip{uid}"><path d="{body}"/></clipPath></defs>'
        f'<rect width="{W}" height="{H}" fill="url(#bg)"/>'
        f'<rect width="{W}" height="{H}" fill="url(#vig)"/>'
        f'<g transform="translate({tx:.1f},{ty:.1f}) scale({sc})">'
        f'<ellipse cx="{cx}" cy="{cy}" rx="{rx}" ry="{ry}" fill="url(#sh{uid})"/>'
        f'{SHAPES[shape](uid, color)}'
        f'{volume(uid)}'
        f'</g></svg>'
    )


# ------------------------------------------------------- marketing surfaces
BRAND_DEEP = '#071229'
BRAND_MID = '#123066'
BRAND = '#1F6FEB'
BRAND_LIGHT = '#7FB3FF'


def _garment(shape, color, uid, x, y, sc, opacity=1.0):
    dx, dy, base = FIT.get(shape, (0, 0, 1.0))
    return (f'<g transform="translate({x},{y}) scale({sc})" opacity="{opacity}">'
            f'{SHAPES[shape](uid, color)}</g>')


def tile(shape, tint, uid='t', size=800):
    """A category tile: the garment in off-white on a brand-tinted ground."""
    cloth = '#f4f6fa'
    sc = 0.78
    dx, dy, fit_sc = FIT.get(shape, (0, 0, 1.0))
    # centre the silhouette in the square
    ox = size / 2 - 450 * sc + dx * sc * 0.4
    oy = size / 2 - 600 * sc + dy * sc * 0.6
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {size} {size}" width="{size}" height="{size}" role="img">'
        f'<defs>{BLUR}{fabric_defs(uid, cloth)}'
        f'<linearGradient id="tg{uid}" x1="0" y1="0" x2="0.6" y2="1">'
        f'<stop offset="0" stop-color="{shade(tint, 1.18)}"/><stop offset="1" stop-color="{shade(tint, 0.78)}"/>'
        f'</linearGradient></defs>'
        f'<rect width="{size}" height="{size}" fill="url(#tg{uid})"/>'
        f'<circle cx="{size * 0.78}" cy="{size * 0.2}" r="{size * 0.3}" fill="#ffffff" opacity="0.07"/>'
        f'<circle cx="{size * 0.16}" cy="{size * 0.9}" r="{size * 0.26}" fill="#ffffff" opacity="0.05"/>'
        f'<g transform="translate({ox:.0f},{oy:.0f}) scale({sc})">{SHAPES[shape](uid, cloth)}</g>'
        f'</svg>'
    )


def banner(key, shapes, w=1800, h=760):
    """A hero banner: brand gradient, a soft glow, a row of garments on the side."""
    uid = key.replace('-', '')
    cloth = '#eef3fb'
    parts = [
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" width="{w}" height="{h}" role="img">',
        f'<defs>{BLUR}{fabric_defs(uid, cloth)}',
        f'<linearGradient id="bg{uid}" x1="0" y1="0" x2="1" y2="1">'
        f'<stop offset="0" stop-color="{BRAND_DEEP}"/><stop offset="0.55" stop-color="{BRAND_MID}"/>'
        f'<stop offset="1" stop-color="{BRAND}"/></linearGradient>'
        f'<radialGradient id="glow{uid}" cx="0.5" cy="0.5" r="0.5">'
        f'<stop offset="0" stop-color="{BRAND_LIGHT}" stop-opacity="0.5"/>'
        f'<stop offset="1" stop-color="{BRAND_LIGHT}" stop-opacity="0"/></radialGradient></defs>',
        f'<rect width="{w}" height="{h}" fill="url(#bg{uid})"/>',
        f'<ellipse cx="{w * 0.72}" cy="{h * 0.1}" rx="{w * 0.3}" ry="{h * 0.6}" fill="url(#glow{uid})"/>',
        f'<circle cx="{w * 0.14}" cy="{h * 0.92}" r="{h * 0.34}" fill="#ffffff" opacity="0.05"/>',
    ]
    step = 250
    x0 = w - 130 - step * len(shapes)
    for i, shape in enumerate(shapes):
        parts.append(_garment(shape, cloth, uid, x0 + i * step - 260, h * 0.5 - 380, 0.62, 0.95))
    parts.append('</svg>')
    return ''.join(parts)


def promo(key, shape, c1, c2, w=1000, h=760):
    uid = key.replace('-', '')
    cloth = '#f4f7fc'
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" width="{w}" height="{h}" role="img">'
        f'<defs>{BLUR}{fabric_defs(uid, cloth)}'
        f'<linearGradient id="pg{uid}" x1="0" y1="0" x2="0.8" y2="1">'
        f'<stop offset="0" stop-color="{c1}"/><stop offset="1" stop-color="{c2}"/></linearGradient></defs>'
        f'<rect width="{w}" height="{h}" fill="url(#pg{uid})"/>'
        f'<circle cx="{w * 0.82}" cy="{h * 0.18}" r="{h * 0.34}" fill="#ffffff" opacity="0.09"/>'
        f'{_garment(shape, cloth, uid, w * 0.5 - 300, h * 0.5 - 420, 0.66, 0.95)}'
        f'</svg>'
    )
