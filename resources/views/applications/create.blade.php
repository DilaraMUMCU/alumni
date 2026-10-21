<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İş Başvurusu Yap - Alumni Tracking System</title>
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
            max-width: 800px;
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

        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
        }

        .form-card {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }

        .card-header {
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 16px;
        }

        .card-header h2 {
            font-size: 22px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #f8fafc;
            padding: 12px 16px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
            background: rgba(15, 23, 42, 0.9);
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.45);
        }

        .btn-cancel {
            color: #94a3b8;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🎓 Alumni Tracking System
        </a>
        <div class="navbar-links">
            <a href="/applications">⬅️ Başvurular Listesine Dön</a>
            <a href="/job-postings">💼 İlanlar</a>
        </div>
    </nav>

    <div class="form-card">
        <div class="card-header">
            <h2>✍️ Yeni İş / Staj Başvurusu Gönder</h2>
            <p>Seçilen iş pozisyonuna bir aday profili eşleyerek başvuru kaydı oluşturun.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <form action="/applications" method="POST">
            @csrf

            <div class="form-group">
                <label for="job_posting_id">Başvurulacak İş İlanı *</label>
                <select name="job_posting_id" id="job_posting_id" class="form-control" required>
                    <option value="">-- Hedef İş İlanını Seçin --</option>
                    @foreach($jobPostings as $job)
                        <option value="{{ $job->id }}" {{ (old('job_posting_id', $selectedJobId) == $job->id) ? 'selected' : '' }}>
                            {{ $job->title }} — {{ $job->company }} ({{ $job->location }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">Başvuru Yapan Öğrenci / Mezun (Aday) *</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Aday Kullanıcı Seçin --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role == 'student' ? 'Öğrenci' : 'Mezun' }}) - {{ $user->department }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="resume_url">Özgeçmiş / CV / Portfolyo Web Bağlantısı (Varsa)</label>
                <input type="url" name="resume_url" id="resume_url" class="form-control" placeholder="https://linkedin.com/in/... veya https://storage.alumni.edu/cv.pdf" value="{{ old('resume_url') }}">
            </div>

            <div class="form-group">
                <label for="cover_letter">Ön Yazı / Aday Motivasyon Notu (Cover Letter)</label>
                <textarea name="cover_letter" id="cover_letter" class="form-control" placeholder="Bu ilana başvurma motivasyonunuz, uzmanlıklarınız ve tecrübeleriniz...">{{ old('cover_letter') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="/applications" class="btn-cancel">İptal</a>
                <button type="submit" class="btn-submit">🚀 Başvuruyu Tamamla</button>
            </div>
        </form>
    </div>

</body>
</html>
