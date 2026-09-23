<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni - Temporary Main Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .container {
            max-width: 720px;
            width: 100%;
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            text-align: center;
        }
        .badge {
            display: inline-block;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(96, 165, 250, 0.3);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        p.subtitle {
            font-size: 18px;
            color: #94a3b8;
            margin-bottom: 32px;
        }
        .routes-section {
            text-align: left;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 24px;
        }
        .routes-title {
            font-size: 14px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .route-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.2s;
            border-radius: 6px;
        }
        .route-item:last-child {
            border-bottom: none;
        }
        .route-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .route-badge {
            background: #10b981;
            color: #064e3b;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            margin-right: 12px;
        }
        .route-link {
            color: #38bdf8;
            text-decoration: none;
            font-family: monospace;
            font-size: 14px;
            flex-grow: 1;
        }
        .route-link:hover {
            text-decoration: underline;
        }
        .route-desc {
            color: #64748b;
            font-size: 13px;
        }
        .footer {
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">Laravel 11 � Step 6</div>
        <h1>Alumni Tracking System</h1>
        <p class="subtitle">Temporary Main Page</p>

        <div class="routes-section">
            <div class="routes-title">Tan�ml� Rotalar (Active Routes)</div>
            <div class="route-item">
                <div>
                    <span class="route-badge">GET</span>
                    <a class="route-link" href="/">/</a>
                </div>
                <span class="route-desc">Temporary Main Page</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge">GET</span>
                    <a class="route-link" href="/about">/about</a>
                </div>
                <span class="route-desc">Temporary About Page</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge">GET</span>
                    <a class="route-link" href="/hello">/hello</a>
                </div>
                <span class="route-desc">"Hello, world!"</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge">GET</span>
                    <a class="route-link" href="/hello/dilara">/hello/{name}</a>
                </div>
                <span class="route-desc">"Hello, Dilara!"</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge">GET</span>
                    <a class="route-link" href="/sum/5/3">/sum/{n1}/{n2}</a>
                </div>
                <span class="route-desc">Toplam: 8</span>
            </div>
        </div>

        <div class="footer">
            Alumni Tracking & Community Networking System � Powered by Docker & Nginx
        </div>
    </div>
</body>
</html><?php /**PATH /var/www/resources/views/welcome.blade.php ENDPATH**/ ?>