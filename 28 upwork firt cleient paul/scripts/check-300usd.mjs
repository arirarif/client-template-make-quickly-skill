#!/usr/bin/env node
// Oracles for the $300 job (GBP + reviews + mailing list, three sites).
// Portable Node >=18 (global fetch). No dependencies, no shell tools.
//
// Usage: node scripts/check-300usd.mjs <check>
//   pages      every URL in each site's sitemap returns 200
//   signup     Brevo-backed signup form live in the footer of all three sites
//   nojsembed  no third-party newsletter JS on any homepage
//   thankyou   /thank-you/ exists on all three sites (signup conversion target)
//   gbplink    Google Business Profile linked from each site
//   sameas     GBP URL present in each site's LocalBusiness/Organization schema
//   reviews    >=3 Review schema items per site, no unsourced AggregateRating
//
// Every check exits non-zero on any failure and prints its success marker only
// after all assertions pass. Absence checks run a positive control first: if the
// detector fails to flag a known-bad fixture, the check fails instead of passing.

const SITES = [
  { key: 'express', home: 'https://expressrealestatephotos.com/' },
  { key: 'bnb', home: 'https://www.bnbphotos.com/' },
  { key: 'dvpfl', home: 'https://www.dvpfl.com/' },
];

// Out of scope by the client's own decision, so not a regression this job can fail on.
// /book-now/ hands off to the external Vercel booking app, which answers anonymous
// requests with a 429 security challenge. Audit issue #8 was DEFERRED at Paul's request
// in August 2026 and he has since confirmed he is happy with the booking flow as it is.
// Excluded from the page guard, and recorded here rather than silently skipped.
// Scoped to Express only: BNB also has a /book-now/ page, but that one is an ordinary
// page and must stay guarded.
const EXCLUDED_URLS = [{ site: 'express', pattern: /\/book-now\/?$/i }];

const UA = 'Mozilla/5.0 (compatible; unlazy-gate-check/1.0)';
const TIMEOUT_MS = 25000;
const THROTTLE_MS = 200; // hosts reset rapid sequential requests; serialise.

let lastRequest = 0;
const failures = [];

function fail(msg) {
  failures.push(msg);
}

async function sleep(ms) {
  return new Promise((r) => setTimeout(r, ms));
}

// A transport failure is usually the host resetting rapid sequential requests, not a
// dead page — the same oracle defect that produced false alarms in the August work.
// Retry transport failures with backoff before believing them.
async function get(url, attempts = 3) {
  let res;
  for (let i = 0; i < attempts; i += 1) {
    res = await getOnce(url);
    if (res.status !== 0) return res;
    if (i < attempts - 1) await sleep(500 * 2 ** i);
  }
  return res;
}

async function getOnce(url) {
  const wait = THROTTLE_MS - (Date.now() - lastRequest);
  if (wait > 0) await sleep(wait);
  const ac = new AbortController();
  const timer = setTimeout(() => ac.abort(), TIMEOUT_MS);
  try {
    const res = await fetch(url, {
      redirect: 'follow',
      signal: ac.signal,
      headers: { 'user-agent': UA, accept: '*/*' },
    });
    const body = await res.text();
    return { status: res.status, body, url: res.url };
  } catch (err) {
    return { status: 0, body: '', url, error: String(err && err.message ? err.message : err) };
  } finally {
    clearTimeout(timer);
    lastRequest = Date.now();
  }
}

// ---------- detectors (pure, so they can be run against control fixtures) ----

const BREVO_ACTION = /<form[^>]+action\s*=\s*["'][^"']*(sendinblue|brevo)[^"']*["']/i;
const BREVO_SCRIPT = /<script[^>]+src\s*=\s*["'][^"']*(sibforms|sendinblue|brevo|mailerlite|mailchimp|list-manage)[^"']*["']/i;
const GBP_LINK = /https?:\/\/(?:www\.)?(?:google\.[a-z.]+\/maps\/[^"'\s]+|g\.page\/[^"'\s]+|business\.google\.com\/[^"'\s]+|maps\.app\.goo\.gl\/[^"'\s]+)/i;
const HONEYPOT = /<input[^>]+(type\s*=\s*["']hidden["'][^>]*name\s*=\s*["'][^"']*(hp|honey|website_url)[^"']*["']|name\s*=\s*["'][^"']*(hp|honey|website_url)[^"']*["'][^>]*type\s*=\s*["']hidden["'])/i;
const CONSENT = /unsubscribe/i;

function jsonLdBlocks(html) {
  const out = [];
  const re = /<script[^>]+type\s*=\s*["']application\/ld\+json["'][^>]*>([\s\S]*?)<\/script>/gi;
  let m;
  while ((m = re.exec(html)) !== null) {
    try {
      out.push(JSON.parse(m[1].trim()));
    } catch {
      /* malformed block: ignored here, surfaced by the gate that needs it */
    }
  }
  return out;
}

function flattenLd(node, acc = []) {
  if (Array.isArray(node)) {
    for (const n of node) flattenLd(n, acc);
  } else if (node && typeof node === 'object') {
    acc.push(node);
    for (const v of Object.values(node)) {
      if (v && typeof v === 'object') flattenLd(v, acc);
    }
  }
  return acc;
}

function hasGbpSameAs(html) {
  return flattenLd(jsonLdBlocks(html)).some((n) => {
    const s = n.sameAs;
    if (!s) return false;
    return (Array.isArray(s) ? s : [s]).some((u) => GBP_LINK.test(String(u)));
  });
}

function reviewNodes(html) {
  return flattenLd(jsonLdBlocks(html)).filter((n) => {
    const t = n['@type'];
    const types = Array.isArray(t) ? t : [t];
    return types.includes('Review');
  });
}

function aggregateNodes(html) {
  return flattenLd(jsonLdBlocks(html)).filter((n) => {
    const t = n['@type'];
    const types = Array.isArray(t) ? t : [t];
    return types.includes('AggregateRating') || n.aggregateRating;
  });
}

// ---------- positive controls -------------------------------------------------
// An absence assertion is only trustworthy if the detector demonstrably fires on
// a known-bad input. Each control below must be detected, or the check fails.

function runControl(name, detector, badFixture) {
  if (!detector(badFixture)) {
    fail(`positive control failed: ${name} did not flag its known-bad fixture — detector is broken, absence proves nothing`);
    return false;
  }
  return true;
}

const CONTROL_JS_EMBED =
  '<html><head><script src="https://sibforms.com/forms/end-form/build/main.js"></script></head><body></body></html>';
const CONTROL_AGGREGATE =
  '<script type="application/ld+json">{"@type":"LocalBusiness","aggregateRating":{"@type":"AggregateRating","ratingValue":"5","reviewCount":"12"}}</script>';

// ---------- checks ------------------------------------------------------------

async function sitemapUrls(home) {
  const seen = new Set();
  const urls = [];
  const queue = [new URL('/sitemap_index.xml', home).href, new URL('/sitemap.xml', home).href];
  while (queue.length) {
    const sm = queue.shift();
    if (seen.has(sm)) continue;
    seen.add(sm);
    const res = await get(sm);
    if (res.status !== 200 || !res.body.includes('<')) continue;
    const isIndex = /<sitemapindex/i.test(res.body);
    const locs = [...res.body.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/gi)].map((m) => m[1]);
    for (const loc of locs) {
      if (isIndex) queue.push(loc);
      else if (!urls.includes(loc)) urls.push(loc);
    }
  }
  return urls;
}

async function checkPages() {
  let total = 0;
  for (const site of SITES) {
    const urls = await sitemapUrls(site.home);
    if (urls.length === 0) {
      fail(`${site.key}: no sitemap URLs discovered — cannot guard regressions`);
      continue;
    }
    let bad = 0;
    let skipped = 0;
    for (const u of urls) {
      if (EXCLUDED_URLS.some((x) => x.site === site.key && x.pattern.test(u))) {
        skipped += 1;
        console.log(`  ${site.key}: SKIP ${u} (client-deferred, out of scope)`);
        continue;
      }
      const res = await get(u);
      if (res.status !== 200) {
        bad += 1;
        fail(`${site.key}: ${u} -> ${res.status}${res.error ? ` (${res.error})` : ''}`);
      }
    }
    const checked = urls.length - skipped;
    total += checked;
    console.log(
      `  ${site.key}: ${checked - bad}/${checked} sitemap URLs return 200` +
        (skipped ? ` (${skipped} excluded)` : ''),
    );
  }
  if (total === 0) fail('no pages checked at all');
  return 'PAGES VERIFICATION PASSED';
}

async function checkSignup() {
  for (const site of SITES) {
    const res = await get(site.home);
    if (res.status !== 200) {
      fail(`${site.key}: homepage -> ${res.status}`);
      continue;
    }
    const problems = [];
    if (!BREVO_ACTION.test(res.body)) problems.push('no form posting to a Brevo endpoint');
    if (!HONEYPOT.test(res.body)) problems.push('no hidden honeypot field');
    if (!CONSENT.test(res.body)) problems.push('no unsubscribe/consent wording');
    if (problems.length) fail(`${site.key}: ${problems.join('; ')}`);
    else console.log(`  ${site.key}: signup form present, honeypot + consent wording present`);
  }
  return 'SIGNUP VERIFICATION PASSED';
}

async function checkNoJsEmbed() {
  if (!runControl('newsletter JS embed', (h) => BREVO_SCRIPT.test(h), CONTROL_JS_EMBED)) {
    return 'NOJSEMBED VERIFICATION PASSED';
  }
  console.log('  positive control: detector correctly flags a known sibforms embed');
  for (const site of SITES) {
    const res = await get(site.home);
    if (res.status !== 200) {
      fail(`${site.key}: homepage -> ${res.status}`);
      continue;
    }
    if (BREVO_SCRIPT.test(res.body)) fail(`${site.key}: third-party newsletter JS is loading on the homepage`);
    else console.log(`  ${site.key}: no third-party newsletter JS`);
  }
  return 'NOJSEMBED VERIFICATION PASSED';
}

async function checkThankYou() {
  for (const site of SITES) {
    const url = new URL('/thank-you/', site.home).href;
    const res = await get(url);
    if (res.status !== 200) fail(`${site.key}: ${url} -> ${res.status}`);
    else console.log(`  ${site.key}: /thank-you/ returns 200`);
  }
  return 'THANKYOU VERIFICATION PASSED';
}

async function checkGbpLink() {
  for (const site of SITES) {
    const res = await get(site.home);
    if (res.status !== 200) {
      fail(`${site.key}: homepage -> ${res.status}`);
      continue;
    }
    const m = res.body.match(GBP_LINK);
    if (!m) fail(`${site.key}: no Google Business Profile link anywhere on the homepage`);
    else console.log(`  ${site.key}: GBP link present -> ${m[0].slice(0, 80)}`);
  }
  return 'GBPLINK VERIFICATION PASSED';
}

async function checkSameAs() {
  for (const site of SITES) {
    const res = await get(site.home);
    if (res.status !== 200) {
      fail(`${site.key}: homepage -> ${res.status}`);
      continue;
    }
    if (!hasGbpSameAs(res.body)) fail(`${site.key}: no GBP URL in any schema sameAs`);
    else console.log(`  ${site.key}: schema sameAs includes the GBP URL`);
  }
  return 'SAMEAS VERIFICATION PASSED';
}

async function checkReviews() {
  if (!runControl('aggregateRating', (h) => aggregateNodes(h).length > 0, CONTROL_AGGREGATE)) {
    return 'REVIEWS VERIFICATION PASSED';
  }
  console.log('  positive control: detector correctly flags an aggregateRating block');
  for (const site of SITES) {
    const res = await get(site.home);
    if (res.status !== 200) {
      fail(`${site.key}: homepage -> ${res.status}`);
      continue;
    }
    const reviews = reviewNodes(res.body);
    if (reviews.length < 3) fail(`${site.key}: ${reviews.length} Review schema items, need >= 3`);
    else console.log(`  ${site.key}: ${reviews.length} Review schema items`);
    const aggs = aggregateNodes(res.body);
    for (const a of aggs) {
      const node = a.aggregateRating || a;
      const count = Number(node.reviewCount ?? node.ratingCount ?? 0);
      if (!Number.isFinite(count) || count <= 0) {
        fail(`${site.key}: aggregateRating present with no real review count — unsourced rating is a manual-action risk`);
      }
    }
  }
  return 'REVIEWS VERIFICATION PASSED';
}

const CHECKS = {
  pages: checkPages,
  signup: checkSignup,
  nojsembed: checkNoJsEmbed,
  thankyou: checkThankYou,
  gbplink: checkGbpLink,
  sameas: checkSameAs,
  reviews: checkReviews,
};

const name = process.argv[2];
if (!name || !CHECKS[name]) {
  console.error(`usage: node scripts/check-300usd.mjs <${Object.keys(CHECKS).join('|')}>`);
  process.exit(2);
}

const marker = await CHECKS[name]();
if (failures.length) {
  console.error(`\n${name.toUpperCase()} FAILED — ${failures.length} problem(s):`);
  for (const f of failures) console.error(`  - ${f}`);
  process.exit(1);
}
console.log(marker);
