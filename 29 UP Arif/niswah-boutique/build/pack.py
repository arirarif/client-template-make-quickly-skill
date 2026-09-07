"""Package the Niswah Boutique child theme into an installable WordPress zip.

Replaces the ZipArchive route in pack.ps1: on 2026-09-04 and again on
2026-09-07 WordPress rejected zips written by System.IO.Compression with
"The theme is missing the style.css stylesheet" while zips written by
Python's zipfile with explicit directory entries installed fine.

Usage:  python build/pack.py            (from the theme folder's parent or anywhere)
"""
import os, re, sys, zipfile

HERE = os.path.dirname(os.path.abspath(__file__))
THEME = os.path.dirname(HERE)                       # .../niswah-boutique
NAME = os.path.basename(THEME)
OUT = os.path.join(os.path.dirname(THEME), NAME + '.zip')

style = open(os.path.join(THEME, 'style.css'), encoding='utf8').read()
funcs = open(os.path.join(THEME, 'functions.php'), encoding='utf8').read()
sv = re.search(r'^\s*Version:\s*([0-9.]+)', style, re.M).group(1)
fv = re.search(r"NB_THEME_VERSION',\s*'([0-9.]+)'", funcs).group(1)
if sv != fv:
    sys.exit(f'Version mismatch: style.css {sv} vs functions.php {fv}. Bump both.')

if os.path.exists(OUT):
    os.remove(OUT)
count = 0
with zipfile.ZipFile(OUT, 'w', zipfile.ZIP_DEFLATED) as z:
    z.writestr(zipfile.ZipInfo(NAME + '/'), '')
    for d, dirs, files in os.walk(THEME):
        dirs[:] = sorted(x for x in dirs if x != 'build')
        rel = os.path.relpath(d, THEME).replace(os.sep, '/')
        if rel != '.':
            z.writestr(zipfile.ZipInfo(f'{NAME}/{rel}/'), '')
        for f in sorted(files):
            arc = f'{NAME}/{f}' if rel == '.' else f'{NAME}/{rel}/{f}'
            z.write(os.path.join(d, f), arc)
            count += 1
print(f'Packed {NAME} v{sv} -> {OUT} ({os.path.getsize(OUT)} bytes, {count} files)')
