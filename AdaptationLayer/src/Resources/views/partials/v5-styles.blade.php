{{-- Shared v5 design language styles (Apple-esque minimalist).
     Push once per page via @include('asef-adaptation::partials.v5-styles'). --}}
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", Arial, sans-serif;
            background: #FFFFFF;
            color: #1a1c1d;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            line-height: 1.5;
        }
        img { max-width: 100%; display: block; }

        .asef-root a { color: inherit; text-decoration: none; }
        .asef-root button { font-family: inherit; cursor: pointer; border: 0; background: none; }

        :root {
            --primary: #000000;
            --on-surface: #1a1c1d;
            --secondary: #5f5e60;
            --gray-secondary: #86868B;
            --outline: #D2D2D7;
            --surface-alt: #F5F5F7;
            --link-blue: #0066CC;
        }

        .asef-container { max-width: 1024px; margin: 0 auto; padding: 0 20px; }
        .asef-container-wide { max-width: 1440px; margin: 0 auto; padding: 0 20px; }
        @media (min-width: 768px) { .asef-container-wide { padding: 0 32px; } }

        /* NAV */
        .asef-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(210,210,215,0.5);
        }
        .asef-nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 56px;
            max-width: 1024px; margin: 0 auto; padding: 0 20px;
        }
        .asef-brand {
            font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary);
        }
        .asef-nav-menu { display: none; align-items: center; gap: 32px; }
        @media (min-width: 900px) { .asef-nav-menu { display: flex; } }
        .asef-nav-menu > a,
        .asef-nav-item > a {
            font-size: 13px; color: var(--secondary); font-weight: 500;
            transition: color .15s; cursor: pointer;
        }
        .asef-nav-menu > a:hover,
        .asef-nav-item:hover > a,
        .asef-nav-item:focus-within > a { color: var(--primary); }
        .asef-nav-item { position: static; }

        /* MEGA MENU */
        .asef-mega {
            position: absolute; top: 100%; left: 0; right: 0;
            background: rgba(255,255,255,0.98);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(210,210,215,0.5);
            padding: 36px 0 40px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity .22s ease, transform .28s ease, visibility 0s linear .22s;
            z-index: 99;
        }
        .asef-nav-item:hover .asef-mega,
        .asef-nav-item:focus-within .asef-mega,
        .asef-mega:hover {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity .22s ease, transform .28s ease, visibility 0s linear 0s;
        }
        .asef-mega-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px;
            max-width: 1024px; margin: 0 auto; padding: 0 20px;
        }
        .asef-mega-col h5 {
            font-size: 12px; font-weight: 400; color: var(--gray-secondary);
            margin-bottom: 14px; letter-spacing: 0;
        }
        .asef-mega-main a {
            display: block; padding: 4px 0;
            font-size: 22px; font-weight: 600; letter-spacing: -0.01em;
            color: var(--primary); line-height: 1.3;
        }
        .asef-mega-main a:hover { color: var(--link-blue); }
        .asef-mega-side a {
            display: block; padding: 4px 0;
            font-size: 12px; color: var(--on-surface);
            font-weight: 400;
        }
        .asef-mega-side a:hover { color: var(--link-blue); }
        .asef-mega-small { margin-top: 10px; }
        .asef-mega-small a {
            display: block; padding: 3px 0;
            font-size: 12px; font-weight: 400; color: var(--secondary);
            letter-spacing: 0;
        }
        .asef-mega-small a:hover { color: var(--link-blue); }
        .asef-nav-actions { display: none; align-items: center; gap: 8px; }
        @media (min-width: 900px) { .asef-nav-actions { display: flex; } }
        .asef-nav-icon-btn {
            width: 34px; height: 34px; display: grid; place-items: center;
            color: var(--secondary); transition: color .15s; position: relative;
        }
        .asef-nav-icon-btn:hover { color: var(--primary); }
        .asef-nav-icon-btn .asef-badge {
            position: absolute; top: -1px; right: -3px;
            background: var(--link-blue); color: white;
            font-size: 9px; font-weight: 700;
            min-width: 15px; height: 15px; padding: 0 4px; border-radius: 999px;
            display: grid; place-items: center;
        }
        .asef-nav-cta {
            background: var(--link-blue); color: white;
            padding: 6px 14px; border-radius: 999px;
            font-size: 12px; font-weight: 600;
            margin-left: 8px;
        }
        .asef-nav-cta:hover { opacity: 0.9; }
        .asef-nav-mobile-btn {
            display: grid; place-items: center; width: 34px; height: 34px; color: var(--primary);
        }
        @media (min-width: 900px) { .asef-nav-mobile-btn { display: none; } }

        .asef-main { padding-top: 56px; }

        .asef-label-caps {
            font-size: 12px; font-weight: 500; letter-spacing: 0.08em;
            text-transform: uppercase; color: var(--gray-secondary);
        }

        /* HERO */
        .asef-hero {
            max-width: 1024px; margin: 0 auto;
            padding: 40px 20px 48px;
            text-align: center;
        }
        @media (min-width: 768px) { .asef-hero { padding: 56px 20px 72px; } }
        .asef-hero h1 {
            font-size: clamp(36px, 5.8vw, 56px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.08;
            color: var(--primary); margin: 24px auto;
            max-width: 780px;
        }
        .asef-hero p {
            font-size: clamp(17px, 1.8vw, 21px);
            color: var(--gray-secondary);
            max-width: 620px; margin: 0 auto 32px;
            line-height: 1.5;
        }
        .asef-hero-ctas { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .asef-cta-pill {
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            padding: 13px 26px; border-radius: 999px;
            font-size: 15px; font-weight: 600;
            letter-spacing: -0.005em;
            transition: transform .18s ease, box-shadow .2s ease, background .15s;
            line-height: 1;
        }
        .asef-cta-pill svg { flex-shrink: 0; }
        .asef-cta-pill.primary {
            background: linear-gradient(180deg, #0077E0 0%, #0066CC 100%);
            color: #FFFFFF !important;
            box-shadow: 0 1px 0 rgba(255,255,255,0.16) inset, 0 4px 14px rgba(0, 102, 204, 0.28);
        }
        .asef-cta-pill.primary:hover {
            background: linear-gradient(180deg, #0080ED 0%, #006EDA 100%);
            box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 6px 20px rgba(0, 102, 204, 0.4);
            transform: translateY(-1px);
        }
        .asef-cta-pill.primary:active { transform: translateY(0); }

        .asef-cta-pill.black {
            background: linear-gradient(180deg, #1c1c1e 0%, #000000 100%);
            color: #FFFFFF !important;
            box-shadow: 0 1px 0 rgba(255,255,255,0.14) inset, 0 4px 14px rgba(0,0,0,0.28);
        }
        .asef-cta-pill.black:hover {
            background: linear-gradient(180deg, #262629 0%, #0d0d0f 100%);
            box-shadow: 0 1px 0 rgba(255,255,255,0.18) inset, 0 6px 20px rgba(0,0,0,0.4);
            transform: translateY(-1px);
        }
        .asef-cta-pill.black:active { transform: translateY(0); }

        .asef-cta-pill.outline {
            background: white; color: var(--primary);
            border: 1px solid var(--outline);
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .asef-cta-pill.outline:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-1px);
        }
        .asef-cta-pill.outline:active { transform: translateY(0); }

        .asef-cta-pill.ghost {
            color: var(--link-blue); font-weight: 500;
            padding: 11px 18px;
        }
        .asef-cta-pill.ghost:hover { opacity: 0.7; transform: translateX(2px); }
        .asef-cta-pill.white-bg {
            background: white; color: var(--primary);
            box-shadow: 0 4px 14px rgba(0,0,0,0.14);
        }
        .asef-cta-pill.white-bg:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.22);
            transform: translateY(-1px);
        }
        .asef-cta-arrow { font-weight: 400; margin-left: 2px; transition: transform .2s; display: inline-block; }
        .asef-cta-pill:hover .asef-cta-arrow { transform: translateX(2px); }

        /* HERO IMAGE */
        .asef-hero-image-wrap {
            max-width: 1440px; margin: 0 auto 80px;
            padding: 0 20px;
        }
        @media (min-width: 768px) {
            .asef-hero-image-wrap { padding: 0 32px; margin-bottom: 120px; }
        }
        .asef-hero-image {
            width: 100%;
            height: 380px;
            border-radius: 20px;
            overflow: hidden;
            background: #14161a;
        }
        @media (min-width: 768px) { .asef-hero-image { height: 560px; } }
        .asef-hero-image img { width: 100%; height: 100%; object-fit: cover; }

        /* SECTION SPACING */
        .asef-section { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
        @media (min-width: 768px) { .asef-section { margin-bottom: 120px; } }
        .asef-section-wide { max-width: 1440px; margin: 0 auto 80px; padding: 0 20px; }
        @media (min-width: 768px) { .asef-section-wide { margin-bottom: 120px; padding: 0 32px; } }

        .asef-section-head {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 32px;
        }
        .asef-section-head-left { display: flex; flex-direction: column; gap: 6px; }
        .asef-section-head h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600; letter-spacing: -0.01em; line-height: 1.1;
            color: var(--primary);
        }
        .asef-section-head-center {
            text-align: center; margin-bottom: 40px;
        }
        .asef-section-head-center .asef-label-caps { margin-bottom: 8px; }
        .asef-section-head-center h2 { margin: 0 auto; max-width: 700px; }
        .asef-section-link {
            color: var(--link-blue); font-size: 14px; font-weight: 500;
            display: none; align-items: center; gap: 4px;
        }
        @media (min-width: 768px) { .asef-section-link { display: inline-flex; } }
        .asef-section-link:hover { opacity: 0.7; }

        /* CATEGORY GRID (kompakt) */
        .asef-cat-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;
        }
        @media (min-width: 768px) { .asef-cat-grid { grid-template-columns: repeat(4, 1fr); } }
        .asef-cat-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            transition: transform .25s ease, background .2s;
            display: flex; flex-direction: column;
        }
        .asef-cat-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-cat-media {
            aspect-ratio: 1/1;
            overflow: hidden;
            background: #14161a;
        }
        .asef-cat-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-cat-body { padding: 14px 16px 16px; }
        .asef-cat-title { font-size: 15px; font-weight: 600; color: var(--primary); }
        .asef-cat-meta { font-size: 12px; color: var(--gray-secondary); margin-top: 2px; }

        /* PRODUCT BENTO */
        .asef-prod-grid {
            display: grid; grid-template-columns: 1fr; gap: 16px;
        }
        @media (min-width: 768px) { .asef-prod-grid { grid-template-columns: 1fr 1fr; } }
        .asef-prod-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform .25s ease, background .2s;
        }
        .asef-prod-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-prod-media {
            aspect-ratio: 16/10;
            background: #14161a;
            overflow: hidden;
        }
        .asef-prod-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-prod-body { padding: 24px; }
        .asef-prod-sku {
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 11px; letter-spacing: 0.1em;
            color: var(--gray-secondary); margin-bottom: 6px;
        }
        .asef-prod-title {
            font-size: 22px; font-weight: 600; letter-spacing: -0.005em;
            color: var(--primary); margin-bottom: 8px;
        }
        .asef-prod-desc {
            font-size: 15px; color: var(--secondary);
            line-height: 1.5; margin-bottom: 16px;
        }
        .asef-prod-link {
            color: var(--link-blue); font-size: 14px; font-weight: 500;
        }

        /* MARKA TANITIMI */
        .asef-brand-block { text-align: center; }
        .asef-brand-block h2 {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: var(--primary); max-width: 720px; margin: 20px auto 20px;
        }
        .asef-brand-block p {
            font-size: clamp(17px, 1.6vw, 19px);
            color: var(--gray-secondary); max-width: 620px; margin: 0 auto 24px;
            line-height: 1.55;
        }

        /* HIZMETLER */
        .asef-services-grid {
            display: grid; grid-template-columns: 1fr; gap: 16px;
        }
        @media (min-width: 768px) { .asef-services-grid { grid-template-columns: repeat(3, 1fr); } }
        .asef-service-card {
            background: var(--surface-alt); border-radius: 20px; padding: 32px;
        }
        .asef-service-icon {
            width: 40px; height: 40px; color: var(--primary);
            margin-bottom: 20px;
        }
        .asef-service-title {
            font-size: 22px; font-weight: 600; color: var(--primary);
            margin-bottom: 10px; letter-spacing: -0.005em;
        }
        .asef-service-desc {
            font-size: 15px; color: var(--secondary); line-height: 1.55;
        }

        /* MAKINE VITRIN */
        .asef-machine-showcase {
            position: relative; border-radius: 20px; overflow: hidden;
            height: 420px;
        }
        @media (min-width: 768px) { .asef-machine-showcase { height: 560px; } }
        .asef-machine-showcase-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
        }
        .asef-machine-showcase::after {
            content: "";
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        }
        .asef-machine-content {
            position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
            padding: 32px;
            color: white;
        }
        @media (min-width: 768px) { .asef-machine-content { padding: 56px; } }
        .asef-machine-content .asef-label-caps { color: rgba(255,255,255,0.7); margin-bottom: 12px; }
        .asef-machine-content h2 {
            font-size: clamp(32px, 4.5vw, 48px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: white; margin-bottom: 16px; max-width: 600px;
        }
        .asef-machine-content p {
            font-size: clamp(15px, 1.6vw, 19px);
            color: rgba(255,255,255,0.85);
            max-width: 500px; margin-bottom: 24px;
            line-height: 1.55;
        }

        /* TIMELINE */
        .asef-timeline-wrap { max-width: 720px; margin: 0 auto; padding: 20px 0; position: relative; }
        .asef-timeline-wrap::before {
            content: "";
            position: absolute; top: 20px; bottom: 20px;
            left: 50%; transform: translateX(-50%);
            width: 2px; background: #E5E5EA;
        }
        @media (max-width: 767px) {
            .asef-timeline-wrap::before { left: 12px; transform: none; }
        }
        .asef-timeline-item {
            position: relative;
            display: grid; grid-template-columns: 1fr 40px 1fr;
            align-items: center;
            margin-bottom: 32px;
        }
        .asef-timeline-item:last-child { margin-bottom: 0; }
        .asef-timeline-dot {
            position: relative; z-index: 2;
            width: 12px; height: 12px; border-radius: 999px; background: var(--primary);
            justify-self: center;
            box-shadow: 0 0 0 4px white;
        }
        .asef-timeline-content {
            background: var(--surface-alt); border-radius: 16px; padding: 20px 24px;
        }
        .asef-timeline-year {
            font-size: 24px; font-weight: 600; color: var(--primary); margin-bottom: 4px;
            letter-spacing: -0.01em;
        }
        .asef-timeline-text {
            font-size: 15px; color: var(--secondary); line-height: 1.5;
        }
        .asef-timeline-item.left .asef-timeline-content { grid-column: 1; }
        .asef-timeline-item.right .asef-timeline-content { grid-column: 3; }
        @media (max-width: 767px) {
            .asef-timeline-item { grid-template-columns: 40px 1fr; }
            .asef-timeline-dot { grid-column: 1; }
            .asef-timeline-content,
            .asef-timeline-item.left .asef-timeline-content,
            .asef-timeline-item.right .asef-timeline-content {
                grid-column: 2;
            }
        }

        /* CTA BAND */
        .asef-cta-band {
            background: var(--surface-alt); border-radius: 20px;
            padding: 48px 32px; text-align: center;
        }
        @media (min-width: 768px) { .asef-cta-band { padding: 64px 48px; } }
        .asef-cta-band .asef-label-caps { margin-bottom: 16px; }
        .asef-cta-band h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600; letter-spacing: -0.02em;
            color: var(--primary); margin-bottom: 12px; max-width: 640px;
            margin-left: auto; margin-right: auto;
        }
        .asef-cta-band p {
            font-size: 15px; color: var(--gray-secondary);
            max-width: 500px; margin: 0 auto 24px; line-height: 1.55;
        }
        .asef-cta-band-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* SEARCH PAGE — hero search bar */
        .asef-search-hero {
            max-width: 1024px; margin: 0 auto;
            padding: 40px 20px 32px;
            text-align: center;
        }
        @media (min-width: 768px) { .asef-search-hero { padding: 56px 20px 40px; } }
        .asef-search-hero h1 {
            font-size: clamp(36px, 5vw, 48px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: var(--primary); margin: 16px auto 12px;
        }
        .asef-search-hero p {
            font-size: 17px; color: var(--gray-secondary);
            max-width: 500px; margin: 0 auto 28px;
        }
        .asef-search-form {
            max-width: 640px; margin: 0 auto;
            position: relative;
            padding: 2px;
            border-radius: 999px;
            overflow: hidden;
            isolation: isolate;
            background: #FFFFFF;
        }
        .asef-search-form::before {
            content: "";
            position: absolute;
            top: 50%; left: 50%;
            width: 200%; aspect-ratio: 1;
            transform: translate(-50%, -50%);
            background: conic-gradient(
                from 0deg,
                transparent 0%,
                transparent 55%,
                #000 68%,
                transparent 82%,
                transparent 100%
            );
            animation: asef-search-spin 3s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        .asef-search-form::after {
            content: "";
            position: absolute; inset: 2px;
            border-radius: 999px;
            background: #F5F5F7;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.9), inset 0 -1px 2px rgba(0,0,0,0.03);
            z-index: 1;
            pointer-events: none;
        }
        @keyframes asef-search-spin {
            to { transform: translate(-50%, -50%) rotate(1turn); }
        }
        @media (prefers-reduced-motion: reduce) {
            .asef-search-form::before { animation: none; }
        }
        .asef-search-input {
            position: relative; z-index: 2;
            width: 100%; height: 54px; padding: 0 56px 0 24px;
            border-radius: 999px; border: 0;
            background: transparent;
            font-family: inherit; font-size: 17px; color: var(--primary);
            outline: none;
        }
        .asef-search-input::placeholder { color: var(--gray-secondary); }
        .asef-search-btn {
            position: absolute; top: 50%; right: 8px;
            transform: translateY(-50%);
            width: 40px; height: 40px; border-radius: 999px;
            background: var(--link-blue); color: white;
            display: grid; place-items: center;
            cursor: pointer;
            z-index: 3;
            transition: opacity .15s, transform .15s;
        }
        .asef-search-btn:hover { opacity: 0.9; }
        .asef-search-btn:active { transform: translateY(-50%) scale(0.96); }

        /* CATEGORY CHIPS (premium 3D) */
        .asef-chips-row {
            max-width: 1024px; margin: 0 auto 40px;
            padding: 0 20px;
            display: flex; flex-wrap: wrap; gap: 10px;
            justify-content: center;
        }
        .asef-chip {
            position: relative;
            display: inline-flex; align-items: center; gap: 6px;
            height: 34px;
            padding: 0 16px; border-radius: 999px;
            font-size: 13px; font-weight: 500; letter-spacing: -0.005em;
            border: 1px solid var(--primary);
            background: #FFFFFF;
            color: var(--on-surface);
            box-sizing: border-box;
            transition: transform .2s cubic-bezier(0.16, 1, 0.3, 1), border-color .2s, color .2s, background .2s, box-shadow .22s;
            cursor: pointer; user-select: none;
            box-shadow:
                0 1px 0 rgba(255,255,255,0.9) inset,
                0 1px 2px rgba(0,0,0,0.04),
                0 2px 6px rgba(0,0,0,0.03);
        }
        .asef-chip:hover {
            border-color: var(--primary);
            background: #F5F5F7;
            transform: translateY(-1px);
            box-shadow:
                0 1px 0 rgba(255,255,255,1) inset,
                0 3px 6px rgba(0,0,0,0.05),
                0 6px 16px rgba(0,0,0,0.06);
        }
        .asef-chip:active { transform: translateY(0); box-shadow: 0 1px 2px rgba(0,0,0,0.06); }
        .asef-chip.active {
            background: linear-gradient(180deg, #262629 0%, #000 100%);
            color: #FFFFFF;
            border-color: #000;
            box-shadow:
                0 1px 0 rgba(255,255,255,0.16) inset,
                0 -1px 0 rgba(0,0,0,0.4) inset,
                0 6px 16px rgba(0,0,0,0.22),
                0 2px 4px rgba(0,0,0,0.12);
        }
        .asef-chip.active:hover {
            background: linear-gradient(180deg, #313134 0%, #0a0a0c 100%);
            transform: translateY(-1px);
            box-shadow:
                0 1px 0 rgba(255,255,255,0.2) inset,
                0 -1px 0 rgba(0,0,0,0.4) inset,
                0 8px 22px rgba(0,0,0,0.3),
                0 3px 6px rgba(0,0,0,0.14);
        }
        .asef-chip.active:active {
            transform: translateY(0);
            box-shadow:
                0 1px 0 rgba(255,255,255,0.12) inset,
                0 2px 6px rgba(0,0,0,0.28);
        }

        /* PRODUCT GRID (search results) */
        .asef-search-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;
            max-width: 1024px; margin: 0 auto; padding: 0 20px;
        }
        @media (min-width: 768px) { .asef-search-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; } }
        @media (min-width: 1024px) { .asef-search-grid { grid-template-columns: repeat(4, 1fr); } }
        .asef-search-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform .25s ease, background .2s;
        }
        .asef-search-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-search-media {
            aspect-ratio: 1/1;
            background: #14161a; overflow: hidden;
            position: relative;
        }
        .asef-search-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-search-sku {
            position: absolute; left: 10px; bottom: 10px;
            background: rgba(0,0,0,0.72); color: white;
            padding: 4px 8px; border-radius: 6px;
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 10px; letter-spacing: 0.08em;
        }
        .asef-search-body { padding: 14px 16px 12px; flex: 1; display: flex; flex-direction: column; }
        .asef-search-cat { font-size: 11px; color: var(--gray-secondary); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 4px; }
        .asef-search-name { font-size: 15px; font-weight: 600; color: var(--primary); margin-bottom: 4px; line-height: 1.3; }
        .asef-search-desc { font-size: 13px; color: var(--secondary); line-height: 1.4; flex: 1; }
        .asef-search-foot {
            padding: 10px 12px 12px;
            display: flex; gap: 6px;
        }
        .asef-root .asef-search-add,
        button.asef-search-add {
            flex: 1 1 auto !important;
            display: inline-flex !important;
            align-items: center !important; justify-content: center !important; gap: 8px !important;
            padding: 11px 16px !important;
            background-color: #0066CC !important;
            background-image: none !important;
            color: #FFFFFF !important;
            border-radius: 999px !important;
            border: 0 !important;
            font-size: 13px !important; font-weight: 600 !important; letter-spacing: -0.005em !important;
            transition: transform .15s ease, box-shadow .2s ease, background-color .15s !important;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.28) !important;
            cursor: pointer !important; font-family: inherit !important;
            opacity: 1 !important;
            line-height: 1 !important;
        }
        .asef-root .asef-search-add:hover,
        button.asef-search-add:hover {
            background-color: #0077E0 !important;
            box-shadow: 0 6px 18px rgba(0, 102, 204, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        .asef-root .asef-search-add:active,
        button.asef-search-add:active { transform: translateY(0) !important; }
        .asef-root .asef-search-add svg,
        button.asef-search-add svg { width: 16px !important; height: 16px !important; flex-shrink: 0; color: #FFFFFF !important; }

        .asef-search-detail {
            width: 44px !important; padding: 10px !important;
            display: inline-flex !important; align-items: center !important; justify-content: center !important;
            background-color: #FFFFFF !important;
            background-image: none !important;
            color: var(--primary) !important;
            border: 1px solid var(--outline) !important;
            border-radius: 999px !important;
            transition: border-color .15s, transform .15s, box-shadow .2s;
            flex-shrink: 0;
        }
        .asef-search-detail:hover {
            border-color: var(--primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .asef-search-detail svg { width: 16px !important; height: 16px !important; }

        .asef-search-count {
            max-width: 1024px; margin: 0 auto 20px; padding: 0 20px;
            font-size: 13px; color: var(--gray-secondary);
            display: flex; justify-content: space-between; align-items: center;
        }
        .asef-search-empty {
            max-width: 1024px; margin: 0 auto; padding: 60px 20px; text-align: center;
        }
        .asef-search-empty h3 { font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 8px; }
        .asef-search-empty p { font-size: 15px; color: var(--gray-secondary); margin-bottom: 24px; }

        /* FOOTER */
        .asef-footer {
            border-top: 1px solid rgba(210,210,215,0.5);
            padding: 60px 0 24px;
            margin-top: 80px;
        }
        @media (min-width: 768px) { .asef-footer { margin-top: 120px; } }
        .asef-footer-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 40px 24px;
            margin-bottom: 40px;
        }
        @media (min-width: 768px) {
            .asef-footer-grid { grid-template-columns: 1.5fr 1fr 1fr 1fr; }
        }
        .asef-footer-brand { grid-column: 1 / -1; }
        @media (min-width: 768px) { .asef-footer-brand { grid-column: auto; max-width: 300px; } }
        .asef-footer-brand .asef-brand { display: block; margin-bottom: 12px; }
        .asef-footer-brand p { font-size: 13px; color: var(--gray-secondary); line-height: 1.55; }
        .asef-footer-col h4 {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--gray-secondary); margin-bottom: 16px;
        }
        .asef-footer-col ul { list-style: none; }
        .asef-footer-col li { margin-bottom: 12px; font-size: 13px; color: var(--secondary); line-height: 1.55; }
        .asef-footer-col a { font-size: 13px; color: var(--secondary); }
        .asef-footer-col a:hover { color: var(--primary); }
        .asef-footer-bottom {
            padding-top: 20px;
            border-top: 1px solid rgba(210,210,215,0.5);
            display: flex; flex-direction: column; gap: 12px;
            justify-content: space-between; align-items: center;
            font-size: 12px; color: var(--gray-secondary);
        }
        @media (min-width: 768px) { .asef-footer-bottom { flex-direction: row; } }
        .asef-footer-legal { display: flex; gap: 20px; }
        .asef-footer-legal a:hover { color: var(--primary); }

        /* ============= PRODUCT DETAIL ============= */
        .asef-pd-wrap {
            max-width: 1024px; margin: 0 auto;
            padding: 40px 20px 24px;
        }
        @media (min-width: 768px) { .asef-pd-wrap { padding: 56px 20px 32px; } }
        .asef-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--gray-secondary);
            margin-bottom: 24px;
        }
        .asef-breadcrumb a { color: var(--gray-secondary); transition: color .15s; }
        .asef-breadcrumb a:hover { color: var(--link-blue); }
        .asef-breadcrumb .sep { color: var(--outline); }
        .asef-breadcrumb .current { color: var(--on-surface); font-weight: 500; }

        .asef-pd-grid {
            display: grid; grid-template-columns: 1fr; gap: 32px;
        }
        @media (min-width: 900px) { .asef-pd-grid { grid-template-columns: 1.05fr 1fr; gap: 48px; } }

        .asef-pd-gallery {
            background: var(--surface-alt);
            border-radius: 24px;
            overflow: hidden;
            aspect-ratio: 1/1;
            display: grid; place-items: center;
        }
        .asef-pd-gallery img { width: 100%; height: 100%; object-fit: cover; }
        .asef-pd-thumbs {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 12px;
        }
        .asef-pd-thumb {
            aspect-ratio: 1/1; border-radius: 12px; overflow: hidden;
            background: var(--surface-alt); cursor: pointer;
            border: 2px solid transparent;
            transition: border-color .15s;
        }
        .asef-pd-thumb.active { border-color: var(--primary); }
        .asef-pd-thumb img { width: 100%; height: 100%; object-fit: cover; }

        .asef-pd-info { display: flex; flex-direction: column; }
        .asef-pd-cat {
            font-size: 13px; font-weight: 500; color: var(--link-blue);
            letter-spacing: 0.02em; margin-bottom: 12px;
        }
        .asef-pd-title {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: var(--primary); margin-bottom: 16px;
        }
        .asef-pd-sku-line {
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 12px; letter-spacing: 0.08em; color: var(--gray-secondary);
            margin-bottom: 20px;
        }
        .asef-pd-desc {
            font-size: 17px; color: var(--secondary); line-height: 1.55;
            margin-bottom: 28px;
        }

        .asef-pd-usecases-title {
            font-size: 15px; font-weight: 600; color: var(--primary);
            margin-bottom: 12px;
        }
        .asef-pd-usecases {
            display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px;
        }
        .asef-pd-usecase {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; border-radius: 999px;
            background: var(--surface-alt); color: var(--on-surface);
            font-size: 13px; font-weight: 500;
        }
        .asef-pd-usecase svg { width: 14px; height: 14px; color: var(--link-blue); }

        .asef-pd-spec-head {
            padding-top: 32px; margin-bottom: 20px;
            display: flex; align-items: baseline; justify-content: space-between;
            border-top: 1px solid var(--outline);
        }
        .asef-pd-spec-title {
            font-size: 22px; font-weight: 600; letter-spacing: -0.01em;
            color: var(--primary);
        }
        .asef-pd-spec-sub {
            font-size: 12px; color: var(--gray-secondary);
            letter-spacing: 0.06em; text-transform: uppercase;
        }
        .asef-pd-spec-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
        }
        .asef-pd-spec-card {
            background: var(--surface-alt);
            border-radius: 18px;
            padding: 20px 22px 22px;
            position: relative;
            overflow: hidden;
            transition: transform .2s ease, background .2s;
        }
        .asef-pd-spec-card::before {
            content: "";
            position: absolute; inset: 0;
            background: radial-gradient(circle at 100% 0%, rgba(0,102,204,0.06), transparent 55%);
            pointer-events: none;
        }
        .asef-pd-spec-card:hover { transform: translateY(-1px); background: #EEEEF0; }
        .asef-pd-spec-num {
            display: block;
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 11px; letter-spacing: 0.08em;
            color: var(--gray-secondary);
            margin-bottom: 8px;
        }
        .asef-pd-spec-label-new {
            display: block;
            font-size: 13px; color: var(--secondary); font-weight: 500;
            margin-bottom: 10px;
            letter-spacing: -0.005em;
        }
        .asef-pd-spec-value-new {
            display: block;
            font-size: 20px; font-weight: 600; letter-spacing: -0.01em;
            color: var(--primary);
            line-height: 1.15;
        }
        @media (max-width: 500px) {
            .asef-pd-spec-grid { grid-template-columns: 1fr; }
        }

        .asef-pd-card {
            background: var(--surface-alt); border-radius: 20px;
            padding: 24px;
            margin-top: 28px;
        }
        .asef-pd-card-head {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 16px;
        }
        .asef-pd-card-title {
            font-size: 18px; font-weight: 600; color: var(--primary);
        }
        .asef-pd-stock {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; color: #10794A;
        }
        .asef-pd-stock::before {
            content: ""; width: 8px; height: 8px; border-radius: 999px; background: #10794A;
        }
        .asef-pd-qty-row {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 16px;
        }
        .asef-pd-qty-label { font-size: 13px; color: var(--gray-secondary); }
        .asef-qty-picker {
            display: inline-flex; align-items: center;
            background: white; border-radius: 999px; border: 1px solid var(--outline);
            padding: 4px;
        }
        .asef-qty-btn {
            width: 32px; height: 32px; border-radius: 999px;
            display: grid; place-items: center;
            color: var(--primary);
            transition: background .15s;
        }
        .asef-qty-btn:hover { background: var(--surface-alt); }
        .asef-qty-btn:disabled { opacity: 0.3; cursor: not-allowed; }
        .asef-qty-value {
            min-width: 32px; text-align: center; font-weight: 600; font-size: 15px;
        }
        .asef-pd-cta-row {
            display: flex; gap: 10px; flex-wrap: wrap;
        }
        .asef-pd-cta-row .asef-cta-pill { flex: 1; justify-content: center; min-width: 120px; padding: 13px 22px; font-size: 15px; }

        .asef-pd-note {
            display: flex; gap: 12px;
            padding: 14px 16px;
            background: var(--surface-alt); border-radius: 12px;
            margin-top: 16px;
            font-size: 13px; color: var(--secondary); line-height: 1.5;
        }
        .asef-pd-note svg { flex-shrink: 0; width: 18px; height: 18px; color: var(--gray-secondary); margin-top: 1px; }

        /* Related products */
        .asef-related-wrap {
            max-width: 1024px; margin: 60px auto 80px; padding: 0 20px;
        }
        @media (min-width: 768px) { .asef-related-wrap { margin: 80px auto 120px; } }
        .asef-related-head {
            text-align: center; margin-bottom: 32px;
        }
        .asef-related-head h2 {
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 600; letter-spacing: -0.01em; color: var(--primary);
        }
        .asef-related-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;
        }
        @media (min-width: 768px) { .asef-related-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; } }
        .asef-related-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            padding: 20px 20px 16px;
            display: flex; flex-direction: column;
            transition: transform .25s, background .2s;
        }
        .asef-related-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-related-media {
            aspect-ratio: 16/10; background: white;
            border-radius: 14px; overflow: hidden;
            display: grid; place-items: center;
            margin-bottom: 14px;
        }
        .asef-related-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-related-name { font-size: 15px; font-weight: 600; color: var(--primary); margin-bottom: 4px; }
        .asef-related-desc { font-size: 13px; color: var(--secondary); line-height: 1.4; margin-bottom: 10px; flex: 1; }
        .asef-related-link { font-size: 13px; color: var(--link-blue); font-weight: 500; }

        /* ============= SEPET ============= */
        .asef-cart-wrap {
            max-width: 1024px; margin: 0 auto;
            padding: 40px 20px 40px;
        }
        @media (min-width: 768px) { .asef-cart-wrap { padding: 56px 20px 60px; } }
        .asef-cart-title {
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 600; letter-spacing: -0.02em;
            color: var(--primary); margin-bottom: 32px;
        }
        .asef-cart-grid {
            display: grid; grid-template-columns: 1fr; gap: 24px;
        }
        @media (min-width: 900px) { .asef-cart-grid { grid-template-columns: 1.5fr 1fr; gap: 40px; align-items: flex-start; } }

        .asef-cart-items {
            display: flex; flex-direction: column;
        }
        .asef-cart-item {
            display: grid; grid-template-columns: 88px 1fr auto; gap: 18px; align-items: center;
            padding: 20px 0;
            border-top: 1px solid var(--outline);
        }
        .asef-cart-item:last-child { border-bottom: 1px solid var(--outline); }
        .asef-cart-item-img {
            width: 88px; height: 88px; border-radius: 14px; overflow: hidden;
            background: var(--surface-alt);
            display: grid; place-items: center;
            transition: transform .18s ease;
            flex-shrink: 0;
        }
        .asef-cart-item-img:hover { transform: scale(1.02); }
        .asef-cart-item-img img { width: 100%; height: 100%; object-fit: cover; }
        .asef-cart-item-img-fallback {
            width: 100%; height: 100%;
            display: grid; place-items: center;
            color: var(--gray-secondary);
        }
        .asef-cart-item-img-fallback svg { width: 34px; height: 34px; opacity: 0.6; }
        .asef-cart-item-body { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
        .asef-cart-item-name {
            font-size: 16px; font-weight: 600; color: var(--primary); line-height: 1.3;
            transition: color .15s;
        }
        .asef-cart-item-name:hover { color: var(--link-blue); }
        .asef-cart-item-sku {
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 11px; letter-spacing: 0.08em; color: var(--gray-secondary);
        }
        .asef-cart-item-qty-row { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
        .asef-cart-item-remove {
            width: 36px; height: 36px; border-radius: 999px;
            display: grid; place-items: center;
            color: var(--gray-secondary);
            transition: background .15s, color .15s;
        }
        .asef-cart-item-remove:hover { background: var(--surface-alt); color: #B21A1A; }

        .asef-cart-summary {
            background: var(--surface-alt); border-radius: 20px;
            padding: 28px;
            position: sticky; top: 80px;
        }
        .asef-cart-summary h3 {
            font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 20px;
        }
        .asef-cart-summary-row {
            display: flex; justify-content: space-between; align-items: baseline;
            padding: 14px 0; border-bottom: 1px solid var(--outline);
            font-size: 15px;
        }
        .asef-cart-summary-row:last-of-type { border-bottom: 0; }
        .asef-cart-summary-label { color: var(--secondary); }
        .asef-cart-summary-value { color: var(--primary); font-weight: 600; text-align: right; }
        .asef-cart-summary-value.muted { color: var(--gray-secondary); font-weight: 500; font-size: 13px; }
        .asef-cart-cta-block { padding-top: 20px; }
        .asef-cart-cta-block .asef-cta-pill { width: 100%; justify-content: center; padding: 14px 22px; font-size: 15px; margin-bottom: 10px; }
        .asef-cart-continue {
            display: block; text-align: center;
            color: var(--link-blue); font-size: 14px; font-weight: 500;
            padding: 10px;
        }
        .asef-cart-trust {
            border-top: 1px solid var(--outline); margin-top: 16px; padding-top: 16px;
            display: flex; flex-direction: column; gap: 8px;
        }
        .asef-cart-trust-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: var(--secondary);
        }
        .asef-cart-trust-item svg { width: 16px; height: 16px; color: var(--secondary); }

        .asef-cart-empty {
            text-align: center; padding: 80px 20px;
        }
        .asef-cart-empty-icon {
            width: 64px; height: 64px; margin: 0 auto 20px;
            color: var(--gray-secondary);
        }
        .asef-cart-empty h3 { font-size: 24px; font-weight: 600; color: var(--primary); margin-bottom: 10px; }
        .asef-cart-empty p { font-size: 15px; color: var(--gray-secondary); margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto; }

        .asef-cart-clear-row {
            display: flex; justify-content: flex-end;
            margin-top: 12px;
        }
        .asef-cart-clear {
            font-size: 13px; color: var(--gray-secondary);
            padding: 8px 12px; border-radius: 999px;
            transition: color .15s, background .15s;
        }
        .asef-cart-clear:hover { color: #B21A1A; background: var(--surface-alt); }
    </style>
@endpush
