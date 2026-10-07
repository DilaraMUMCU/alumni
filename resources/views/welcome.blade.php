<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni - Active Routes & API</title>
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
            padding: 32px 16px;
        }
        .container {
            max-width: 880px;
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
            font-size: 17px;
            color: #94a3b8;
            margin-bottom: 28px;
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
            font-size: 13px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 14px;
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
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            margin-right: 12px;
            display: inline-block;
        }
        .badge-get {
            background: #10b981;
            color: #064e3b;
        }
        .badge-post {
            background: #f59e0b;
            color: #78350f;
        }
        .badge-put {
            background: #8b5cf6;
            color: #2e1065;
        }
        .badge-patch {
            background: #06b6d4;
            color: #083344;
        }
        .badge-delete {
            background: #ef4444;
            color: #450a0a;
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
        .test-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-bottom: 24px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .btn {
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn-get {
            background: #10b981;
            color: #064e3b;
        }
        .btn-post {
            background: #f59e0b;
            color: #78350f;
        }
        .btn-put {
            background: #a855f7;
            color: #ffffff;
        }
        .btn-patch {
            background: #06b6d4;
            color: #083344;
        }
        .btn-delete {
            background: #ef4444;
            color: #ffffff;
        }
        .btn-reset {
            background: #475569;
            color: #f1f5f9;
        }
        pre.response-box {
            background: #020617;
            color: #a7f3d0;
            padding: 14px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 13px;
            margin-top: 14px;
            overflow-x: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-height: 280px;
            display: none;
        }
        .footer {
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">Laravel 11 � RESTful CRUD</div>
        <h1>Alumni Tracking System</h1>
        <p class="subtitle">Complete RESTful Resource Management (GET, POST, PUT, PATCH, DELETE)</p>

        <div class="routes-section">
            <div class="routes-title">Aktif Rotalar (Active Routes)</div>
            <div class="route-item" style="background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.35); margin-bottom: 8px;">
                <div>
                    <span class="route-badge" style="background: #38bdf8; color: #082f49; font-weight: 800;">DOCS</span>
                    <a class="route-link" style="color: #38bdf8; font-weight: 700;" href="/api/swagger">/api/swagger</a>
                </div>
                <span class="route-desc" style="color: #bae6fd; font-weight: 600;">⚡ İnteraktif Swagger UI Dokümantasyonu</span>
            </div>
            <div class="route-item" style="background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.4); margin-bottom: 8px;">
                <div>
                    <span class="route-badge" style="background: #a855f7; color: #ffffff; font-weight: 800;">VIEW</span>
                    <a class="route-link" style="color: #c084fc; font-weight: 700;" href="/users">/users</a>
                </div>
                <span class="route-desc" style="color: #e9d5ff; font-weight: 600;">👥 Web Arayüzü: Kullanıcı Listesi & Ekleme Formu (View Layer)</span>
            </div>
            <div class="route-item" style="background: rgba(234, 179, 8, 0.15); border: 1px solid rgba(234, 179, 8, 0.4); margin-bottom: 8px;">
                <div>
                    <span class="route-badge" style="background: #eab308; color: #713f12; font-weight: 800;">VIEW</span>
                    <a class="route-link" style="color: #fde047; font-weight: 700;" href="/announcements">/announcements</a>
                </div>
                <span class="route-desc" style="color: #fef08a; font-weight: 600;">📢 Web Arayüzü: Duyurular Yönetimi & Ekleme Formu (View Layer)</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-get">GET</span>
                    <a class="route-link" href="/">/</a>
                </div>
                <span class="route-desc">Temporary Main Page</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-get">GET</span>
                    <a class="route-link" href="/about">/about</a>
                </div>
                <span class="route-desc">Temporary About Page</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-get">GET</span>
                    <a class="route-link" href="/api/health">/api/health</a>
                </div>
                <span class="route-desc">JSON: Health Check</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-get">GET</span>
                    <a class="route-link" href="/api/users">/api/users</a>
                </div>
                <span class="route-desc">JSON: List All Users</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-get">GET</span>
                    <a class="route-link" href="/api/users/1">/api/users/{id}</a>
                </div>
                <span class="route-desc">JSON: Show Single User</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-post">POST</span>
                    <span class="route-link" style="color: #fbbf24;">/api/users</span>
                </div>
                <span class="route-desc">JSON: Create User</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-put">PUT</span>
                    <span class="route-link" style="color: #c084fc;">/api/users/{id}</span>
                </div>
                <span class="route-desc">JSON: Full Update</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-patch">PATCH</span>
                    <span class="route-link" style="color: #67e8f9;">/api/users/{id}</span>
                </div>
                <span class="route-desc">JSON: Partial Update</span>
            </div>
            <div class="route-item">
                <div>
                    <span class="route-badge badge-delete">DELETE</span>
                    <span class="route-link" style="color: #f87171;">/api/users/{id}</span>
                </div>
                <span class="route-desc">JSON: Delete User</span>
            </div>
        </div>

        <div class="test-card">
            <span style="font-weight: 600; font-size: 14px; color: #fca5a5;">RESTful API Canl� Test Konsolu</span>
            <p style="font-size: 13px; color: #94a3b8; margin: 8px 0 12px 0;">
                T�m CRUD i�lemlerini s�rayla canl� olarak test edebilirsiniz:
            </p>
            <div class="btn-group">
                <button class="btn btn-get" onclick="fetchGetUsers()">1. GET (Listele)</button>
                <button class="btn btn-post" onclick="sendPostRequest()">2. POST (Ekle)</button>
                <button class="btn btn-put" onclick="sendPutRequest(1)">3. PUT (Tam G�ncelle)</button>
                <button class="btn btn-patch" onclick="sendPatchRequest(1)">4. PATCH (K�smi G�ncelle)</button>
                <button class="btn btn-delete" onclick="sendDeleteRequest(3)">5. DELETE (ID: 3 Sil)</button>
                <button class="btn btn-reset" onclick="resetUsers()">S�f�rla</button>
            </div>
            <pre id="responseOutput" class="response-box"></pre>
        </div>

        <div class="footer">
            Alumni Tracking & Community Networking System � Powered by Docker & Nginx
        </div>
    </div>

    <script>
        const output = document.getElementById('responseOutput');

        async function fetchGetUsers() {
            output.style.display = 'block';
            output.textContent = 'GET /api/users iste�i g�nderiliyor...';

            try {
                const response = await fetch('/api/users', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                output.textContent = '?? GET /api/users (Toplam ' + data.count + ' kullan�c�):\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPostRequest() {
            output.style.display = 'block';
            output.textContent = 'POST /api/users iste�i g�nderiliyor...';

            const randomNames = ['Zeynep Kaya', 'Burak �zt�rk', 'Ay�e �elik', 'Mehmet Aksoy'];
            const chosenName = randomNames[Math.floor(Math.random() * randomNames.length)];

            try {
                const response = await fetch('/api/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: chosenName,
                        email: chosenName.toLowerCase().replace(/[^a-z]/g, '') + '@alumni.edu',
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
                output.textContent = '? POST BA�ARILI (HTTP ' + response.status + ' Created)\n\n' +
                                     'Eklenen Kullan�c�:\n' + JSON.stringify(data.data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPutRequest(id) {
            output.style.display = 'block';
            output.textContent = 'PUT /api/users/' + id + ' (Tam G�ncelleme) iste�i g�nderiliyor...';

            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
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
                output.textContent = '?? PUT BA�ARILI (HTTP ' + response.status + ' OK)\n\n' +
                                     'G�ncellenen Kullan�c�:\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendPatchRequest(id) {
            output.style.display = 'block';
            output.textContent = 'PATCH /api/users/' + id + ' iste�i g�nderiliyor...';

            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        current_company: 'OpenAI Research',
                        job_title: 'AI Systems Architect'
                    })
                });

                const data = await response.json();
                output.textContent = '? PATCH BA�ARILI (HTTP ' + response.status + ' OK)\n\n' +
                                     'G�ncellenen Kullan�c�:\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function sendDeleteRequest(id) {
            output.style.display = 'block';
            output.textContent = 'DELETE /api/users/' + id + ' iste�i g�nderiliyor...';

            try {
                const response = await fetch('/api/users/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                const data = await response.json();
                output.textContent = '??? DELETE BA�ARILI (HTTP ' + response.status + ' OK)\n\n' +
                                     'Silinen Kullan�c�:\n' + JSON.stringify(data.deleted_user, null, 2) +
                                     '\n\n?? �imdi "1. GET" butonuna basarak ID: ' + id + ' kullan�c�s�n�n listeden ��kt���n� teyit edebilirsiniz!';
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }

        async function resetUsers() {
            output.style.display = 'block';
            output.textContent = 'Liste s�f�rlan�yor...';

            try {
                const response = await fetch('/api/users/reset', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                output.textContent = '?? Liste ba�lang�� haline s�f�rland�:\n\n' + JSON.stringify(data, null, 2);
            } catch (err) {
                output.textContent = 'Hata: ' + err.message;
            }
        }
    </script>
</body>
</html>