<?php
/**
 * BizJump Wizard — Main template.
 *
 * Renders one of three views depending on the shortcode's `view` attribute
 * (passed in via $atts from BJW_Shortcode::render):
 *   - "wizard" (default): only the 14-step wizard markup
 *   - "hero":             only the homepage hero markup
 *   - "auto":             both sections; JS toggles between them
 *
 * @package BizJump_Wizard
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$bjw_view = isset( $atts['view'] ) ? $atts['view'] : 'wizard';
$show_hero   = ( $bjw_view === 'hero'   || $bjw_view === 'auto' );
$show_wizard = ( $bjw_view === 'wizard' || $bjw_view === 'auto' );
?>
<?php if ( $show_hero ): ?>
<!-- ==========  HOMEPAGE HERO (initial view)  ========== -->
<section id="screen-home" class="hero">
<div class="hero-inner">
  <div class="hero-logo">
    <span class="brand">bizjump</span>
    <span class="brand-sub">Led by Real Small Business Experts Since 1998</span>
  </div>

  <div class="hero-headline-row">
    <h1 class="hero-headline">Start Your Business<br>With <span class="accent">Confidence</span></h1>
    <p class="hero-side-text"><strong>Your big idea deserves a bold execution.</strong> Say goodbye to stress and hello to your new business.</p>
  </div>

  <div class="hero-card">
    <h2 class="hero-card-title">Launch Your LLC in Days</h2>
    <p class="hero-card-sub">Transparent pricing. No "$0" hooks. No surprise renewals.</p>

    <div class="hero-controls">
      <div class="control-group">
        <label class="control-label"><span class="control-chip">1</span> Pick Entity</label>
        <select id="hero-entity" class="control-input">
          <option value="">Pick Entity</option>
          <option value="LLC" selected>LLC</option>
          <option value="S-Corporation">S-Corporation</option>
          <option value="C-Corporation">C-Corporation</option>
          <option value="Nonprofit">Nonprofit</option>
        </select>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="control-chip">2</span> Select State</label>
        <select id="hero-state" class="control-input">
          <option value="">Select State</option>
          <?php foreach ( BJW_State_Fees::all_states() as $st ): ?>
            <option value="<?php echo esc_attr( $st ); ?>"<?php echo $st === 'Florida' ? ' selected' : ''; ?>><?php echo esc_html( $st ); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button id="hero-start" class="btn btn-primary btn-large">Start My Business →</button>
    </div>

    <div id="hero-fee" class="hero-fee" style="display:none"></div>
  </div>

  <div class="hero-trust">
    <span class="hero-trust-text">Owned <span class="hl">Since 1998</span>. With <span class="hl">Over 500+ Entrepreneurs</span> Served!</span>
  </div>
</div>

<div class="footer" style="margin-top:64px">
  <div class="footer-inner">
    <a href="#">Contact</a><a href="#">Legal Disclaimer</a><a href="#">Site Map</a><a href="#">Affiliates</a><a href="#">Glossary</a><a href="#">Privacy Policy</a><a href="#">Cookies Settings</a>
  </div>
</div>
</section>
<?php endif; /* end hero */ ?>

<?php if ( $show_wizard ): ?>
<!-- ==========  WIZARD  ========== -->
<section id="screen-wizard" class="wizard">

<!-- top bar -->
<div class="topbar">
  <div class="topbar-inner">
    <div class="topbar-logo">
      <span class="brand">bizjump</span>
      <span class="brand-sub">Led by Real Small Business Experts Since 1998</span>
    </div>
    <div class="topbar-progress">
      <span class="topbar-progress-label">Your Progress:</span>
      <div class="topbar-progress-track"><div id="progress-fill" class="topbar-progress-fill"></div></div>
    </div>
    <a href="tel:18445555555" class="topbar-phone">📞 1 (844) 555-5555</a>
  </div>
</div>

<!-- ==========  STEP 1 — PACKAGE SELECTION  ========== -->
<div id="step-1" class="step active">
  <div class="step-banner">
    <div class="step-banner-inner">
      <h1>YOU BRING THE IDEA. WE'LL <span class="accent">MAKE IT OFFICIAL.</span></h1>
      <p>500+ businesses formed. Choose your entity type and state to get started.</p>
      <div class="step-banner-controls">
        <span class="control-pill"><span class="control-chip">1</span> <span id="banner-entity">LLC</span></span>
        <span class="control-pill"><span class="control-chip">2</span> <span id="banner-state">Florida</span></span>
        <button class="btn btn-secondary" onclick="goHome()">Change</button>
      </div>
    </div>
  </div>

  <div class="wizard-body single-col">
    <div>
      <div class="pkg-pitch">
        Many competitors advertise <strong>$0 + state fees</strong>, then charge $200–$350/year in surprise compliance fees, registered-agent renewals, and "annual maintenance" fees that auto-charge your card. <strong>We don't.</strong> Choose a package, pay once, get exactly what's listed. We email you when it's time to renew anything — <strong>we never auto-charge</strong>.
      </div>

      <div class="pkg-table">
        <div class="pkg-header">
          <div class="pkg-header-cell">Business Formation Packages</div>
          <div class="pkg-header-cell">
            <div class="pkg-tier-name">Basic</div>
            <div class="pkg-tier-price"><span class="currency">$</span>99</div>
            <div class="pkg-tier-fee">+ <span class="state-fee-display">$87.50</span> state fee</div>
            <div class="pkg-tier-speed">⏰ 7 days</div>
          </div>
          <div class="pkg-header-cell">
            <div class="pkg-tier-name">Pro</div>
            <div class="pkg-tier-price"><span class="currency">$</span>195</div>
            <div class="pkg-tier-fee">+ <span class="state-fee-display">$87.50</span> state fee</div>
            <div class="pkg-tier-speed">⏰ 2 days</div>
          </div>
          <div class="pkg-header-cell recommended">
            <span class="pkg-ribbon">★ Recommended</span>
            <div class="pkg-tier-name">Premium</div>
            <div class="pkg-tier-price"><span class="currency">$</span>395</div>
            <div class="pkg-tier-fee">+ <span class="state-fee-display">$87.50</span> state fee</div>
            <div class="pkg-tier-speed">⏰ 24 hours</div>
          </div>
        </div>

        <!-- Always-included filing row (state fees per tier) -->
        <div id="pkg-row-filing"></div>

        <!-- Dynamic addon rows (rendered by renderPackageRows()) -->
        <div id="pkg-rows"></div>

        <div class="pkg-footer">
          <div class="pkg-footer-cell"></div>
          <div class="pkg-footer-cell"><button class="pkg-select" onclick="selectPlan('basic')">Get Started</button></div>
          <div class="pkg-footer-cell"><button class="pkg-select" onclick="selectPlan('pro')">Get Started</button></div>
          <div class="pkg-footer-cell recommended"><button class="pkg-select" onclick="selectPlan('premium')">Get Started ★</button></div>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Frequently Asked Questions</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>01 — What is included in the formation package?</span><span class="chev">⌄</span></button><div class="faq-a"><p>All packages include the essentials needed to legally form your business: preparation and filing of your formation documents, business name verification, digital delivery of approved documents, filing status updates, and secure client portal access. Our higher-tier packages — Pro and Premium — also include additional services such as EIN filing and other startup support services, bundled at significantly lower pricing than purchased separately. Of course, clients may also select additional services within any package based on their specific business needs.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>02 — Which package should I choose?</span><span class="chev">⌄</span></button><div class="faq-a"><p><strong>Basic</strong> — Ideal for experienced founders who only need business formation services and can handle the remaining setup steps themselves.<br><strong>Pro</strong> — Best for busy entrepreneurs who want additional setup support while still managing a few tasks independently.<br><strong>Premium</strong> — Designed for founders who want a more complete setup experience with expedited processing and broader hands-on support from our team.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>03 — Why are state fees separate?</span><span class="chev">⌄</span></button><div class="faq-a"><p>State filing fees are government charges paid directly to the Secretary of State. These fees vary by state and entity type and are not included in BizJump's service fees.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>04 — Do I need an EIN?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Almost all businesses require an EIN to open a business bank account, hire employees, process payroll, or file taxes.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>05 — What is a Registered Agent?</span><span class="chev">⌄</span></button><div class="faq-a"><p>A Registered Agent receives legal notices and official government correspondence on behalf of your business.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>06 — Do I need a Registered Agent?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Most states legally require it. You may act as your own RA using your business address; using your home creates privacy concerns.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>07 — What are Compliance Alerts?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Reminders about annual reports, filing deadlines, and Secretary of State compliance requirements.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>08 — How fast is filing?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Varies by package and Secretary of State speed. Some states also charge $50–$100+ expedited fees.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>09 — Can BizJump guarantee state approval?</span><span class="chev">⌄</span></button><div class="faq-a"><p>No. Final approval is determined by the Secretary of State; if your name is unavailable we work with you on an alternative.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>10 — Do I need a business bank account?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Yes — separating personal/business finances is strongly recommended.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>11 — Can BizJump help with taxes?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Yes — CPA-supported tax filing, accounting setup, bookkeeping, and tax planning.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>12 — Can you help set up my website and social media?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Yes — website + hosting, Google Business Profile, and social account setup.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>13 — Are monthly fees refundable?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Subscriptions are cancellable per terms; government filing fees are non-refundable once submitted.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>14 — Is BizJump a law firm?</span><span class="chev">⌄</span></button><div class="faq-a"><p>No — BizJump is not a law firm and does not provide legal advice.</p></div></div>
      </div>
    </div>
  </div>
</div>

<!-- ==========  STEP 2 — COMPANY INFORMATION  ========== -->
<div id="step-2" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Company Information</h2>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="biz-name">What's the name of your business? <span class="field-tooltip" title="Enter your desired business name. We'll verify availability with the state.">i</span></label>
            <input id="biz-name" class="input" type="text" placeholder="e.g. Acme Holdings" oninput="state.business.name=this.value;renderSidebar()">
          </div>
          <div class="field">
            <label class="field-label" for="biz-designator">Designator <span class="field-tooltip" title="The legal suffix of your business name — depends on entity type.">i</span></label>
            <select id="biz-designator" class="select" onchange="state.business.designator=this.value">
              <?php foreach ( BJW_Designators::all_unique() as $d ): ?>
                <option value="<?php echo esc_attr( $d ); ?>"><?php echo esc_html( $d ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="field">
          <label class="field-label" for="biz-purpose">Business Purpose <span class="field-counter" id="purpose-counter">You have 100 characters left</span></label>
          <textarea id="biz-purpose" class="textarea" maxlength="100" placeholder="Please provide brief description of Business Purpose" oninput="state.business.purpose=this.value;document.getElementById('purpose-counter').textContent='You have '+(100-this.value.length)+' characters left'"></textarea>
        </div>

        <div class="field">
          <label class="field-label" for="biz-naics">Tell us what industry your business is in? <span class="field-tooltip" title="NAICS code helps us file correctly with the IRS and state.">i</span></label>
          <select id="biz-naics" class="select" onchange="state.business.naics=this.value">
            <option value="">Select Business Type/Industry</option>
            <option value="541-Professional">Professional Services (541)</option>
            <option value="722-Food">Food Services (722)</option>
            <option value="335-Manufacturing">Manufacturing — Electric Equipment (335)</option>
            <option value="811-Repair">Repair & Maintenance (811)</option>
            <option value="453-Retail">Retail (453)</option>
            <option value="611-Education">Education Services (611)</option>
            <option value="621-Health">Health Care (621)</option>
            <option value="236-Construction">Construction (236)</option>
            <option value="518-Tech">Tech / Software (518)</option>
            <option value="other">Other</option>
          </select>
          <div class="field-helper">e.g. hair salon, accountant, bar owner, social media…</div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Are there any restrictions on Company Name Choice?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Your company name must be distinguishable from other businesses already registered in your state. Certain words such as "doctor" may also require additional state approval or professional licensing.</p><p>To help avoid delays:</p><ul><li>Avoid names that are too similar to existing registered businesses</li><li>Do not include restricted words such as "Bank," "Insurance," or "University" unless properly authorized</li><li>Special characters and punctuation may be restricted in some states</li></ul><p>We recommend you have 2–3 alternative names in case your first choice is unavailable. We will reach out to you via email if your first name is not approved.</p><p><strong>Important Note:</strong> Approval of a company name is determined solely by the state filing office. A name being available online or as a domain name does not guarantee state approval.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>What if my company name is unavailable?</span><span class="chev">⌄</span></button><div class="faq-a"><p>If your requested company name is unavailable, we will contact you to request an alternative name. Our team will continue working with you until a name is approved by the state.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Does my company name need to end with "LLC" or "INC"?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Yes. Most states require incorporated businesses to include a legal designator showing the type of entity. These designators help identify the legal structure of the business to the public and the state.</p><p>Allowable endings include:</p><ul><li>For C-Corp, S-Corp &amp; Nonprofit Corporations: <strong>INC, CORPORATION, INCORPORATED, CORP</strong></li><li>For LLCs: <strong>LLC, LIMITED LIABILITY COMPANY</strong></li></ul><p>The most common designators are "LLC" for Limited Liability Companies and "INC" for Corporations.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Why is the Business Purpose and Industry Needed?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Your business purpose and industry classification help determine the correct type of business entity and filing requirements for your company. Certain industries are regulated and may require specialized entity structures, additional licenses, or state approvals before formation can be completed.</p><p>For example:</p><ul><li>Medical practices, legal firms, accounting firms, architects, and certain licensed professionals may need to form a <strong>PLLC</strong> (Professional Limited Liability Company) or <strong>Professional Corporation</strong> instead of a standard LLC or Corporation.</li><li>Non-profit organizations may require additional IRS and state filings.</li><li>Financial, insurance, transportation, healthcare, and childcare businesses may require special state licenses or regulatory approvals.</li></ul><p>Providing accurate business purpose information also helps ensure:</p><ul><li>Your company is formed correctly from the beginning</li><li>The proper state documents are filed</li><li>Banking and tax setup is completed properly</li><li>You avoid delays or rejections from the Secretary of State</li></ul><p>If your business requires a specialized entity type or additional compliance steps, the BizJump team will help guide you through the process.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 3 — STATE FILING TIME  ========== -->
<div id="step-3" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">State Filing Time</h2>
        <p class="card-intro">The typical state filing time for <strong id="filing-state-name">Florida</strong> is <strong id="filing-state-time">3 weeks</strong>. In a hurry? <span id="filing-state-name-2">Florida</span> offers an expedited filing option as well. Select the filing time that best meets your needs.</p>

        <div class="radio-cards">
          <div id="filing-rush-card" class="radio-card" data-type="expedited" data-price="50" onclick="selectFilingTime(this,'rush',+this.dataset.price)">
            <div class="radio-card-dot"></div>
            <div class="radio-card-body">
              <div style="display:flex;justify-content:space-between;align-items:start;gap:12px"><div class="radio-card-title">3 business days filing time.</div><div class="radio-card-price" id="filing-rush-price">$50</div></div>
              <div class="radio-card-date"><span class="radio-card-date-label">Estimated Formation Date:</span><br><span class="radio-card-date-val" id="rush-date">Thursday, May 14*</span></div>
            </div>
          </div>
          <div class="radio-card" onclick="selectFilingTime(this,'standard',0)">
            <div class="radio-card-dot"></div>
            <div class="radio-card-body">
              <div style="display:flex;justify-content:space-between;align-items:start;gap:12px"><div class="radio-card-title">Standard filing time.</div><div class="radio-card-price">$0</div></div>
              <div class="radio-card-date"><span class="radio-card-date-label">Estimated Formation Date:</span><br><span class="radio-card-date-val" id="std-date">Wednesday, June 10*</span></div>
            </div>
          </div>
        </div>

        <p class="footnote">* These dates are estimations based on current state turnaround times and are subject to change based on state processing.</p>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button id="filing-next" class="btn btn-primary" onclick="nextStep()" disabled>Next ›</button>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 4 — CONTACT (NEW)  ========== -->
<div id="step-4" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Who is the main contact for this new business?</h2>
        <p class="card-intro">This is who we'll contact if more info is needed during the filing process. This person could also be an owner for the new business.</p>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="ct-first">First Name</label>
            <input id="ct-first" class="input" type="text" placeholder="First name" oninput="state.contact.firstName=this.value;validateContact()">
          </div>
          <div class="field">
            <label class="field-label" for="ct-last">Last Name</label>
            <input id="ct-last" class="input" type="text" placeholder="Last name" oninput="state.contact.lastName=this.value;validateContact()">
          </div>
        </div>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="ct-email">Email</label>
            <input id="ct-email" class="input" type="email" placeholder="you@example.com" oninput="state.contact.email=this.value;validateContact()">
          </div>
          <div class="field">
            <label class="field-label" for="ct-phone">Mobile Phone (US +1)</label>
            <input id="ct-phone" class="input" type="tel" placeholder="(555) 555-5555" oninput="state.contact.phone=this.value;validateContact()">
          </div>
        </div>

        <div class="field">
          <label class="field-label" for="ct-street1">Street Address</label>
          <input id="ct-street1" class="input" type="text" placeholder="123 Main Street" oninput="state.contact.street1=this.value;validateContact()">
        </div>

        <div class="field">
          <label class="field-label" for="ct-street2">Address 2 <span class="field-helper" style="font-weight:400;color:var(--bz-g400)">(Optional)</span></label>
          <input id="ct-street2" class="input" type="text" placeholder="Apt, suite, unit, etc." oninput="state.contact.street2=this.value">
        </div>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="ct-city">City</label>
            <input id="ct-city" class="input" type="text" placeholder="City" oninput="state.contact.city=this.value;validateContact()">
          </div>
          <div class="field">
            <label class="field-label" for="ct-state">State</label>
            <select id="ct-state" class="select state-select" onchange="state.contact.state=this.value;validateContact()">
              <option value="">Select state</option>
              <?php foreach ( BJW_State_Fees::all_states() as $st ): ?>
                <option value="<?php echo esc_attr( $st ); ?>"><?php echo esc_html( $st ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label class="field-label" for="ct-county">County <span class="field-helper" style="font-weight:400;color:var(--bz-g400)">(Optional)</span></label>
            <input id="ct-county" class="input" type="text" placeholder="County" oninput="state.contact.county=this.value">
          </div>
        </div>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="ct-country">Country</label>
            <select id="ct-country" class="select" onchange="state.contact.country=this.value">
              <option value="US" selected>United States</option>
            </select>
          </div>
          <div class="field">
            <label class="field-label" for="ct-zip">Zip Code</label>
            <input id="ct-zip" class="input" type="text" inputmode="numeric" maxlength="10" placeholder="Zip" oninput="state.contact.zip=this.value;validateContact()">
          </div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button id="contact-next" class="btn btn-primary" onclick="nextStep()" disabled>Next ›</button>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 13 — ORDER SUMMARY REVIEW  ========== -->
<div id="step-13" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <div style="margin-bottom:20px"><div class="sidebar-biz-pill" id="review-biz-pill">Your Business LLC</div></div>
        <h2 class="card-title" style="margin-bottom:24px">Order Summary</h2>

        <div id="review-sections"></div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 13 — BILLING & PAYMENT  ========== -->
<div id="step-14" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Billing Information</h2>

        <div style="display:flex;justify-content:space-between;align-items:center;border:1px solid var(--bz-g200);border-radius:var(--radius-md);padding:16px;margin-bottom:24px">
          <label style="display:flex;align-items:center;gap:10px;font-size:14px;font-weight:600"><input type="radio" name="paymethod" checked style="accent-color:var(--bz-orange)"> Add a Credit Card</label>
          <div style="display:flex;gap:8px;align-items:center;font-size:13px;color:var(--bz-g600)">
            <span style="background:#1A56DB;color:#fff;padding:3px 8px;border-radius:3px;font-weight:700;font-size:11px">VISA</span>
            <span style="background:#016FD0;color:#fff;padding:3px 8px;border-radius:3px;font-weight:700;font-size:11px">AMEX</span>
            <span style="background:#EB001B;color:#fff;padding:3px 8px;border-radius:3px;font-weight:700;font-size:11px">MC</span>
            <span>+ more</span>
          </div>
        </div>

        <h3 style="font-size:16px;font-weight:700;margin-bottom:14px;color:var(--bz-black)">Credit Card Information</h3>
        <div class="field"><label class="field-label">Cardholder Full Name</label><input class="input" type="text" placeholder="Full Name"></div>
        <div class="field"><label class="field-label">Card Number</label><input class="input" type="text" placeholder="1234 1234 1234 1234"></div>
        <div class="field-row">
          <div class="field"><label class="field-label">Expiry Date</label><input class="input" type="text" placeholder="MM/YY"></div>
          <div class="field"><label class="field-label">CVV/CVC</label><input class="input" type="text" placeholder="3 digits"></div>
        </div>

        <h3 style="font-size:16px;font-weight:700;margin:24px 0 14px;color:var(--bz-black)">Billing Address</h3>
        <div class="field"><label class="field-label">Country</label><select class="select"><option>United States of America (United States)</option></select></div>
        <div class="field-row">
          <div class="field"><label class="field-label">Street Address</label><input class="input" type="text"></div>
          <div class="field"><label class="field-label">Address (Cont) <span style="font-weight:400;color:var(--bz-g400)">Optional</span></label><input class="input" type="text"></div>
        </div>
        <div class="field-row-3">
          <div class="field"><label class="field-label">City</label><input class="input" type="text"></div>
          <div class="field"><label class="field-label">State</label><select class="select" id="billing-state"><option value="">Select State</option><?php foreach ( BJW_State_Fees::all_states() as $st ): ?><option value="<?php echo esc_attr( $st ); ?>"><?php echo esc_html( $st ); ?></option><?php endforeach; ?></select></div>
          <div class="field"><label class="field-label">ZIP Code</label><input class="input" type="text"></div>
        </div>

        <div class="info info-blue"><span class="info-icon">ⓘ</span><div><strong>Billing Information</strong> — In order to avoid delays and/or the cancellation of your order, ensure that the billing address provided matches the payment card used.</div></div>

        <div class="actions" style="justify-content:flex-start"><button class="btn btn-secondary" onclick="prevStep()">‹ Back</button></div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>What is the cancellation policy for my order?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Full refund within 24 hours of order placement, before state filing begins. After state filing begins, refunds depend on how much of the work has been completed — contact us via support.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Can I edit my order after it's been placed?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Yes, you can request edits via your dashboard or by contacting support. Note: state filings already submitted cannot be modified — you would need to file an amendment after formation.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>What happens after I pay?</span><span class="chev">⌄</span></button><div class="faq-a"><p>You'll get a confirmation email, your customer dashboard will be activated, and our team will start preparing your formation documents within 1 business day.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>How can I track my order?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Your dashboard shows real-time order status — pending review, submitted to state, awaiting state response, completed. You'll also get email updates at each stage.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 14 — CONFIRMATION  ========== -->
<div id="step-15" class="step">
  <div class="wizard-body single-col">
    <div style="max-width:700px;margin:0 auto;text-align:center;padding:64px 0">
      <div style="font-size:64px;margin-bottom:24px">🎉</div>
      <h1 style="font-size:36px;font-weight:800;color:var(--bz-black);margin-bottom:12px;letter-spacing:-.5px">Welcome to BizJump, <span id="confirm-name">friend</span>!</h1>
      <p style="font-size:18px;color:var(--bz-g600);margin-bottom:32px">Your order has been placed successfully.</p>

      <div class="card" style="text-align:left;margin-bottom:24px">
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--bz-g200)"><strong>Order Number</strong><span id="confirm-order-num" style="font-family:monospace;color:var(--bz-orange);font-weight:700">BJ-204508</span></div>
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--bz-g200)"><strong>Business Name</strong><span id="confirm-biz-name">Your Business LLC</span></div>
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--bz-g200)"><strong>State of Formation</strong><span id="confirm-state">Florida</span></div>
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--bz-g200)"><strong>Package</strong><span id="confirm-plan">Pro</span></div>
        <div style="display:flex;justify-content:space-between;padding:10px 0"><strong>Total Paid</strong><span id="confirm-total" style="color:var(--bz-orange);font-weight:700">$0.00</span></div>
      </div>

      <p style="font-size:15px;color:var(--bz-g600);margin-bottom:24px">Your filing is in queue. We'll email you the moment the state confirms.</p>
      <button class="btn btn-primary btn-large" onclick="alert('Dashboard would open here.')">Go to Dashboard →</button>
      <div style="margin-top:24px"><a href="#" onclick="location.reload();return false">Start a new order</a></div>
    </div>
  </div>
</div>

<!-- ==========  STEP 8 — EIN / TAX ID  ========== -->
<div id="step-9" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">EIN / Tax Identification Number Information</h2>
        <p class="card-intro">An Employer Identification Number (EIN) is a nine-digit number assigned by the IRS, used to identify your business. We will apply and obtain your EIN from the IRS electronically. This is the fastest way to get your EIN.</p>

        <div class="field"><label class="field-label">I am a foreign individual and do not have a social security number</label>
          <div class="radio-cards">
            <div class="radio-card" onclick="setEINForeign(this,true)"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">Yes</div></div></div>
            <div class="radio-card selected" onclick="setEINForeign(this,false)"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">No</div></div></div>
          </div>
        </div>

        <div class="field-row">
          <div class="field"><label class="field-label">First Name</label><input class="input" type="text" oninput="state.ein.firstName=this.value"></div>
          <div class="field"><label class="field-label">Last Name</label><input class="input" type="text" oninput="state.ein.lastName=this.value"></div>
        </div>

        <div class="field"><label class="field-label">Identification number by which I will obtain the EIN</label>
          <div class="radio-cards">
            <div class="radio-card selected" onclick="setEINIdType(this,'ssn')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">SSN</div></div></div>
            <div class="radio-card" onclick="setEINIdType(this,'itin')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">ITIN</div></div></div>
          </div>
        </div>

        <div class="field" style="max-width:280px">
          <label class="field-label">SSN <span class="field-tooltip" title="The IRS needs your SSN to verify your identity and prevent fraud.">i</span></label>
          <input class="input" type="text" placeholder="000-00-0000" oninput="state.ein.idNumber=this.value">
        </div>

        <h3 style="font-size:16px;font-weight:700;margin:24px 0 12px;color:var(--bz-black)">IRS Contact Address</h3>
        <p style="font-size:14px;color:var(--bz-g600);margin-bottom:12px">The IRS requires a physical street address to issue your EIN.</p>
        <ul style="list-style:disc;padding-left:20px;font-size:13px;color:var(--bz-g600);margin-bottom:16px;line-height:1.7">
          <li>PO Boxes are not accepted.</li>
          <li>This address is used only by the IRS to mail your official EIN Confirmation Letter.</li>
          <li>It is your responsibility to provide a valid, deliverable address.</li>
          <li>After the EIN is issued, the confirmation letter may take a couple of weeks to arrive.</li>
        </ul>

        <div class="radio-cards">
          <div class="radio-card selected" onclick="setEINAddr(this,'company')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">Use the assigned company address provided by BizJump</div></div></div>
          <div class="radio-card" onclick="setEINAddr(this,'own')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">Use a different address</div></div></div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 9 — SMALL BUSINESS BANKING  ========== -->
<div id="step-10" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Setting up Small Business Banking</h2>
        <p style="font-size:14px;color:var(--bz-g600);font-style:italic;margin-bottom:18px">No-Fee Business Banking for the Modern Business</p>
        <p class="card-intro">When forming a business, separating your business and personal accounts is a crucial step to protecting your assets. <strong>Relay</strong> is an online business banking and money management platform that helps small businesses take control of their cash flow.</p>
        <p style="font-size:13px;color:var(--bz-g600);margin-bottom:20px">*With Relay, you can apply in a few minutes, once your state formation and EIN are complete.</p>

        <div style="border:1px solid var(--bz-g200);border-radius:var(--radius-md);padding:24px;margin-bottom:20px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px">
            <div style="font-size:28px;font-weight:800;color:var(--bz-orange);font-style:italic">Relay</div>
            <a href="#" style="font-size:13px;color:var(--bz-g600)">Disclaimer</a>
          </div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;font-size:14px">
            <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> No account fees or minimums</li>
            <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Up to 20 individual checking accounts to help you control projects, budgets, and taxes</li>
            <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Have employees? Issue up to 50 Visa debit cards to keep your business moving</li>
            <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> FDIC insured*</li>
          </ul>
        </div>

        <div style="background:var(--bz-g100);border-radius:var(--radius-md);padding:20px;margin-bottom:8px">
          <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:10px"><strong style="font-size:14px">John</strong><span style="font-size:12px;color:var(--bz-g400)">4 days ago</span></div>
          <p style="font-size:14px;line-height:1.55;color:var(--bz-g900)">"Relay has been perfect for our small business. We are able to have multiple accounts to separate funds into different categories and they do not charge any fees per account. We are able to get physical cards for each account sent to us easily as well as generate virtual cards instantly for any account."</p>
        </div>

        <div class="actions-3">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <div class="group">
            <button class="btn btn-secondary" onclick="setBanking('ask_later')">Ask me later</button>
            <button class="btn btn-primary" onclick="setBanking('yes')">Yes, I'm interested ›</button>
          </div>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 10 — TAX STRATEGY CONSULTATION  ========== -->
<div id="step-11" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Tax Strategy / Free Consultation</h2>
        <p class="card-intro">This consultation can help you identify important tax deductions and provide insight into the IRS tax classification of your new business. <strong>The offer is completely free of charge and does not obligate you in any way.</strong></p>

        <h3 style="font-size:15px;font-weight:700;margin-bottom:12px">What you'll learn:</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:24px">
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>How your LLC is taxed</div>
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>Business bookkeeping requirements</div>
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>How to choose the proper IRS tax election</div>
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>How to reduce the chance of an IRS audit</div>
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>Commonly missed tax deductions</div>
          <div style="display:flex;gap:8px;font-size:14px"><span style="color:var(--bz-green);font-weight:700">✓</span>How to reduce self-employment taxes</div>
        </div>

        <div class="radio-cards">
          <div class="radio-card" onclick="setTaxConsult(this,'no')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">I'm not interested at this time.</div></div></div>
          <div class="radio-card" onclick="setTaxConsult(this,'yes')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">Yes, I would like the Business Tax Consultation <span style="color:var(--bz-green);font-weight:700">(FREE)</span></div></div></div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button id="tax-next" class="btn btn-primary" onclick="nextStep()" disabled>Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Is a Tax Strategy / Free Consultation something I should consider?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Incorporating a new business can burden owners with complicated tax filing. As a client you are entitled to receive a free 30-minute consultation with a certified tax professional who can answer questions regarding tax obligations of your company.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 11 — BUSINESS LICENSE RESEARCH  ========== -->
<div id="step-12" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:20px">
          <div style="font-size:48px;line-height:1">📋</div>
          <div>
            <h2 class="card-title" id="license-title" style="margin-bottom:8px">We've identified <strong style="color:var(--bz-orange)">2 licenses</strong> for your business in <strong id="license-state">Florida</strong></h2>
            <p style="font-size:14px;color:var(--bz-g600);line-height:1.55">As a business owner, you are responsible for making sure your business has the proper federal, state and local licenses to operate legally. To make this easier:</p>
          </div>
        </div>

        <ul style="list-style:none;padding:0;margin:0 0 20px;display:flex;flex-direction:column;gap:10px;font-size:14px">
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span>Team of licensing specialists will conduct the research for you</li>
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span>We'll determine all the licenses you need to stay compliant</li>
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span>We'll upload the research results along with a guide to next steps to your dashboard</li>
        </ul>

        <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:var(--bz-g100);border-radius:var(--radius-md);margin-bottom:24px">
          <div style="display:flex">
            <div style="width:32px;height:32px;border-radius:50%;background:#FF9F43;border:2px solid #fff;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700">A</div>
            <div style="width:32px;height:32px;border-radius:50%;background:#54A0FF;border:2px solid #fff;margin-left:-8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700">J</div>
            <div style="width:32px;height:32px;border-radius:50%;background:#10B981;border:2px solid #fff;margin-left:-8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700">M</div>
          </div>
          <p style="font-size:14px;color:var(--bz-g900);line-height:1.5"><strong>Join the 500+ business owners</strong> who have gained peace of mind with this package.</p>
        </div>

        <div class="radio-cards">
          <div class="radio-card" onclick="setLicense(this,'no')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">No thanks, I'd do the work myself</div></div></div>
          <div class="radio-card" onclick="setLicense(this,'yes')"><div class="radio-card-dot"></div><div class="radio-card-body"><div class="radio-card-title">Yes, please do the research for me <span style="color:var(--bz-orange);font-weight:700">($99)</span></div></div></div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>When will my Business License Research Package be ready?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Typically within 5–7 business days. Our team researches federal, state, county, and city license requirements for your specific industry and address, then uploads a PDF report to your dashboard with next-step instructions for each license.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 5 — PREMIUM SERVICE BUNDLE  ========== -->
<div id="step-6" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Premium Service Bundle</h2>
        <p class="card-intro">Upgrade for only <strong>$99</strong> to receive these 2 premium services — <strong>up to $330 value!</strong></p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
          <div style="border:1px solid var(--bz-g200);border-radius:var(--radius-md);padding:20px">
            <div style="display:flex;align-items:start;gap:14px">
              <div style="font-size:32px;line-height:1">📄</div>
              <div style="flex:1">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;margin-bottom:6px">
                  <div style="font-size:15px;font-weight:700">25+ Contract Library</div>
                  <div style="font-size:13px;color:var(--bz-g400);text-decoration:line-through;font-weight:600">$150</div>
                </div>
                <div style="font-size:13px;color:var(--bz-g600);line-height:1.5">Affordable, lawyer-approved business documents.</div>
              </div>
            </div>
          </div>
          <div style="border:1px solid var(--bz-g200);border-radius:var(--radius-md);padding:20px">
            <div style="display:flex;align-items:start;gap:14px">
              <div style="font-size:32px;line-height:1">📱</div>
              <div style="flex:1">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;margin-bottom:6px">
                  <div style="font-size:15px;font-weight:700">Business Phone Number</div>
                  <div style="font-size:13px;color:var(--bz-g400);text-decoration:line-through;font-weight:600">$180</div>
                </div>
                <div style="font-size:13px;color:var(--bz-g600);line-height:1.5">An all-in-one app for calls, texts, and contact management.</div>
              </div>
            </div>
          </div>
        </div>

        <div style="border-top:1px solid var(--bz-g200);padding-top:16px">
          <div style="display:flex;justify-content:space-between;font-size:14px;padding:6px 0"><span>Subtotal:</span><span>$330</span></div>
          <div style="display:flex;justify-content:space-between;font-size:14px;padding:6px 0;color:var(--bz-green);font-weight:600"><span>Package Discount:</span><span>-$231</span></div>
          <div style="display:flex;justify-content:space-between;font-size:20px;font-weight:800;padding:12px 0;border-top:1px solid var(--bz-g200);margin-top:8px"><span>Package Total:</span><span>$99</span></div>
        </div>

        <div class="actions-3" style="justify-content:space-between">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <div class="group">
            <button class="btn btn-secondary" onclick="declineBundle()">No thanks</button>
            <button class="btn btn-primary" onclick="acceptBundle()">Get limited time offer ›</button>
          </div>
        </div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 6 — MEMBERS INFORMATION  ========== -->
<div id="step-7" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title" id="members-title">Please provide Members Information</h2>

        <div class="field" style="max-width:240px">
          <label class="field-label">Number of Members/Owners</label>
          <select class="select" id="member-count" onchange="changeMemberCount(this.value)">
            <option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>
          </select>
        </div>

        <div id="members-list"></div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>What information is included in the Articles of Organization for an LLC?</span><span class="chev">⌄</span></button><div class="faq-a"><p>Most states require the LLC name, principal address, registered agent name and address, and the names of members or managers. Some states (like NY) require additional information such as the business purpose.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 7 — REGISTERED AGENT  ========== -->
<div id="step-8" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Your registered agent</h2>
        <p class="card-intro"><strong id="ra-state-name">Florida</strong> requires every <strong id="ra-entity-name">LLC</strong> to have a registered agent. A registered agent receives legal and state mail for your business, so you don't have to.</p>

        <ul style="list-style:none;padding:0;margin:0 0 20px;display:flex;flex-direction:column;gap:8px;font-size:14px">
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Receives legal documents and notices for your business</li>
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Keeps your home address off public records</li>
          <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Scans, uploads, and alerts you when documents arrive</li>
        </ul>

        <div class="radio-cards">
          <div class="radio-card selected" onclick="selectRA(this,'bizjump')">
            <div class="radio-card-dot"></div>
            <div class="radio-card-body"><div class="radio-card-title">Use BizJump as my registered agent <span style="font-weight:400;color:var(--bz-g600)">(first year included)</span></div></div>
          </div>
          <div class="radio-card" onclick="selectRA(this,'own')">
            <div class="radio-card-dot"></div>
            <div class="radio-card-body"><div class="radio-card-title">I'll be my own registered agent</div></div>
          </div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Your first year is included</span><span class="chev">⌄</span></button><div class="faq-a"><p>Year 1: included free with your package. Year 2 onward: $99/year, billed only when you choose to renew. We email a reminder 30 days before your year ends. <strong>We never auto-charge.</strong></p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Keep your address private</span><span class="chev">⌄</span></button><div class="faq-a"><p>Our address is listed on your public formation document instead of your home address. Less spam mail, less risk of legal documents being served at your house.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Never miss a document that matters</span><span class="chev">⌄</span></button><div class="faq-a"><p>We scan and upload every piece of mail to your dashboard within 1 business day and email you immediately when something urgent arrives (lawsuits, state notices, IRS letters).</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>Available during business hours</span><span class="chev">⌄</span></button><div class="faq-a"><p>Our team is available Monday–Friday 9 A.M. to 6 P.M. CST to accept your mail and certified delivery.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

<!-- ==========  STEP 4 — COMPANY ADDRESS  ========== -->
<div id="step-5" class="step">
  <div class="wizard-body">
    <div>
      <div class="card">
        <h2 class="card-title">Company Address Information</h2>
        <p class="card-intro">Formation documents are often publicly available and may include business or owner addresses. Many businesses choose to use a virtual address service for privacy.</p>

        <!-- Virtual Address sub-card -->
        <div style="border:1px solid var(--bz-g200);border-radius:var(--radius-lg);padding:24px;margin-bottom:24px;position:relative">
          <div style="display:inline-block;position:absolute;top:-12px;right:24px;background:var(--bz-green);color:#fff;font-size:11px;font-weight:700;padding:5px 12px;border-radius:var(--radius-sm);text-transform:uppercase;letter-spacing:.5px">First Month Free</div>
          <h3 style="font-size:18px;font-weight:700;margin-bottom:14px;color:var(--bz-black)">Virtual Address</h3>
          <div style="display:grid;grid-template-columns:1fr auto;gap:16px;align-items:start">
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;font-size:14px;color:var(--bz-g900)">
              <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Keep your address off public records</li>
              <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Real physical address for your business</li>
              <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Compliant with state mail requirements</li>
              <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> Unlimited mail scans with instant alerts</li>
              <li style="display:flex;gap:8px"><span style="color:var(--bz-green);font-weight:700">✓</span> 24/7 access to your mail online</li>
            </ul>
            <div style="font-size:48px;line-height:1">📱</div>
          </div>
          <div class="radio-cards" style="margin-top:20px;margin-bottom:12px">
            <div class="radio-card selected" onclick="selectVirtualAddress(this,true)">
              <div class="radio-card-dot"></div>
              <div class="radio-card-body"><div class="radio-card-title">Use Virtual Address</div></div>
            </div>
            <div class="radio-card" onclick="selectVirtualAddress(this,false)">
              <div class="radio-card-dot"></div>
              <div class="radio-card-body"><div class="radio-card-title">I'll use my own address</div></div>
            </div>
          </div>
          <p style="font-size:13px;color:var(--bz-g600);margin-top:8px">First month of Virtual Address free; then <strong>$29/month</strong>. Renew manually each year. We never auto-charge.</p>
          <p style="font-size:12px;color:var(--bz-g400);margin-top:6px">Some States may require an amendment after cancellation.</p>
          <div class="info info-blue" style="margin-top:16px"><span class="info-icon">ⓘ</span><div>USPS regulations require that we verify your identity and address before we can open and scan your mail. You will be able to complete this process and sign the corresponding USPS Form 1583 from your dashboard.</div></div>
        </div>

        <!-- Contact Address -->
        <h3 style="font-size:18px;font-weight:700;margin-bottom:6px;color:var(--bz-black)">Contact Address</h3>
        <label style="display:flex;align-items:center;gap:10px;margin:8px 0 14px;font-weight:600;color:var(--bz-g900);cursor:pointer">
          <input type="checkbox" id="same-as-contact" checked onchange="toggleSameAsContact(this.checked)" style="width:18px;height:18px;accent-color:var(--bz-orange)">
          <span>Same as Contact person</span>
        </label>
        <p style="font-size:14px;color:var(--bz-g600);margin-bottom:20px">Please provide the address of the person whom we may contact for State, IRS, or legal correspondence relating to your business.</p>

        <div id="company-addr-fields">
        <div class="field-row">
          <div class="field"><label class="field-label">First Name</label><input class="input addr-input" data-key="firstName" type="text" oninput="state.address.firstName=this.value"></div>
          <div class="field"><label class="field-label">Last Name</label><input class="input addr-input" data-key="lastName" type="text" oninput="state.address.lastName=this.value"></div>
        </div>
        <div class="field-row">
          <div class="field"><label class="field-label">Email</label><input class="input addr-input" data-key="email" type="email" oninput="state.address.email=this.value"></div>
          <div class="field"><label class="field-label">Phone</label><input class="input addr-input" data-key="phone" type="tel" oninput="state.address.phone=this.value" placeholder="+1 (555) 555-5555"></div>
        </div>

        <div class="field"><label class="field-label">Country</label><select class="select addr-input" data-key="country" onchange="state.address.country=this.value"><option value="US">United States of America (United States)</option></select></div>
        <div class="field-row">
          <div class="field"><label class="field-label">Street Address</label><input class="input addr-input" data-key="street1" type="text" oninput="state.address.street1=this.value"></div>
          <div class="field"><label class="field-label">Address (Cont) <span style="font-weight:400;color:var(--bz-g400)">Optional</span></label><input class="input addr-input" data-key="street2" type="text" oninput="state.address.street2=this.value"></div>
        </div>
        <div class="field-row-3">
          <div class="field"><label class="field-label">City</label><input class="input addr-input" data-key="city" type="text" oninput="state.address.city=this.value"></div>
          <div class="field"><label class="field-label">State</label><select class="select addr-input state-dropdown" data-key="state" id="contact-state" onchange="state.address.state=this.value"><option value="">Select State</option><?php foreach ( BJW_State_Fees::all_states() as $st ): ?><option value="<?php echo esc_attr( $st ); ?>"><?php echo esc_html( $st ); ?></option><?php endforeach; ?></select></div>
          <div class="field"><label class="field-label">Zip Code</label><input class="input addr-input" data-key="zip" type="text" oninput="state.address.zip=this.value"></div>
        </div>
        </div>

        <div class="actions">
          <button class="btn btn-secondary" onclick="prevStep()">‹ Back</button>
          <button class="btn btn-primary" onclick="nextStep()">Next ›</button>
        </div>
      </div>

      <div class="faq-card">
        <div class="faq-title">Additional Explanation</div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>How will this address be used?</span><span class="chev">⌄</span></button><div class="faq-a"><p>The contact address is used by us, the state, and the IRS to send you correspondence. The company address (Virtual or your own) is what appears on your formation document.</p></div></div>
        <div class="faq-item" onclick="this.classList.toggle('open')"><button class="faq-q"><span>How does my Free 1 month Trial work?</span><span class="chev">⌄</span></button><div class="faq-a"><p>You get one month of Virtual Address free. After that, $29/month — but only if you choose to renew. We never auto-charge. You'll get an email reminder 30 days before your first month ends.</p></div></div>
      </div>
    </div>
    <aside class="sidebar sidebar-root"></aside>
  </div>
</div>

</section>
<?php endif; /* end wizard */ ?>
