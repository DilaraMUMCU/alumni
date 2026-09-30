<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni API - Swagger Dokümantasyonu</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />
    <style>
        html { box-sizing: border-box; overflow-y: scroll; }
        *, *:before, *:after { box-sizing: inherit; }
        body { margin: 0; background: #fafafa; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .topbar-custom {
            background: #0f172a;
            color: #ffffff;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            flex-wrap: wrap;
            gap: 12px;
        }
        .topbar-custom h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #38bdf8;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .topbar-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-custom a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.2s;
        }
        .topbar-custom a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }
        .btn-json {
            color: #38bdf8 !important;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }
        .btn-json:hover {
            background: rgba(56, 189, 248, 0.15) !important;
        }
    </style>
</head>
<body>
    <div class="topbar-custom">
        <h2>🎓 Alumni Tracking System - API Swagger Dokümantasyonu</h2>
        <div class="topbar-links">
            <a href="/api/swagger.json" target="_blank" class="btn-json">📄 Saf JSON Gör (/api/swagger.json)</a>
            <a href="/">🏠 Ana Sayfaya Dön</a>
        </div>
    </div>

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