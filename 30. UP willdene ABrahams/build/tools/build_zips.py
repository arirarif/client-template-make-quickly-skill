"""Packs the theme and the plugin into build/dist/*.zip for upload to WordPress.

Run from the project folder:  python build/tools/build_zips.py
Uses forward slashes inside the zip (Windows' Compress-Archive writes
backslashes, which break on Linux hosts).
"""
import os
import zipfile

BUILD = os.path.join(os.path.dirname(__file__), '..')
DIST = os.path.join(BUILD, 'dist')
os.makedirs(DIST, exist_ok=True)

for name in ('emma-child', 'emma-core'):
    src = os.path.join(BUILD, name)
    out = os.path.join(DIST, name + '.zip')
    count = 0
    with zipfile.ZipFile(out, 'w', zipfile.ZIP_DEFLATED) as z:
        for root, dirs, files in os.walk(src):
            dirs[:] = [d for d in dirs if not d.startswith('.')]
            for f in files:
                if f.startswith('.') or f.endswith(('.map', '.log')):
                    continue
                full = os.path.join(root, f)
                arc = name + '/' + os.path.relpath(full, src).replace(os.sep, '/')
                z.write(full, arc)
                count += 1
    print('%s  %d files  %.1f KB' % (os.path.relpath(out, BUILD), count, os.path.getsize(out) / 1024))
