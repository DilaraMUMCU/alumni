<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş ve Staj İlanları - Alumni Tracking System</title>
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
            max-width: 1300px;
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
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .navbar-links a:hover, .navbar-links a.active {
            color: #ffffff;
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.4);
        }

        .db-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #6ee7b7;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }

        .db-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }

        .main-container {
            max-width: 1300px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
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

        .stat-info h4 {
            font-size: 13px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .stat-info .stat-number {
            font-size: 26px;
            font-weight: 800;
            color: #f8fafc;
        }

        .stat-icon {
            font-size: 30px;
            opacity: 0.85;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #4ade80;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            flex: 1;
        }

        .search-input {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #f8fafc;
            padding: 10px 16px;
            font-size: 14px;
            min-width: 240px;
            outline: none;
        }

        .search-input:focus {
            border-color: #38bdf8;
        }

        .select-filter {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #f8fafc;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            cursor: pointer;
        }

        .btn-filter {
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            background: rgba(56, 189, 248, 0.35);
        }

        .btn-create {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(56, 189, 248, 0.3);
            transition: all 0.2s ease;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.45);
        }

        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 20px;
        }

        .job-card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(12px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .job-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .job-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 12px;
        }

        .job-title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.4;
        }

        .type-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .type-full-time {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .type-internship {
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
            border: 1px solid rgba(168, 85, 247, 0.4);
        }

        .type-part-time {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        .job-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .job-description {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 18px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .job-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .applicant-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #38bdf8;
            font-size: 13px;
            font-weight: 600;
            background: rgba(56, 189, 248, 0.12);
            padding: 5px 10px;
            border-radius: 6px;
        }

        .job-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-apply {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-apply:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-detail {
            background: rgba(255, 255, 255, 0.08);
            color: #f1f5f9;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-detail:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        .empty-state {
            background: rgba(30, 41, 59, 0.5);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 60px 20px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state h3 {
            font-size: 18px;
            color: #f8fafc;
            margin-bottom: 8px;
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
            <a href="/users">👥 Mezunlar & Öğrenciler</a>
            <a href="/announcements">📢 Duyurular</a>
            <a href="/job-postings" class="active">💼 İş & Staj İlanları</a>
            <a href="/applications">📄 Başvurular</a>
            <a href="/job-postings/create">➕ Yeni İlan</a>
            <a href="/api/swagger" target="_blank">📜 Swagger UI</a>
            <div class="db-status-badge">
                <span class="db-dot"></span> 🗄️ MySQL 8.0: Connected (alumni.job_postings)
            </div>
        </div>
    </nav>

    <div class="main-container">

        <!-- Başarı / Hata Bildirimleri -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- İstatistik KPI Kartları -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Toplam İlan</h4>
                    <div class="stat-number">{{ $jobs->count() }}</div>
                </div>
                <div class="stat-icon">💼</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Tam Zamanlı</h4>
                    <div class="stat-number">{{ $jobs->where('employment_type', 'full-time')->count() }}</div>
                </div>
                <div class="stat-icon">👔</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Staj Fırsatları</h4>
                    <div class="stat-number">{{ $jobs->where('employment_type', 'internship')->count() }}</div>
                </div>
                <div class="stat-icon">🚀</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Toplam Başvuru</h4>
                    <div class="stat-number">{{ $jobs->sum(fn($j) => $j->applications->count()) }}</div>
                </div>
                <div class="stat-icon">📄</div>
            </div>
        </div>

        <!-- Araç Çubuğu (Filtreleme & Yeni İlan) -->
        <div class="toolbar">
            <form action="/job-postings" method="GET" class="filter-form">
                <input type="text" name="search" class="search-input" placeholder="🔍 İlan başlığı, şirket veya şehir ara..." value="{{ request('search') }}">
                <select name="employment_type" class="select-filter">
                    <option value="">Tüm Çalışma Tipleri</option>
                    <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Tam Zamanlı (Full-Time)</option>
                    <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Staj (Internship)</option>
                    <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Yarı Zamanlı (Part-Time)</option>
                </select>
                <button type="submit" class="btn-filter">Filtrele</button>
                @if(request()->has('search') || request()->has('employment_type'))
                    <a href="/job-postings" style="color: #94a3b8; font-size: 13px; text-decoration: none;">Temizle</a>
                @endif
            </form>
            <a href="/job-postings/create" class="btn-create">➕ Yeni İlan Yayınla</a>
        </div>

        <!-- İlan Kartları Izgarası -->
        @if($jobs->isEmpty())
            <div class="empty-state">
                <div style="font-size: 40px; margin-bottom: 12px;">📂</div>
                <h3>Henüz yayınlanmış iş ilanı bulunmuyor</h3>
                <p>İlk fırsatı oluşturmak için "Yeni İlan Yayınla" butonuna tıklayabilirsiniz.</p>
            </div>
        @else
            <div class="job-grid">
                @foreach($jobs as $job)
                    <div class="job-card">
                        <div>
                            <div class="job-header">
                                <h3 class="job-title">{{ $job->title }}</h3>
                                <span class="type-badge type-{{ $job->employment_type }}">
                                    {{ $job->employment_type == 'full-time' ? 'Tam Zamanlı' : ($job->employment_type == 'internship' ? 'Staj' : 'Yarı Zamanlı') }}
                                </span>
                            </div>

                            <div class="job-meta">
                                <span class="meta-item">🏢 <strong>{{ $job->company }}</strong></span>
                                <span class="meta-item">📍 {{ $job->location }}</span>
                                @if($job->user)
                                    <span class="meta-item">👤 {{ $job->user->name }}</span>
                                @endif
                                @if($job->deadline)
                                    <span class="meta-item">⏳ Son: {{ \Carbon\Carbon::parse($job->deadline)->format('d.m.Y') }}</span>
                                @endif
                            </div>

                            <p class="job-description">{{ $job->description }}</p>
                        </div>

                        <div class="job-footer">
                            <a href="/job-postings/{{ $job->id }}" class="applicant-count">
                                📩 {{ $job->applications->count() }} Başvuru
                            </a>

                            <div class="job-actions">
                                <a href="/applications/create?job_posting_id={{ $job->id }}" class="btn-apply">
                                    ✍️ Başvur
                                </a>
                                <a href="/job-postings/{{ $job->id }}" class="btn-detail">
                                    Detay / Yönet
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</body>
</html>
