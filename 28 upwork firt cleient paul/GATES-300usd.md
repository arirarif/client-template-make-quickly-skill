# Gates: the $300 job — GBP + reviews + mailing list, three sites

OWNS: GATES-300usd.md, scripts/**, WORKFLOW-300USD-parallel.md, SCOPE-2026-09-03-300usd.md

Scope: deliver a Google Business Profile, on-site reviews, and a working mailing list for
expressrealestatephotos.com, bnbphotos.com and dvpfl.com, plus the bundled Search Console /
BNB hardening / form-delivery work, without regressing the speed and uptime won in August.

Written before implementation. Every runnable gate below is expected to FAIL on first run —
that failing baseline is the proof the oracles can fail, recorded as evidence.

Manual gates exist where no command can decide the outcome: they live inside Paul's Google
account, Paul's Brevo account, or Paul's inbox, and no public HTTP request can observe them.

---

## Mailing list

- [ ] G1: a Brevo account owned by Paul's email holds exactly the three audience lists
  EVIDENCE: pending

- [ ] G2: a Brevo-backed signup form with honeypot and consent wording is live on all three homepages
  CHECK: node scripts/check-300usd.mjs signup
  EXPECT: SIGNUP VERIFICATION PASSED
  EVIDENCE: pending

- [x] G3: no third-party newsletter JavaScript loads on any homepage (protects PSI 93/94)
  CHECK: node scripts/check-300usd.mjs nojsembed
  EXPECT: NOJSEMBED VERIFICATION PASSED
  EVIDENCE: exit=0; shell=C:\WINDOWS\system32\cmd.exe; cwd=C:\Users\arira\Desktop\All-Fiverr-project-code\00001. client-template-make-quickly-skill-main\28 upwork firt cleient paul; path=d19c2f893715/38 entries; output=dvpfl: no third-party newsletter JS | NOJSEMBED VERIFICATION PASSED

- [ ] G4: each site has a /thank-you/ page returning 200 as the signup conversion target
  CHECK: node scripts/check-300usd.mjs thankyou
  EXPECT: THANKYOU VERIFICATION PASSED
  EVIDENCE: pending

- [ ] G5: PSI mobile after the signup deploy is not below the August baseline (Express 93, BNB 94)
  EVIDENCE: pending

- [ ] G6: a real test address submitted through each live form lands in the correct list within 60s
  EVIDENCE: pending

- [ ] G7: a welcome email fires automatically on all three lists
  EVIDENCE: pending

- [ ] G8: three seasonal campaigns exist as saved drafts in Brevo
  EVIDENCE: pending

- [ ] G9: the consent-capture route from each site's real contact form is documented and working, or the manual-export fallback is written into the handover
  EVIDENCE: pending

## Google Business Profile

- [ ] G10: three profiles exist with every field filled and 10+ photos each
  EVIDENCE: pending

- [ ] G11: verification has been submitted for all three profiles (submitted is the gate; Google owns "verified")
  EVIDENCE: pending

- [ ] G12: business name, phone and service areas on each profile match the live site exactly
  EVIDENCE: pending

- [ ] G13: a Google Business Profile link is present on all three sites
  CHECK: node scripts/check-300usd.mjs gbplink
  EXPECT: GBPLINK VERIFICATION PASSED
  EVIDENCE: pending

- [ ] G14: each site's LocalBusiness/Organization schema carries the GBP URL in sameAs
  CHECK: node scripts/check-300usd.mjs sameas
  EXPECT: SAMEAS VERIFICATION PASSED
  EVIDENCE: pending

- [ ] G15: one GBP post is published per profile
  EVIDENCE: pending

## Reviews

- [ ] G16: each site carries at least three Review schema items and no unsourced aggregateRating
  CHECK: node scripts/check-300usd.mjs reviews
  EXPECT: REVIEWS VERIFICATION PASSED
  EVIDENCE: pending

- [ ] G17: every published quote is traceable to a real message Paul forwarded, with permission where the source was private
  EVIDENCE: pending

- [ ] G18: the review-ask template and the short GBP review link are delivered to Paul
  EVIDENCE: pending

## Bundled inside the price

- [ ] G19: Search Console is verified with the sitemap submitted on all three sites
  EVIDENCE: pending

- [ ] G20: a live submission through every contact form reaches Paul's inbox and is not in spam
  EVIDENCE: pending

- [ ] G21: GA4 conversion events fire for form submit, phone tap and newsletter signup on all three sites
  EVIDENCE: pending

- [ ] G22: BNB has Elementor updated, wp-login rate-limited in Wordfence, and a running backup routine
  EVIDENCE: pending

- [x] G23: every URL in every site's sitemap still returns 200 after all deploys (regression guard)
  CHECK: node scripts/check-300usd.mjs pages
  EXPECT: PAGES VERIFICATION PASSED
  EVIDENCE: exit=0; shell=C:\WINDOWS\system32\cmd.exe; cwd=C:\Users\arira\Desktop\All-Fiverr-project-code\00001. client-template-make-quickly-skill-main\28 upwork firt cleient paul; path=d19c2f893715/38 entries; output=dvpfl: 27/27 sitemap URLs return 200 | PAGES VERIFICATION PASSED

## Close-out

- [ ] G24: the handover page is delivered — logins, how to send one campaign, how to ask for a review
  EVIDENCE: pending

- [ ] G25: Paul received the three promised updates (first deploy, halfway, handover)
  EVIDENCE: pending
