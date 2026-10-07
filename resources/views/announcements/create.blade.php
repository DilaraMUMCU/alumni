<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Duyuru Oluştur - Alumni Tracking System</title>
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

        .card {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 36px;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            margin-bottom: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 20px;
        }

        .card-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .card-header p {
            color: #94a3b8;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
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
            padding: 12px 16px;
            color: #ffffff;
            font-size: 15px;
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
            gap: 16px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 140px;
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
            gap: 10px;
            font-size: 14px;
            color: #cbd5e1;
            cursor: pointer;
            margin-top: 8px;
        }

        .checkbox-label input {
            cursor: pointer;
            width: 18px;
            height: 18px;
            accent-color: #38bdf8;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-cancel {
            color: #94a3b8;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-submit {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 12px 28px;
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
    </style>
</head>
<body>

    <div class="container">
        <div class="top-nav">
            <a href="/announcements" class="btn-back">⬅️ Duyurular Listesine Dön</a>
            <span style="color: #64748b; font-size: 13px;">View: announcements.create (GET /announcements/create)</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h1>📢 Yeni Duyuru Yayını</h1>
                <p>Alumni topluluğu, etkinlikler veya kariyer fırsatları için yeni duyuru oluşturun.</p>
            </div>

            <form action="/announcements" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Duyuru Başlığı *</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Örn: 2026 Mezunlar Buluşması ve Kariyer Zirvesi" required>
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
                        <label for="priority">Öncelik Derecesi</label>
                        <select id="priority" name="priority" class="form-control">
                            <option value="normal" selected>Normal</option>
                            <option value="important">Önemli</option>
                            <option value="urgent">Acil / Kritik</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="author">Yayınlayan Birim / Kişi</label>
                        <input type="text" id="author" name="author" class="form-control" placeholder="Örn: Mezunlar Koordinatörlüğü" value="Mezunlar Koordinatörlüğü">
                    </div>

                    <div class="form-group">
                        <label for="target_audience">Hedef Kitle</label>
                        <select id="target_audience" name="target_audience" class="form-control">
                            <option value="all" selected>Tüm Topluluk (Öğrenci & Mezun)</option>
                            <option value="alumni">Yalnızca Mezunlar</option>
                            <option value="students">Yalnızca Öğrenciler</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Duyuru Tam Metni *</label>
                    <textarea id="content" name="content" class="form-control" placeholder="Duyuru içeriğini tüm detaylarıyla buraya yazınız..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="pinned" value="1">
                        <span>📌 Bu duyuruyu en üstte sabitle (Pinned Announcement)</span>
                    </label>
                </div>

                <div class="form-actions">
                    <a href="/announcements" class="btn-cancel">İptal</a>
                    <button type="submit" class="btn-submit">
                        📢 Duyuruyu Yayınla (POST /announcements)
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
