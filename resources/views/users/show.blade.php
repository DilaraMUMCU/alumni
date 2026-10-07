<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user['name'] ?? 'Kullanıcı Detayı' }} - Profil - Alumni Tracking System</title>
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
            align-items: center;
        }

        .container {
            max-width: 720px;
            width: 100%;
        }

        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .btn-back {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #4ade80;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .profile-card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 28px;
            margin-bottom: 28px;
        }

        .avatar {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(56, 189, 248, 0.35);
        }

        .profile-title h1 {
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .role-badge {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            display: inline-block;
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

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (min-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .info-item {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 16px 20px;
        }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            color: #e2e8f0;
            font-weight: 500;
        }

        .skills-section {
            margin-bottom: 32px;
        }

        .skills-section h3 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .skill-tag {
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.25);
            color: #7dd3fc;
            font-size: 13px;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .card-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 24px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            font-size: 14px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background: rgba(234, 179, 8, 0.2);
            color: #fde047;
            border: 1px solid rgba(234, 179, 8, 0.4);
        }
        .btn-edit:hover {
            background: rgba(234, 179, 8, 0.35);
            color: #ffffff;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.35);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="top-nav">
            <a href="/users" class="btn-back">⬅️ Kullanıcı Listesine Dön</a>
            <span style="color: #64748b; font-size: 13px;">View: users.show (GET /users/{{ $user['id'] }})</span>
        </div>

        @if (session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar">
                    {{ strtoupper(substr($user['name'] ?? 'U', 0, 1)) }}
                </div>
                <div class="profile-title">
                    <h1>{{ $user['name'] ?? 'İsimsiz' }}</h1>
                    <span class="role-badge {{ ($user['role'] ?? '') === 'student' ? 'role-student' : 'role-alumni' }}">
                        {{ $user['role'] ?? 'alumni' }}
                    </span>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">E-posta Adresi</div>
                    <div class="info-value">{{ $user['email'] ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Bölüm / Fakülte</div>
                    <div class="info-value">{{ $user['department'] ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Mezuniyet Yılı</div>
                    <div class="info-value">{{ $user['graduation_year'] ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Kullanıcı ID</div>
                    <div class="info-value">#{{ $user['id'] }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Mevcut Şirket</div>
                    <div class="info-value">{{ $user['current_company'] ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Pozisyon / Unvan</div>
                    <div class="info-value">{{ $user['job_title'] ?? '-' }}</div>
                </div>

                @if (!empty($user['linkedin_url']))
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <div class="info-label">LinkedIn Profili</div>
                        <div class="info-value">
                            <a href="{{ $user['linkedin_url'] }}" target="_blank" style="color: #38bdf8; text-decoration: none;">
                                🔗 {{ $user['linkedin_url'] }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            @if (!empty($user['skills']) && is_array($user['skills']))
                <div class="skills-section">
                    <h3>Yetenekler & Uzmanlıklar</h3>
                    <div class="skills-list">
                        @foreach ($user['skills'] as $skill)
                            <span class="skill-tag">🏷️ {{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="card-actions">
                <div style="color: #64748b; font-size: 12px;">
                    Oluşturulma: {{ !empty($user['created_at']) ? substr($user['created_at'], 0, 19) : '-' }}
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="/users/{{ $user['id'] }}/edit" class="btn-action btn-edit">
                        ✏️ Düzenle (GET)
                    </a>
                    <form action="/users/{{ $user['id'] }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            🗑️ Sil (DELETE)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
