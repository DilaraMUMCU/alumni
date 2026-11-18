# 🎨 İstanbul Üniversitesi Mezun Takip Sistemi — Marka Kimliği ve Web Tasarım Kılavuzu (Brand Guidelines)

Bu belge, **İstanbul Üniversitesi (İÜ) Mezun Takip ve İletişim Ağı (Alumni Tracking System)** web uygulaması için kurumsal marka kimliğini, kullanıcı arayüzü (UI) ve kullanıcı deneyimi (UX) tasarım ilkelerini, renk, tipografi, biçim, ses tonu ve amblem standartlarını tanımlar.

---

## 📑 İçindekiler
1. [Name and Promise (İsim ve Marka Vaadi)](#1-name-and-promise-i%CC%87sim-ve-marka-vaadi)
2. [Color (Renk Paleti ve Erişilebilirlik)](#2-color-renk-paleti-ve-eri%C5%9Filebilirlik)
3. [Type (Tipografi ve Okunabilirlik Standartları)](#3-type-tipografi-ve-okunabilirlik-standartlar%C4%B1)
4. [Shape (Bileşen Geometrisi, Alanlama ve Görsel Hiyerarşi)](#4-shape-bile%C5%9Fen-geometrisi-alanlama-ve-g%C3%B6rsel-hiyerar%C5%9Fi)
5. [Voice (Ses Tonu, İletişim Dili ve Metin Yazımı)](#5-voice-ses-tonu-i%CC%87leti%C5%9Fim-dili-ve-metin-yaz%C4%B1m%C4%B1)
6. [Mark (Logo, Amblem, İkonografi ve Kullanım Kuralları)](#6-mark-logo-amblem-i%CC%87konografi-ve-kullan%C4%B1m-kurallar%C4%B1)

---

## 1. Name and Promise (İsim ve Marka Vaadi)

### 1.1. Resmi ve Dijital İsimlendirme
* **Resmi Türkçe İsim:** İstanbul Üniversitesi Mezun Takip ve Kariyer Ağı
* **Kısa / Dijital İsim:** İÜ Mezun (IU Alumni Connect / Alumni ATS)
* **İngilizce Karşılık:** Istanbul University Alumni Tracking & Networking System

### 1.2. Marka Vaadi (Brand Promise)
> **"1453’ten Geleceğe Kesintisiz Bağlantı, Güçlü Mezun Ekosistemi."**

İstanbul Üniversitesi'nin yarım binyılı aşan köklü akademik birikimini ve Beyazıt mirasını; dijital çağın hızında, mezunlarımız ve öğrencilerimiz arasında ömür boyu sürecek profesyonel dayanışmaya, mentorluk iş birliklerine ve kariyer fırsatlarına dönüştürmeyi taahhüt eder.

### 1.3. Temel Değerler (Core Values)
| Değer | Açıklama |
| :--- | :--- |
| **Köklülük & Prestij** | Türkiye'nin ilk ve en köklü üniversitesinin vakarını, güvenini ve saygınlığını dijital arayüzde hissettirmek. |
| **Erişilebilirlik & Kucaklayıcılık** | Tüm yaş gruplarından mezunların ve öğrencilerin zorlanmadan kullanabileceği, yüksek kontrastlı ve sade bir deneyim sunmak. |
| **Kariyer Odaklı Dayanışma** | Mezunların birbirine iş, staj ve mentorluk sağladığı yaşayan ve üreten bir topluluk oluşturmak. |
| **Teknolojik Şeffaflık & Güven** | Modern RESTful mimari, Guardian hata kalkanları ve veri gizliliği ile kullanıcıya tam güven aşılamak. |

---

## 2. Color (Renk Paleti ve Erişilebilirlik)

Renk paleti; **İstanbul Üniversitesi’nin tarihi kurumsal renkleri** (Beyazıt Bordosu, Akademi Laciverti, Tarihi Kapı Altını) temel alınarak oluşturulmuş, dijital ekranlarda **yüksek okunabilirlik (WCAG 2.1 AA/AAA)** sağlayacak modern tonlarla zenginleştirilmiştir.

### 2.1. Kurumsal Ana Renkler (Primary Heritage Colors)

| Renk Adı | HEX Kodu | RGB | Rol / Kullanım Alanı | Anlam & Duygu |
| :--- | :---: | :---: | :--- | :--- |
| **İÜ Bordosu (Crimson Burgundy)** | `#8A1538` | `138, 21, 56` | Birincil marka rengi, ana aksiyon butonları (CTA), aktif menü vurguları, başlıklar | Köklü miras, aidiyet, akademik vakar |
| **Koyu Bordo (Deep Maroon)** | `#660F29` | `102, 15, 41` | Buton hover durumları, üst bar gradyan bitişleri | Derinlik, ciddiyet |
| **Akademi Laciverti (Heritage Navy)** | `#0B1B3D` | `11, 27, 61` | Arka planlar, koyu tema kartları, navbar | Güvenilirlik, bilgi, kurumsal güç |
| **Tarihi Kapı Altını (University Gold)** | `#D4AF37` | `212, 175, 55` | Rozetler, başarı göstergeleri, premium ve mezuniyet vurguları | Başarı, onur, mükemmeliyet |

### 2.2. İşlevsel / Fonksiyonel UI Renkleri (Functional & Feedback Colors)
Kullanıcının form doldurma, başvuru yapma ve hata durumlarında bilişsel yükünü azaltmak için net ve standartlaştırılmış renkler:

| Durum | HEX Kodu | Açık Tema Zemin | Koyu Tema Zemin | Kullanım Alanı |
| :--- | :---: | :---: | :---: | :--- |
| **Success (Başarı)** | `#10B981` | `#ECFDF5` | `rgba(16, 185, 129, 0.15)` | Başvuru kabul edildi, profil güncellendi, aktif ilanlar |
| **Warning (Uyarı / Beklemede)** | `#F59E0B` | `#FFFBEB` | `rgba(245, 158, 11, 0.15)` | Değerlendirme aşamasında, son başvuru tarihi yaklaşıyor |
| **Danger (Hata / Red / Acil)** | `#EF4444` | `#FEF2F2` | `rgba(239, 68, 68, 0.15)` | 404/5xx Guardian uyarıları, acil duyurular, silme aksiyonları |
| **Info (Bilgi / Etkinlik)** | `#0284C7` | `#F0F9FF` | `rgba(2, 132, 199, 0.15)` | Sistem bildirimleri, etkinlikler, Swagger API bağlantıları |

### 2.3. Nötr Yüzey ve Metin Renkleri (Neutral & Surface Tones)

#### A. Koyu Tema (Varsayılan Dark Slate & Navy Tema)
* **Ana Zemin:** `#070D1B` (Derin Gece Mavisi)
* **Kart ve Yüzeyler:** `rgba(15, 27, 61, 0.75)` (Buzlu cam efektli Akademi Laciverti)
* **Kart Kenarlıkları:** `rgba(255, 255, 255, 0.08)` (Zarif ve göz yormayan ayrım)
* **Birincil Metin:** `#F8FAFC` (Net beyaz, maksimum kontrast)
* **İkincil / Destekleyici Metin:** `#94A3B8` (Muted Slate, WCAG AA uyumlu)

#### B. Açık Tema (Clean Academic Light Tema)
* **Ana Zemin:** `#F8FAFC`
* **Kart ve Yüzeyler:** `#FFFFFF` (Saf beyaz, `0 10px 25px rgba(11, 27, 61, 0.06)` gölge ile)
* **Kart Kenarlıkları:** `#E2E8F0`
* **Birincil Metin:** `#0F172A` (Koyu arduvaz, gözü yormayan siyah alternatifi)
* **İkincil Metin:** `#475569`

### 2.4. Erişilebilirlik (WCAG 2.1) Kontrast Güvencesi
* `#8A1538` (İÜ Bordo) beyaz zemin üzerinde **7.8:1** kontrast oranına sahiptir (WCAG AAA geçer).
* `#F8FAFC` metin `#0B1B3D` zemin üzerinde **14.2:1** kontrast sunar (Maksimum okunabilirlik).
* Tıklanabilir butonlarda metin boyutu en az `14px`, hedef dokunma alanı ise minimum `44x44px` boyutundadır.

---

## 3. Type (Tipografi ve Okunabilirlik Standartları)

Web arayüzünde akademik ciddiyet ile modern dijital ürün deneyimini harmanlayan tipografik bir hiyerarşi uygulanır.

### 3.1. Font Aileleri
* **Birincil Metin ve UI Fontu:** `Plus Jakarta Sans` veya `Inter`
  * *Neden seçildi?* Geometrik ve hümanist çizgileri birleştiren yapısı sayesinde küçük ekranlarda, form girdilerinde ve listelerde harf açıklığı mükemmeldir; Türkçe karakterleri (ç, ğ, ı, ö, ş, ü) tam destekler.
* **Akademik Prestij & Başlık Fontu:** `Cinzel` veya `Merriweather`
  * *Kullanım:* Sadece ana sayfa "Hero" başlığı, resmi mezuniyet belgeleri ve tarihi anma panolarında alternatif olarak.
* **Kod & API Telemetrisi:** `JetBrains Mono` / `SF Mono` / `Consolas`
  * *Kullanım:* Swagger UI parametreleri, endpoint yolları (`/api/users`), log kayıtları.

### 3.2. Tipografik Ölçek ve Hiyerarşi

| Seviye | Font Boyutu | Ağırlık (Weight) | Satır Yüksekliği (Line-Height) | Harf Aralığı (Tracking) | Örnek Kullanım |
| :--- | :---: | :---: | :---: | :---: | :--- |
| **Hero Display** | `42px - 56px` | 800 (Extra Bold) | 1.15 | `-1px` | Ana sayfa karşılama sloganı |
| **Heading 1 (H1)** | `28px - 34px` | 700 (Bold) | 1.25 | `-0.5px` | Sayfa ana başlıkları (Kullanıcılar, İlanlar) |
| **Heading 2 (H2)** | `22px - 26px` | 700 (Bold) | 1.3 | `-0.2px` | Modül ve blok başlıkları |
| **Heading 3 (H3)** | `18px - 20px` | 600 (Semi-Bold) | 1.4 | `0px` | Kart başlıkları, ilan unvanları |
| **Body Large** | `16px` | 400 / 500 | 1.6 | `0px` | Hero alt metinleri, duyuru gövdesi |
| **Body Regular** | `14px` | 400 / 500 | 1.5 | `0px` | Tablo metinleri, form etiketleri, açıklamalar |
| **Caption / Badge** | `11px - 12px` | 700 (Bold) | 1.2 | `+0.5px` | Kategori etiketleri, durum rozetleri (Tümü BÜYÜK HARF) |

---

## 4. Shape (Bileşen Geometrisi, Alanlama ve Görsel Hiyerarşi)

Kullanıcı arayüzünde kullanılan geometrik formlar, üniversitenin sağlamlığını ve çağdaş web standartlarını yansıtır.

### 4.1. Köşe Yuvarlama Standartları (Border Radius)
* **Rozetler & Hap Butonlar (Pills):** `9999px` (Tam yuvarlak, samimi ve dikkat çekici).
* **Butonlar ve Girdi Alanları (Inputs):** `10px - 12px` (Modern, ergonomik tıklama hissi).
* **Kartlar (Cards & Panels):** `16px - 20px` (İçeriği odaklayan yumuşak hatlar).
* **Büyük Konteynerlar & Modallar:** `24px` (Köklü ve kapsayıcı görünüm).

### 4.2. Boşluk Sistemi (Spacing Grid)
Tüm arayüz **8px tabanlı ritmik ızgara (8-Point Grid)** sistemine sadıktır:
* `4px` — Mikro boşluklar (Rozet içi ikon mesafesi)
* `8px` — Kompakt eleman ayrımı (İkon-metin arası)
* `16px` — Standart bileşen içi padding
* `24px` — Kart içi dolgu (card padding) ve kolonlar arası boşluk
* `32px / 48px` — Bölümler (section) arası ritmik boşluk
* `64px / 80px` — Ana sayfa blokları arası nefes alanları

### 4.3. Katmanlama, Gölgeler ve Cam Efekti (Depth & Glassmorphism)
* **Arka Plan Bulanıklığı:** `backdrop-filter: blur(14px)` kullanılarak içerik zeminle kaynaştırılır.
* **Yumuşak Gölgeler:** Keskin ve siyah gölgeler yerine lacivert tonlu derinlik:
  ```css
  box-shadow: 0 10px 30px rgba(11, 27, 61, 0.4), 0 0 1px rgba(255, 255, 255, 0.1);
  ```
* **İnce Işıltı Kenarlığı:** Kartların üst kenarında İÜ Bordo/Altın geçişli 3px'lik vurgu çizgisi:
  ```css
  background: linear-gradient(90deg, #8A1538, #D4AF37);
  ```

---

## 5. Voice (Ses Tonu, İletişim Dili ve Metin Yazımı)

İstanbul Üniversitesi Mezun Sistemi’nin dijital dili; **saygın, kucaklayıcı, açık ve teşvik edici** olmalıdır.

### 5.1. Dil İlkeleri
1. **Kurumsal ama Sıcak:** Devlet geleneğinin ciddiyeti korunurken, mezunlar arası iletişimi canlandıracak samimi bir bağ kurulur. ("Siz" dili esastır, ancak bürokratik soğukluktan kaçınılır).
2. **Kapsayıcı ve Çok Kuşaklı:** 1970 mezunu bir tecrübeli bürokrat ile 2026 mezunu bir yazılımcı arayüzde kendini eşit derecede evinde hissetmelidir.
3. **Eylem Odaklı (Action-Oriented):** Buton metinleri net ve fiil içermelidir: *"Gönder"* yerine *"Başvuruyu Tamamla"*, *"Kaydet"* yerine *"Profili Güncelle"*.
4. **Yapıcı ve Güven Veren Hata İletişimi:** Guardian hata sayfalarında (404/5xx) kullanıcı asla suçlanmaz; sorunun nedeni şeffafça açıklanır ve güvenle ana rotaya yönlendirilir.

### 5.2. İletişim Örnekleri (Do's and Don'ts)

| Durum | ❌ Kaçınılması Gereken Dil | ✅ Tercih Edilen İÜ Mezun Dili |
| :--- | :--- | :--- |
| **Karşılama** | "Sisteme giriş yaptınız." | "İstanbul Üniversitesi Mezun Ailesine Hoş Geldiniz." |
| **İş İlanı Butonu** | "İlan ekle." | "💼 Yeni Bir Kariyer Fırsatı Paylaş" |
| **404 Sayfa Hatası** | "Hata: Sayfa mevcut değil." | "Aradığınız sayfaya ulaşılamadı. 5 saniye içinde ana sayfaya güvenle aktarılıyorsunuz." |
| **Başvuru Onayı** | "İşlem başarılı." | "🎉 Başvurunuz başarıyla iletildi. Süreci Başvurularım ekranından takip edebilirsiniz." |
| **Form Boş Alanı** | "Geçersiz veri girdiniz." | "Lütfen unvan ve şirket bilginizi eksiksiz doldurunuz." |

---

## 6. Mark (Logo, Amblem, İkonografi ve Kullanım Kuralları)

### 6.1. Amblem Referansı ve Sembolizm
* **Tarihi Beyazıt Kapısı:** Üniversitenin ilim kapısını ve asırlık hafızasını temsil eder.
* **Meşale & Güneş:** Bilimin ışığını ve mezunların topluma kattığı aydınlığı simgeler.
* **1453:** Üniversitenin kuruluş tarihini ve köklerini belgeler.

### 6.2. Dijital Marka İşareti (Favicon & App Icon)
* Dijital ekranda küçük boyutlarda dahi ayırt edilebilirlik için:
  * **İkon Kombinasyonu:** Bordo kalkan zemin üzerinde Altın Sarısı akademik kep (`🎓`) ve `İÜ` harf monogramı.
  * **Minimum Boyut:** Ekranlarda `24x24px`, favicon için `32x32px`.

### 6.3. Güvenlik Alanı (Clear Space)
Logonun veya amblemin etrafında, görsel gücünü korumak adına diğer grafik elemanlar veya kenarlıklarla arasına **logo yüksekliğinin en az 1/4'ü (0.25x)** kadar boşluk bırakılmalıdır.

```
       ┌───────────────────────────────┐
       │             0.25x             │
       │     ┌───────────────────┐     │
 0.25x │     │   🎓 İÜ MEZUN     │     │ 0.25x
       │     └───────────────────┘     │
       │             0.25x             │
       ┌───────────────────────────────┘
```

### 6.4. Hatalı Kullanımlar (Never Do)
* ❌ İÜ Bordosu (`#8A1538`) yerine rastgele kırmızı veya pembe tonları kullanılmamalıdır.
* ❌ Amblem veya logo en-boy oranı bozulacak şekilde basık/uzatılmış olarak yerleştirilmemelidir.
* ❌ Okunabilirliği düşürecek desenli veya karmaşık arka planların üzerine doğrudan metin konulmamalı; yarı saydam koyu katman (`rgba(11, 27, 61, 0.8)`) eklenmelidir.
* ❌ Kurumsal altın sarısı (`#D4AF37`) dışında parlak neon sarı kullanılmamalıdır.

---

> 🔗 **İlgili Mimari Belgeler:**
> - Sistem genel mimarisi ve MVC yapısı: [`README.md`](README.md)
> - Veri modelleri, validasyon ve veritabanı şeması: [`ddd.md`](ddd.md)
> - İnteraktif API Dokümantasyonu: [http://localhost:8000/api/swagger](http://localhost:8000/api/swagger)
