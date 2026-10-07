<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Yönetimi - Alumni Tracking System</title>
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
            max-width: 1250px;
            margin: 0 auto 28px auto;
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

        .stats-grid {
            max-width: 1250px;
            margin: 0 auto 28px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 18px 22px;
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card .stat-info h3 {
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-card .stat-info .stat-num {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
        }

        .stat-icon {
            font-size: 32px;
            opacity: 0.85;
        }

        .main-container {
            max-width: 1250px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }

        @media (min-width: 1024px) {
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            height: fit-content;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h2 {
            font-size: 19px;
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
            margin-bottom: 16px;
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

        textarea.form-control {
            resize: vertical;
            min-height: 95px;
        }

        select.form-control {
            cursor: pointer;
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #cbd5e1;
            cursor: pointer;
            margin-top: 6px;
        }

        .checkbox-label input {
            cursor: pointer;
            width: 16px;
            height: 16px;
            accent-color: #38bdf8;
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

        /* Announcement List Cards */
        .announcement-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .announcement-card {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 20px;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
        }

        .announcement-card.is-pinned {
            border-color: rgba(234, 179, 8, 0.4);
            background: rgba(234, 179, 8, 0.04);
        }

        .announcement-card:hover {
            border-color: rgba(56, 189, 248, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
            background: rgba(15, 23, 42, 0.75);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge-group {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
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
            font-size: 17px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.4;
        }

        .announcement-excerpt {
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.6;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #64748b;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            flex-wrap: wrap;
            gap: 8px;
        }

        .announcement-meta strong {
            color: #cbd5e1;
        }

        .announcement-actions {
            display: flex;
            align-items: center;
            gap: 8px;
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
            <a href="/users">👥 Kullanıcılar</a>
            <a href="/announcements" class="active">📢 Duyurular (/announcements)</a>
            <a href="/announcements/create">➕ Yeni Duyuru Ekle</a>
            <a href="/api/swagger" target="_blank">📜 Swagger UI</a>
            <a href="/api/swagger.json" target="_blank">📄 OpenAPI JSON</a>
        </div>
    </nav>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Toplam Duyuru</h3>
                <div class="stat-num">{{ count($announcements) }}</div>
            </div>
            <div class="stat-icon">📢</div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Sabitlenenler</h3>
                <div class="stat-num">{{ count(array_filter($announcements, fn($a) => !empty($a['pinned']))) }}</div>
            </div>
            <div class="stat-icon">📌</div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Kariyer & Staj</h3>
                <div class="stat-num">{{ count(array_filter($announcements, fn($a) => ($a['category'] ?? '') === 'career')) }}</div>
            </div>
            <div class="stat-icon">💼</div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Etkinlikler</h3>
                <div class="stat-num">{{ count(array_filter($announcements, fn($a) => ($a['category'] ?? '') === 'event')) }}</div>
            </div>
            <div class="stat-icon">🎯</div>
        </div>
    </div>

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

        <!-- SOL KOLON: Yeni Duyuru Ekleme Formu (POST /announcements) -->
        <div class="card">
            <div class="card-header">
                <h2>➕ Yeni Duyuru Yayınla</h2>
                <span class="count-badge">POST /announcements</span>
            </div>

            <form action="/announcements" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Duyuru Başlığı *</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Örn: 2026 Mezunlar Zirvesi Kayıtları" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category" class="form-control">
                            <option value="general">Genel Duyuru</option>
                            <option value="event" selected>Etkinlik & Buluşma</option>
                            <option value="career">Kariyer & Staj</option>
                            <option value="mentorship">Mentorluk</option>
                            <option value="academic">Akademik</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priority">Öncelik</label>
                        <select id="priority" name="priority" class="form-control">
                            <option value="normal" selected>Normal</option>
                            <option value="important">Önemli</option>
                            <option value="urgent">Acil / Kritik</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="author">Yayınlayan Birim/Kişi</label>
                        <input type="text" id="author" name="author" class="form-control" placeholder="Örn: Kariyer Merkezi" value="Mezunlar Koordinatörlüğü">
                    </div>

                    <div class="form-group">
                        <label for="target_audience">Hedef Kitle</label>
                        <select id="target_audience" name="target_audience" class="form-control">
                            <option value="all" selected>Tüm Topluluk</option>
                            <option value="alumni">Yalnızca Mezunlar</option>
                            <option value="students">Yalnızca Öğrenciler</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Duyuru İçeriği *</label>
                    <textarea id="content" name="content" class="form-control" placeholder="Duyurunun tüm detaylarını buraya yazın..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="pinned" value="1">
                        <span>📌 Bu duyuruyu en üstte sabitle (Pinned)</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    📢 Duyuruyu Yayınla (POST)
                </button>
            </form>
        </div>

        <!-- SAĞ KOLON: Yayınlanan Duyurular Listesi (GET /announcements) -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Yayınlanan Duyurular Rehberi</h2>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="/announcements/create" class="action-btn btn-view" style="font-size: 13px; padding: 6px 14px;">➕ Yeni Sayfada Ekle</a>
                    <span class="count-badge">{{ count($announcements) }} Duyuru</span>
                </div>
            </div>

            <div class="announcement-list">
                @forelse ($announcements as $announcement)
                    <div class="announcement-card {{ !empty($announcement['pinned']) ? 'is-pinned' : '' }}">
                        <div class="card-top">
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
                                        'event' => 'Etkinlik',
                                        'career' => 'Kariyer & Staj',
                                        'mentorship' => 'Mentorluk',
                                        'academic' => 'Akademik',
                                        default => 'Genel',
                                    };
                                    $priority = $announcement['priority'] ?? 'normal';
                                    $priorityClass = match($priority) {
                                        'urgent' => 'badge-priority-urgent',
                                        'important' => 'badge-priority-important',
                                        default => 'badge-priority-normal',
                                    };
                                    $priorityName = match($priority) {
                                        'urgent' => 'Acil',
                                        'important' => 'Önemli',
                                        default => 'Normal',
                                    };
                                @endphp

                                <span class="badge {{ $catClass }}">{{ $catName }}</span>
                                <span class="badge {{ $priorityClass }}">{{ $priorityName }}</span>
                            </div>

                            <span style="font-size: 12px; color: #64748b;">
                                #{{ $announcement['id'] }}
                            </span>
                        </div>

                        <div class="announcement-title">
                            {{ $announcement['title'] ?? 'İsimsiz Duyuru' }}
                        </div>

                        <div class="announcement-excerpt">
                            {{ \Illuminate\Support\Str::limit($announcement['content'] ?? '', 170) }}
                        </div>

                        <div class="announcement-meta">
                            <div>
                                👤 <strong>{{ $announcement['author'] ?? 'Bilinmiyor' }}</strong> 
                                &bull; 🎯 {{ match($announcement['target_audience'] ?? 'all') { 'alumni' => 'Mezunlar', 'students' => 'Öğrenciler', default => 'Herkes' } }}
                                &bull; 🗓️ {{ !empty($announcement['created_at']) ? substr($announcement['created_at'], 0, 10) : '' }}
                            </div>

                            <div class="announcement-actions">
                                <a href="/announcements/{{ $announcement['id'] }}" class="action-btn btn-view">
                                    👁️ Detay (GET)
                                </a>
                                <a href="/announcements/{{ $announcement['id'] }}/edit" class="action-btn btn-edit">
                                    ✏️ Düzenle (GET)
                                </a>
                                <form action="/announcements/{{ $announcement['id'] }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete">
                                        🗑️ Sil (DELETE)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #94a3b8; text-align: center; padding: 32px;">Henüz yayınlanmış bir duyuru bulunmamaktadır.</p>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>
