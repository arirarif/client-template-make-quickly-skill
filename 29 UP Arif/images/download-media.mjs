/**
 * Download every media attachment listed in the WordPress export XML.
 *
 * The export is media-only (326 attachment items, no posts), so the XML is the
 * authoritative list — more reliable than paging upload.php in a browser, and
 * it carries the original full-size URL rather than a resized derivative.
 *
 * Files land under images/uploads/<year>/<month>/ mirroring the site's own
 * structure, so a path here maps one-to-one onto a path on the server.
 * Re-running skips anything already downloaded at the expected size.
 *
 * Writes manifest.json: url -> { file, title, date, bytes }, which is what
 * later steps use to wire real photography into products and Divi layouts.
 */
import fs from 'node:fs';
import path from 'node:path';

const DIR = import.meta.dirname;
const XML = path.join(DIR, '..', 'niswahboutique.WordPress.2026-08-26.xml');
const OUT_ROOT = path.join(DIR, 'uploads');
const MANIFEST = path.join(DIR, 'manifest.json');
const CONCURRENCY = 3;

const xml = fs.readFileSync(XML, 'utf8');

// Pull each <item> so the URL keeps its title/date context.
const items = [...xml.matchAll(/<item>([\s\S]*?)<\/item>/g)].map((m) => m[1]);

const cdata = (block, tag) => {
  const m = block.match(new RegExp(`<${tag}>\\s*(?:<!\\[CDATA\\[)?([\\s\\S]*?)(?:\\]\\]>)?\\s*</${tag}>`));
  return m ? m[1].trim() : '';
};

const records = [];
for (const block of items) {
  const url = cdata(block, 'wp:attachment_url');
  if (!url) continue;
  records.push({
    url,
    title: cdata(block, 'title'),
    date: cdata(block, 'wp:post_date'),
  });
}

// De-duplicate by URL, keeping the first record.
const seen = new Set();
const unique = records.filter((r) => {
  if (seen.has(r.url)) return false;
  seen.add(r.url);
  return true;
});

console.log(`attachments in export: ${records.length} (${unique.length} unique)`);

// Map a URL onto a local path that mirrors wp-content/uploads/.
function localPathFor(url) {
  const u = new URL(url);
  const rel = u.pathname.replace(/^.*\/wp-content\/uploads\//, '');
  return path.join(OUT_ROOT, rel.split('/').join(path.sep));
}

const manifest = {};
const failures = [];
let downloaded = 0;
let skipped = 0;
let bytesTotal = 0;

async function fetchOne(rec) {
  const dest = localPathFor(rec.url);
  fs.mkdirSync(path.dirname(dest), { recursive: true });

  if (fs.existsSync(dest) && fs.statSync(dest).size > 0) {
    const size = fs.statSync(dest).size;
    skipped++;
    bytesTotal += size;
    manifest[rec.url] = { file: path.relative(DIR, dest).split(path.sep).join('/'), title: rec.title, date: rec.date, bytes: size };
    return;
  }

  // These are multi-MB originals and the host drops connections when pushed,
  // so a first-pass failure is usually transient rather than a missing file.
  // Retry with backoff before believing it.
  let lastErr = '';
  for (let attempt = 1; attempt <= 4; attempt++) {
    try {
      const r = await fetch(rec.url, { headers: { 'User-Agent': 'Mozilla/5.0' } });
      if (!r.ok) {
        lastErr = `HTTP ${r.status}`;
        if (r.status === 404) break; // genuinely absent — no point retrying
        throw new Error(lastErr);
      }
      const buf = Buffer.from(await r.arrayBuffer());
      if (!buf.length) throw new Error('empty body');

      fs.writeFileSync(dest, buf);
      downloaded++;
      bytesTotal += buf.length;
      manifest[rec.url] = { file: path.relative(DIR, dest).split(path.sep).join('/'), title: rec.title, date: rec.date, bytes: buf.length };
      return;
    } catch (e) {
      lastErr = e.message;
      if (attempt < 4) await new Promise((res) => setTimeout(res, attempt * 1500));
    }
  }
  failures.push(`${lastErr} — ${rec.url}`);
}

// Simple worker pool so the server is not hit with 326 parallel requests.
let cursor = 0;
async function worker() {
  while (cursor < unique.length) {
    const i = cursor++;
    await fetchOne(unique[i]);
    if ((downloaded + skipped) % 50 === 0) {
      console.log(`  ...${downloaded + skipped}/${unique.length}`);
    }
  }
}
await Promise.all(Array.from({ length: CONCURRENCY }, worker));

fs.writeFileSync(MANIFEST, JSON.stringify(manifest, null, 1));

const mb = (bytesTotal / 1024 / 1024).toFixed(1);
console.log('---');
console.log(`downloaded : ${downloaded}`);
console.log(`already had: ${skipped}`);
console.log(`failed     : ${failures.length}`);
console.log(`total size : ${mb} MB`);
console.log(`manifest   : ${MANIFEST}`);
for (const f of failures.slice(0, 25)) console.log('  FAIL ' + f);
