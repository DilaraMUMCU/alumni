<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement['title'] ?? 'Duyuru Detayı' }} - Alumni Tracking System</title>
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
            max-width: 780px;
            width: 100%;
        }

        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
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

        .announcement-card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .badges-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .badge-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-pinned {
            background: rgba(234, 179, 8, 0.2);
            color: #facc15;
            border: 1px solid rgba(234, 179, 8, 0.4);
        }

        .badge-category-event {
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
            border: 1px solid rgba(192, 132, 252, 0.3);
        }

        .badge-category-career {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.3);
        }

        .badge-category-mentorship {
            background: rgba(56, 189, 248, 0.2);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }

        .badge-category-general {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .badge-priority-urgent {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .badge-priority-important {
            background: rgba(249, 115, 22, 0.2);
            color: #fb923c;
            border: 1px solid rgba(249, 115, 22, 0.3);
        }

        .badge-priority-normal {
            background: rgba(100, 116, 139, 0.2);
            color: #94a3b8;
            border: 1px solid rgba(100, 116, 139, 0.3);
        }

        .announcement-title {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.4;
            margin-bottom: 20px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }

        .meta-item .meta-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .meta-item .meta-value {
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
        }

        .content-body {
            font-size: 16px;
            line-height: 1.8;
            color: #cbd5e1;
            white-space: pre-line;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 32px;
            margin-bottom: 28px;
        }

        .card-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
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
            <a href="/announcements" class="btn-back">⬅️ Duyurular Listesine Dön</a>
            <span style="color: #64748b; font-size: 13px;">View: announcements.show (GET /announcements/{{ $announcement['id'] }})</span>
        </div>

        @if (session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="announcement-card">
            <div class="badges-header">
                <div class="badge-group">
                    @if (!empty($announcement['pinned']))
                        <span class="badge badge-pinned">📌 Sabitlendi</span>
                    @endif

                    @php
                        $cat = $announcement['category'] ?? 'general';
                        $catClass = match($cat) {
                            'event' => 'badge-category-event',
                            'career' => 'badge-category-career',
                            'mentorship' => 'badge-category-mentorship',
                            default => 'badge-category-general',
                        };
                        $catName = match($cat) {
                            'event' => 'Etkinlik & Buluşma',
                            'career' => 'Kariyer & Staj',
                            'mentorship' => 'Mentorluk',
                            'academic' => 'Akademik',
                            default => 'Genel Duyuru',
                        };
                        $priority = $announcement['priority'] ?? 'normal';
                        $priorityClass = match($priority) {
                            'urgent' => 'badge-priority-urgent',
                            'important' => 'badge-priority-important',
                            default => 'badge-priority-normal',
                        };
                        $priorityName = match($priority) {
                            'urgent' => 'Acil / Kritik',
                            'important' => 'Önemli',
                            default => 'Normal',
                        };
                    @endphp

                    <span class="badge {{ $catClass }}">{{ $catName }}</span>
                    <span class="badge {{ $priorityClass }}">{{ $priorityName }}</span>
                </div>

                <span style="color: #64748b; font-size: 13px; font-weight: 600;">Duyuru #{{ $announcement['id'] }}</span>
            </div>

            <h1 class="announcement-title">
                {{ $announcement['title'] ?? 'İsimsiz Duyuru' }}
            </h1>

            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Yayınlayan</div>
                    <div class="meta-value">👤 {{ $announcement['author'] ?? '-' }}</div>
                </div>

                <div class="meta-item">
                    <div class="meta-label">Hedef Kitle</div>
                    <div class="meta-value">🎯 {{ match($announcement['target_audience'] ?? 'all') { 'alumni' => 'Mezunlar', 'students' => 'Öğrenciler', default => 'Tüm Topluluk' } }}</div>
                </div>

                <div class="meta-item">
                    <div class="meta-label">Yayın Tarihi</div>
                    <div class="meta-value">🗓️ {{ !empty($announcement['created_at']) ? substr($announcement['created_at'], 0, 10) : '-' }}</div>
                </div>

                <div class="meta-item">
                    <div class="meta-label">Durum</div>
                    <div class="meta-value">{{ !empty($announcement['is_active']) ? '🟢 Yayında' : '⚪ Arşivlendi' }}</div>
                </div>
            </div>

            <div class="content-body">
                {{ $announcement['content'] ?? '' }}
            </div>

            <div class="card-actions">
                <div style="color: #64748b; font-size: 12px;">
                    Son Güncelleme: {{ !empty($announcement['updated_at']) ? substr($announcement['updated_at'], 0, 19) : '-' }}
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="/announcements/{{ $announcement['id'] }}/edit" class="btn-action btn-edit">
                        ✏️ Düzenle (GET)
                    </a>
                    <form action="/announcements/{{ $announcement['id'] }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
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
