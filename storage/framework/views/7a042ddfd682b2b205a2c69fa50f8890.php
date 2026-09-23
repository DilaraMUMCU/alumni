<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Temporary About Page</title>
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
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
            border: 1px solid rgba(192, 132, 252, 0.3);
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
            background: linear-gradient(to right, #ffffff, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        p.subtitle {
            font-size: 18px;
            color: #94a3b8;
            margin-bottom: 28px;
        }
        .about-card {
            text-align: left;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 28px;
            line-height: 1.6;
            color: #cbd5e1;
        }
        .about-card p {
            margin-bottom: 12px;
        }
        .about-card p:last-child {
            margin-bottom: 0;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            background: #3b82f6;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-back:hover {
            background: #2563eb;
        }
        .footer {
            font-size: 13px;
            color: #64748b;
            margin-top: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">Laravel 11 � Step 6</div>
        <h1>About the System</h1>
        <p class="subtitle">Temporary About Page</p>

        <div class="about-card">
            <p><strong>Alumni Tracking & Community Networking System</strong></p>
            <p>A scalable, web-based alumni management and engagement platform designed to bridge the gap between educational institutions, organizations, students, and graduates.</p>
            <p>The system empowers communities to maintain lifelong connections, support professional growth, and foster collaborative networking.</p>
        </div>

        <a href="/" class="btn-back">� Back to Main Page</a>

        <div class="footer">
            Alumni Tracking & Community Networking System � Powered by Docker & Nginx
        </div>
    </div>
</body>
</html><?php /**PATH /var/www/resources/views/about.blade.php ENDPATH**/ ?>