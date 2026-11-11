<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı | Alumni Tracking System</title>
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
            padding: 24px;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto 32px auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px 28px;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            flex-wrap: wrap;
            gap: 16px;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: #38bdf8;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .navbar-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .navbar-links a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0 40px 0;
        }

        .error-card {
            max-width: 760px;
            width: 100%;
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(239, 68, 68, 0.35);
            border-radius: 24px;
            padding: 44px 36px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), 0 0 40px rgba(239, 68, 68, 0.12);
            backdrop-filter: blur(16px);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ef4444, #f97316, #eab308, #ef4444);
            background-size: 200% 100%;
            animation: gradientMove 4s linear infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .guardian-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #f87171;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 84px;
            font-weight: 900;
            letter-spacing: -3px;
            line-height: 1;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #ef4444 0%, #fca5a5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .error-subtitle {
            font-size: 15px;
            color: #94a3b8;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .details-box {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 18px 22px;
            text-align: left;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .details-row {
            display: flex;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .details-row:last-child {
            margin-bottom: 0;
        }

        .details-label {
            width: 140px;
            flex-shrink: 0;
            color: #94a3b8;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .details-value {
            color: #f1f5f9;
            word-break: break-all;
            flex: 1;
        }

        .details-value code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            color: #38bdf8;
            font-family: monospace;
            font-size: 13px;
        }

        .redirect-banner {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .redirect-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
            color: #bae6fd;
        }

        .redirect-info strong {
            color: #38bdf8;
            font-size: 16px;
        }

        .redirect-progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            overflow: hidden;
        }

        .redirect-progress-fill {
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, #0284c7, #38bdf8);
            border-radius: 9999px;
            transition: width 0.1s linear;
        }

        .pause-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #e2e8f0;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pause-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4);
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .quick-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
            font-size: 13px;
        }

        .quick-links span {
            color: #64748b;
        }

        .quick-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .quick-links a:hover {
            color: #38bdf8;
            text-decoration: underline;
        }

        .footer-note {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-top: 24px;
        }
    </style>
</head>
<body>

    <!-- Üst Menü / Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <span>🎓</span>
            <span>Alumni Tracking System</span>
        </a>
        <div class="navbar-links">
            <a href="/">🏠 Ana Sayfa</a>
            <a href="/users">👥 Mezunlar</a>
            <a href="/announcements">📢 Duyurular</a>
            <a href="/job-postings">💼 İş İlanları</a>
            <a href="/applications">📄 Başvurular</a>
            <a href="/api/swagger" target="_blank">📜 Swagger API</a>
        </div>
    </nav>

    <!-- Ana Hata Kartı -->
    <main class="main-wrapper">
        <div class="error-card">
            <div class="guardian-badge">🛡️ 404 Guardian Protected</div>
            
            <div class="error-code">404</div>
            <h1 class="error-title">Aradığınız Sayfa veya Kaynak Bulunamadı</h1>
            <p class="error-subtitle">
                Ulaşmaya çalıştığınız geçersiz adres sunucumuzda tanımlı değil veya taşınmış olabilir.
            </p>

            <!-- Hata Detayları -->
            <div class="details-box">
                <div class="details-row">
                    <span class="details-label">Geçersiz İstek:</span>
                    <span class="details-value">
                        <code>{{ $method ?? 'GET' }}</code>
                        <code>{{ $path ?? request()->path() }}</code>
                    </span>
                </div>
                <div class="details-row">
                    <span class="details-label">Açıklama:</span>
                    <span class="details-value">
                        {{ $reason ?? 'İstenen kaynak bulunamadı. Lütfen URL adresinizi kontrol edin veya ana sayfaya dönün.' }}
                    </span>
                </div>
                <div class="details-row">
                    <span class="details-label">Hata Zamanı:</span>
                    <span class="details-value">
                        {{ $timestamp ?? date('Y-m-d H:i:s') }}
                    </span>
                </div>
            </div>

            <!-- Otomatik Yönlendirme Alanı -->
            <div class="redirect-banner">
                <div class="redirect-info">
                    <span id="countdown-text">
                        ⏱️ Bu geçersiz istek nedeniyle <strong id="countdown">5</strong> saniye içinde ana sayfaya yönlendirileceksiniz...
                    </span>
                    <button type="button" id="pause-btn" class="pause-btn" onclick="toggleRedirect()">
                        ⏸️ Durdur
                    </button>
                </div>
                <div class="redirect-progress-bar">
                    <div id="progress-fill" class="redirect-progress-fill"></div>
                </div>
            </div>

            <!-- Aksiyon Butonları -->
            <div class="actions">
                <a href="/" class="btn btn-primary">
                    <span>🏠 Hemen Ana Sayfaya Dön</span>
                </a>
                <a href="/job-postings" class="btn btn-secondary">
                    <span>💼 İş İlanları</span>
                </a>
                <a href="/announcements" class="btn btn-secondary">
                    <span>📢 Duyurular</span>
                </a>
                <a href="/users" class="btn btn-secondary">
                    <span>👥 Kullanıcılar</span>
                </a>
            </div>

            <!-- Hızlı Bağlantılar -->
            <div class="quick-links">
                <span>Hızlı Geçiş:</span>
                <a href="/api/swagger" target="_blank">📜 Swagger UI</a>
                <a href="/api/health" target="_blank">🩺 Health Check</a>
                <a href="/about">ℹ️ Hakkında</a>
            </div>
        </div>
    </main>

    <div class="footer-note">
        Alumni Tracking System &copy; {{ date('Y') }} &bull; Güvenli Hata Yönetimi &bull; 404 Guardian
    </div>

    <!-- Otomatik Yönlendirme Sayacı Betiği -->
    <script>
        (function() {
            let totalSeconds = 5;
            let remainingSeconds = totalSeconds;
            let isPaused = false;
            const targetUrl = "/";

            const countdownElem = document.getElementById("countdown");
            const progressFill = document.getElementById("progress-fill");
            const pauseBtn = document.getElementById("pause-btn");
            const countdownText = document.getElementById("countdown-text");

            const intervalMs = 100; // Her 100ms'de barı güncelle
            const totalSteps = (totalSeconds * 1000) / intervalMs;
            let currentStep = 0;

            const timer = setInterval(function() {
                if (isPaused) return;

                currentStep++;
                const percentage = Math.max(0, 100 - (currentStep / totalSteps * 100));
                if (progressFill) {
                    progressFill.style.width = percentage + "%";
                }

                const newRemaining = Math.ceil((totalSteps - currentStep) * (intervalMs / 1000));
                if (newRemaining !== remainingSeconds) {
                    remainingSeconds = Math.max(0, newRemaining);
                    if (countdownElem) {
                        countdownElem.innerText = remainingSeconds;
                    }
                }

                if (currentStep >= totalSteps) {
                    clearInterval(timer);
                    window.location.href = targetUrl;
                }
            }, intervalMs);

            window.toggleRedirect = function() {
                isPaused = !isPaused;
                if (isPaused) {
                    pauseBtn.innerHTML = "▶️ Devam Et";
                    pauseBtn.style.background = "rgba(56, 189, 248, 0.2)";
                    pauseBtn.style.color = "#38bdf8";
                    if (countdownText) {
                        countdownText.innerHTML = "⏸️ Otomatik yönlendirme duraklatıldı. İstediğiniz bağlantıya tıklayabilirsiniz.";
                    }
                } else {
                    pauseBtn.innerHTML = "⏸️ Durdur";
                    pauseBtn.style.background = "rgba(255, 255, 255, 0.08)";
                    pauseBtn.style.color = "#e2e8f0";
                    if (countdownText) {
                        countdownText.innerHTML = '⏱️ Bu geçersiz istek nedeniyle <strong id="countdown">' + remainingSeconds + '</strong> saniye içinde ana sayfaya yönlendirileceksiniz...';
                    }
                }
            };
        })();
    </script>
</body>
</html>
