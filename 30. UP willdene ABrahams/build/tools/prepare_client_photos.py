"""Turn the client's photos (client-assets/2026-09-26) into web copies in emma-core/assets/img.

Run: python build/tools/prepare_client_photos.py
Straightens the tilted horizon, crops each photo to the slot it fills, and rebuilds the favicon
without the transparency checkerboard that is saved into IMG_9719.png.
"""
import os

import numpy as np
from PIL import Image, ImageOps

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SRC = os.path.join(ROOT, 'client-assets', '2026-09-26', 'photos-and-policy')
OUT = os.path.join(ROOT, 'build', 'emma-core', 'assets', 'img')


def load(name):
    return ImageOps.exif_transpose(Image.open(os.path.join(SRC, name)))


def crop_ratio(im, ratio, cx=0.5, cy=0.5):
    """Largest crop with width/height = ratio, centred on (cx, cy) as fractions of the image."""
    w, h = im.size
    if w / h > ratio:
        nw, nh = round(h * ratio), h
    else:
        nw, nh = w, round(w / ratio)
    left = min(max(round(cx * w - nw / 2), 0), w - nw)
    top = min(max(round(cy * h - nh / 2), 0), h - nh)
    return im.crop((left, top, left + nw, top + nh))


def straighten(im, degrees):
    """Rotate, then cut away the empty corners the rotation leaves."""
    w, h = im.size
    rot = im.rotate(degrees, resample=Image.BICUBIC, expand=False)
    a = abs(np.radians(degrees))
    # Largest axis-aligned rectangle inside the rotated frame (same aspect as the source).
    scale = 1 / (np.cos(a) + max(w / h, h / w) * np.sin(a))
    nw, nh = int(w * scale), int(h * scale)
    return rot.crop(((w - nw) // 2, (h - nh) // 2, (w + nw) // 2, (h + nh) // 2))


def save_jpg(im, name, max_w):
    im = im.convert('RGB')
    if im.width > max_w:
        im = im.resize((max_w, round(im.height * max_w / im.width)), Image.LANCZOS)
    im.save(os.path.join(OUT, name), quality=82, optimize=True, progressive=True)
    print(name, im.size)


def favicon():
    """IMG_9719 is an orange sunflower drawn over a grey checkerboard that was saved into the pixels.
    The checkerboard is neutral grey and the flower is strongly coloured, so the colour strength
    (max - min channel) gives a clean alpha, and every pixel gets the pure flower colour."""
    px = np.asarray(load('IMG_9719.png').convert('RGB')).astype(float)
    chroma = px.max(axis=2) - px.min(axis=2)
    solid = chroma > 150
    colour = np.median(px[solid], axis=0)
    full = np.median(chroma[solid])
    alpha = np.clip((chroma - 25) / (full - 25), 0, 1)
    rgba = np.zeros(px.shape[:2] + (4,), dtype=np.uint8)
    rgba[..., :3] = colour.round().astype(np.uint8)
    rgba[..., 3] = (alpha * 255).round().astype(np.uint8)
    icon = Image.fromarray(rgba, 'RGBA')
    icon = icon.crop(icon.getchannel('A').point(lambda v: 255 if v > 40 else 0).getbbox())
    side = round(max(icon.size) * 1.06)
    canvas = Image.new('RGBA', (side, side), (0, 0, 0, 0))
    canvas.paste(icon, ((side - icon.width) // 2, (side - icon.height) // 2))
    canvas.resize((512, 512), Image.LANCZOS).save(os.path.join(OUT, 'emma-favicon.png'), optimize=True)
    print('emma-favicon.png (512, 512), colour #%02X%02X%02X' % tuple(int(c) for c in colour))


def main():
    # Home, wide band: sun over the golden field. Horizon measured at about -1.4 degrees.
    save_jpg(straighten(load('IMG_9714.png'), -1.4), 'emma-field-sunset.jpg', 1600)
    # Home, intro (4:5 slot): sunflower against the sunlit wall; the flower sits left of centre.
    save_jpg(crop_ratio(load('IMG_9716.png'), 4 / 5, cx=0.42), 'emma-sunflower-wall.jpg', 1000)
    # Home, intro (16:10 slot): working at the desk by the window.
    save_jpg(crop_ratio(load('IMG_9713.png'), 16 / 10, cy=0.45), 'emma-desk.jpg', 1536)
    # Hero + CTA: their own sunflower cut-out (real transparency), trimmed to the flower.
    flower = load('IMG_9715.png')
    flower = flower.crop(flower.getchannel('A').getbbox())
    flower.thumbnail((900, 900), Image.LANCZOS)
    # 256-colour palette with alpha: about 150 KB instead of 780 KB, no visible change on cream.
    flower = flower.convert('RGBA').quantize(colors=256, method=Image.Quantize.FASTOCTREE, dither=Image.Dither.FLOYDSTEINBERG)
    flower.save(os.path.join(OUT, 'emma-sunflower-cutout.png'), optimize=True)
    print('emma-sunflower-cutout.png', flower.size)
    favicon()


if __name__ == '__main__':
    main()
