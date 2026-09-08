#!/usr/bin/env node
// Diagnoses "Duplicate, Google chose different canonical than user" for a site.
// Usage: node scripts/canonical-audit.mjs https://www.bnbphotos.com/
//
// Checks, in order:
//   1. host/protocol variants of the homepage - do http, non-www and trailing-slash
//      variants all redirect to ONE canonical URL, or do several answer 200?
//   2. every sitemap URL - self-referencing canonical? cross-canonical? missing?
//   3. duplicate <title> and duplicate canonical targets across pages
//   4. pages reachable with and without a trailing slash both returning 200
//
// Prints a report. Exits 0 - this is a diagnostic, not a gate.

const START = process.argv[2] || 'https://www.bnbphotos.com/';
const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126 Safari/537.36';
const THROTTLE_MS = 250;

let last = 0;
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function get(url, redirect = 'follow') {
  const wait = THROTTLE_MS - (Date.now() - last);
  if (wait > 0) await sleep(wait);
  try {
    const res = await fetch(url, { redirect, headers: { 'user-agent': UA } });
    const body = res.status < 400 || res.status === 200 ? await res.text() : '';
    return { status: res.status, body, finalUrl: res.url, location: res.headers.get('location') };
  } catch (e) {
    return { status: 0, body: '', finalUrl: url, error: e.message };
  } finally {
    last = Date.now();
  }
}

const canonicalOf = (html) => {
  const m = html.match(/<link[^>]+rel=["']?canonical["']?[^>]*>/i);
  if (!m) return null;
  const h = m[0].match(/href=["']([^"']+)["']/i);
  return h ? h[1] : null;
};
const titleOf = (html) => {
  const m = html.match(/<title[^>]*>([\s\S]*?)<\/title>/i);
  return m ? m[1].trim().replace(/\s+/g, ' ') : null;
};
const robotsOf = (html) => {
  const m = html.match(/<meta[^>]+name=["']robots["'][^>]*>/i);
  if (!m) return null;
  const c = m[0].match(/content=["']([^"']+)["']/i);
  return c ? c[1] : null;
};
const norm = (u) => (u || '').replace(/\/+$/, '').toLowerCase();

const origin = new URL(START).origin;
const host = new URL(START).host;
const bareHost = host.replace(/^www\./, '');

console.log(`\n=== 1. Host and protocol variants of the homepage ===\n`);
const variants = [
  `http://${bareHost}/`,
  `https://${bareHost}/`,
  `http://www.${bareHost}/`,
  `https://www.${bareHost}/`,
  `${origin}`,
  `${origin}/index.php`,
  `${origin}/?utm_source=test`,
];
const answered200 = [];
for (const v of variants) {
  const r = await get(v, 'manual');
  let note = '';
  if (r.status >= 300 && r.status < 400) note = `-> ${r.location}`;
  if (r.status === 200) {
    answered200.push(v);
    const c = canonicalOf(r.body);
    note = `canonical=${c || '(none)'}`;
  }
  console.log(`  ${String(r.status).padEnd(4)} ${v.padEnd(38)} ${note}`);
}
if (answered200.length > 1) {
  console.log(`\n  ⚠ ${answered200.length} variants answer 200 directly. Each is a separate URL to Google.`);
} else {
  console.log(`\n  ✓ Only one variant answers 200 directly; the rest redirect.`);
}

console.log(`\n=== 2. Sitemap URLs: canonical, title, robots ===\n`);
const smUrls = new Set();
const queue = [`${origin}/sitemap_index.xml`, `${origin}/sitemap.xml`];
const seenSm = new Set();
while (queue.length) {
  const sm = queue.shift();
  if (seenSm.has(sm)) continue;
  seenSm.add(sm);
  const r = await get(sm);
  if (r.status !== 200) continue;
  const isIndex = /<sitemapindex/i.test(r.body);
  for (const m of r.body.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/gi)) {
    if (isIndex) queue.push(m[1]);
    else smUrls.add(m[1]);
  }
}
console.log(`  ${smUrls.size} URLs in sitemaps\n`);

const rows = [];
for (const u of smUrls) {
  const r = await get(u);
  if (r.status !== 200) {
    console.log(`  ${r.status} ${u}`);
    continue;
  }
  const can = canonicalOf(r.body);
  const self = norm(can) === norm(r.finalUrl);
  rows.push({ url: u, finalUrl: r.finalUrl, can, self, title: titleOf(r.body), robots: robotsOf(r.body) });
  const flag = !can ? 'NO CANONICAL' : self ? 'self' : `CROSS -> ${can}`;
  console.log(`  ${flag.padEnd(34)} ${u.replace(origin, '') || '/'}`);
  if (r.finalUrl !== u) console.log(`     redirected to ${r.finalUrl}`);
  if (r.robots) console.log(`     robots: ${r.robots}`);
}

console.log(`\n=== 3. Duplicate titles and shared canonical targets ===\n`);
const byTitle = new Map();
const byCanon = new Map();
for (const r of rows) {
  if (r.title) byTitle.set(r.title, [...(byTitle.get(r.title) || []), r.url]);
  if (r.can) byCanon.set(norm(r.can), [...(byCanon.get(norm(r.can)) || []), r.url]);
}
let dupes = 0;
for (const [t, us] of byTitle) if (us.length > 1) { dupes++; console.log(`  DUPLICATE TITLE "${t}"`); us.forEach((u) => console.log(`     ${u}`)); }
for (const [c, us] of byCanon) if (us.length > 1) { dupes++; console.log(`  ${us.length} pages share canonical ${c}`); us.forEach((u) => console.log(`     ${u}`)); }
if (!dupes) console.log('  none found');

console.log(`\n=== 4. Trailing-slash duplicates (both forms answering 200) ===\n`);
let slashDupes = 0;
for (const r of rows.slice(0, 40)) {
  const u = r.url.replace(/\/$/, '');
  if (u === origin) continue;
  const alt = r.url.endsWith('/') ? u : `${r.url}/`;
  const res = await get(alt, 'manual');
  if (res.status === 200) {
    slashDupes++;
    console.log(`  BOTH 200: ${r.url}  AND  ${alt}`);
  }
}
if (!slashDupes) console.log('  none - the alternate form redirects, which is correct');

console.log(`\n=== summary ===`);
console.log(`  homepage variants answering 200 directly: ${answered200.length}`);
console.log(`  sitemap URLs checked: ${rows.length}`);
console.log(`  pages with no canonical: ${rows.filter((r) => !r.can).length}`);
console.log(`  pages whose canonical points elsewhere: ${rows.filter((r) => r.can && !r.self).length}`);
console.log(`  trailing-slash duplicates: ${slashDupes}`);
