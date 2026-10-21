<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - İlan Detayı & Başvurular</title>
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

        .navbar-links a:hover {
            color: #ffffff;
            background: rgba(56, 189, 248, 0.2);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 12px;
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

        .card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 28px;
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }

        .job-hero-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .job-title {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .job-meta-badges {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 13px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-company {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #38bdf8;
        }

        .badge-location {
            background: rgba(148, 163, 184, 0.15);
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: #cbd5e1;
        }

        .badge-type {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            text-transform: uppercase;
        }

        .job-hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-edit {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .job-body {
            font-size: 15px;
            line-height: 1.8;
            color: #e2e8f0;
            white-space: pre-line;
            margin-bottom: 24px;
        }

        .job-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 18px;
        }

        .detail-item strong {
            display: block;
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .detail-item span {
            font-size: 15px;
            color: #f1f5f9;
            font-weight: 500;
        }

        /* Başvuru Bölümü */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-header h3 {
            font-size: 20px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .apply-box {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 28px;
        }

        .apply-box h4 {
            font-size: 16px;
            color: #38bdf8;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .apply-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-control {
            width: 100%;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #f8fafc;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #38bdf8;
        }

        select.form-control option {
            background: #1e293b;
        }

        .btn-apply-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-apply-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
        }

        /* Gelen Başvurular Tablosu */
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

        .status-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .status-pending { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
        .status-reviewing { background: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); }
        .status-shortlisted { background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.4); }
        .status-accepted { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
        .status-rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }

        .status-select {
            background: #1e293b;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🎓 Alumni Tracking System
        </a>
        <div class="navbar-links">
            <a href="/job-postings">💼 İlanlar Listesi</a>
            <a href="/applications">📄 Tüm Başvurular</a>
            <a href="/job-postings/create">➕ Yeni İlan</a>
        </div>
    </nav>

    <div class="main-container">

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <!-- İlan Bilgi Kartı -->
        <div class="card">
            <div class="job-hero-header">
                <div>
                    <h1 class="job-title">{{ $job->title }}</h1>
                    <div class="job-meta-badges">
                        <span class="badge badge-company">🏢 {{ $job->company }}</span>
                        <span class="badge badge-location">📍 {{ $job->location }}</span>
                        <span class="badge badge-type">
                            {{ $job->employment_type == 'full-time' ? 'Tam Zamanlı' : ($job->employment_type == 'internship' ? 'Staj' : 'Yarı Zamanlı') }}
                        </span>
                    </div>
                </div>

                <div class="job-hero-actions">
                    <a href="/job-postings/{{ $job->id }}/edit" class="btn-edit">✏️ Düzenle</a>
                    <form action="/job-postings/{{ $job->id }}" method="POST" onsubmit="return confirm('Bu ilanı silmek istediğinizden emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">🗑️ Sil</button>
                    </form>
                </div>
            </div>

            <h4 style="font-size: 15px; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px;">📋 Pozisyon Detayları ve Açıklama:</h4>
            <div class="job-body">{{ $job->description }}</div>

            <div class="job-details-grid">
                <div class="detail-item">
                    <strong>Yayınlayan Mezun:</strong>
                    <span>{{ $job->user ? $job->user->name . ' (' . $job->user->current_company . ')' : 'Belirtilmedi' }}</span>
                </div>
                <div class="detail-item">
                    <strong>Son Başvuru Tarihi:</strong>
                    <span>{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d.m.Y') : 'Açık / Belirtilmemiş' }}</span>
                </div>
                <div class="detail-item">
                    <strong>Harici Web Başvuru URL:</strong>
                    <span>
                        @if($job->application_url)
                            <a href="{{ $job->application_url }}" target="_blank" style="color: #38bdf8;">Dış Bağlantıya Git ↗</a>
                        @else
                            Yok (Sadece Sistem Üzerinden)
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Alınan Başvuru Sayısı:</strong>
                    <span style="color: #38bdf8; font-weight: 700;">{{ $job->applications->count() }} Aday</span>
                </div>
            </div>
        </div>

        <!-- Hızlı Başvuru Kutusu -->
        <div class="apply-box">
            <h4>✍️ Bu İlana Yeni Aday Başvurusu Ekle</h4>
            <form action="/applications" method="POST">
                @csrf
                <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
                <input type="hidden" name="redirect_to" value="/job-postings/{{ $job->id }}">

                <div class="apply-form-row">
                    <div>
                        <label style="font-size: 12px; color: #cbd5e1; margin-bottom: 6px; display: block;">Başvuru Yapan Öğrenci / Mezun *</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Aday Seçin --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->role == 'student' ? 'Öğrenci' : 'Mezun' }}) - {{ $user->department }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 12px; color: #cbd5e1; margin-bottom: 6px; display: block;">Özgeçmiş (CV) / Portfolyo Linki</label>
                        <input type="url" name="resume_url" class="form-control" placeholder="https://linkedin.com/in/... veya PDF linki">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; color: #cbd5e1; margin-bottom: 6px; display: block;">Ön Yazı / Aday Notu (Cover Letter)</label>
                    <textarea name="cover_letter" class="form-control" rows="2" placeholder="Neden bu pozisyona uygun olduğunuzu özetleyin..."></textarea>
                </div>

                <button type="submit" class="btn-apply-submit">📤 Başvuruyu Kaydet</button>
            </form>
        </div>

        <!-- Gelen Başvurular Listesi (Nested Sub-Resource) -->
        <div class="card">
            <div class="section-header">
                <h3>👥 Bu İlana Yapılan Başvurular ({{ $job->applications->count() }})</h3>
            </div>

            @if($job->applications->isEmpty())
                <div style="text-align: center; padding: 40px; color: #94a3b8;">
                    Henüz bu ilana başvuru yapılmamış. Yukarıdaki formdan ilk adayı kaydedebilirsiniz.
                </div>
            @else
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Aday Bilgisi</th>
                                <th>Bölüm / Rol</th>
                                <th>CV / Portfolyo</th>
                                <th>Ön Yazı</th>
                                <th>Tarih</th>
                                <th>Değerlendirme Durumu</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job->applications as $application)
                                <tr>
                                    <td>
                                        <strong>{{ $application->user ? $application->user->name : 'Kullanıcı #' . $application->user_id }}</strong><br>
                                        <small style="color: #94a3b8;">{{ $application->user ? $application->user->email : '' }}</small>
                                    </td>
                                    <td>
                                        {{ $application->user ? $application->user->department : '-' }}<br>
                                        <small style="color: #38bdf8;">{{ $application->user ? ucfirst($application->user->role) : '' }}</small>
                                    </td>
                                    <td>
                                        @if($application->resume_url)
                                            <a href="{{ $application->resume_url }}" target="_blank" style="color: #38bdf8; text-decoration: underline;">📄 CV Aç ↗</a>
                                        @else
                                            <span style="color: #64748b;">Belirtilmedi</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $application->cover_letter ?? '-' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($application->applied_at)->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <form action="/applications/{{ $application->id }}/status" method="POST" style="display: inline-flex; align-items: center; gap: 8px;">
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
                                        <form action="/applications/{{ $application->id }}" method="POST" onsubmit="return confirm('Başvuruyu silmek istediğinize emin misiniz?');">
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
