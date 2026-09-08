// Re-measures BNB page weight after the Seraphinite cache TTL expires.
// Writes the result to bnbphotos.com/sep2026/cache-recheck.log
import fs from 'node:fs';
const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126 Safari/537.36';
const OUT = 'bnbphotos.com/sep2026/cache-recheck.log';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
const WAIT_MS = Number(process.argv[2] ?? 3900) * 1000; // default 65 min

const lines = [`\n=== recheck started ${new Date().toISOString()}, waiting ${WAIT_MS / 60000} min ===`];
await sleep(WAIT_MS);
for (const p of ['/', '/services/', '/contact/']) {
  try {
    const r = await fetch('https://www.bnbphotos.com' + p, { headers: { 'user-agent': UA } });
    const t = await r.text();
    const css = (t.match(/<link[^>]+rel=["']?stylesheet/gi) || []).length;
    const hdr = (r.headers.get('x-seraph-accel-cache') || '').slice(0, 70);
    lines.push(`${new Date().toISOString()} ${p.padEnd(12)} ${r.status} ${String(t.length).padStart(7)}b css=${String(css).padStart(4)} | ${hdr}`);
  } catch (e) {
    lines.push(`${new Date().toISOString()} ${p} ERROR ${e.message}`);
  }
  await sleep(1500);
}
const home = lines.find((l) => l.includes(' /  '));
lines.push(`VERDICT: compare homepage bytes against 874254 (bad) and ~285860 (pre-update baseline).`);
fs.appendFileSync(OUT, lines.join('\n') + '\n');
console.log(lines.join('\n'));
