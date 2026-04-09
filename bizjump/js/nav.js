/* ─── nav.js ─────────────────────────────────────────────────────
   Handles:
   - Sticky nav scroll class (.nav.scrolled)
   - Mobile drawer open/close (#navHamburger ↔ #navMobile)
   - Announcement bar dismiss
   - Close mobile menu on link click
   ─────────────────────────────────────────────────────────────── */

function initNav() {
  /* ── Sticky scroll class ── */
  const nav = document.getElementById('mainNav');
  if (nav) {
    const onScroll = () => {
      nav.classList.toggle('scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load
  }

  /* ── Mobile drawer toggle ── */
  const hamburger = document.getElementById('navHamburger');
  const mobileMenu = document.getElementById('navMobile');

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('open');
      hamburger.classList.toggle('open', isOpen);
      hamburger.setAttribute('aria-expanded', isOpen);
      // Prevent body scroll when drawer is open
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on any link inside the drawer
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });

    // Close on overlay click (clicking outside the drawer panel)
    mobileMenu.addEventListener('click', (e) => {
      if (e.target === mobileMenu) {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  /* ── Announcement bar dismiss ── */
  const dismissBtn = document.getElementById('announceClose');
  const bar = document.getElementById('announceBar');
  if (dismissBtn && bar) {
    dismissBtn.addEventListener('click', () => {
      bar.style.maxHeight = bar.offsetHeight + 'px';
      requestAnimationFrame(() => {
        bar.style.transition = 'max-height 300ms ease, opacity 300ms ease';
        bar.style.maxHeight = '0';
        bar.style.opacity = '0';
        bar.style.overflow = 'hidden';
      });
      bar.addEventListener('transitionend', () => bar.remove(), { once: true });
    });
  }
}
