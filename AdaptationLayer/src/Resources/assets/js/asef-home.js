/* Asef Sondaj — homepage interactions (dark Apple-style design)
   Mobile menu toggle + smooth anchor scroll. No scroll-reveal:
   content is always visible (see 38761a7 for why that matters). */
(function () {
    'use strict';

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Mobile menu ---------- */
    function initMenu() {
        var nav = document.querySelector('.asef-nav');
        var burger = document.getElementById('asef-nav-burger');
        var links = document.getElementById('asef-nav-links');
        if (!nav || !burger || !links) return;

        function setOpen(open) {
            nav.classList.toggle('is-open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        burger.addEventListener('click', function () {
            setOpen(!nav.classList.contains('is-open'));
        });

        links.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () { setOpen(false); });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) setOpen(false);
        });
    }

    /* ---------- Smooth anchor scroll (nav offset) ---------- */
    function initAnchors() {
        document.querySelectorAll('.asef-home a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var id = link.getAttribute('href').slice(1);
                if (!id) return;
                var target = document.getElementById(id);
                if (!target) return;
                e.preventDefault();
                var top = target.getBoundingClientRect().top + window.pageYOffset - 64;
                window.scrollTo({ top: top, behavior: reducedMotion ? 'auto' : 'smooth' });
            });
        });
    }

    /* Bagisto mounts a Vue app on #app and re-renders its DOM on
       DOMContentLoaded; bind after window load on fresh nodes. */
    function init() {
        requestAnimationFrame(function () {
            initMenu();
            initAnchors();
        });
    }

    if (document.readyState === 'complete') {
        init();
    } else {
        window.addEventListener('load', init);
    }
})();
