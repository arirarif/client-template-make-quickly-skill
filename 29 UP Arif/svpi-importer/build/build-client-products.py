"""Build svpi-importer/products.json from the client's spreadsheet + photos.

Inputs
  29 UP Arif/Products/website.xlsx           sheet "PRODUCTS LISTING"
  29 UP Arif/client-products/images-map.json from build-client-images.py

Outputs
  29 UP Arif/client-products/products.json   importer file (WooCommerce → Import Products (SVPI))
  29 UP Arif/client-products/build-report.md what was built, what is pending, what to ask
  29 UP Arif/client-products/descriptions-ar.json  Arabic text the client supplied (NB0020, NB0022)

Per-product decisions live in PRODUCTS below. Everything the client still has to
answer is marked pending=... and such products are written to products.json with
"pending" set, and are skipped by the importer unless INCLUDE_PENDING is true.

Run:  python svpi-importer/build/build-client-products.py
"""
import os, re, sys, json, html, collections, warnings
warnings.filterwarnings('ignore')
import openpyxl

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.abspath(os.path.join(HERE, '..', '..'))
XLSX = os.path.join(ROOT, 'Products', 'website.xlsx')
OUT = os.path.join(ROOT, 'client-products')
MAP = os.path.join(OUT, 'images-map.json')

# Where build-client-images.py output will live once uploaded to the Media Library.
MEDIA_BASE = 'https://niswahboutique.com/wp-content/uploads/2026/09'
INCLUDE_PENDING = '--include-pending' in sys.argv

# ---------------------------------------------------------------------------
# Category tree (client's Sheet2, 2026-09-07). (parent, child)
# ---------------------------------------------------------------------------
PREMIUM = ('Premium', None)

PRODUCTS = {
    'NB0001': dict(name='Bamboo Jersey Arm Sleeves', cats=[('Essential', 'Arm Sleeves')]),
    'NB0002': dict(name='Bamboo Jersey Hijab', cats=[('Hijab', 'Bamboo Jersey'), PREMIUM]),
    'NB0003': dict(name='Sport Hijab', cats=[('Sports Wear', 'Sport Hijab')]),
    'NB0004': dict(name='Instant Moscrepe Hijab', cats=[('Instant Hijab', 'Moscrepe')]),
    'NB0005': dict(name='Instant Ruffle Chiffon Hijab', cats=[('Instant Hijab', 'Ruffle Chiffon')]),
    'NB0006': dict(name='Cotton Crinkle Hijab', cats=[('Hijab', 'Cotton Crinkle')],
                   pending='price missing; 38 photos without colour names'),
    'NB0007': dict(name='Modal Hijab', cats=[('Hijab', 'Modal'), PREMIUM]),
    'NB0008': dict(name='Pashmina Hijab', cats=[('Hijab', 'Pashmina')]),
    'NB0009': dict(name='Korean Chiffon Embroidered Hijab', cats=[('Hijab', 'Korean Chiffon Embroidered'), PREMIUM]),
    'NB0010': dict(name='Instant Kids Hijab – Moscrepe', cats=[('Kids', 'Hijab')],
                   colours_from_images=True, pending='price missing (19 colours found in photos)'),
    'NB0011': dict(name='One Piece Jilbab', cats=[('Prayer Essential', 'Jilbab')]),
    'NB0012': dict(name='Prayer Dress – Silk Cotton Viscose Blend', cats=[('Prayer Essential', 'Prayer Dress')],
                   pending='no photos, price missing'),
    'NB0013': dict(name='Hijab Cap', cats=[('Essential', 'Hijab Cap')]),
    'NB0014': dict(name='Hijab Mini Pins (Box of 50)', cats=[('Jewelry & Accessories', 'Mini Pins')], simple=True),
    'NB0015': dict(name='Hijab Pins (Box of 8)', cats=[('Jewelry & Accessories', 'Hijab Pins')]),
    'NB0016': dict(split=[
        dict(rows=range(1, 11), name='Magnetic Hijab Pins (2-Pack)', cats=[('Jewelry & Accessories', 'Magnetic Pins')], sku='NB0016'),
        dict(rows=range(11, 15), name='Magnetic Flower Shape Pins (2-Pack)', cats=[('Jewelry & Accessories', 'Magnetic Pins')], sku='NB0016F'),
    ]),
    'NB0017': dict(name='Magnetic Chiffon Hijab with Bamboo Jersey Cap', cats=[('Instant Hijab', 'Magnetic Chiffon')]),
    'NB0018': dict(name='Magnetic Ninja Chiffon Hijab', cats=[('Instant Hijab', 'Magnetic Ninja')]),
    'NB0019': dict(name='Plain Chiffon Hijab', cats=[('Hijab', 'Plain Chiffon')]),
    'NB0020': dict(name='Criss Cross Chiffon Hijab', cats=[('Instant Hijab', 'Criss Cross Chiffon')]),
    'NB0021': dict(name='Prayer Mat (115 × 70 cm)', cats=[('Prayer Essential', 'Prayer Matt')], simple=True),
    'NB0022': dict(split=[
        dict(rows=range(1, 10), name='Tasbeeh Prayer Beads (100 Beads)', cats=[('Prayer Essential', 'Tasbeeh - Beads')],
             sku='NB0022', colour_from_name=r'-\s*(.+)$'),
        dict(rows=[10], name='Miswak Stick', cats=[('Prayer Essential', 'Tasbeeh - Beads')], sku='NB0022M', simple=True),
    ]),
    'NB0023': dict(split=[
        dict(rows=[1], name='Long Kurti', cats=[('Modest Wear', None)], sku='NB0023K', simple=True),
        dict(rows=[2, 3, 4, 5], name='Printed Cotton Salwar Suit Set', cats=[('Modest Wear', None)], sku='NB0023S',
             size_attr=True, pending='three rows share size XXL (one priced, two out of stock): confirm which sets these are'),
        dict(rows=[6], name='Co-ord Set', cats=[('Modest Wear', None)], sku='NB0023C', simple=True,
             pending='out of stock, no price'),
    ], images_as_gallery=True),
    'NB0024': dict(name='Black Niqab', cats=[('Essential', 'Niqab')], attr_name='Style',
                   value_from_name=r'NIQAB\s*-\s*(.+)$'),
    'NB0025': dict(name='Embroidered Co-ord Set', cats=[('Modest Wear', 'Embroidered Coord Sets')],
                   colour_fix={'DUSTY': 'Dusty Pink', 'SAIGE GREEN': 'Sage Green'}),
    'NB0026': dict(name='Printed Cotton Co-ord Set', cats=[('Modest Wear', 'Printed Cotton Coord Sets')]),
    'NB0027': dict(name='Resin Quran Bookmark (4 inch)', cats=[('Gift Sets', 'Islamic Resin Art')],
                   attr_name='Design', value_seq='Design {n}', pending='10 identical rows: client to name the designs'),
    'NB0028': dict(name='Printed Signature Co-ord Set', cats=[('Modest Wear', 'Solid Coord Sets')],
                   colour_from_name=r'SET\s*-?\s*(.+?)-\s*(?:S|M|L|XL)$', size_from_sku=True),
    'NB0029': dict(name='Linen Blend Embroidered Dress', cats=[('Modest Wear', 'Embroidered Linen Dress')],
                   colour_from_name=r'FREE SIZE-\s*(.+)$'),
}

# ---------------------------------------------------------------------------
# Colour swatches. Names as the client writes them (upper-cased key).
# ---------------------------------------------------------------------------
HEX = {
 'WHITE':'#FFFFFF','OFF WHITE':'#F5F1E8','CREAM':'#F3E9D2','BEIGE':'#D9C3A5','LIGHT BEIGE':'#E6D5BC','SAND BEIGE':'#D8C3A0',
 'BLACK':'#111111','GREY':'#8A8A8A','LIGHT GREY':'#C9C9C9','DARK GREY':'#4A4A4A','CHARCOAL GREY':'#3B3B3B','CHARCOAL':'#3B3B3B',
 'ASH GREY':'#B2B2B2','SLATE GREY':'#708090','STONE GREY':'#A7A29A','PEARL GREY':'#D6D3CE','SOFT GREY':'#BFBFBF','CARCOAL GREY':'#3B3B3B',
 'CLOUD GREY':'#C8CCD0','SILVER':'#C0C0C0','DUSK GREY':'#8C8A94','GREY TONE':'#9A9A9A',
 'PINK':'#F4A6B8','SOFT PINK':'#F7C6CF','BABY PINK':'#F8C8D4','BLUSH':'#F2B8B5','BLUSH PINK':'#F2B8B5','NUDE PINK':'#E8B4A8',
 'DEEP PINK':'#D64B7A','ROSE PINK':'#E7889E','DUSTY PINK':'#D9A5A0','DUSTY ROSE':'#C98A8A','PINK BLOSSOM':'#F1B7C2','DARK PINK':'#C9457A',
 'CORAL PINK':'#F08080','CORAL PEACH':'#F5A48A','PEACH':'#F6B79C','PEACHY NUDE':'#E9B9A0','PEACHY SHADES':'#F0B49E','PEACHY SHADE':'#F0B49E',
 'TEA ROSE':'#E9A8A8','ROSEWOOD':'#9B4B4B','MAGENTA':'#B5205E','DUSTY MAUVE':'#B39BA6','MAUVE':'#B58FA7','MAUVE DUSK':'#A88CA0','DARK MAUVE':'#8E6A80',
 'NUDE':'#D9B49B','DARK NUDE':'#C69B7B','PALE NUDE':'#E9CFB8','SAND':'#D9C49B','SAND STONE':'#CBB58F','CARAMEL':'#B57A46','CAMEL':'#C19A6B',
 'BROWN':'#6B4226','KHAKI BROWN':'#8C7A5B','COCOA':'#5C3A2E','COCA':'#5C3A2E','WOOD':'#8B6B4A','OAK':'#9A7B5B','WALNUT':'#5E4634','NUTELA':'#5A3825',
 'BROW':'#6B4226','MULBERRY':'#70193D','MAROON':'#5A1A2B','RUBY RED':'#9B111E','RED':'#C21807','RUST':'#B7410E','ORANGE':'#E8772E',
 'BLUE':'#2F5DA8','NAVY BLUE':'#1F2A44','MIDNIGHT BLUE':'#191970','SKY BLUE':'#87CEEB','LIGHT BLUE':'#A8CBE8','DENIM BLUE':'#4A6FA5','DARK BLUE':'#1E3A6E','TURQUOISE':'#40B5AD',
 'VIOLET':'#7A4E9B','LAVENDER':'#B9A7D6','DUSTY PURPLE':'#8F7A9C',
 'GREEN':'#3C7A4E','OLIVE':'#6B7A3A','OLIVE GREEN':'#6B7A3A','SAGE':'#9CAF88','SAGE GREEN':'#9CAF88','SAGE GREE':'#9CAF88','SAIGE GREEN':'#9CAF88',
 'PISTA GREEN':'#A9C48A','DARK GREEN':'#1F4D2B','BOTTLE GREEN':'#0B3D2E','PALE YELLOW':'#F4E7A1','BUTTER YELLOW':'#F3E39A',
 'MULTICOLOR':'#D9A5A0','BLACK & WHITE':'#555555','SS':'#C0C0C0',
}

ARABIC = re.compile(r'[؀-ۿ]')
HEADINGS = re.compile(r'^(product details|why you.?ll love it|features|material and texture|design & detail|design and detail|'
                      r'fabric & comfort|style & fit|care instructions|how to use a miswak stick|key features)[:\s]*$', re.I)

def title_case(s):
    s = re.sub(r'\s+', ' ', s.strip())
    small = {'and', 'of', 'the', 'with', 'for', 'a', 'in', 'to'}
    out = []
    for i, w in enumerate(s.lower().split(' ')):
        out.append(w if (w in small and i) else w.capitalize())
    return ' '.join(out).replace('&', '&')

def desc_to_html(text, product_name):
    """Sheet description -> (short, html, arabic)."""
    if not text:
        return '', '', ''
    lines = [l.strip() for l in text.replace('\r', '').split('\n')]
    lines = [re.sub(r'[✨]', '', l).strip() for l in lines]
    ar = [l for l in lines if ARABIC.search(l)]
    en = [l for l in lines if l and not ARABIC.search(l)]
    if not en:
        return '', '', '\n'.join(ar)
    # drop a leading title line (short, no sentence punctuation) — the client's
    # descriptions open with the product name as a heading
    if en and len(en[0]) < 80 and not re.search(r'[.!?]', en[0].rstrip(':')):
        en = en[1:]
    en = [l for l in en if l.upper() != 'OUT OF STOCK']
    parts, bullets = [], []
    def flush():
        nonlocal bullets
        if bullets:
            parts.append('<ul>' + ''.join(f'<li>{html.escape(b)}</li>' for b in bullets) + '</ul>')
            bullets = []
    short = ''
    for l in en:
        b = re.match(r'^[\*\-•]\s*(.+)$', l)
        if b:
            bullets.append(b.group(1)); continue
        flush()
        if HEADINGS.match(l) or (l.endswith(':') and len(l) < 40):
            parts.append(f'<h3>{html.escape(l.rstrip(":"))}</h3>')
        else:
            # "Fabric: 100% Bamboo" style lines inside a details block become bullets
            if re.match(r'^[A-Z][A-Za-z &/]{2,30}:\s*\S', l) and parts and parts[-1].startswith('<h3>'):
                bullets.append(l); continue
            parts.append(f'<p>{html.escape(l)}</p>')
            if not short:
                short = l
    flush()
    return short, '\n'.join(parts), '\n'.join(ar)

def load_rows():
    ws = openpyxl.load_workbook(XLSX, data_only=True)['PRODUCTS LISTING']
    rows = []
    for r in ws.iter_rows(min_row=3, values_only=True):
        inv = r[2]
        if not inv or not str(inv).strip().upper().startswith('NB'):
            continue
        rows.append(dict(inv=str(inv).strip(), cat=(r[3] or '').strip(), name=(r[4] or '').strip(), desc=(r[5] or '') if isinstance(r[5], str) else '',
                         color=(r[6].strip() if isinstance(r[6], str) else ''), size=(str(r[7]).strip() if r[7] is not None else ''),
                         price=r[8]))
    return rows

def variant_num(inv):
    m = re.match(r'NB\d{4}\.(\d+)', inv)
    return int(m.group(1)) if m else None

def size_from_sku(inv):
    m = re.search(r'\((\w+)\)$', inv)
    return m.group(1).upper() if m else None

def main():
    rows = load_rows()
    imgmap = json.load(open(MAP, encoding='utf8'))['images'] if os.path.exists(MAP) else []
    by_prod = collections.defaultdict(list)
    for r in rows:
        by_prod[r['inv'][:6]].append(r)
    imgs_by = collections.defaultdict(list)
    for e in imgmap:
        imgs_by[e['product']].append(e)

    products, report, unknown_colours, ar_texts = [], [], set(), {}

    def img_url(e):
        return f"{MEDIA_BASE}/{e['file']}"

    def images_for(pid, variant):
        v = sorted([e for e in imgs_by[pid] if e['variant'] == variant], key=lambda e: e['shot'])
        return v

    def gallery_for(pid):
        return sorted([e for e in imgs_by[pid] if e['variant'] is None], key=lambda e: e['shot'])

    def build(pid, cfg, prows):
        name = cfg['name']
        sku = cfg.get('sku', pid)
        first = prows[0] if prows else None
        short, desc_html, ar = desc_to_html(first['desc'] if first else '', name)
        if ar:
            ar_texts[sku] = ar
        # size / dimension line from the sheet if the description lacks it
        dim = first['size'] if first else ''
        if dim and re.search(r'\d+\s*[xX×]\s*\d+', dim) and 'Size:' not in desc_html and 'size' not in desc_html.lower():
            desc_html += f'\n<p><strong>Size:</strong> {html.escape(dim.replace("X", "×").replace("x", "×"))}</p>'
        cats = [{'name': p} if c is None else {'name': c, 'parent': p} for p, c in cfg['cats']]
        # make sure parents are declared before children for the importer
        ordered = []
        for c in cats:
            if 'parent' in c and {'name': c['parent']} not in ordered and {'name': c['parent']} not in cats:
                ordered.append({'name': c['parent']})
            ordered.append(c)
        cats = ordered
        prod = dict(name=name, sku=sku, type='simple' if cfg.get('simple') else 'variable', categories=cats, tags=[],
                    short_description=short, description_html=desc_html)
        if cfg.get('pending'):
            prod['pending'] = cfg['pending']
        gallery = [img_url(e) for e in gallery_for(pid)]
        if cfg.get('images_as_gallery'):
            gallery = [img_url(e) for e in sorted(imgs_by[pid], key=lambda e: (e['variant'] or 0, e['shot']))]

        if prod['type'] == 'simple':
            r = prows[0]
            prod['regular_price'] = str(int(r['price'])) if r['price'] else ''
            if str(r['desc']).strip().upper() == 'OUT OF STOCK':
                prod['stock_quantity'] = 0
            vimgs = images_for(pid, variant_num(r['inv'])) or images_for(pid, None)
            if vimgs and not gallery:
                gallery = [img_url(e) for e in vimgs]
            if not gallery:
                gallery = [img_url(e) for e in sorted(imgs_by[pid], key=lambda e: e['shot'])[:6]]
            prod['gallery_images'] = gallery
            products.append(prod)
            report.append((pid, name, 'simple', 1, len(gallery), cfg.get('pending', '')))
            return

        attr_name = cfg.get('attr_name', 'Color')
        options, variations, seen = [], [], set()
        if cfg.get('colours_from_images'):
            # NB0010: the sheet has one row; colour names live in the photo filenames
            r = prows[0]
            for e in sorted(imgs_by[pid], key=lambda e: (e['variant'] or 0, e['shot'])):
                if e['variant'] is None or e['shot'] != 1:
                    continue
                cname = re.sub(r'^NB\d{4}[.,\-]\d+\s*', '', os.path.splitext(os.path.basename(e['src']))[0])
                cname = re.sub(r'\s*\(\d\)|\s+\d$', '', cname).strip() or f'Colour {e["variant"]}'
                cname = title_case(cname)
                if cname in seen: continue
                seen.add(cname)
                options.append({'value': cname, 'color_code': HEX.get(cname.upper(), '#CCCCCC')})
                if cname.upper() not in HEX: unknown_colours.add(cname)
                variations.append(dict(sku=f'{pid}.{e["variant"]}', regular_price=str(int(r['price'])) if r['price'] else '', sale_price='',
                                       in_stock=True, attributes={attr_name: cname}, image_url=img_url(e),
                                       gallery_images=[img_url(x) for x in images_for(pid, e['variant'])[1:]]))
        else:
            size_values = []
            for n, r in enumerate(prows, 1):
                vn = variant_num(r['inv'])
                value = None
                if cfg.get('value_seq'):
                    value = cfg['value_seq'].format(n=n)
                elif cfg.get('value_from_name'):
                    m = re.search(cfg['value_from_name'], r['name'], re.I); value = m.group(1) if m else r['name']
                elif cfg.get('colour_from_name'):
                    m = re.search(cfg['colour_from_name'], r['name'], re.I); value = m.group(1) if m else (r['color'] or r['name'])
                else:
                    value = r['color'] or r['size'] or f'Option {n}'
                value = cfg.get('colour_fix', {}).get(value.strip().upper(), value)
                value = title_case(value)
                size = size_from_sku(r['inv']) if cfg.get('size_from_sku') else (r['size'].upper() if cfg.get('size_attr') else None)
                if size in ('MEDIUM',): size = 'M'
                if value not in seen:
                    seen.add(value)
                    opt = {'value': value}
                    if attr_name == 'Color':
                        opt['color_code'] = HEX.get(value.upper(), '#CCCCCC')
                        if value.upper() not in HEX: unknown_colours.add(value)
                    options.append(opt)
                if size and size not in size_values: size_values.append(size)
                vimgs = images_for(pid, vn)
                attrs = {attr_name: value}
                if size: attrs['Size'] = size
                vsku = r['inv'].replace(' (', '-').replace(')', '')
                variations.append(dict(sku=vsku, regular_price=str(int(r['price'])) if r['price'] else '', sale_price='',
                                       in_stock=str(r['desc']).strip().upper() != 'OUT OF STOCK' and bool(r['price']),
                                       attributes=attrs, image_url=img_url(vimgs[0]) if vimgs else '',
                                       gallery_images=[img_url(e) for e in vimgs[1:]]))
            if size_values:
                order = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL']
                size_values.sort(key=lambda s: order.index(s) if s in order else 99)
        attrs_out = [{'name': attr_name, 'slug': attr_name.lower(), 'type': 'color' if attr_name == 'Color' else 'button', 'options': options}]
        if any('Size' in v['attributes'] for v in variations):
            sizes = []
            for v in variations:
                s = v['attributes'].get('Size')
                if s and s not in sizes: sizes.append(s)
            order = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL']
            sizes.sort(key=lambda s: order.index(s) if s in order else 99)
            attrs_out.append({'name': 'Size', 'slug': 'size', 'type': 'button', 'options': [{'value': s} for s in sizes]})
        prod['attributes'] = attrs_out
        # The importer uses the first gallery image as the parent's featured
        # image; without one the shop card is blank (seen 2026-09-07, fixed by
        # REST afterwards). Fall back to the first variation photo.
        if not gallery:
            first = next((v['image_url'] for v in variations if v.get('image_url')), '')
            if first:
                gallery = [first]
        prod['gallery_images'] = gallery
        prod['variations'] = variations
        products.append(prod)
        missing_img = sum(1 for v in variations if not v['image_url'])
        report.append((pid, name, f'variable ({attr_name}{" × Size" if len(attrs_out) > 1 else ""})', len(variations),
                       sum(1 for v in variations if v['image_url']) + len(gallery), (cfg.get('pending', '') + (f'; {missing_img} variants without image' if missing_img else '')).strip('; ')))

    for pid in sorted(PRODUCTS):
        cfg = PRODUCTS[pid]
        prows = by_prod.get(pid, [])
        if 'split' in cfg:
            for part in cfg['split']:
                sel = [r for r in prows if variant_num(r['inv']) in set(part['rows'])]
                c = dict(part); c.setdefault('images_as_gallery', cfg.get('images_as_gallery', False))
                build(pid, c, sel)
        else:
            build(pid, cfg, prows)

    final = [p for p in products if INCLUDE_PENDING or not p.get('pending')]
    out = dict(source='Client spreadsheet Products/website.xlsx + Products/ photos, 2026-09-07',
               generated_by='svpi-importer/build/build-client-products.py', currency='QAR', products=final)
    os.makedirs(OUT, exist_ok=True)
    json.dump(out, open(os.path.join(OUT, 'products.json'), 'w', encoding='utf8'), indent=1, ensure_ascii=False)
    json.dump(ar_texts, open(os.path.join(OUT, 'descriptions-ar.json'), 'w', encoding='utf8'), indent=1, ensure_ascii=False)

    nvar = sum(len(p.get('variations', [])) for p in final)
    lines = ['# Product build report', '',
             f'{len(final)} products written ({len(products) - len(final)} pending, not written), {nvar} variations, media base {MEDIA_BASE}', '',
             '| ID | Product | Type | Variants | Images | Pending / notes |', '|---|---|---|---|---|---|']
    for r in report:
        lines.append('| ' + ' | '.join(str(x) for x in r) + ' |')
    lines += ['', f'Unknown colour names (grey swatch used): {", ".join(sorted(unknown_colours)) or "none"}',
              f'Arabic descriptions captured: {", ".join(ar_texts) or "none"}']
    open(os.path.join(OUT, 'build-report.md'), 'w', encoding='utf8').write('\n'.join(lines) + '\n')
    print('\n'.join(lines))

if __name__ == '__main__':
    main()
