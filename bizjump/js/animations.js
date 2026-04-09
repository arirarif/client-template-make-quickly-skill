/* ─── animations.js ──────────────────────────────────────────────
   Handles:
   - Scroll reveal (.reveal → .is-visible via IntersectionObserver)
   - Animated stat counters (.stat-num[data-target])
   - 3D tilt on hover (.pricing-card, .feature-card, .entity-card)
   ─────────────────────────────────────────────────────────────── */

function initAnimations() {
  initScrollReveal();
  initCounters();
  initTilt();
}

/* ── 1. Scroll Reveal ──────────────────────────────────────────── */
function initScrollReveal() {
  const revealEls = document.querySelectorAll('.reveal');
  if (!revealEls.length) return;

  // Respect prefers-reduced-motion
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReduced) {
    revealEls.forEach(el => el.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target); // fire once
        }
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -48px 0px' }
  );

  revealEls.forEach(el => observer.observe(el));
}

/* ── 2. Animated Counters ──────────────────────────────────────── */
function initCounters() {
  const counters = document.querySelectorAll('.stat-num[data-target]');
  if (!counters.length) return;

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        observer.unobserve(entry.target);

        const el = entry.target;
        const target = parseFloat(el.dataset.target);
        const suffix = el.dataset.suffix || '';
        const prefix = el.dataset.prefix || '';
        const isDecimal = String(target).includes('.');
        const decimals = isDecimal ? 1 : 0;
        const duration = 1500; // ms

        if (prefersReduced) {
          el.textContent = prefix + target.toFixed(decimals) + suffix;
          return;
        }

        const start = performance.now();
        const tick = (now) => {
          const elapsed = Math.min((now - start) / duration, 1);
          // Ease-out cubic
          const progress = 1 - Math.pow(1 - elapsed, 3);
          const current = target * progress;
          el.textContent = prefix + current.toFixed(decimals) + suffix;
          if (elapsed < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      });
    },
    { threshold: 0.5 }
  );

  counters.forEach(el => observer.observe(el));
}

/* ── 3. 3-D Card Tilt ──────────────────────────────────────────── */
function initTilt() {
  // Skip on touch devices and reduced-motion
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if ('ontouchstart' in window) return;

  const TILT_MAX = 8; // degrees
  const cards = document.querySelectorAll(
    '.pricing-card, .feature-card, .entity-card'
  );

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width  - 0.5; // -0.5 → 0.5
      const y = (e.clientY - rect.top)  / rect.height - 0.5;
      card.style.transform = `
        perspective(600px)
        rotateY(${x * TILT_MAX * 2}deg)
        rotateX(${-y * TILT_MAX * 2}deg)
        translateY(-4px)
      `;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
}
