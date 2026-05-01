/* ================================================================
   BizJump Elementor Plugin — Global Scripts
   Version: 1.0.0
   ================================================================ */

(function () {
    'use strict';

    /* ── 1. Scroll Reveal — .bj-reveal ────────────────────────── */
    function initReveal() {
        var revealEls = document.querySelectorAll('.bj-reveal');
        if (!revealEls.length) return;

        var revealObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('bj-visible');
                    revealObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { revealObs.observe(el); });
    }

    /* ── 2. Counter Animation — [data-bj-counter] ──────────────── */
    function initCounters() {
        var counterEls = document.querySelectorAll('[data-bj-counter]');
        if (!counterEls.length) return;

        var counterObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el      = entry.target;
                var target  = parseInt(el.getAttribute('data-bj-counter'), 10);
                var prefix  = el.getAttribute('data-bj-prefix')  || '';
                var suffix  = el.getAttribute('data-bj-suffix')  || '';
                var dur     = 1600;
                var started = false;

                if (started) return;
                started = true;

                var startTime = performance.now();
                (function tick(now) {
                    var elapsed = now - startTime;
                    var progress = Math.min(elapsed / dur, 1);
                    /* Cubic ease-out */
                    var ease = 1 - Math.pow(1 - progress, 3);
                    var val  = Math.floor(ease * target);
                    el.textContent = prefix + val.toLocaleString() + suffix;
                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    } else {
                        el.textContent = prefix + target.toLocaleString() + suffix;
                    }
                })(startTime);

                counterObs.unobserve(el);
            });
        }, { threshold: 0.5 });

        counterEls.forEach(function (el) { counterObs.observe(el); });
    }

    /* ── 3. Hero Word Cycle — #bj-hero-word ────────────────────── */
    function initHeroWordCycle() {
        var el = document.getElementById('bj-hero-word');
        if (!el) return;

        /* Words are stored as a JSON array on a data attribute,
           populated by the widget render() function.             */
        var wordsAttr = el.getAttribute('data-bj-words');
        var words;
        try {
            words = wordsAttr ? JSON.parse(wordsAttr) : ['LLC', 'Corporation', 'S-Corp', 'Non-Profit'];
        } catch (e) {
            words = ['LLC', 'Corporation', 'S-Corp', 'Non-Profit'];
        }

        var idx = 0;

        function cycle() {
            el.classList.remove('bjw03-enter');
            el.classList.add('bjw03-exit');
            setTimeout(function () {
                idx = (idx + 1) % words.length;
                el.textContent = words[idx];
                el.classList.remove('bjw03-exit');
                el.classList.add('bjw03-enter');
            }, 420);
        }

        setInterval(cycle, 2800);
    }

    /* ── Init on DOM ready ──────────────────────────────────────── */
    function init() {
        initReveal();
        initCounters();
        initHeroWordCycle();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /* ── Re-init inside Elementor editor (preview refreshes) ───── */
    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function () {
            initReveal();
            initCounters();
            initHeroWordCycle();
        });
    }

})();
