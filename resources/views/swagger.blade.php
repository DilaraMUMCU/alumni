<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESTful API & Swagger Dokümantasyonu — İstanbul Üniversitesi</title>
    <meta name="description" content="İstanbul Üniversitesi Mezun Takip Sistemi OpenAPI 3.0 / Swagger interaktif uç nokta dokümantasyonu.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Lora:ital,wght@0,600;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />

    <style>
        :root {
            --iu-crimson: #8A1538;
            --iu-navy: #0B1B3D;
            --iu-gold: #D4AF37;
            --canvas-warm: #FBF9F5;
            --border-cream: #EBE3D7;
        }

        html { box-sizing: border-box; overflow-y: scroll; }
        *, *:before, *:after { box-sizing: inherit; }

        body {
            margin: 0;
            background: var(--canvas-warm);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #1E293B;
        }

        /* Top Institutional Heritage Bar */
        .topbar-iu {
            background: var(--iu-navy);
            color: #FFFFFF;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid var(--iu-gold);
            box-shadow: 0 4px 16px rgba(11, 27, 61, 0.2);
            flex-wrap: wrap;
            gap: 16px;
        }

        .brand-block {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-seal {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--iu-crimson), #660F29);
            color: #FFFFFF;
            border: 2px solid var(--iu-gold);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-seal .seal-iu {
            font-family: 'Lora', Georgia, serif;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
        }

        .brand-seal .seal-year {
            font-size: 7px;
            font-weight: 800;
            color: var(--iu-gold);
            line-height: 1;
            margin-top: 1px;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.3px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11.5px;
            color: var(--iu-gold);
            font-weight: 600;
            line-height: 1.2;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-gold {
            background: linear-gradient(135deg, #E5C158 0%, #D4AF37 100%);
            color: #0B1B3D;
            font-weight: 700;
        }
        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
        }

        /* Swagger UI Overrides */
        .swagger-ui .topbar { display: none; }
        .swagger-ui {
            max-width: 1240px;
            margin: 20px auto 60px auto;
            padding: 0 20px;
            font-family: inherit;
        }
        .swagger-ui .info {
            margin: 20px 0 30px 0;
            background: #FFFFFF;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-cream);
            box-shadow: 0 4px 16px rgba(11, 27, 61, 0.05);
        }
        .swagger-ui .info .title {
            font-family: 'Lora', Georgia, serif;
            color: var(--iu-navy);
        }
        .swagger-ui .scheme-container {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--border-cream);
            box-shadow: 0 2px 8px rgba(11, 27, 61, 0.04);
            margin-bottom: 24px;
            padding: 16px 24px;
        }
        .swagger-ui .opblock {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(12, 23, 84, 0.1);
            box-shadow: 0 1px 4px rgba(12, 23, 84, 0.03);
            margin-bottom: 14px;
        }
        .swagger-ui .btn.execute {
            background: var(--iu-crimson);
            border-color: var(--iu-crimson);
            border-radius: 100px;
            color: #FFFFFF;
            font-weight: 700;
        }
        .swagger-ui .btn.execute:hover {
            background: #660F29;
        }
    </style>
</head>
<body>

    <!-- Institutional Brand Topbar -->
    <header class="topbar-iu">
        <a href="/" class="brand-block" title="Ana Sayfaya Dön">
            <div class="brand-seal">
                <span class="seal-iu">İÜ</span>
                <span class="seal-year">1453</span>
            </div>
            <div>
                <div class="brand-title">İSTANBUL ÜNİVERSİTESİ</div>
                <div class="brand-subtitle">RESTful API • OpenAPI 3.0 Dokümantasyonu</div>
            </div>
        </a>

        <div class="topbar-actions">
            <a href="/api/swagger.json" target="_blank" class="btn-pill btn-gold">
                <span>📄 Saf JSON (/api/swagger.json)</span>
            </a>
            <a href="/" class="btn-pill btn-ghost">
                <span>🏠 Portala Dön</span>
            </a>
            <a href="/users" class="btn-pill btn-ghost">
                <span>🎓 Mezunlar</span>
            </a>
            <a href="/job-postings" class="btn-pill btn-ghost">
                <span>💼 İlanlar</span>
            </a>
        </div>
    </header>

    <!-- Swagger UI Mount Point -->
    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            window.ui = SwaggerUIBundle({
                url: "/api/swagger.json",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "BaseLayout"
            });
        };
    </script>
</body>
</html>
