<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Kullanıcı Oluştur - Alumni Tracking System</title>
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
            max-width: 680px;
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

        select.form-control {
            cursor: pointer;
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
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
            <a href="/users" class="btn-back">⬅️ Kullanıcı Listesine Dön</a>
            <span style="color: #64748b; font-size: 13px;">View: users.create (GET /users/create)</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h1>➕ Yeni Kullanıcı Kaydı</h1>
                <p>Alumni veya öğrenci profil bilgilerini doldurarak sisteme yeni kullanıcı ekleyin.</p>
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
                        <label for="role">Kullanıcı Rolü</label>
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
                    <label for="department">Bölüm / Fakülte</label>
                    <input type="text" id="department" name="department" class="form-control" placeholder="Örn: MIS / Bilgisayar Mühendisliği" value="Computer Engineering">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="current_company">Çalıştığı Şirket</label>
                        <input type="text" id="current_company" name="current_company" class="form-control" placeholder="Örn: Google / Samsung">
                    </div>

                    <div class="form-group">
                        <label for="job_title">Unvan / Görev</label>
                        <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Örn: Senior Software Engineer">
                    </div>
                </div>

                <div class="form-group">
                    <label for="skills">Yetenekler (Virgülle ayırın)</label>
                    <input type="text" id="skills" name="skills" class="form-control" placeholder="PHP, Laravel, Docker, MySQL, Python">
                </div>

                <div class="form-group">
                    <label for="linkedin_url">LinkedIn Profil Linki</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/...">
                </div>

                <div class="form-actions">
                    <a href="/users" class="btn-cancel">İptal</a>
                    <button type="submit" class="btn-submit">
                        💾 Kullanıcıyı Oluştur (POST /users)
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
