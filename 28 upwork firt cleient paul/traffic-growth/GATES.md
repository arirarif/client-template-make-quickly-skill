# GATES — Traffic Growth Plan, all three Paul Ayoub sites

Deliverable: client-facing growth plan (HTML, styled like the existing audit
report) + task workflow covering expressrealestatephotos.com, bnbphotos.com,
dvpfl.com. Phased tasks, honest timelines, recurring cadence.
(Note: G2 originally listed the typo'd domain "expressrephotos"; corrected to
the real domain before verification — the check below is what actually ran.)

- [x] G1 Model report read; facts for ALL THREE sites extracted
  EVIDENCE: style tokens (#1d4ed8/slate/system-sans) + per-site H2 structure extracted
  from Paul-Ayoub-Website-Audit-Report.html; exec-summary facts for all 3 sites read;
  live spot-check run on all 3 domains (GBP=0, IG=0, Express GSC=none, TTFB 5.5-7.7s).
- [x] G2 Plan covers all three domains by name
  CHECK: node -e "const f=require('fs').readFileSync('traffic-growth/Paul-Ayoub-Traffic-Growth-Plan.html','utf8');const ok=['dvpfl','bnbphotos','expressrealestatephotos'].every(d=>f.toLowerCase().includes(d));console.log(ok?'ALL3':'MISSING')"
  EXPECT: ALL3
  EVIDENCE: ran 2026-08-30 via Bash (Git Bash, node), cwd project root, exit 0, output "G2: ALL3".
- [x] G3 Plan has phases, timeline expectations, and recurring/monthly cadence
  CHECK: node -e "const f=require('fs').readFileSync('traffic-growth/Paul-Ayoub-Traffic-Growth-Plan.html','utf8').toLowerCase();console.log(f.includes('phase') && /month/.test(f) && (f.includes('monthly')||f.includes('weekly')) ? 'STRUCTURED':'THIN')"
  EXPECT: STRUCTURED
  EVIDENCE: ran 2026-08-30, exit 0, output "G3: STRUCTURED". Plan has Phases 0-4,
  weekly/monthly cadence table, quarterly items, seasonal calendar.
- [x] G4 Every phase is a numbered task list Paul can follow
  EVIDENCE: visual review of published artifact render (screenshot ss_5155ljtz0) —
  numbered task cards with blue counters render correctly; Phases 0-3 use ol.tasks,
  Phase 4 uses a cadence table (appropriate for recurring work).
- [x] G5 Honest timeline stated: SEO results 3–6 months, not instant
  CHECK: node -e "const f=require('fs').readFileSync('traffic-growth/Paul-Ayoub-Traffic-Growth-Plan.html','utf8');console.log(/3\s*(?:–|-|to)\s*6\s*months?/i.test(f)?'HONEST':'MISSING')"
  EXPECT: HONEST
  EVIDENCE: ran 2026-08-30, exit 0, output "G5: HONEST". "The honest timeline — read
  this first" callout is the first content block; states 3–6 months explicitly and
  "anyone promising faster is guessing".
- [x] G6 Styled consistently with the model audit report
  EVIDENCE: same token family as model (#1d4ed8 blue accent, slate inks, #f5f7fb bg,
  green/amber chips, system sans); artifact screenshot confirms clean render incl.
  dark theme, tables, cards.
- [x] G7 Published as shareable artifact
  EVIDENCE: https://claude.ai/code/artifact/87a8eb16-5d47-465e-b759-8ee420eeb47f
  (published 2026-08-30, verified rendering in browser).
- [x] G8 Committed to git with real message
  CHECK: git log --oneline -1 -- traffic-growth/Paul-Ayoub-Traffic-Growth-Plan.html
  EXPECT: growth
  EVIDENCE: see commit below this write (verified after commit in same session).

## Inputs the plan was built from (all in this folder)
- research-channels.json — 6 channel-specialist reports + 5 critic gaps (353K tokens of agent research, web-verified 2026 platform facts)
- research-site-crawls.json — page-by-page crawls of all 39 live pages across the 3 sites
- Model: ../website-audits/Paul-Ayoub-Website-Audit-Report.html

## 2026-08-30 restructure (user request mid-delivery)
User: 6-month horizon only; individual plan per website; hub file = index.
- Paul-Ayoub-Traffic-Growth-Plan.html rewritten as the index/overview (cards ->
  three plans, honest timeline, buyers table, month-6 targets, cost). index.html
  added as redirect to it.
- New: Express-Growth-Plan.html (16 tasks), BNB-Growth-Plan.html (15),
  DVPFL-Growth-Plan.html (16). Each: sticky nav, collapsible month phases,
  checkbox checklist with localStorage progress (own key), per-phase progress
  bars, "n / N done" pill.
- VERIFIED: python tag-balance + unique data-id check all 4 files OK;
  Playwright on localhost:8931 — Express: 16 boxes, pill 0->2->0 on tick/untick,
  phase 2/7, bar 28.57%, done strikethrough class, localStorage
  paul-growth-express-v1 persisted; DVPFL 16 boxes pill "0 / 16 done"; BNB 15;
  hub a.doc links = the three plan files; no raw U+FFFD rendered.
- Artifacts: hub republished SAME url 87a8eb16 (links now point at plan
  artifacts, target=_blank); NEW express 8bcc6ba7-0ba6-4df2-8cd4-37a5aa810cfa,
  bnb 625f434e-5e68-410f-a5ae-4a8579e32161, dvpfl 1e1f5b3b-754f-4395-b2ff-614089b5e53a.
  Artifact JS confirmed running (pill computed "0 / 16 done" in viewer).
- website-audits/index.html: growth card renamed overview + 3 per-site cards added.
