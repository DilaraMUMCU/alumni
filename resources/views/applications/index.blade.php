<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş Başvuruları Yönetimi - Alumni Tracking System</title>
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 16px 20px;
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h4 {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .stat-info .stat-number {
            font-size: 24px;
            font-weight: 800;
            color: #f8fafc;
        }

        .stat-icon {
            font-size: 28px;
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
        }

        .card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
        }

        th {
            background: rgba(15, 23, 42, 0.7);
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        td {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .status-select {
            background: #1e293b;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 12px;
            cursor: pointer;
            outline: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🎓 Alumni Tracking System
        </a>
        <div class="navbar-links">
            <a href="/">🏠 Ana Sayfa</a>
            <a href="/users">👥 Mezunlar & Öğrenciler</a>
            <a href="/announcements">📢 Duyurular</a>
            <a href="/job-postings">💼 İş & Staj İlanları</a>
            <a href="/applications" class="active">📄 Başvurular</a>
            <a href="/applications/create">➕ Yeni Başvuru</a>
            <a href="/api/swagger" target="_blank">📜 Swagger UI</a>
            <div class="db-status-badge">
                <span class="db-dot"></span> 🗄️ MySQL 8.0: Connected (alumni.applications)
            </div>
        </div>
    </nav>

    <div class="main-container">

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <!-- İstatistik KPI Kartları -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Toplam Başvuru</h4>
                    <div class="stat-number">{{ $applications->count() }}</div>
                </div>
                <div class="stat-icon">📄</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Beklemede</h4>
                    <div class="stat-number" style="color: #fbbf24;">{{ $applications->where('status', 'pending')->count() }}</div>
                </div>
                <div class="stat-icon">⏳</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>İnceleniyor</h4>
                    <div class="stat-number" style="color: #38bdf8;">{{ $applications->where('status', 'reviewing')->count() }}</div>
                </div>
                <div class="stat-icon">🔍</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Kısa Liste</h4>
                    <div class="stat-number" style="color: #c084fc;">{{ $applications->where('status', 'shortlisted')->count() }}</div>
                </div>
                <div class="stat-icon">⭐</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Kabul Edildi</h4>
                    <div class="stat-number" style="color: #34d399;">{{ $applications->where('status', 'accepted')->count() }}</div>
                </div>
                <div class="stat-icon">✅</div>
            </div>
        </div>

        <!-- Filtre ve Yeni Başvuru Toolbar -->
        <div class="toolbar">
            <form action="/applications" method="GET" class="filter-form">
                <select name="status" class="select-filter">
                    <option value="">Tüm Durumlar</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Beklemede</option>
                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>🔍 İnceleniyor</option>
                    <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>⭐ Kısa Liste</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>✅ Kabul Edildi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Reddedildi</option>
                </select>

                <select name="job_posting_id" class="select-filter">
                    <option value="">Tüm İlanlar</option>
                    @foreach($jobPostings as $job)
                        <option value="{{ $job->id }}" {{ request('job_posting_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->title }} ({{ $job->company }})
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-filter">Filtrele</button>
                @if(request()->has('status') || request()->has('job_posting_id'))
                    <a href="/applications" style="color: #94a3b8; font-size: 13px; text-decoration: none;">Temizle</a>
                @endif
            </form>

            <a href="/applications/create" class="btn-create">✍️ Yeni Başvuru Gönder</a>
        </div>

        <!-- Başvurular Tablosu -->
        <div class="card">
            @if($applications->isEmpty())
                <div class="empty-state">
                    <div style="font-size: 40px; margin-bottom: 12px;">📭</div>
                    <h3>Henüz kayıtlı başvuru bulunmuyor</h3>
                    <p>İş ilanlarına başvuru yapıldığında aday kayıtları burada listelenecektir.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Aday (Öğrenci / Mezun)</th>
                                <th>Hedef İş İlanı</th>
                                <th>Özgeçmiş / CV</th>
                                <th>Ön Yazı / Not</th>
                                <th>Başvuru Tarihi</th>
                                <th>Durum Değiştir</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    <td style="color: #64748b; font-weight: 700;">#{{ $application->id }}</td>
                                    <td>
                                        <strong>{{ $application->user ? $application->user->name : 'Kullanıcı #' . $application->user_id }}</strong><br>
                                        <small style="color: #94a3b8;">{{ $application->user ? $application->user->email : '' }}</small><br>
                                        <small style="color: #38bdf8;">{{ $application->user ? $application->user->department : '' }}</small>
                                    </td>
                                    <td>
                                        @if($application->jobPosting)
                                            <a href="/job-postings/{{ $application->jobPosting->id }}" style="color: #ffffff; font-weight: 600; text-decoration: none;">
                                                💼 {{ $application->jobPosting->title }}
                                            </a><br>
                                            <small style="color: #94a3b8;">🏢 {{ $application->jobPosting->company }} ({{ $application->jobPosting->location }})</small>
                                        @else
                                            <span style="color: #64748b;">Silinmiş İlan (#{{ $application->job_posting_id }})</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($application->resume_url)
                                            <a href="{{ $application->resume_url }}" target="_blank" style="color: #38bdf8; text-decoration: underline;">
                                                📄 CV Görüntüle ↗
                                            </a>
                                        @else
                                            <span style="color: #64748b;">Belirtilmedi</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $application->cover_letter ?? '-' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($application->applied_at)->format('d.m.Y H:i') }}
                                    </td>
                                    <td>
                                        <form action="/applications/{{ $application->id }}/status" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="status-select" onchange="this.form.submit()">
                                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>⏳ Beklemede</option>
                                                <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>🔍 İnceleniyor</option>
                                                <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>⭐ Kısa Liste</option>
                                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>✅ Kabul Edildi</option>
                                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>❌ Reddedildi</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="/applications/{{ $application->id }}" method="POST" onsubmit="return confirm('Bu başvuruyu silmek istediğinizden emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #f87171; cursor: pointer; font-size: 13px;">🗑️ Sil</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
