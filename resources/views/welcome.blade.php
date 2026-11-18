<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Tracking System - Mezun ve Kariyer Ağı</title>
    <meta name="description" content="Üniversitemiz mezunları, öğrencileri ve iş dünyası arasında köprü kuran resmi topluluk ve kariyer platformu.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-primary: #0b1120;
            --bg-secondary: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.7);
            --bg-card-hover: rgba(51, 65, 85, 0.8);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(56, 189, 248, 0.35);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent-blue: #38bdf8;
            --accent-cyan: #06b6d4;
            --accent-emerald: #10b981;
            --accent-amber: #f59e0b;
            --accent-purple: #c084fc;
            --accent-rose: #f43f5e;
            --glow-color: rgba(56, 189, 248, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 10% 20%, rgba(56, 189, 248, 0.08) 0px, transparent 50%),
                radial-gradient(at 90% 10%, rgba(192, 132, 252, 0.06) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Container */
        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Glassmorphism Navbar */
        .navbar-wrapper {
            position: sticky;
            top: 16px;
            z-index: 100;
            padding: 0 16px;
            margin-bottom: 40px;
        }

        .navbar {
            max-width: 1240px;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 800;
            font-size: 19px;
            letter-spacing: -0.5px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4);
        }

        .brand-pill {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-left: 6px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* Hero Section */
        .hero {
            padding: 40px 0 60px 0;
            text-align: center;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.1);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.25);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: clamp(34px, 5.5vw, 58px);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 50%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-title span {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: clamp(16px, 2vw, 19px);
            color: var(--text-secondary);
            max-width: 720px;
            margin: 0 auto 36px auto;
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        /* Stats Bar */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 22px 20px;
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.25s ease;
            text-align: left;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-icon-blue { background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
        .stat-icon-emerald { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .stat-icon-amber { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .stat-icon-purple { background: rgba(192, 132, 252, 0.15); color: #c084fc; border: 1px solid rgba(192, 132, 252, 0.3); }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Section Header */
        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .section-title-wrap {
            text-align: left;
        }

        .section-tag {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            display: block;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .section-desc {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .section-link {
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s ease;
        }

        .section-link:hover {
            gap: 10px;
            text-decoration: underline;
        }

        /* Module Grid (4 Pillars) */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 70px;
        }

        .module-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 28px;
            text-align: left;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .module-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45);
        }

        .module-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .module-title {
            font-size: 19px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .module-desc {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.5;
        }

        .module-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 14px;
            transition: color 0.2s;
        }

        .module-action:hover {
            color: #ffffff;
        }

        /* Showcase Cards (Jobs & Announcements) */
        .showcase-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .job-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
            transition: all 0.25s ease;
        }

        .job-card:hover {
            border-color: rgba(56, 189, 248, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .job-meta-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 8px;
        }

        .badge-type {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 9999px;
            text-transform: uppercase;
        }

        .badge-fulltime { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-internship { background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
        .badge-parttime { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }

        .job-company {
            color: var(--accent-blue);
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .job-title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            line-height: 1.35;
        }

        .job-details {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .job-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Announcement Card */
        .announcement-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
            transition: all 0.25s ease;
        }

        .announcement-card:hover {
            border-color: rgba(245, 158, 11, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .badge-category {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 9999px;
            text-transform: uppercase;
        }

        .cat-event { background: rgba(192, 132, 252, 0.15); color: #c084fc; border: 1px solid rgba(192, 132, 252, 0.3); }
        .cat-career { background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
        .cat-mentorship { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .cat-general { background: rgba(148, 163, 184, 0.15); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.3); }

        .announcement-title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            line-height: 1.35;
        }

        .announcement-snippet {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 18px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Spotlight Users */
        .spotlight-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
            margin-bottom: 70px;
        }

        .spotlight-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
            text-align: center;
            transition: all 0.25s ease;
        }

        .spotlight-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            margin: 0 auto 14px auto;
            border: 2px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.3);
        }

        .user-name {
            font-size: 17px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .user-role-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
            display: inline-block;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .user-position {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            font-weight: 500;
        }

        .user-company {
            font-size: 13px;
            color: var(--accent-emerald);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .user-skills {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .skill-pill {
            background: rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Architecture Banner */
        .infra-banner {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 22px;
            padding: 36px 32px;
            margin-bottom: 70px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            align-items: center;
        }

        .infra-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            text-align: left;
        }

        .infra-icon {
            font-size: 28px;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.25);
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .infra-title {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .infra-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Developer Console (Collapsible) */
        .dev-console-wrapper {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            margin-bottom: 60px;
            overflow: hidden;
            text-align: left;
        }

        .dev-console-header {
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            background: rgba(30, 41, 59, 0.5);
            user-select: none;
            transition: background 0.2s;
        }

        .dev-console-header:hover {
            background: rgba(51, 65, 85, 0.6);
        }

        .dev-console-title {
            font-size: 15px;
            font-weight: 700;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dev-console-badge {
            font-size: 11px;
            background: rgba(56, 189, 248, 0.15);
            color: var(--accent-blue);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
        }

        .dev-console-body {
            padding: 24px;
            display: none;
            border-top: 1px solid var(--border-color);
        }

        .dev-console-body.open {
            display: block;
        }

        .console-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .btn-console {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
        }

        .btn-console:hover { opacity: 0.85; }
        .btn-console-get { background: #10b981; color: #064e3b; }
        .btn-console-post { background: #f59e0b; color: #78350f; }
        .btn-console-put { background: #c084fc; color: #3b0764; }
        .btn-console-patch { background: #06b6d4; color: #083344; }
        .btn-console-delete { background: #ef4444; color: #450a0a; }
        .btn-console-reset { background: #475569; color: #f8fafc; }

        pre.response-box {
            background: #020617;
            color: #a7f3d0;
            padding: 16px;
            border-radius: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            overflow-x: auto;
            max-height: 280px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: none;
        }

        /* Bottom CTA */
        .bottom-cta {
            background: radial-gradient(circle at center, rgba(56, 189, 248, 0.15) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 24px;
            padding: 50px 32px;
            text-align: center;
            margin-bottom: 70px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .cta-title {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .cta-desc {
            font-size: 16px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 28px auto;
        }

        /* Footer */
        .footer {
            border-top: 1px solid var(--border-color);
            padding: 40px 0 30px 0;
            color: var(--text-muted);
            font-size: 13px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr repeat(3, 1fr);
            gap: 32px;
            margin-bottom: 36px;
            text-align: left;
        }

        .footer-brand-title {
            font-size: 17px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-brand-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 340px;
        }

        .footer-col-title {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--accent-blue);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .status-indicators {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px #10b981;
        }

        @media (max-width: 860px) {
            .navbar {
                flex-direction: column;
                align-items: stretch;
            }
            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }
            .nav-actions {
                justify-content: center;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }
    </style>
</head>
<body>

    <!-- Sticky Glass Navbar -->
    <div class="navbar-wrapper">
        <nav class="navbar">
            <a href="/" class="brand-link">
                <div class="brand-icon">🎓</div>
                <span>Alumni ATS</span>
                <span class="brand-pill">
                    <span class="status-dot"></span> Canlı
                </span>
            </a>

            <ul class="nav-links">
                <li><a href="/" class="active">Ana Sayfa</a></li>
                <li><a href="/users">Mezunlar</a></li>
                <li><a href="/job-postings">İş İlanları</a></li>
                <li><a href="/announcements">Duyurular</a></li>
                <li><a href="/applications">Başvurular</a></li>
                <li><a href="/api/swagger" target="_blank">Swagger API</a></li>
            </ul>

            <div class="nav-actions">
                <a href="/job-postings/create" class="btn btn-primary btn-sm">
                    <span>💼 İlan Yayınla</span>
                </a>
                <a href="/users/create" class="btn btn-secondary btn-sm">
                    <span>➕ Mezun Ekle</span>
                </a>
            </div>
        </nav>
    </div>

    <main class="container">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-badge">
                <span>✨</span> Üniversite & Mezun Kariyer Ekosistemi
            </div>
            <h1 class="hero-title">
                Mezunlarımızla Güçlü,<br>
                <span>Geleceğe Birlikte.</span>
            </h1>
            <p class="hero-desc">
                Üniversite mezunlarımız, öğrencilerimiz ve sektör liderleri arasında ömür boyu süren köprü. 
                Kariyer fırsatlarını yakalayın, mentorluk alın ve güçlü mezun topluluğu ile bağınızı asla koparmayın.
            </p>
            <div class="hero-actions">
                <a href="/job-postings" class="btn btn-primary">
                    <span>💼 İş & Staj İlanlarını İncele</span>
                </a>
                <a href="/users" class="btn btn-secondary">
                    <span>👥 Mezun Topluluğunu Keşfet</span>
                </a>
                <a href="/announcements" class="btn btn-secondary">
                    <span>📢 Güncel Duyurular</span>
                </a>
            </div>

            <!-- Live Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">👥</div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['users_count'] ?? 0) }}</div>
                        <div class="stat-label">Mezun & Öğrenci Kaydı</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-emerald">💼</div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['job_postings_count'] ?? 0) }}</div>
                        <div class="stat-label">Aktif İş & Staj İlanı</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-amber">📢</div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['announcements_count'] ?? 0) }}</div>
                        <div class="stat-label">Kurumsal Duyuru</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-purple">📄</div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['applications_count'] ?? 0) }}</div>
                        <div class="stat-label">Aday Başvurusu</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Modules Grid (4 Pillars) -->
        <section style="margin-bottom: 70px;">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-tag">Platformun Temel Güçleri</span>
                    <h2 class="section-title">Entegre Mezun & Kariyer Modülleri</h2>
                    <p class="section-desc">Mezun yönetiminden işe alım ve mentorluk süreçlerine kadar tüm ihtiyaçlar tek çatıda.</p>
                </div>
            </div>

            <div class="modules-grid">
                <!-- Modül 1 -->
                <div class="module-card">
                    <div>
                        <div class="module-badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8;">👥</div>
                        <h3 class="module-title">Mezun & Öğrenci Dizini</h3>
                        <p class="module-desc">Mezuniyet yılı, departman ve çalıştığı şirket bazında arama yapın, mezunlarımızla LinkedIn üzerinden bağlantı kurun.</p>
                    </div>
                    <a href="/users" class="module-action">
                        <span>Rehberi Keşfet &rarr;</span>
                    </a>
                </div>

                <!-- Modül 2 -->
                <div class="module-card">
                    <div>
                        <div class="module-badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">💼</div>
                        <h3 class="module-title">Kariyer & Fırsat Merkezi</h3>
                        <p class="module-desc">Mezunlarımızın çalıştığı şirketlerden açılan tam zamanlı ve staj fırsatlarına doğrudan başvurun.</p>
                    </div>
                    <a href="/job-postings" class="module-action">
                        <span>İlanlara Göz At &rarr;</span>
                    </a>
                </div>

                <!-- Modül 3 -->
                <div class="module-card">
                    <div>
                        <div class="module-badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">📢</div>
                        <h3 class="module-title">Duyurular & Etkinlikler</h3>
                        <p class="module-desc">Üniversite zirveleri, mezun panelleri, seminerler ve resmi akademik bildirimleri kaçırmayın.</p>
                    </div>
                    <a href="/announcements" class="module-action">
                        <span>Duyuruları İncele &rarr;</span>
                    </a>
                </div>

                <!-- Modül 4 -->
                <div class="module-card">
                    <div>
                        <div class="module-badge" style="background: rgba(192, 132, 252, 0.15); color: #c084fc;">🤝</div>
                        <h3 class="module-title">Mentorluk & Başvuru Takibi</h3>
                        <p class="module-desc">Öğrencilere kariyer rehberliği sunun, açık pozisyonlara gelen aday başvurularını tek merkezden yönetin.</p>
                    </div>
                    <a href="/applications" class="module-action">
                        <span>Başvuru Paneli &rarr;</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Showcase 1: Latest Job Postings -->
        <section style="margin-bottom: 70px;">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-tag">Kariyer Fırsatları</span>
                    <h2 class="section-title">Son Eklenen İş ve Staj İlanları</h2>
                    <p class="section-desc">Mezunlarımız ve partner kuruluşlar tarafından yayınlanan en güncel pozisyonlar.</p>
                </div>
                <a href="/job-postings" class="section-link">Tüm İlanları Görüntüle ({{ $stats['job_postings_count'] }}) &rarr;</a>
            </div>

            <div class="showcase-grid">
                @forelse($latestJobs as $job)
                    <div class="job-card">
                        <div>
                            <div class="job-meta-top">
                                <span class="job-company">🏢 {{ $job->company }}</span>
                                @php
                                    $typeClass = match(strtolower($job->employment_type ?? '')) {
                                        'internship' => 'badge-internship',
                                        'part-time' => 'badge-parttime',
                                        default => 'badge-fulltime'
                                    };
                                    $typeLabel = match(strtolower($job->employment_type ?? '')) {
                                        'internship' => 'Staj',
                                        'part-time' => 'Yarı Zamanlı',
                                        default => 'Tam Zamanlı'
                                    };
                                @endphp
                                <span class="badge-type {{ $typeClass }}">{{ $typeLabel }}</span>
                            </div>
                            <h3 class="job-title">{{ $job->title }}</h3>
                            <div class="job-details">
                                <span>📍 {{ $job->location ?? 'Belirtilmedi' }}</span>
                                @if($job->deadline)
                                    <span>⏳ Son Başvuru: {{ \Carbon\Carbon::parse($job->deadline)->format('d.m.Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="job-footer">
                            <span>Eklenme: {{ $job->created_at ? $job->created_at->diffForHumans() : 'Yeni' }}</span>
                            <a href="/job-postings/{{ $job->id }}" class="btn btn-secondary btn-sm">
                                <span>İlanı İncele &rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="job-card" style="text-align: center; padding: 40px;">
                        <p style="color: var(--text-secondary); margin-bottom: 16px;">Henüz yayınlanmış bir iş ilanı bulunmuyor.</p>
                        <a href="/job-postings/create" class="btn btn-primary btn-sm">İlk İlanı Siz Yayınlayın</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Showcase 2: Featured Announcements -->
        <section style="margin-bottom: 70px;">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-tag">Kurumsal Haberler</span>
                    <h2 class="section-title">Öne Çıkan Duyurular</h2>
                    <p class="section-desc">Mezun buluşmaları, zirveler ve topluluk gelişmeleri.</p>
                </div>
                <a href="/announcements" class="section-link">Tüm Duyurular ({{ $stats['announcements_count'] }}) &rarr;</a>
            </div>

            <div class="showcase-grid">
                @forelse($latestAnnouncements as $announcement)
                    <div class="announcement-card">
                        <div>
                            <div class="job-meta-top">
                                @php
                                    $catClass = match(strtolower($announcement->category ?? '')) {
                                        'event' => 'cat-event',
                                        'career' => 'cat-career',
                                        'mentorship' => 'cat-mentorship',
                                        default => 'cat-general'
                                    };
                                    $catLabel = match(strtolower($announcement->category ?? '')) {
                                        'event' => 'Etkinlik',
                                        'career' => 'Kariyer',
                                        'mentorship' => 'Mentorluk',
                                        default => 'Genel'
                                    };
                                @endphp
                                <span class="badge-category {{ $catClass }}">{{ $catLabel }}</span>
                                @if($announcement->priority === 'urgent')
                                    <span style="font-size: 11px; background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 2px 8px; border-radius: 9999px; font-weight: 700;">ACİL</span>
                                @endif
                            </div>
                            <h3 class="announcement-title">{{ $announcement->title }}</h3>
                            <p class="announcement-snippet">{{ $announcement->content }}</p>
                        </div>
                        <div class="job-footer">
                            <span>✍️ {{ $announcement->author ?? 'Koordinasyon Ofisi' }}</span>
                            <a href="/announcements/{{ $announcement->id }}" class="btn btn-secondary btn-sm">
                                <span>Detay &rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="announcement-card" style="text-align: center; padding: 40px;">
                        <p style="color: var(--text-secondary); margin-bottom: 16px;">Aktif duyuru bulunmuyor.</p>
                        <a href="/announcements/create" class="btn btn-primary btn-sm">Duyuru Oluştur</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Showcase 3: Spotlight Alumni -->
        <section style="margin-bottom: 70px;">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-tag">Mezun Topluluğumuz</span>
                    <h2 class="section-title">Topluluktan Öne Çıkanlar</h2>
                    <p class="section-desc">Farklı sektörlerde kariyerlerini sürdüren mezun ve öğrencilerimiz.</p>
                </div>
                <a href="/users" class="section-link">Tüm Mezunları Gör ({{ $stats['users_count'] }}) &rarr;</a>
            </div>

            <div class="spotlight-grid">
                @forelse($spotlightUsers as $user)
                    <div class="spotlight-card">
                        @php
                            $initials = collect(explode(' ', $user->name))->map(fn($part) => mb_substr($part, 0, 1))->take(2)->join('');
                        @endphp
                        <div class="user-avatar">{{ $initials }}</div>
                        <h4 class="user-name">{{ $user->name }}</h4>
                        <span class="user-role-badge">{{ $user->role ?? 'Alumni' }}</span>
                        <div class="user-position">{{ $user->job_title ?? 'Pozisyon Belirtilmedi' }}</div>
                        <div class="user-company">{{ $user->current_company ?? $user->department }}</div>

                        @if(is_array($user->skills) && count($user->skills) > 0)
                            <div class="user-skills">
                                @foreach(array_slice($user->skills, 0, 3) as $skill)
                                    <span class="skill-pill">{{ $skill }}</span>
                                @endforeach
                            </div>
                        @endif

                        <a href="/users/{{ $user->id }}" class="btn btn-secondary btn-sm" style="width: 100%;">
                            <span>Profili İncele</span>
                        </a>
                    </div>
                @empty
                    <div class="spotlight-card" style="grid-column: 1 / -1; padding: 40px;">
                        <p style="color: var(--text-secondary);">Henüz kayıtlı mezun bulunmuyor.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Platform Reliability & Architecture Section -->
        <section class="infra-banner">
            <div class="infra-item">
                <div class="infra-icon">🛡️</div>
                <div>
                    <div class="infra-title">Guardian Hata Yönetimi</div>
                    <div class="infra-desc">404 ve 5xx Guardian middleware katmanı sayesinde sistem arızaları maskelenir, detaylı nedenlerle kalıcı olarak loglanır.</div>
                </div>
            </div>
            <div class="infra-item">
                <div class="infra-icon">⚡</div>
                <div>
                    <div class="infra-title">OpenAPI 3.0 & Swagger</div>
                    <div class="infra-desc">Tüm REST API servisleri Swagger UI ile interaktif olarak belgelenmiş olup anlık test edilebilir durumdadır.</div>
                </div>
            </div>
            <div class="infra-item">
                <div class="infra-icon">🗄️</div>
                <div>
                    <div class="infra-title">MySQL 8.0 & Docker</div>
                    <div class="infra-desc">Konteynerize mimari, Redis önbellekleme ve MySQL 8.0 ilişkisel veritabanı ile yüksek performans.</div>
                </div>
            </div>
        </section>

        <!-- Developer & Interactive API Console (Collapsible) -->
        <section class="dev-console-wrapper">
            <div class="dev-console-header" onclick="toggleDevConsole()">
                <div class="dev-console-title">
                    <span>🛠️ Geliştirici & REST API Hızlı Test Konsolu</span>
                    <span class="dev-console-badge">Geliştirici Araçları</span>
                </div>
                <div style="color: var(--text-secondary); font-size: 13px;" id="consoleToggleIcon">
                    ▶️ Paneli Aç
                </div>
            </div>

            <div class="dev-console-body" id="devConsoleBody">
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 14px;">
                    Doğrudan canlı backend API uç noktalarına istek atarak JSON yanıtlarını inceleyebilirsiniz:
                </p>
                <div class="console-buttons">
                    <button class="btn-console btn-console-get" onclick="fetchGetUsers()">1. GET /api/users</button>
                    <button class="btn-console btn-console-post" onclick="sendPostRequest()">2. POST /api/users</button>
                    <button class="btn-console btn-console-put" onclick="sendPutRequest(1)">3. PUT /api/users/1</button>
                    <button class="btn-console btn-console-patch" onclick="sendPatchRequest(1)">4. PATCH /api/users/1</button>
                    <button class="btn-console btn-console-delete" onclick="sendDeleteRequest(3)">5. DELETE /api/users/3</button>
                    <button class="btn-console btn-console-reset" onclick="resetUsers()">Sıfırla (Reset)</button>
                    <a href="/api/swagger" target="_blank" class="btn-console" style="background: #0284c7; color: #fff; text-decoration: none;">📜 Swagger UI</a>
                    <a href="/api/health" target="_blank" class="btn-console" style="background: rgba(255,255,255,0.1); color: #fff; text-decoration: none;">🩺 Health Check</a>
                </div>
                <pre id="responseOutput" class="response-box"></pre>
            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="bottom-cta">
            <h2 class="cta-title">Büyük Mezun Ailesinin Bir Parçası Olun</h2>
            <p class="cta-desc">
                İster yeni mezun olun ister yılların deneyimli profesyoneli; profilinizi oluşturun, kariyer fırsatlarını paylaşın veya üniversite etkinliklerinde yerinizi alın.
            </p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="/users/create" class="btn btn-primary">
                    <span>➕ Yeni Mezun Kaydı Oluştur</span>
                </a>
                <a href="/job-postings/create" class="btn btn-secondary">
                    <span>💼 İş / Staj İlanı Yayınla</span>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand-title">
                        <span>🎓</span> Alumni Tracking System
                    </div>
                    <p class="footer-brand-desc">
                        Üniversite mezunları ile öğrencileri bir araya getiren, kariyer fırsatlarını ve topluluk iletişimini güçlendiren yeni nesil platform.
                    </p>
                </div>
                <div>
                    <div class="footer-col-title">Modüller</div>
                    <ul class="footer-links">
                        <li><a href="/users">Mezun Rehberi</a></li>
                        <li><a href="/job-postings">İş & Staj İlanları</a></li>
                        <li><a href="/announcements">Duyurular & Zirveler</a></li>
                        <li><a href="/applications">Kariyer Başvuruları</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Geliştirici & API</div>
                    <ul class="footer-links">
                        <li><a href="/api/swagger" target="_blank">Swagger UI Dokümantasyonu</a></li>
                        <li><a href="/api/swagger.json" target="_blank">OpenAPI 3.0 JSON</a></li>
                        <li><a href="/api/health" target="_blank">Sistem Sağlık Kontrolü (Health)</a></li>
                        <li><a href="/test-500" target="_blank">5xx Guardian Testi</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Kurumsal</div>
                    <ul class="footer-links">
                        <li><a href="/about">Hakkında</a></li>
                        <li><a href="/404">404 Guardian Sayfası</a></li>
                        <li><a href="https://github.com/DilaraMUMCU/alumni" target="_blank">GitHub Deposu</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} Alumni Tracking System. Tüm hakları saklıdır.
                </div>
                <div class="status-indicators">
                    <span><span class="status-dot"></span> MySQL 8.0 Bağlı</span>
                    <span><span class="status-dot"></span> Redis Aktif</span>
                    <span><span class="status-dot"></span> 404 & 5xx Guardian Korumalı</span>
                    <span><span class="status-dot"></span> Docker Nginx</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        function toggleDevConsole() {
            const body = document.getElementById('devConsoleBody');
            const icon = document.getElementById('consoleToggleIcon');
            if (body.classList.contains('open')) {
                body.classList.remove('open');
                icon.innerHTML = '▶️ Paneli Aç';
            } else {
                body.classList.add('open');
                icon.innerHTML = '▼ Paneli Kapat';
            }
        }

        const output = document.getElementById('responseOutput');

        async function fetchGetUsers() {
            output.style.display = 'block';
            output.textContent = 'GET /api/users isteği gönderiliyor...';
            try {
                const response = await fetch('/api/users', { headers: { 'Accept': 'application/json' } });
                const data = await response.json();
                output.textContent = '✅ GET /api/users (Toplam ' + (data.count || (data.data ? data.data.length : '0')) + ' kayıt):\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPostRequest() {
            output.style.display = 'block';
            output.textContent = 'POST /api/users isteği gönderiliyor...';
            const randomNames = ['Zeynep Kaya', 'Burak Öztürk', 'Ayşe Çelik', 'Mehmet Aksoy'];
            const chosenName = randomNames[Math.floor(Math.random() * randomNames.length)];
            try {
                const response = await fetch('/api/users', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        name: chosenName,
                        email: chosenName.toLowerCase().replace(/[^a-z]/g, '') + Date.now() + '@alumni.edu',
                        role: 'alumni',
                        department: 'Software Engineering',
                        graduation_year: 2025,
                        current_company: 'Trendyol',
                        job_title: 'Full Stack Developer',
                        linkedin_url: 'https://linkedin.com/in/' + chosenName.toLowerCase().replace(/[^a-z]/g, ''),
                        skills: ['PHP', 'Laravel', 'Vue.js', 'PostgreSQL']
                    })
                });
                const data = await response.json();
                output.textContent = '🎉 POST BAŞARILI (HTTP ' + response.status + ' Created)\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPutRequest(id) {
            output.style.display = 'block';
            output.textContent = 'PUT /api/users/' + id + ' (Tam Güncelleme) isteği gönderiliyor...';
            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        name: 'Dilara Mumcu',
                        email: 'dilara@alumni.edu',
                        role: 'alumni',
                        department: 'Computer Engineering',
                        graduation_year: 2024,
                        current_company: 'Google DeepMind',
                        job_title: 'Lead Software Architect',
                        linkedin_url: 'https://linkedin.com/in/dilaramumcu',
                        skills: ['PHP', 'Laravel', 'Docker', 'AI Engineering']
                    })
                });
                const data = await response.json();
                output.textContent = '✅ PUT BAŞARILI (HTTP ' + response.status + ' OK)\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPatchRequest(id) {
            output.style.display = 'block';
            output.textContent = 'PATCH /api/users/' + id + ' isteği gönderiliyor...';
            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        current_company: 'OpenAI Research',
                        job_title: 'AI Systems Architect'
                    })
                });
                const data = await response.json();
                output.textContent = '✅ PATCH BAŞARILI (HTTP ' + response.status + ' OK)\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendDeleteRequest(id) {
            output.style.display = 'block';
            output.textContent = 'DELETE /api/users/' + id + ' isteği gönderiliyor...';
            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                output.textContent = '🗑️ DELETE BAŞARILI (HTTP ' + response.status + ' OK)\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function resetUsers() {
            output.style.display = 'block';
            output.textContent = 'Liste sıfırlanıyor...';
            try {
                const response = await fetch('/api/users/reset', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                output.textContent = '🔄 Liste başlangıç haline sıfırlandı:\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }
    </script>
</body>
</html>
