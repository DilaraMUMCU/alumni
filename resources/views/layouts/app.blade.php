<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'İstanbul Üniversitesi Mezun Takip Sistemi')</title>
    <meta name="description" content="@yield('meta_description', '1453\'ten geleceğe kesintisiz bağlantı. İstanbul Üniversitesi Mezun ve Kariyer İletişim Ağı.')">

    <!-- Fonts: Lora (Editorial Serif), Plus Jakarta Sans (UI Humanist), JetBrains Mono (Code/Telemetry) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================================
           DESIGN TOKENS (Refero Benchmarks: Craft Docs, Superr, Officevibe + brand.md)
           ========================================================================== */
        :root {
            /* Surfaces & Canvases */
            --canvas-warm: #FBF9F5;
            --canvas-tint: #F7EFE9;
            --surface-paper: #FFFFFF;
            --surface-card: #FFFFFF;
            --surface-card-subtle: #FDFBF8;
            --surface-navy: #0B1B3D;
            --surface-dark-card: #11224D;

            /* Inks & Text */
            --ink-primary: #0C1754;
            --ink-charcoal: #1E293B;
            --ink-secondary: #64748B;
            --ink-muted: #94A3B8;
            --ink-white: #FFFFFF;

            /* Istanbul University Brand Identity (brand.md) */
            --iu-crimson: #8A1538;
            --iu-crimson-hover: #660F29;
            --iu-crimson-soft: rgba(138, 21, 56, 0.08);
            --iu-crimson-border: rgba(138, 21, 56, 0.25);
            --iu-navy: #0B1B3D;
            --iu-navy-dark: #070D1B;
            --iu-gold: #D4AF37;
            --iu-gold-soft: rgba(212, 175, 55, 0.15);
            --iu-gold-border: rgba(212, 175, 55, 0.35);

            /* Chromatic Accents (DESIGN.md) */
            --academic-sapphire: #1D4ED8;
            --academic-sapphire-hover: #1E40AF;
            --academic-sapphire-soft: rgba(29, 78, 216, 0.08);
            --academic-sapphire-border: rgba(29, 78, 216, 0.25);

            --marker-amber: #FF6F1E;
            --marker-amber-soft: rgba(255, 111, 30, 0.1);
            --mint-success: #10B981;
            --mint-success-soft: rgba(16, 185, 129, 0.12);
            --mint-success-border: rgba(16, 185, 129, 0.3);
            --rose-danger: #EF4444;
            --rose-danger-soft: rgba(239, 68, 68, 0.12);
            --rose-danger-border: rgba(239, 68, 68, 0.3);

            /* Borders */
            --border-cream: #EBE3D7;
            --border-subtle: rgba(12, 23, 84, 0.08);
            --border-card: rgba(12, 23, 84, 0.06);

            /* Typography */
            --font-serif: 'Lora', 'Merriweather', Georgia, serif;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --font-mono: 'JetBrains Mono', 'SF Mono', Consolas, monospace;

            /* Ergonomics & Radii */
            --radius-pill: 100px;
            --radius-tag: 20px;
            --radius-card: 16px;
            --radius-input: 12px;
            --radius-hero: 24px;

            /* Multi-Stage Diffuse Shadows (Craft Docs Benchmark) */
            --shadow-subtle: 0 1px 3px rgba(12, 23, 84, 0.04), 0 2px 6px rgba(12, 23, 84, 0.03);
            --shadow-card: 
                0 50px 40px rgba(12, 23, 84, 0.02),
                0 20px 30px rgba(12, 23, 84, 0.04),
                0 4px 12px rgba(12, 23, 84, 0.06),
                0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-card-hover: 
                0 60px 48px rgba(12, 23, 84, 0.04),
                0 26px 36px rgba(12, 23, 84, 0.07),
                0 8px 18px rgba(12, 23, 84, 0.08),
                0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-pill: 0 8px 20px rgba(138, 21, 56, 0.22);
            --shadow-sapphire: 0 8px 20px rgba(29, 78, 216, 0.22);
            --shadow-navbar: 0 12px 30px rgba(11, 27, 61, 0.08), 0 1px 3px rgba(11, 27, 61, 0.04);
        }

        /* Base Resets */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--canvas-warm);
            color: var(--ink-charcoal);
            font-family: var(--font-sans);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(at 15% 10%, rgba(212, 175, 55, 0.04) 0px, transparent 40%),
                radial-gradient(at 85% 15%, rgba(138, 21, 56, 0.03) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(29, 78, 216, 0.03) 0px, transparent 60%);
            background-attachment: fixed;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Editorial Typography Standards */
        .font-serif {
            font-family: var(--font-serif);
        }
        .font-mono {
            font-family: var(--font-mono);
        }
        .font-sans {
            font-family: var(--font-sans);
        }

        h1, h2, h3, h4, .title-editorial {
            font-family: var(--font-serif);
            color: var(--ink-primary);
            letter-spacing: -0.02em;
            line-height: 1.25;
            font-weight: 600;
        }

        .title-editorial em, h1 em, h2 em {
            font-style: italic;
            color: var(--iu-crimson);
            font-weight: 400;
        }

        /* Top Institutional Heritage Bar */
        .top-heritage-bar {
            background: var(--iu-navy);
            color: rgba(255, 255, 255, 0.85);
            font-size: 12px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.25);
            position: relative;
            z-index: 101;
        }
        .top-heritage-bar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        .heritage-tagline {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }
        .heritage-tagline .gate-badge {
            background: linear-gradient(135deg, #D4AF37, #B8860B);
            color: #0B1B3D;
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .top-heritage-links {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .top-heritage-links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            font-weight: 500;
        }
        .top-heritage-links a:hover {
            color: var(--iu-gold);
        }

        /* Floating Glass Navigation Bar (DESIGN.md Benchmark) */
        .navbar-wrapper {
            position: sticky;
            top: 16px;
            z-index: 100;
            padding: 0 24px;
            margin-bottom: 28px;
        }

        .navbar-floating {
            max-width: 1240px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-cream);
            border-radius: var(--radius-pill);
            padding: 10px 18px 10px 24px;
            box-shadow: var(--shadow-navbar);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            transition: all 0.25s ease;
        }

        .brand-seal {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-emblem-badge {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--iu-crimson) 0%, var(--iu-crimson-hover) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(138, 21, 56, 0.35);
            border: 2px solid var(--iu-gold);
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .brand-seal:hover .brand-emblem-badge {
            transform: scale(1.05) rotate(-3deg);
        }

        .brand-emblem-badge .iu-initials {
            font-family: var(--font-serif);
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1;
            color: #FFFFFF;
        }

        .brand-emblem-badge .iu-year {
            font-size: 8px;
            font-weight: 800;
            color: var(--iu-gold);
            letter-spacing: 0.5px;
            line-height: 1;
            margin-top: 1px;
        }

        .brand-texts {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--iu-navy);
            line-height: 1.2;
            text-transform: uppercase;
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--ink-secondary);
            font-weight: 500;
            line-height: 1.2;
        }

        /* Navigation Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .nav-link {
            padding: 8px 14px;
            border-radius: var(--radius-pill);
            color: var(--ink-charcoal);
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }

        .nav-link:hover {
            color: var(--iu-crimson);
            background: var(--canvas-tint);
        }

        .nav-link.active {
            color: var(--iu-crimson);
            background: var(--iu-crimson-soft);
            border: 1px solid var(--iu-crimson-border);
            font-weight: 700;
        }

        .nav-link .badge-count {
            background: var(--iu-crimson);
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 10px;
            margin-left: 2px;
        }

        /* Quick Action CTA */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Mobile Hamburger */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            color: var(--ink-primary);
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
                position: absolute;
                top: calc(100% + 12px);
                left: 24px;
                right: 24px;
                background: #FFFFFF;
                border: 1px solid var(--border-cream);
                border-radius: 20px;
                padding: 16px;
                flex-direction: column;
                align-items: stretch;
                box-shadow: var(--shadow-card);
            }
            .nav-links.open {
                display: flex;
            }
            .mobile-toggle {
                display: block;
            }
        }

        /* Button Ergonomics (Superr & Officevibe Benchmark) */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 13.5px;
            font-weight: 600;
            border-radius: var(--radius-pill);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
            text-align: center;
            white-space: nowrap;
            line-height: 1.4;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--iu-crimson) 0%, var(--iu-crimson-hover) 100%);
            color: #FFFFFF;
            box-shadow: var(--shadow-pill);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #74112e 0%, #520c21 100%);
            color: #FFFFFF;
            box-shadow: 0 10px 24px rgba(138, 21, 56, 0.32);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--surface-paper);
            color: var(--ink-primary);
            border: 1px solid var(--border-cream);
            box-shadow: var(--shadow-subtle);
        }
        .btn-secondary:hover {
            background: var(--canvas-tint);
            border-color: rgba(12, 23, 84, 0.2);
            color: var(--iu-crimson);
            transform: translateY(-1px);
        }

        .btn-sapphire {
            background: linear-gradient(135deg, var(--academic-sapphire) 0%, var(--academic-sapphire-hover) 100%);
            color: #FFFFFF;
            box-shadow: var(--shadow-sapphire);
        }
        .btn-sapphire:hover {
            background: linear-gradient(135deg, #173fae 0%, #173387 100%);
            color: #FFFFFF;
            transform: translateY(-1px);
        }

        .btn-gold {
            background: linear-gradient(135deg, #E5C158 0%, #D4AF37 100%);
            color: #0B1B3D;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.3);
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .btn-danger:hover {
            background: #FCA5A5;
            color: #991B1B;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12.5px;
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 15px;
        }

        /* Elevated Card (Craft Docs Benchmark) */
        .card {
            background: var(--surface-card);
            border: 1px solid var(--border-cream);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            padding: 28px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-card-hover);
        }

        .card-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-title {
            font-family: var(--font-serif);
            font-size: 20px;
            color: var(--ink-primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-subtitle {
            font-size: 13.5px;
            color: var(--ink-secondary);
            margin-top: 4px;
        }

        /* Pill Badges & Status Chips */
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .badge-crimson {
            background: var(--iu-crimson-soft);
            color: var(--iu-crimson);
            border: 1px solid var(--iu-crimson-border);
        }

        .badge-sapphire {
            background: var(--academic-sapphire-soft);
            color: var(--academic-sapphire);
            border: 1px solid var(--academic-sapphire-border);
        }

        .badge-gold {
            background: var(--iu-gold-soft);
            color: #997300;
            border: 1px solid var(--iu-gold-border);
        }

        .badge-success {
            background: var(--mint-success-soft);
            color: #065F46;
            border: 1px solid var(--mint-success-border);
        }

        .badge-amber {
            background: var(--marker-amber-soft);
            color: #C2410C;
            border: 1px solid rgba(255, 111, 30, 0.3);
        }

        .badge-danger {
            background: var(--rose-danger-soft);
            color: #991B1B;
            border: 1px solid var(--rose-danger-border);
        }

        .badge-neutral {
            background: rgba(100, 116, 139, 0.1);
            color: #475569;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        /* Form Inputs & Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink-primary);
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        .form-label span.required {
            color: var(--iu-crimson);
            margin-left: 2px;
        }

        .form-control, .form-select, .form-textarea {
            width: 100%;
            padding: 12px 16px;
            font-family: var(--font-sans);
            font-size: 14px;
            color: var(--ink-charcoal);
            background-color: #FFFFFF;
            border: 1.5px solid var(--border-cream);
            border-radius: var(--radius-input);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--iu-crimson);
            box-shadow: 0 0 0 3px rgba(138, 21, 56, 0.12);
            background-color: #FFFFFF;
        }

        .form-control::placeholder, .form-textarea::placeholder {
            color: var(--ink-muted);
        }

        .form-help {
            font-size: 12px;
            color: var(--ink-secondary);
            margin-top: 5px;
        }

        /* Flash Notifications Banner */
        .flash-alerts {
            margin-bottom: 24px;
        }

        .alert-pill {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: var(--shadow-subtle);
            animation: slideDown 0.3s ease;
        }

        .alert-pill-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-pill-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .alert-pill-warning {
            background: #FFFBEB;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .alert-dismiss {
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            font-size: 16px;
            line-height: 1;
        }
        .alert-dismiss:hover {
            opacity: 1;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Main Content Layout */
        main.main-content {
            flex: 1;
            padding-bottom: 60px;
        }

        /* Institutional Footer */
        .footer-institutional {
            background: var(--iu-navy);
            color: #F8FAFC;
            padding: 60px 0 30px 0;
            border-top: 4px solid var(--iu-gold);
            margin-top: auto;
            position: relative;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 48px;
        }

        @media (max-width: 992px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        .footer-col h4 {
            font-family: var(--font-serif);
            font-size: 16px;
            color: var(--iu-gold);
            margin-bottom: 16px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .footer-brand-bio {
            font-size: 13.5px;
            color: #94A3B8;
            line-height: 1.7;
            margin-top: 14px;
            max-width: 360px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            font-size: 13.5px;
            color: #CBD5E1;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-links a:hover {
            color: var(--iu-gold);
            transform: translateX(3px);
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 12px;
            color: #94A3B8;
        }

        .footer-bottom-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Utility Micro-classes */
        .text-crimson { color: var(--iu-crimson); }
        .text-navy { color: var(--iu-navy); }
        .text-gold { color: #997300; }
        .text-sapphire { color: var(--academic-sapphire); }
        .text-muted { color: var(--ink-secondary); }
        .bg-white { background: #FFFFFF; }
        .bg-warm { background: var(--canvas-warm); }

        /* Filter bar pills container */
        .filter-pills-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 24px;
        }

        .filter-pill {
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            font-size: 13px;
            font-weight: 600;
            background: #FFFFFF;
            border: 1px solid var(--border-cream);
            color: var(--ink-charcoal);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-pill:hover {
            border-color: var(--iu-crimson);
            color: var(--iu-crimson);
            background: var(--canvas-tint);
        }

        .filter-pill.active {
            background: var(--iu-crimson);
            color: #FFFFFF;
            border-color: var(--iu-crimson);
            box-shadow: 0 4px 12px rgba(138, 21, 56, 0.25);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- 1. Top Institutional Heritage Bar -->
    <header class="top-heritage-bar">
        <div class="container">
            <div class="heritage-tagline">
                <span class="gate-badge">1453</span>
                <span>İstanbul Üniversitesi • Mezun ve Kariyer İletişim Portalı</span>
            </div>
            <div class="top-heritage-links">
                <a href="https://istanbul.edu.tr" target="_blank" rel="noopener">istanbul.edu.tr ↗</a>
                <a href="/api/swagger">Swagger UI ↗</a>
                <a href="/about">Hakkımızda</a>
            </div>
        </div>
    </header>

    <!-- 2. Floating Glass Navbar -->
    <div class="navbar-wrapper">
        <nav class="navbar-floating">
            <!-- Brand Logo with Emblem Seal -->
            <a href="/" class="brand-seal" title="İstanbul Üniversitesi Mezun Portalı">
                <div class="brand-emblem-badge">
                    <span class="iu-initials">İÜ</span>
                    <span class="iu-year">1453</span>
                </div>
                <div class="brand-texts">
                    <span class="brand-title">İSTANBUL ÜNİVERSİTESİ</span>
                    <span class="brand-subtitle">Mezun Takip & Kariyer Ağı</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <ul class="nav-links" id="mainNavLinks">
                <li>
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <span>Ana Sayfa</span>
                    </a>
                </li>
                <li>
                    <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <span>Mezunlar & Öğrenciler</span>
                    </a>
                </li>
                <li>
                    <a href="/job-postings" class="nav-link {{ request()->is('job-postings*') ? 'active' : '' }}">
                        <span>İş & Staj İlanları</span>
                    </a>
                </li>
                <li>
                    <a href="/applications" class="nav-link {{ request()->is('applications*') ? 'active' : '' }}">
                        <span>Başvurular</span>
                    </a>
                </li>
                <li>
                    <a href="/announcements" class="nav-link {{ request()->is('announcements*') ? 'active' : '' }}">
                        <span>Duyurular</span>
                    </a>
                </li>
                <li>
                    <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                        <span>Hakkımızda</span>
                    </a>
                </li>
            </ul>

            <!-- Right Actions & Mobile Hamburger -->
            <div class="nav-actions">
                <a href="/job-postings/create" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>İlan Yayınla</span>
                </a>
                <button class="mobile-toggle" id="mobileNavToggle" aria-label="Menüyü Aç/Kapat">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>
        </nav>
    </div>

    <!-- 3. Global Flash Notification Alerts -->
    <div class="container flash-alerts">
        @if (session('success'))
            <div class="alert-pill alert-pill-success" role="alert">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button class="alert-dismiss" onclick="this.parentElement.remove();">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-pill alert-pill-error" role="alert">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button class="alert-dismiss" onclick="this.parentElement.remove();">&times;</button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert-pill alert-pill-warning" role="alert">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>{{ session('warning') }}</span>
                </div>
                <button class="alert-dismiss" onclick="this.parentElement.remove();">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-pill alert-pill-error" role="alert">
                <div>
                    <strong>Lütfen formdaki hataları gideriniz:</strong>
                    <ul style="margin: 6px 0 0 20px; font-size: 13px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="alert-dismiss" onclick="this.parentElement.remove();">&times;</button>
            </div>
        @endif
    </div>

    <!-- 4. Main Body Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- 5. Institutional Academic Footer -->
    <footer class="footer-institutional">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: Heritage & Brand -->
                <div class="footer-col">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div class="brand-emblem-badge" style="width: 38px; height: 38px;">
                            <span class="iu-initials" style="font-size: 13px;">İÜ</span>
                            <span class="iu-year" style="font-size: 7px;">1453</span>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 13px; color: #FFFFFF; letter-spacing: 0.5px;">İSTANBUL ÜNİVERSİTESİ</div>
                            <div style="font-size: 11px; color: var(--iu-gold);">Mezun & Kariyer Portalı</div>
                        </div>
                    </div>
                    <p class="footer-brand-bio">
                        1453'ten günümüze yarım binyılı aşan akademik gelenekle, mezunlarımızı, akademisyenlerimizi ve öğrencilerimizi geleceğin lider kariyer ekosisteminde buluşturuyoruz.
                    </p>
                </div>

                <!-- Col 2: Hızlı Bağlantılar -->
                <div class="footer-col">
                    <h4>Hızlı Erişim</h4>
                    <ul class="footer-links">
                        <li><a href="/">Ana Sayfa</a></li>
                        <li><a href="/users">Mezun & Öğrenci Dizini</a></li>
                        <li><a href="/job-postings">Kariyer & Staj İlanları</a></li>
                        <li><a href="/applications">Başvuru Takibi</a></li>
                        <li><a href="/announcements">Üniversite Duyuruları</a></li>
                        <li><a href="/about">Tarihçe & Hakkımızda</a></li>
                    </ul>
                </div>

                <!-- Col 3: Mimari & Standartlar -->
                <div class="footer-col">
                    <h4>Mimari & Standartlar</h4>
                    <ul class="footer-links">
                        <li><a href="/brand.md" target="_blank">🎨 brand.md (Marka Kimliği)</a></li>
                        <li><a href="/DESIGN.md" target="_blank">🏛️ DESIGN.md (Refero UI/UX)</a></li>
                        <li><a href="/ddd.md" target="_blank">📊 ddd.md (Veri Modelleri)</a></li>
                        <li><a href="/api/swagger">⚡ Swagger / OpenAPI 3.0</a></li>
                        <li><a href="/api/health">🛡️ API Health Check</a></li>
                    </ul>
                </div>

                <!-- Col 4: İletişim & Yerleşke -->
                <div class="footer-col">
                    <h4>Beyazıt Yerleşkesi</h4>
                    <ul class="footer-links" style="font-size: 13px; color: #94A3B8;">
                        <li>📍 Beyazıt Meydanı, 34452 Fatih / İstanbul</li>
                        <li>📞 +90 (212) 440 00 00</li>
                        <li>✉️ mezun@istanbul.edu.tr</li>
                        <li>🏛️ Rektörlük Binası, Zemin Kat</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Line -->
            <div class="footer-bottom">
                <div>
                    © 1453 – {{ date('Y') }} İstanbul Üniversitesi Rektörlüğü. Tüm hakları saklıdır.
                </div>
                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <span class="footer-bottom-badge">
                        <span style="color: #10B981;">●</span> WCAG 2.1 AAA Uyumlu
                    </span>
                    <span class="footer-bottom-badge">
                        Docker & Nginx • Laravel 11 MVC
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Nav Toggle Script -->
    <script>
        const mobileToggle = document.getElementById('mobileNavToggle');
        const navLinks = document.getElementById('mainNavLinks');
        if (mobileToggle && navLinks) {
            mobileToggle.addEventListener('click', () => {
                navLinks.classList.toggle('open');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
