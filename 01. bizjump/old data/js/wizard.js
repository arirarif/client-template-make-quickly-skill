/* ─── wizard.js ──────────────────────────────────────────────────
   Handles:
   - Pricing toggle: one-time vs subscription
     Reads data-onetime / data-subscription on .pc-amount elements
     Updates .pc-per text accordingly
   ─────────────────────────────────────────────────────────────── */

function initWizard() {
  initPricingToggle();
}

/* ── Pricing Toggle ────────────────────────────────────────────── */
function initPricingToggle() {
  const toggleBtns = document.querySelectorAll('.ptoggle-btn');
  if (!toggleBtns.length) return;

  let currentMode = 'onetime'; // default

  toggleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const mode = btn.dataset.plan;
      if (mode === currentMode) return;
      currentMode = mode;
      setPricingPlan(mode);
    });
  });

  // Initialise on load
  setPricingPlan(currentMode);
}

function setPricingPlan(mode) {
  /* Update toggle button states */
  document.querySelectorAll('.ptoggle-btn').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.plan === mode);
  });

  /* Update prices */
  document.querySelectorAll('.pc-amount[data-onetime]').forEach(el => {
    const val = mode === 'onetime' ? el.dataset.onetime : el.dataset.subscription;
    if (val !== undefined) animatePrice(el, val);
  });

  /* Update per-period label */
  const perLabels = document.querySelectorAll('.pc-per');
  perLabels.forEach(label => {
    label.textContent = mode === 'onetime' ? 'one-time' : '/ year';
  });
}

/* Briefly flash price when switching plans */
function animatePrice(el, newVal) {
  el.style.transition = 'opacity 150ms ease';
  el.style.opacity = '0';
  setTimeout(() => {
    el.textContent = newVal;
    el.style.opacity = '1';
  }, 150);
}
