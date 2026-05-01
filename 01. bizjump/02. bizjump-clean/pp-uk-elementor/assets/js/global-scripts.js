/**
 * PERFORMANCE PEPTIDE UK — GLOBAL SCRIPTS
 * Auto-loaded by pp-uk-elementor plugin (footer).
 */
(function () {
  'use strict';

  /* 1. SCROLL REVEAL */
  var revealEls = document.querySelectorAll('.pp-reveal');
  if (revealEls.length) {
    if (!('IntersectionObserver' in window)) {
      revealEls.forEach(function (el) { el.classList.add('pp-visible'); });
    } else {
      var revealObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry, i) {
          if (!entry.isIntersecting) return;
          var siblings = Array.from(entry.target.parentElement.querySelectorAll('.pp-reveal'));
          var delay = siblings.indexOf(entry.target) * 80;
          setTimeout(function () { entry.target.classList.add('pp-visible'); }, delay);
          revealObs.unobserve(entry.target);
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
      revealEls.forEach(function (el) { revealObs.observe(el); });
    }
  }

  /* 2. FAQ — single-open behaviour */
  var faqItems = document.querySelectorAll('.pp-faq-item');
  faqItems.forEach(function (item) {
    item.addEventListener('toggle', function () {
      if (item.open) {
        faqItems.forEach(function (other) {
          if (other !== item) other.open = false;
        });
      }
    });
  });

  /* 3. AGE GATE — sessionStorage */
  var gate   = document.getElementById('ppAgeGate');
  var accept = document.getElementById('ppGateAccept');
  if (gate && accept) {
    if (!sessionStorage.getItem('pp_age_ok')) {
      gate.classList.add('pp-gate-show');
      document.body.style.overflow = 'hidden';
    }
    accept.addEventListener('click', function () {
      sessionStorage.setItem('pp_age_ok', '1');
      gate.classList.remove('pp-gate-show');
      document.body.style.overflow = '';
    });
  }

  /* 4. NEWSLETTER demo submit handler */
  var newsForms = document.querySelectorAll('.pp-news-form');
  newsForms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var input = form.querySelector('input[type="email"]');
      var note  = form.parentElement.querySelector('.pp-news-note');
      if (input) input.value = '';
      if (note)  note.textContent = "Thanks — you're on the list.";
    });
  });

  /* 5. RESPECT prefers-reduced-motion */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    revealEls.forEach(function (el) { el.classList.add('pp-visible'); });
  }

})();
