"""Convert the client's product photos into web-ready JPGs and an image map.

Input : 29 UP Arif/Products/<NBxxxx name>/**/*.{png,jpg,jpeg}   (558 MB, square, mostly 1024px)
Output: 29 UP Arif/client-products/images/nb0002-3-1.jpg ...      (~200 KB each)
        29 UP Arif/client-products/images-map.json                 {product, variant, shot, src}
        29 UP Arif/client-products/images-report.md

Naming rule read from the client's files (2026-09-07):
    NB0002.3 WOOD.png          -> product NB0002, variant 3, shot 1
    NB0003.1 (2).png           -> variant 1, shot 2
    NB0028.1 (3) BLUSH PINK.jpg-> variant 1, shot 3
    NB0025-1 (1).png           -> variant 1, shot 1
    NB0018,2 BLACK.png         -> variant 2 (typo comma)
    1756808087780.jpg          -> unnamed: kept as product-level gallery, shot order = sort order

Flags (edit CONFIG or pass --no-crop):
    CROP_WATERMARK  trims 4% off the right and bottom edges to remove the AI sparkle
    ROTATE          per-product rotation for phone photos shot sideways (NB0028)
"""
import os, re, sys, json, glob, collections
from PIL import Image, ImageOps

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.abspath(os.path.join(HERE, '..', '..'))          # 29 UP Arif
SRC = os.path.join(ROOT, 'Products')
OUT = os.path.join(ROOT, 'client-products')
IMG_OUT = os.path.join(OUT, 'images')

CONFIG = {
    'MAX_SIDE': 1200,
    'QUALITY': 85,
    'CROP_WATERMARK': '--no-crop' not in sys.argv,
    'CROP_FRACTION': 0.04,           # right + bottom edge
    'ROTATE': {},                    # NB0028's sideways rack photos are fixed by exif_transpose alone (checked 2026-09-07)
    'SKIP_EXT': {'.heic', '.mp4', '.docx', '.xlsx'},
    # Files whose variant digits are really "variant + shot" (NB0024.11 = variant 1 shot 1)
    'SPLIT_DIGITS': {'NB0024'},
}

NAME_RE = re.compile(r'^(NB\d{4})(?:[.,\-](\d+))?(?:\s*\((\d+)\))?', re.I)

def parse(basename, product_hint):
    stem = os.path.splitext(basename)[0]
    m = NAME_RE.match(stem)
    if not m:
        return None
    prod, var, shot = m.group(1).upper(), m.group(2), m.group(3)
    if prod in CONFIG['SPLIT_DIGITS'] and var and len(var) == 2:
        var, shot = var[0], var[1]
    # "NB0018.1 WHITE1.png" style duplicates: trailing digit on the colour word = shot 2
    if var and not shot and re.search(r'[A-Za-z]\d$', stem):
        shot = '2'
    return {'product': prod, 'variant': int(var) if var else None, 'shot': int(shot) if shot else 1}

def main():
    os.makedirs(IMG_OUT, exist_ok=True)
    entries = []
    unnamed_counter = collections.Counter()
    report = collections.OrderedDict()

    for folder in sorted(os.listdir(SRC)):
        fpath = os.path.join(SRC, folder)
        if not os.path.isdir(fpath):
            continue
        prod = folder.split()[0].upper()
        files = sorted(f for f in glob.glob(os.path.join(fpath, '**', '*'), recursive=True)
                       if os.path.isfile(f) and os.path.splitext(f)[1].lower() not in CONFIG['SKIP_EXT']
                       and os.path.splitext(f)[1].lower() in ('.png', '.jpg', '.jpeg'))
        seen_keys = set()
        rep = {'files': len(files), 'converted': 0, 'unnamed': 0, 'dupes': 0, 'errors': []}
        for f in files:
            base = os.path.basename(f)
            info = parse(base, prod)
            if not info or info['product'] != prod:
                unnamed_counter[prod] += 1
                info = {'product': prod, 'variant': None, 'shot': unnamed_counter[prod]}
                rep['unnamed'] += 1
            key = (info['product'], info['variant'], info['shot'])
            while key in seen_keys:                       # .jpg + .png of the same shot
                rep['dupes'] += 1
                info['shot'] += 1
                key = (info['product'], info['variant'], info['shot'])
            seen_keys.add(key)
            out_name = f"{prod.lower()}-{info['variant'] if info['variant'] is not None else 'g'}-{info['shot']}.jpg"
            out_path = os.path.join(IMG_OUT, out_name)
            try:
                with Image.open(f) as im:
                    im = ImageOps.exif_transpose(im)
                    if im.mode in ('RGBA', 'P', 'LA'):
                        bg = Image.new('RGB', im.size, (255, 255, 255))
                        bg.paste(im.convert('RGBA'), mask=im.convert('RGBA').split()[-1])
                        im = bg
                    else:
                        im = im.convert('RGB')
                    if prod in CONFIG['ROTATE']:
                        im = im.rotate(CONFIG['ROTATE'][prod], expand=True)
                    if CONFIG['CROP_WATERMARK']:
                        w, h = im.size
                        im = im.crop((0, 0, int(w * (1 - CONFIG['CROP_FRACTION'])), int(h * (1 - CONFIG['CROP_FRACTION']))))
                    im.thumbnail((CONFIG['MAX_SIDE'], CONFIG['MAX_SIDE']), Image.LANCZOS)
                    im.save(out_path, 'JPEG', quality=CONFIG['QUALITY'], optimize=True, progressive=True)
                entries.append({'file': out_name, 'product': prod, 'variant': info['variant'], 'shot': info['shot'],
                                'src': os.path.relpath(f, SRC).replace(os.sep, '/'),
                                'bytes': os.path.getsize(out_path)})
                rep['converted'] += 1
            except Exception as e:
                rep['errors'].append(f'{base}: {e}')
        report[prod] = rep

    entries.sort(key=lambda e: (e['product'], e['variant'] if e['variant'] is not None else 999, e['shot']))
    json.dump({'config': {k: (sorted(v) if isinstance(v, set) else v) for k, v in CONFIG.items()}, 'images': entries},
              open(os.path.join(OUT, 'images-map.json'), 'w', encoding='utf8'), indent=1, ensure_ascii=False)

    total = sum(e['bytes'] for e in entries)
    lines = [f'# Image build report', '', f'{len(entries)} images, {total/1e6:.1f} MB total, crop watermark = {CONFIG["CROP_WATERMARK"]}', '',
             '| Product | files | converted | unnamed | dupes renumbered | errors |', '|---|---|---|---|---|---|']
    for p, r in report.items():
        lines.append(f"| {p} | {r['files']} | {r['converted']} | {r['unnamed']} | {r['dupes']} | {'; '.join(r['errors']) or ''} |")
    open(os.path.join(OUT, 'images-report.md'), 'w', encoding='utf8').write('\n'.join(lines) + '\n')
    print('\n'.join(lines))

if __name__ == '__main__':
    main()
