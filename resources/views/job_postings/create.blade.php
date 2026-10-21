<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İlan Yayınla - Alumni Tracking System</title>
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
            max-width: 900px;
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

        .form-card {
            max-width: 900px;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
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
            min-height: 140px;
            resize: vertical;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(56, 189, 248, 0.3);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(56, 189, 248, 0.45);
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

        .field-error {
            color: #f87171;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🎓 Alumni Tracking System
        </a>
        <div class="navbar-links">
            <a href="/job-postings">⬅️ İlanlar Listesine Dön</a>
            <a href="/applications">📄 Başvurular</a>
        </div>
    </nav>

    <div class="form-card">
        <div class="card-header">
            <h2>💼 Yeni İş veya Staj İlanı Oluştur</h2>
            <p>Mezunlar ve öğrenciler için yeni bir kariyer fırsatı yayınlayın.</p>
        </div>

        <form action="/job-postings" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="user_id">Yayınlayan Mezun / Yetkili *</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Mezun Seçin --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role == 'alumni' ? 'Mezun' : ($user->role == 'student' ? 'Öğrenci' : 'Yönetici') }}) - {{ $user->current_company ?? $user->department }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="employment_type">Çalışma Tipi *</label>
                    <select name="employment_type" id="employment_type" class="form-control" required>
                        <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Tam Zamanlı (Full-Time)</option>
                        <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Staj (Internship)</option>
                        <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Yarı Zamanlı (Part-Time)</option>
                    </select>
                    @error('employment_type') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="title">İlan Başlığı / Pozisyon Adı *</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Örn: Senior Backend Engineer, Stajyer Yazılımcı" value="{{ old('title') }}" required>
                    @error('title') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="company">Şirket / Organizasyon *</label>
                    <input type="text" name="company" id="company" class="form-control" placeholder="Örn: Google, Trendyol, Getir" value="{{ old('company') }}" required>
                    @error('company') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location">Lokasyon / Çalışma Modeli *</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Örn: İstanbul (Hibrit), Remote, Ankara" value="{{ old('location') }}" required>
                    @error('location') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="deadline">Son Başvuru Tarihi</label>
                    <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
                    @error('deadline') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="application_url">Harici Başvuru / İlan Web Bağlantısı (Varsa)</label>
                <input type="url" name="application_url" id="application_url" class="form-control" placeholder="https://company.com/careers/job-123" value="{{ old('application_url') }}">
                @error('application_url') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">İlan Tanımı, Aranan Nitelikler ve Görevler *</label>
                <textarea name="description" id="description" class="form-control" placeholder="Pozisyon sorumlulukları, aranan teknolojiler (PHP, Laravel, Docker vb.) ve başvuru şartları..." required>{{ old('description') }}</textarea>
                @error('description') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <a href="/job-postings" class="btn-cancel">İptal</a>
                <button type="submit" class="btn-submit">🚀 İlanı Yayınla</button>
            </div>
        </form>
    </div>

</body>
</html>
