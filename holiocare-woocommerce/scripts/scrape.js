const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');
const path = require('path');

const SITE_URL = 'https://holiocare.com';
const PAGES_TO_SCRAPE = ['/', '/shop/', '/about/', '/about-us/'];
const DELAY_BETWEEN_REQUESTS_MS = 800;

const OUTPUT_DIR = path.join(__dirname, '..', 'assets', 'data');
const IMAGES_DIR = path.join(__dirname, '..', 'assets', 'images');

if (!fs.existsSync(OUTPUT_DIR)) fs.mkdirSync(OUTPUT_DIR, { recursive: true });
if (!fs.existsSync(IMAGES_DIR)) fs.mkdirSync(IMAGES_DIR, { recursive: true });

const delay = (ms) => new Promise((res) => setTimeout(res, ms));

async function scrapePage(url) {
  const { data } = await axios.get(url, {
    headers: { 'User-Agent': 'Mozilla/5.0 (compatible; research-bot/1.0)' },
    timeout: 10000,
  });
  return cheerio.load(data);
}

async function run() {
  const results = {};
  const allImages = [];

  for (const page of PAGES_TO_SCRAPE) {
    const url = SITE_URL + page;
    console.log(`Scraping: ${url}`);
    try {
      const $ = await scrapePage(url);

      // Extract text content
      results[page] = {
        title: $('title').text().trim(),
        metaDescription: $('meta[name="description"]').attr('content') || '',
        h1: $('h1').map((_, el) => $(el).text().trim()).get(),
        h2: $('h2').map((_, el) => $(el).text().trim()).get(),
        paragraphs: $('p').map((_, el) => $(el).text().trim()).get().filter(t => t.length > 30),
        ctaButtons: $('a.button, .wc-forward, .btn, [class*="cta"]')
          .map((_, el) => ({ text: $(el).text().trim(), href: $(el).attr('href') }))
          .get(),
      };

      // Extract images
      $('img').each((_, el) => {
        const src = $(el).attr('src') || $(el).attr('data-src') || $(el).attr('data-lazy-src');
        const alt = $(el).attr('alt') || '';
        if (src && src.startsWith('http')) allImages.push({ src, alt, page });
      });

    } catch (err) {
      console.error(`Failed: ${url} — ${err.message}`);
    }

    await delay(DELAY_BETWEEN_REQUESTS_MS);
  }

  fs.writeFileSync(
    path.join(OUTPUT_DIR, 'scraped-content.json'),
    JSON.stringify(results, null, 2)
  );

  fs.writeFileSync(
    path.join(OUTPUT_DIR, 'image-urls.txt'),
    allImages.map(i => i.src).join('\n')
  );

  console.log(`\nDone. Content saved to assets/data/scraped-content.json`);
  console.log(`Images list saved to assets/data/image-urls.txt`);
  console.log(`Total images found: ${allImages.length}`);
}

run();
