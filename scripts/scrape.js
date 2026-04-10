/**
 * scrape.js
 * Scrapes text content + image URLs from a client website.
 * Saves content as JSON and downloads all images.
 *
 * Usage:
 *   npm install
 *   node scrape.js
 *   node scrape.js https://example.com   ← override site URL from CLI
 */

const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');
const path = require('path');
const https = require('https');
const http = require('http');

// ─── CONFIG ────────────────────────────────────────────────────────────────
const SITE_URL = process.argv[2] || 'https://wellnessjunkiez.com';

const PAGES_TO_SCRAPE = [
  '/',
  '/about-us/',
  '/shop/',
];

const OUTPUT_DIR   = path.join(__dirname, '..', 'assets');
const IMAGES_DIR   = path.join(OUTPUT_DIR, 'images');
const DATA_DIR     = path.join(OUTPUT_DIR, 'data');

const REQUEST_HEADERS = {
  'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120 Safari/537.36',
  'Accept-Language': 'en-US,en;q=0.9',
};

const DELAY_BETWEEN_REQUESTS_MS = 800; // be polite to the server
// ───────────────────────────────────────────────────────────────────────────

// Create output folders
[IMAGES_DIR, DATA_DIR].forEach(dir => fs.mkdirSync(dir, { recursive: true }));

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function fetchPage(url) {
  const response = await axios.get(url, {
    headers: REQUEST_HEADERS,
    timeout: 20000,
  });
  return response.data;
}

/** Download a single image to disk */
function downloadImage(imageUrl, filepath) {
  return new Promise((resolve, reject) => {
    const proto = imageUrl.startsWith('https') ? https : http;
    const file = fs.createWriteStream(filepath);

    proto.get(imageUrl, { headers: REQUEST_HEADERS }, (res) => {
      if (res.statusCode !== 200) {
        file.close();
        fs.unlink(filepath, () => {});
        return reject(new Error(`HTTP ${res.statusCode}`));
      }
      res.pipe(file);
      file.on('finish', () => { file.close(); resolve(); });
    }).on('error', (err) => {
      file.close();
      fs.unlink(filepath, () => {});
      reject(err);
    });
  });
}

/** Turn an image URL into a safe local filename */
function toFilename(imageUrl) {
  // Remove query params, grab last path segment, sanitize
  return imageUrl.split('?')[0].split('/').pop().replace(/[^a-zA-Z0-9._-]/g, '_') || 'image.png';
}

/** Resolve a potentially relative URL to absolute */
function toAbsolute(src, base) {
  if (!src) return null;
  if (src.startsWith('data:')) return null; // skip inline base64
  if (src.startsWith('//')) return 'https:' + src;
  if (src.startsWith('http')) return src;
  return base.replace(/\/$/, '') + (src.startsWith('/') ? src : '/' + src);
}

/** Scrape a single page — returns structured content + image URLs */
async function scrapePage(pageUrl) {
  console.log(`\n  Fetching: ${pageUrl}`);
  const html = await fetchPage(pageUrl);
  const $ = cheerio.load(html);

  const content = {
    url: pageUrl,
    title: $('title').text().trim(),
    metaDescription: $('meta[name="description"]').attr('content') || '',
    headings: [],
    paragraphs: [],
    ctaButtons: [],
    links: [],
    imageUrls: [],
  };

  // Headings
  $('h1, h2, h3, h4').each((_, el) => {
    const text = $(el).text().trim().replace(/\s+/g, ' ');
    if (text) content.headings.push({ tag: el.tagName, text });
  });

  // Paragraphs (only meaningful ones)
  $('p').each((_, el) => {
    const text = $(el).text().trim().replace(/\s+/g, ' ');
    if (text.length > 30) content.paragraphs.push(text);
  });

  // Buttons / CTAs
  $('a.button, .wp-block-button a, button, [class*="btn"]').each((_, el) => {
    const text = $(el).text().trim();
    const href = $(el).attr('href') || '';
    if (text) content.ctaButtons.push({ text, href });
  });

  // All links
  $('a[href]').each((_, el) => {
    const href = $(el).attr('href');
    const text = $(el).text().trim().replace(/\s+/g, ' ');
    if (href && text && href.startsWith('http')) {
      content.links.push({ text, href });
    }
  });

  // Images — check multiple possible attributes (lazy loading)
  const imgAttrs = ['src', 'data-src', 'data-lazy-src', 'data-original'];
  const foundUrls = new Set();

  $('img').each((_, el) => {
    for (const attr of imgAttrs) {
      const raw = $(el).attr(attr);
      const abs = toAbsolute(raw, SITE_URL);
      if (abs && !foundUrls.has(abs)) {
        // Strip WordPress resize params to get full-resolution version
        const cleaned = abs.split('?')[0];
        foundUrls.add(cleaned);
      }
    }
  });

  content.imageUrls = [...foundUrls];
  return content;
}

/** Download all unique images, skip already-downloaded ones */
async function downloadAllImages(imageUrls) {
  const total = imageUrls.length;
  console.log(`\n  Downloading ${total} images...`);

  let downloaded = 0;
  let skipped = 0;
  let failed = 0;

  const failedList = [];

  for (const url of imageUrls) {
    const filename = toFilename(url);
    const filepath = path.join(IMAGES_DIR, filename);

    if (fs.existsSync(filepath)) {
      skipped++;
      continue;
    }

    try {
      await downloadImage(url, filepath);
      console.log(`    [OK] ${filename}`);
      downloaded++;
    } catch (err) {
      console.log(`    [FAIL] ${filename} — ${err.message}`);
      failed++;
      failedList.push({ url, error: err.message });
    }

    await sleep(200); // small delay per image
  }

  console.log(`\n  Images: ${downloaded} downloaded, ${skipped} skipped (already exist), ${failed} failed`);
  if (failedList.length) {
    fs.writeFileSync(
      path.join(DATA_DIR, 'failed-images.json'),
      JSON.stringify(failedList, null, 2)
    );
    console.log(`  Failed list saved → assets/data/failed-images.json`);
  }
}

async function main() {
  console.log(`\n===  Website Scraper`);
  console.log(`  Target: ${SITE_URL}`);
  console.log(`  Pages : ${PAGES_TO_SCRAPE.join(', ')}`);
  console.log(`  Output: assets/`);

  const allPageData = [];
  const allImageUrls = new Set();

  for (const page of PAGES_TO_SCRAPE) {
    const url = SITE_URL.replace(/\/$/, '') + page;
    const data = await scrapePage(url);
    allPageData.push(data);
    data.imageUrls.forEach(u => allImageUrls.add(u));
    await sleep(DELAY_BETWEEN_REQUESTS_MS);
  }

  // Save scraped text content
  const contentFile = path.join(DATA_DIR, 'scraped-content.json');
  fs.writeFileSync(contentFile, JSON.stringify(allPageData, null, 2));
  console.log(`\n  Content saved  → assets/data/scraped-content.json`);

  // Save image URL list
  const imageListFile = path.join(DATA_DIR, 'image-urls.txt');
  fs.writeFileSync(imageListFile, [...allImageUrls].join('\n'));
  console.log(`  Image list     → assets/data/image-urls.txt  (${allImageUrls.size} URLs)`);

  // Download images
  await downloadAllImages([...allImageUrls]);

  console.log('\n  All done! Check:');
  console.log('    assets/images/           ← downloaded images');
  console.log('    assets/data/             ← scraped content JSON + image URL list\n');
}

main().catch((err) => {
  console.error('\n  ERROR:', err.message);
  process.exit(1);
});
