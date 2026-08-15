/* Asef Sondaj — homepage interactions
   Scroll reveal + stat count-up. Respects prefers-reduced-motion. */
(function () {
    'use strict';

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Bagisto mounts a Vue app on #app and re-renders its DOM, wiping any
       classes added before mount and orphaning earlier observers. All init
       therefore runs AFTER window load (mount happens on DOMContentLoaded),
       on freshly queried nodes. Until then content is simply visible. */
    function initReveal() {
        if (reducedMotion || !('IntersectionObserver' in window)) return;

        var revealEls = document.querySelectorAll('.asef-reveal:not(.is-visible)');
        if (!revealEls.length) return;

        // Opt in to the hidden pre-reveal state only now that we own it.
        document.documentElement.classList.add('asef-anim');

        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { revealObserver.observe(el); });
    }

    function animateCount(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var duration = 1200;
        var start = null;

        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); /* ease-out cubic */
            el.textContent = Math.round(eased * target) + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    function initStats() {
        var statEls = document.querySelectorAll('.asef-stat-num[data-count]');
        if (reducedMotion || !('IntersectionObserver' in window) || !statEls.length) return;

        var statObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    statObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statEls.forEach(function (el) { statObserver.observe(el); });
    }

    /* ---------- Smooth anchor scroll (header offset) ---------- */
    function initAnchors() {
        document.querySelectorAll('.asef-home a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var id = link.getAttribute('href').slice(1);
                var target = document.getElementById(id);
                if (!target) return;
                e.preventDefault();
                var headerOffset = 80;
                var top = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
                window.scrollTo({ top: top, behavior: reducedMotion ? 'auto' : 'smooth' });
            });
        });
    }

    function init() {
        // Extra frame so Vue's mount render has settled before we touch DOM.
        requestAnimationFrame(function () {
            initReveal();
            initStats();
            initAnchors();
        });
    }

    if (document.readyState === 'complete') {
        init();
    } else {
        window.addEventListener('load', init);
    }
})();
