/**
 * Fetch the reference site's home page and turn it into a section-by-section
 * outline we can rebuild in Divi.
 *
 * The site runs Shopify, which wraps every content block in
 * <div id="shopify-section-template--NNN__<section-type>">. That id carries the
 * section TYPE and, crucially, the order the merchant arranged them in — a far
 * more reliable read of the layout than guessing from rendered boxes.
 *
 * Writes:
 *   home.html     raw page, for reference
 *   outline.json  ordered sections with headings, copy, images, links
 */
import fs from 'node:fs';
import path from 'node:path';

const DIR = import.meta.dirname;
const URL_ = 'https://www.niswafashion.com/';

const res = await fetch(URL_, { headers: { 'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)' } });
const html = await res.text();
fs.writeFileSync(path.join(DIR, 'home.html'), html);
console.log(`fetched ${res.status}, ${html.length} bytes -> home.html`);

// Split on the top-level shopify-section wrappers, keeping document order.
// Both tags matter: the chrome (announcement bar, header, footer, cookie
// banner) uses <div>, while every body section uses <section>. Matching only
// <div> finds the chrome and misses the entire page.
const marker = /<(?:div|section)[^>]*\bid="shopify-section-([^"]+)"[^>]*>/g;
const starts = [];
let m;
while ((m = marker.exec(html))) starts.push({ id: m[1], index: m.index });

const strip = (s) =>
  s.replace(/<script[\s\S]*?<\/script>/gi, ' ')
    .replace(/<style[\s\S]*?<\/style>/gi, ' ')
    .replace(/<noscript[\s\S]*?<\/noscript>/gi, ' ');

const text = (s) =>
  strip(s).replace(/<[^>]+>/g, ' ')
    .replace(/&nbsp;/g, ' ').replace(/&amp;/g, '&').replace(/&#39;/g, "'")
    .replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>')
    .replace(/\s+/g, ' ').trim();

const sections = [];
for (let i = 0; i < starts.length; i++) {
  const from = starts[i].index;
  const to = i + 1 < starts.length ? starts[i + 1].index : html.length;
  const block = html.slice(from, to);
  const clean = strip(block);

  // Section type is the part after the last "__"
  const type = starts[i].id.includes('__') ? starts[i].id.split('__').pop() : starts[i].id;

  const headings = [...clean.matchAll(/<h([1-6])[^>]*>([\s\S]*?)<\/h\1>/gi)]
    .map((h) => ({ level: Number(h[1]), text: text(h[2]) }))
    .filter((h) => h.text);

  const images = [...clean.matchAll(/<img[^>]+>/gi)]
    .map((tag) => {
      const src = (tag[0].match(/(?:data-src|src)="([^"]+)"/) || [])[1] || '';
      const alt = (tag[0].match(/alt="([^"]*)"/) || [])[1] || '';
      return { src: src.startsWith('//') ? 'https:' + src : src, alt };
    })
    .filter((i2) => i2.src && !/^data:/.test(i2.src));

  const links = [...clean.matchAll(/<a[^>]+href="([^"]+)"[^>]*>([\s\S]*?)<\/a>/gi)]
    .map((a) => ({ href: a[1], label: text(a[2]) }))
    .filter((a) => a.label && a.label.length < 60);

  const buttons = links.filter((l) => /shop|view|discover|explore|browse|all/i.test(l.label));

  sections.push({
    order: i + 1,
    type,
    id: starts[i].id,
    bytes: block.length,
    headings: headings.slice(0, 6),
    textSample: text(clean).slice(0, 260),
    imageCount: images.length,
    images: images.slice(0, 6),
    linkCount: links.length,
    buttons: buttons.slice(0, 6),
  });
}

fs.writeFileSync(path.join(DIR, 'outline.json'), JSON.stringify({ url: URL_, sections }, null, 1));

console.log(`\nsections found: ${sections.length}\n`);
for (const s of sections) {
  const h = s.headings[0] ? ` | "${s.headings[0].text.slice(0, 50)}"` : '';
  console.log(`${String(s.order).padStart(2)}. ${s.type.padEnd(26)} imgs:${String(s.imageCount).padStart(3)} links:${String(s.linkCount).padStart(3)}${h}`);
}
console.log('\nwrote outline.json');
