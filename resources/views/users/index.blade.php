<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi - Alumni Tracking System</title>
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
        }

        .navbar {
            max-width: 1200px;
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
            gap: 12px;
            flex-wrap: wrap;
        }

        .navbar-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .navbar-links a:hover, .navbar-links a.active {
            color: #ffffff;
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.4);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }

        @media (min-width: 992px) {
            .main-container {
                grid-template-columns: 420px 1fr;
            }
        }

        .alert {
            grid-column: 1 / -1;
            padding: 16px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #4ade80;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
        }

        .card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 28px;
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }

        .card-header {
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 16px;
        }

        .card-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .count-badge {
            background: rgba(56, 189, 248, 0.2);
            color: #38bdf8;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 12px 14px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
            background: rgba(15, 23, 42, 0.9);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        select.form-control {
            cursor: pointer;
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 20px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(56, 189, 248, 0.3);
            transition: all 0.2s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(56, 189, 248, 0.45);
        }

        /* User List Cards */
        .user-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 640px) {
            .user-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .user-card {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 18px;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .user-card:hover {
            border-color: rgba(56, 189, 248, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            background: rgba(15, 23, 42, 0.7);
        }

        .user-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 10px;
        }

        .user-name {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 13px;
            color: #94a3b8;
            word-break: break-all;
        }

        .role-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .role-alumni {
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
            border: 1px solid rgba(192, 132, 252, 0.3);
        }

        .role-student {
            background: rgba(56, 189, 248, 0.2);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }

        .user-details {
            font-size: 13px;
            color: #cbd5e1;
            margin: 8px 0;
            line-height: 1.5;
        }

        .user-details strong {
            color: #e2e8f0;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .skill-tag {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .user-actions {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }
        .btn-view:hover {
            background: rgba(56, 189, 248, 0.3);
            color: #ffffff;
        }

        .btn-edit {
            background: rgba(234, 179, 8, 0.15);
            color: #facc15;
            border: 1px solid rgba(234, 179, 8, 0.3);
        }
        .btn-edit:hover {
            background: rgba(234, 179, 8, 0.3);
            color: #ffffff;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Üst Navigasyon Menüsü -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🎓 Alumni Tracking System
        </a>
        <div class="navbar-links">
            <a href="/">🏠 Ana Sayfa</a>
            <a href="/users" class="active">👥 Kullanıcılar (/users)</a>
            <a href="/announcements">📢 Duyurular (/announcements)</a>
            <a href="/users/create">➕ Yeni Kullanıcı Sayfası</a>
            <a href="/about">ℹ️ Hakkında</a>
            <a href="/api/swagger" target="_blank">📜 Swagger UI</a>
            <a href="/api/swagger.json" target="_blank">📄 OpenAPI JSON</a>
        </div>
    </nav>

    <div class="main-container">

        <!-- Başarı / Hata Bildirimleri -->
        @if (session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- SOL KOLON: Yeni Kullanıcı Ekleme Formu (POST /users) -->
        <div class="card">
            <div class="card-header">
                <h2>➕ Yeni Kullanıcı Ekle</h2>
                <span class="count-badge">POST /users</span>
            </div>

            <form action="/users" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Ad Soyad *</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Örn: Dilara MUMCU" required>
                </div>

                <div class="form-group">
                    <label for="email">E-posta Adresi *</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Örn: dilara@ogr.iu.edu.tr" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select id="role" name="role" class="form-control">
                            <option value="student">Öğrenci (Student)</option>
                            <option value="alumni" selected>Mezun (Alumni)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="graduation_year">Mezuniyet Yılı</label>
                        <input type="number" id="graduation_year" name="graduation_year" class="form-control" placeholder="2024" value="2024">
                    </div>
                </div>

                <div class="form-group">
                    <label for="department">Bölüm</label>
                    <input type="text" id="department" name="department" class="form-control" placeholder="Örn: MIS / Bilgisayar Mühendisliği" value="Computer Engineering">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="current_company">Mevcut Şirket</label>
                        <input type="text" id="current_company" name="current_company" class="form-control" placeholder="Örn: Google">
                    </div>

                    <div class="form-group">
                        <label for="job_title">Unvan / Pozisyon</label>
                        <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Örn: Software Engineer">
                    </div>
                </div>

                <div class="form-group">
                    <label for="skills">Yetenekler (Virgülle ayırın)</label>
                    <input type="text" id="skills" name="skills" class="form-control" placeholder="PHP, Laravel, Docker, MySQL">
                </div>

                <div class="form-group">
                    <label for="linkedin_url">LinkedIn Profili</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/...">
                </div>

                <button type="submit" class="btn-submit">
                    💾 Kullanıcıyı Kaydet (POST)
                </button>
            </form>
        </div>

        <!-- SAĞ KOLON: Kayıtlı Kullanıcı Listesi (GET /users) -->
        <div class="card">
            <div class="card-header">
                <h2>👥 Kayıtlı Mezun ve Öğrenciler</h2>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="/users/create" class="action-btn btn-view" style="font-size: 13px; padding: 6px 14px;">➕ Yeni Sayfada Ekle</a>
                    <span class="count-badge">{{ count($users) }} Kullanıcı</span>
                </div>
            </div>

            <div class="user-grid">
                @forelse ($users as $user)
                    <div class="user-card">
                        <div>
                            <div class="user-header">
                                <div>
                                    <div class="user-name">{{ $user['name'] ?? 'İsimsiz' }}</div>
                                    <div class="user-email">{{ $user['email'] ?? '-' }}</div>
                                </div>
                                <span class="role-badge {{ ($user['role'] ?? '') === 'student' ? 'role-student' : 'role-alumni' }}">
                                    {{ $user['role'] ?? 'alumni' }}
                                </span>
                            </div>

                            <div class="user-details">
                                <div>🎓 <strong>Bölüm:</strong> {{ $user['department'] ?? '-' }} ({{ $user['graduation_year'] ?? '-' }})</div>
                                @if (!empty($user['current_company']) || !empty($user['job_title']))
                                    <div>💼 <strong>İş:</strong> {{ $user['job_title'] ?? '-' }} @ {{ $user['current_company'] ?? '-' }}</div>
                                @endif
                            </div>

                            @if (!empty($user['skills']) && is_array($user['skills']))
                                <div class="skills-list">
                                    @foreach ($user['skills'] as $skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- CRUD Eylemleri: Görüntüle (GET), Düzenle (GET), Sil (DELETE) -->
                        <div class="user-actions">
                            <a href="/users/{{ $user['id'] }}" class="action-btn btn-view">
                                👁️ Detay (GET)
                            </a>
                            <a href="/users/{{ $user['id'] }}/edit" class="action-btn btn-edit">
                                ✏️ Düzenle (GET)
                            </a>
                            <form action="/users/{{ $user['id'] }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete">
                                    🗑️ Sil (DELETE)
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="color: #94a3b8; text-align: center; grid-column: 1 / -1; padding: 24px;">Henüz kayıtlı kullanıcı bulunmamaktadır.</p>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>
