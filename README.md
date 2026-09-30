# Alumni Tracking & Community Networking System

A scalable, web-based alumni management and engagement platform designed to bridge the gap between educational institutions, organizations, students, and graduates. The system empowers communities to maintain lifelong connections, support professional growth, and foster collaborative networking.


## About the Project

Maintaining active connections with graduates is a significant challenge for many universities, academies, and professional institutions. The **Alumni Tracking System** serves as a centralized digital ecosystem where alumni can showcase their career achievements, engage with peers, mentor upcoming students, and share professional opportunities.

Built with modern web standards, this platform offers a secure, modular, and customizable foundation adaptable to any institution looking to modernize its alumni relations and career support networks.


## Technology Stack

| Layer | Technology | Purpose |
| :--- | :--- | :--- |
| **Backend Framework** | [Laravel (PHP 8.2+)](https://laravel.com/) | Robust MVC architecture, routing, security, and ORM |
| **Database** | [MySQL 8.0](https://www.mysql.com/) | Relational data persistence and optimized query performance |
| **Containerization** | [Docker](https://www.docker.com/) & Docker Compose | Consistent, reproducible development and production environments |
| **Web Server** | Nginx | High-performance reverse proxy and static asset handling |
| **API Documentation** | [Swagger / OpenAPI 3.0](https://swagger.io/) | Interactive API specification and live endpoint testing |
| **Frontend** | Blade & Modern CSS/JS | Responsive, accessible, and intuitive user interfaces |


## Core System Modules & Features

### 1. Comprehensive Profile & Portfolio Management
- **Professional Timeline:** Track employment history, current company, job titles, and industry sectors.
- **Academic Background:** Record degrees, graduation years, departments, academic honors, and certifications.
- **Skill Endorsements & Links:** Showcase core competencies alongside integrated links to LinkedIn, GitHub, and personal portfolios.
- **Privacy Controls:** Allow users to manage the visibility of their contact information and personal details.

### 2. Smart Directory & Advanced Discovery
- **Multi-Criteria Search:** Filter alumni by graduation year, department, current company, role, industry, and geographic location.
- **Interactive Directory:** Browse member profiles with quick-connect features.
- **Geographic Insights:** Discover alumni located in specific cities or countries worldwide.

### 3. Networking & Communication Hub
- **Direct Messaging:** Secure, private communication channels between registered members.
- **Discussion Channels & Announcements:** Broadcast institutional news, achievements, and community discussions.
- **Connection Requests:** Build and expand professional relationships within the verified community.

### 4. Career Hub & Opportunity Board
- **Alumni-Shared Jobs:** Enable alumni to post open positions, internships, and project collaborations from their companies.
- **Internal Referral Network:** Connect job-seeking graduates directly with alumni working in target companies.
- **Application Tracking:** Direct links to application portals and recruiter contacts.

### 5. Mentorship & Guidance Program
- **Mentor Directory:** Identify experienced alumni willing to offer career guidance, resume reviews, or mock interviews.
- **Student-Alumni Engagement:** Bridge the transition between academia and industry for graduating students.

### 6. Events & Meetup Management
- **Event Scheduling:** Host and organize reunions, webinars, panel discussions, and career fairs.
- **RSVP & Attendance Tracking:** Keep track of participant lists and send automated event notifications.

### 7. Administration, Verification & Insights
- **Account Verification:** Prevent fraudulent accounts by verifying student/diploma IDs against institutional records.
- **Role-Based Access Control (RBAC):** Distinct permission levels for Administrators, Alumni, Students, and Institutional Staff.
- **Analytics & Demographics:** Visual reporting on alumni employment rates, industry distribution, and regional density.


---

## 📖 API Dokümantasyonu (Swagger UI & JSON)

Uygulamanın tüm API uç noktaları **OpenAPI 3.0** standardında belgelenmiştir ve 2 farklı şekilde erişilebilir:

1. **İnteraktif Web Arayüzü (Swagger UI):**
   - **Adres:** 👉 **[http://localhost:8000/api/swagger](http://localhost:8000/api/swagger)**
   - **Kullanım:** Bu adresi **Google Chrome, Edge veya Firefox** gibi bir web tarayıcısında açtığınızda tüm rotalar görsel olarak listelenir; **"Try it out"** butonuna basarak doğrudan tarayıcı üzerinden canlı API istekleri gönderebilirsiniz.

2. **JSON Formatında OpenAPI Spesifikasyonu (Postman & Araçlar İçin):**
   - **Saf JSON Adresi:** 👉 **[http://localhost:8000/api/swagger.json](http://localhost:8000/api/swagger.json)**
   - **Postman ile Kullanım:** Postman'e `GET http://localhost:8000/api/swagger` veya `GET http://localhost:8000/api/swagger.json` adresini girdiğinizde tüm endpoint şemalarını içeren saf OpenAPI 3.0 **JSON çıktısını** doğrudan alırsınız.


---

## 📋 Aktif Endpoint Referans Tablosu

Proje üzerinde geliştirilen tüm rotalar ve özellikleri aşağıda listelenmiştir:

| Hafta / Aşama | Metot | Endpoint (URI) | Açıklama / Görev | Örnek İstek / Yanıt |
| :---: | :---: | :--- | :--- | :--- |
| **Hafta 1** | `GET` | `/` | Geçici Ana Sayfa (*Temporary Main Page*) | HTML Arayüzü & Rota Listesi |
| **Hafta 1** | `GET` | `/about` | Geçici Hakkında Sayfası (*Temporary About Page*) | HTML Arayüzü |
| **Hafta 1** | `GET` | `/hello` | Sabit Karşılama Rotası | `"Hello, world!"` |
| **Hafta 1** | `GET` | `/hello/{name}` | Dinamik İsim Parametreli Karşılama | `/hello/dilara` ➔ `"Hello, Dilara!"` |
| **Hafta 1** | `GET` | `/sum/{n1}/{n2}` | İki Sayının Toplamı | `/sum/5/3` ➔ `"8"` |
| **Hafta 2** | `GET` | `/api/health` | Sistem Sağlık Kontrolü (JSON) | `{"status": "ok"}` |
| **Hafta 2** | `GET` | `/api/users` | Tüm Alumni ve Öğrenci Listesi (JSON) | `{"success": true, "count": 3, "data": [...]}` |
| **Hafta 2** | `GET` | `/api/users/{id}` | Tekil Kullanıcı Bilgisi Getirme (JSON) | ID'ye göre kullanıcı detayları döner (404 kontrolü) |
| **Hafta 2** | `POST` | `/api/users` | Yeni Kullanıcı Profili Oluşturma (JSON) | Gövdedeki verilerle kullanıcı ekler (HTTP 201) |
| **Hafta 2** | `PUT` | `/api/users/{id}` | Kullanıcı Bilgilerini Tam Değiştirme (*Full Replacement*) | Gönderilmeyen alanlar standart gereği `null` yapılır |
| **Hafta 2** | `PATCH` | `/api/users/{id}` | Kullanıcı Bilgilerini Kısmi Güncelleme (*Partial Update*) | Yalnızca gönderilen alanlar değişir, diğerleri korunur |
| **Hafta 2** | `DELETE`| `/api/users/{id}` | Kullanıcı Profilini Silme | ID'ye göre kullanıcıyı listeden siler |
| **Hafta 2** | `GET` | `/api/swagger` | Swagger Dokümantasyonu (Tarayıcıda UI, Postman'de JSON) | Swagger UI & OpenAPI JSON |
| **Hafta 2** | `GET` | `/api/swagger.json` | OpenAPI 3.0 Spesifikasyonu (Saf JSON) | JSON Dokümantasyon Şeması |


---

## 🛠️ Haftalık Geliştirme ve Dokümantasyon Yönergesi

Her hafta projeye yeni bir özellik, rota veya modül eklediğinizde dokümantasyonun güncel ve düzenli kalması için aşağıdaki adımları izleyin:

### 1. Yeni Rotayı `routes/web.php` (veya `routes/api.php`) Dosyasında Tanımlayın
- Metodunuza (`GET`, `POST`, `PUT`, `PATCH`, `DELETE`) karar verin.
- Anlamlı durum kodları kullanın (`200 OK`, `201 Created`, `404 Not Found` vb.).
- Başarılı ve başarısız durumlarda tutarlı bir JSON yapısı döndürün:
  ```json
  {
    "success": true,
    "message": "İşlem açıklaması",
    "data": { ... }
  }
  ```

### 2. Swagger Şemasına (`app/Http/SwaggerSpec.php`) Ekleyin
- `SwaggerSpec::get()` fonksiyonu içerisindeki `paths` dizisine yeni rotanızı ve HTTP metodunu ekleyin.
- Rota için `summary`, `description`, `requestBody` (POST/PUT/PATCH için) ve `responses` tanımlarını belirtin.
- Yapılan bu ekleme otomatik olarak hem `http://localhost:8000/api/swagger` arayüzüne hem de `http://localhost:8000/api/swagger.json` çıktısına yansıyacaktır.

### 3. `README.md` Dosyasındaki Referans Tablosunu Güncelleyin
- Yukarıdaki **"Aktif Endpoint Referans Tablosu"** bölümüne yeni bir satır ekleyin:
  ```markdown
  | Hafta X | METOT | `/api/yeni-rota` | Rotanın işlevi | Örnek Yanıt |
  ```

### 4. Canlı Doğrulama ve Git Commit Kuralı
- Yeni rotayı tarayıcıdan, Swagger üzerinden veya Postman ile test edin.
- Haftalık çalışmanızı anlaşılır bir commit mesajıyla kaydedip pushlayın:
  ```bash
  git add .
  git commit -m "feat(api): add new endpoints for Week X"
  git push origin main
  ```


---

## Getting Started with Docker

### Prerequisites
- [Docker](https://www.docker.com/) (version 20.10 or later)
- [Docker Compose](https://docs.docker.com/compose/)

### 1. Clone the Repository
```bash
git clone https://github.com/DilaraMUMCU/alumni.git
cd alumni
```

### 2. Start the Containers
```bash
docker compose up -d --build
```

### 3. Open in Browser
- **Main Page:** [http://localhost:8000](http://localhost:8000)
- **Swagger Documentation:** [http://localhost:8000/api/swagger](http://localhost:8000/api/swagger)
- **Swagger Raw JSON:** [http://localhost:8000/api/swagger.json](http://localhost:8000/api/swagger.json)
- **Health Check:** [http://localhost:8000/api/health](http://localhost:8000/api/health)