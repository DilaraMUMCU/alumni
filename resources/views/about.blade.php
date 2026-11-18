@extends('layouts.app')

@section('title', 'Tarihçe ve Hakkımızda — İstanbul Üniversitesi Mezun Portalı')
@section('meta_description', 'İstanbul Üniversitesi Mezun ve Kariyer Portalı hakkında; 1453\'ten gelen miras, kurumsal vizyon, temel değerler ve teknolojik altyapı.')

@push('styles')
<style>
    .about-hero {
        text-align: center;
        padding: 40px 0 50px 0;
        max-width: 860px;
        margin: 0 auto;
    }

    .about-hero h1 {
        font-size: 42px;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .about-hero p {
        font-size: 17px;
        color: var(--ink-secondary);
        line-height: 1.7;
    }

    /* Core Values Grid */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 60px;
    }

    @media (max-width: 992px) {
        .values-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .values-grid {
            grid-template-columns: 1fr;
        }
    }

    .value-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 28px;
        box-shadow: var(--shadow-subtle);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .value-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card);
    }

    .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .value-card h3 {
        font-family: var(--font-serif);
        font-size: 18px;
        color: var(--iu-navy);
        margin-bottom: 8px;
    }

    .value-card p {
        font-size: 13.5px;
        color: var(--ink-secondary);
        line-height: 1.6;
    }

    /* Historical Timeline */
    .timeline-container {
        position: relative;
        max-width: 860px;
        margin: 0 auto 70px auto;
        padding-left: 32px;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--iu-crimson), var(--iu-gold));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 40px;
    }

    .timeline-dot {
        position: absolute;
        left: -32px;
        top: 6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 4px solid var(--iu-crimson);
        box-shadow: 0 0 0 3px var(--iu-crimson-soft);
    }

    .timeline-content {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-subtle);
    }

    .timeline-year {
        display: inline-block;
        font-family: var(--font-serif);
        font-size: 14px;
        font-weight: 700;
        color: var(--iu-crimson);
        margin-bottom: 6px;
    }

    .timeline-title {
        font-family: var(--font-serif);
        font-size: 19px;
        color: var(--iu-navy);
        margin-bottom: 8px;
    }

    .timeline-text {
        font-size: 14px;
        color: var(--ink-secondary);
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Hero Header -->
    <section class="about-hero">
        <span class="badge-pill badge-crimson" style="margin-bottom: 16px;">
            1453'ten Günümüze • Yarım Binyıllık Miras
        </span>
        <h1>
            Köklü bir çınarın gölgesinde, <em>yarınları inşa eden</em> mezunlar.
        </h1>
        <p>
            İstanbul Üniversitesi Mezun Takip ve Kariyer Ağı; Türkiye'nin ilk ve en köklü üniversitesinin akademik birikimini, mezunlarımızın profesyonel deneyimlerini ve geleceğin lider öğrencilerini tek çatı altında buluşturan resmi dijital platformdur.
        </p>
    </section>

    <!-- Core Values Section -->
    <section>
        <div style="text-align: center; margin-bottom: 32px;">
            <span class="badge-pill badge-gold">Kurumsal Değerlerimiz</span>
            <h2 style="font-size: 28px; color: var(--iu-navy); margin-top: 8px;">Topluluğumuza Yön Veren İlkeler</h2>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon" style="background: var(--iu-crimson-soft); color: var(--iu-crimson);">
                    🏛️
                </div>
                <h3>Köklülük & Prestij</h3>
                <p>
                    1453'ten miras kalan saygınlığı ve kurumsal vakarı her etkileşimde yaşatarak mezunlarımız arasındaki aidiyet bağlarını pekiştiriyoruz.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background: var(--academic-sapphire-soft); color: var(--academic-sapphire);">
                    🤝
                </div>
                <h3>Kariyer Dayanışması</h3>
                <p>
                    Kıdemli mezunlar ile yeni mezunlar ve öğrenciler arasında mentörlük, staj ve istihdam köprüleri tesis ederek ortak başarı üretiyoruz.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background: var(--mint-success-soft); color: #059669;">
                    🌐
                </div>
                <h3>Erişilebilirlik</h3>
                <p>
                    WCAG 2.1 AAA standartlarına uyumlu arayüzümüzle her yaştan ve cihazdan mezunumuzun bilgiye zahmetsizce erişimini güvence altına alıyoruz.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background: var(--iu-gold-soft); color: #B8860B;">
                    ⚡
                </div>
                <h3>Teknolojik Şeffaflık</h3>
                <p>
                    Modern MVC mimarisi, RESTful servisler, Docker altyapısı ve Guardian güvenlik kalkanlarıyla güvenilir ve hızlı bir dijital deneyim sunuyoruz.
                </p>
            </div>
        </div>
    </section>

    <!-- Historical Timeline Section -->
    <section>
        <div style="text-align: center; margin-bottom: 36px;">
            <span class="badge-pill badge-crimson">Tarihsel Yolculuk</span>
            <h2 style="font-size: 28px; color: var(--iu-navy); margin-top: 8px;">1453'ten Dijital Çağa Uzanan Çınar</h2>
        </div>

        <div class="timeline-container">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">1453 • Kuruluş</span>
                    <h3 class="timeline-title">Fatih Sultan Mehmet ve Sahn-ı Seman</h3>
                    <p class="timeline-text">
                        İstanbul'un fethinin hemen ardından kurulan medreselerle Osmanlı'nın ve Türkiye'nin en köklü yükseköğretim geleneği filizlendi. Beyazıt Meydanı'ndaki tarihi kapı, asırlardır bilimin ve aydınlanmanın sembolü oldu.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">1933 • Üniversite Reformu</span>
                    <h3 class="timeline-title">Türkiye Cumhuriyeti'nin İlk Üniversitesi</h3>
                    <p class="timeline-text">
                        Gazi Mustafa Kemal Atatürk'ün öncülüğünde gerçekleştirilen üniversite reformuyla "İstanbul Üniversitesi" adını alarak çağdaş bilim dünyasındaki öncü yerini aldı.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">2026+ • Dijital Ekosistem</span>
                    <h3 class="timeline-title">İstanbul Üniversitesi Mezun ve Kariyer Portalı</h3>
                    <p class="timeline-text">
                        On binlerce mezunumuzun dünyanın dört bir yanında sürdürdüğü başarı hikayelerini ortak bir platformda buluşturuyor; iş fırsatları, etkinlikler ve mentörlük kanallarıyla üniversitemizin gücünü geleceğe taşıyoruz.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Architecture & Open Standards Section -->
    <section class="card" style="margin-bottom: 60px;">
        <div class="card-header">
            <div>
                <span class="badge-pill badge-sapphire">Sistem Mimarisi</span>
                <h3 class="card-title" style="margin-top: 6px;">Yazılım Standartları ve Kurumsal İlkeler</h3>
                <p class="card-subtitle">Bu platform, uluslararası yazılım mühendisliği prensipleri gözetilerek geliştirilmiştir.</p>
            </div>
            <a href="/api/swagger" class="btn btn-sapphire btn-sm">Swagger Dokümantasyonu ↗</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
            <div style="background: var(--canvas-tint); padding: 18px; border-radius: 12px; border: 1px solid var(--border-cream);">
                <div style="font-weight: 700; color: var(--iu-navy); margin-bottom: 4px;">🎨 Marka Kimliği (brand.md)</div>
                <p style="font-size: 13px; color: var(--ink-secondary); line-height: 1.5;">
                    Beyazıt Bordosu (#8A1538), Akademi Laciverti (#0B1B3D) ve Tarihi Kapı Altını (#D4AF37) renk standartları.
                </p>
            </div>

            <div style="background: var(--canvas-tint); padding: 18px; border-radius: 12px; border: 1px solid var(--border-cream);">
                <div style="font-weight: 700; color: var(--iu-navy); margin-bottom: 4px;">🏛️ Tasarım Sistemi (DESIGN.md)</div>
                <p style="font-size: 13px; color: var(--ink-secondary); line-height: 1.5;">
                    Craft Docs, Superr ve Officevibe sentezi: Sıcak kağıt kanvas, Lora editoryal serif ve 100px ergonomik hap butonlar.
                </p>
            </div>

            <div style="background: var(--canvas-tint); padding: 18px; border-radius: 12px; border: 1px solid var(--border-cream);">
                <div style="font-weight: 700; color: var(--iu-navy); margin-bottom: 4px;">📊 Veri Mimarisi (ddd.md)</div>
                <p style="font-size: 13px; color: var(--ink-secondary); line-height: 1.5;">
                    MySQL 8.0 ilişkisel şeması, RESTful uç noktalar, Guardian 404/500 hata koruma kalkanları.
                </p>
            </div>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
            <a href="/users" class="btn btn-primary">Mezun Rehberine Git</a>
            <a href="/" class="btn btn-secondary">Ana Sayfaya Dön</a>
        </div>
    </section>

</div>
@endsection
