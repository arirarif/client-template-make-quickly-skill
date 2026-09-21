# Emma site — install on emmadigitalagency.com

Two zips come out of `python build/tools/build_zips.py`: **`dist/emma-child.zip`** (theme) and
**`dist/emma-core.zip`** (plugin). Everything else is created by one button.

## Before you start (once)

1. hPanel → make a **backup**.
2. WordPress → Settings → Reading → tick **"Discourage search engines"** (until launch).
3. Log in as the **Developer** user, not the client's account.

## Install (about 10 minutes)

| # | Where | Do |
|---|---|---|
| 1 | Appearance → Themes → Add New | Install **Hello Elementor** (from WordPress.org). Do not activate yet |
| 2 | Plugins → Add New | Install + activate **Elementor** (free, from WordPress.org) |
| 3 | Plugins → Add New → Upload | Install + activate **Elementor Pro**, activate the licence |
| 4 | Appearance → Themes → Add New → Upload | Upload **emma-child.zip**, activate **Emma** |
| 5 | Plugins → Add New → Upload | Upload **emma-core.zip**, activate **Emma Core** |
| 6 | Tools → **Emma setup** | Both lines must say "active". Click **Run setup** |
| 7 | Settings → Permalinks | Check it says "Post name", click Save once |
| 8 | Elementor → Tools | "Regenerate Files & Data", then purge LiteSpeed Cache |

Setup creates: brand colours + fonts in Elementor Site Settings · Header, Footer, Single project, Service
archive, Project card, Pricing table and 404 templates (Theme Builder) · the pages Home, About, Services,
Portfolio, Contact · the 6 Services · the main menu · 3 sample projects · logo and site icon.
It is safe to run again: existing pages are kept unless you tick "Replace".

## Check right after setup (these parts need Elementor Pro, so they were not testable locally)

- [ ] Header shows the logo at 60 px, the menu and the "Start a project" button; mobile shows the burger menu
- [ ] Footer is dark with 4 columns
- [ ] Home → "Selected work" shows 3 projects: one large on the left, two stacked on the right
- [ ] Services → each service shows "Related work"; the Pricing table appears above the questions
- [ ] Portfolio → filter buttons (All work + 6 services) filter the grid
- [ ] Open a project → title, cover, facts, text. Empty fields (results, quote, website) are hidden
- [ ] Contact → form shows 5 fields; send a test enquiry and check it arrives (Elementor → Submissions keeps a copy)
- [ ] A wrong address shows the custom "Page not found" page

If a Pro widget shows with default settings (for example the grid has the wrong columns), open it in
Elementor and set it in the panel. The structure and CSS classes are already in place.

## Later

- Form email: create the mailbox `hello@emmadigitalagency.com` in hPanel, add SPF + DKIM + DMARC, and set
  up SMTP (the domain has no SPF record today, so form mail would land in spam).
- Remove the 4 Hostinger plugins and the Hostinger AI theme after the client agrees.
- After launch: delete `emma-core/includes/setup.php` and `emma-core/templates/`.

## How the client edits things

| He wants to | Where |
|---|---|
| Change any text, image or button | Pages → (page) → **Edit with Elementor** → click the text |
| Change a price | Templates → Saved Templates → **Pricing table** → Edit with Elementor (changes everywhere it is shown) |
| Add a portfolio project | **Portfolio → Add project**: title, text, featured image, tick the Services, fill "Project details" |
| Hide the "Sample project" label | Untick "Sample project" on that project (or delete the sample) |
| Change header / footer | Templates → Theme Builder → Header / Footer |
| Change brand colours or fonts | Elementor → Site Settings → Global Colors / Global Fonts |
| Add a new section that matches | Copy an existing section in Elementor (right-click → Duplicate), then change the text |
