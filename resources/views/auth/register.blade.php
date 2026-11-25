@extends('layouts.app')

@section('title', 'Yeni Üye Kaydı — İstanbul Üniversitesi Mezun ve Kariyer Portalı')
@section('meta_description', 'İstanbul Üniversitesi Mezun ve Kariyer Portalı yeni kullanıcı kayıt sayfası.')

@push('styles')
<style>
    .register-shell {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 28px;
        align-items: start;
        max-width: 1120px;
        margin: 8px auto 32px auto;
    }

    @media (max-width: 960px) {
        .register-shell {
            grid-template-columns: 1fr;
        }
    }

    .register-aside {
        background: var(--iu-navy);
        color: var(--ink-white);
        border-radius: var(--radius-hero);
        padding: 36px 30px;
        border: 1px solid rgba(212, 175, 55, 0.28);
        box-shadow: var(--shadow-card);
        position: sticky;
        top: 100px;
    }

    @media (max-width: 960px) {
        .register-aside {
            position: static;
        }
    }

    .register-aside-logo {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 22px;
        margin-bottom: 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .register-aside-logo img {
        width: 52px;
        height: 52px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .register-aside h2 {
        font-family: var(--font-serif);
        font-size: 23px;
        line-height: 1.3;
        color: #FFFFFF;
        margin-bottom: 12px;
    }

    .register-aside p {
        font-size: 13.5px;
        line-height: 1.65;
        color: rgba(255, 255, 255, 0.78);
        margin-bottom: 22px;
    }

    .onboarding-steps {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin: 0;
        padding: 0;
    }

    .onboarding-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.09);
    }

    .onboarding-step-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.2);
        border: 1px solid var(--iu-gold);
        color: var(--iu-gold);
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .onboarding-step-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 3px;
    }

    .onboarding-step-desc {
        font-size: 12.5px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.72);
    }

    .register-card {
        background: var(--surface-card);
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 40px;
        box-shadow: var(--shadow-card);
    }

    @media (max-width: 640px) {
        .register-card {
            padding: 24px 20px;
        }
    }

    .unverified-notice {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
        background: var(--canvas-tint);
        border: 1px solid var(--iu-gold-border);
        border-left: 4px solid var(--iu-gold);
        border-radius: 12px;
        margin-bottom: 28px;
        font-size: 13px;
        line-height: 1.6;
        color: var(--ink-charcoal);
    }

    .unverified-notice svg {
        color: var(--iu-crimson);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .form-section-heading {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--iu-crimson);
        margin: 24px 0 14px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-cream);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-section-heading:first-of-type {
        margin-top: 0;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 640px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .password-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-wrap .form-control {
        padding-right: 44px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 10px;
        background: transparent;
        border: none;
        color: var(--ink-secondary);
        cursor: pointer;
        padding: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: color 0.15s ease, background 0.15s ease;
    }

    .password-toggle-btn:hover {
        color: var(--iu-navy);
        background: rgba(11, 27, 61, 0.05);
    }

    .field-error-msg {
        color: var(--rose-danger);
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
    }

    .form-control.is-invalid {
        border-color: var(--rose-danger);
    }

    .terms-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        background: var(--surface-card-subtle);
        border: 1px solid var(--border-cream);
        border-radius: 12px;
        margin-top: 8px;
        font-size: 13px;
        line-height: 1.55;
        color: var(--ink-charcoal);
        cursor: pointer;
    }

    .terms-box input[type="checkbox"] {
        width: 17px;
        height: 17px;
        margin-top: 2px;
        accent-color: var(--iu-crimson);
        flex-shrink: 0;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="register-shell">

        <!-- Institutional Onboarding Info Column -->
        <aside class="register-aside">
            <div class="register-aside-logo">
                <img src="/images/iu-logo.svg" alt="İstanbul Üniversitesi Logo">
                <div>
                    <div style="font-size: 13px; font-weight: 800; letter-spacing: 0.4px; color: #FFFFFF;">İSTANBUL ÜNİVERSİTESİ</div>
                    <div style="font-size: 11.5px; color: var(--iu-gold); font-weight: 600;">Mezun ve Kariyer Portalı</div>
                </div>
            </div>

            <h2>Kurumsal Ağa Katılın</h2>
            <p>
                İstanbul Üniversitesi öğrenci, mezun ve akademisyen iletişim ekosistemine kayıt olarak kariyer fırsatlarını ve akademik duyuruları takip edebilirsiniz.
            </p>

            <ul class="onboarding-steps">
                <li class="onboarding-step">
                    <span class="onboarding-step-num">1</span>
                    <div>
                        <div class="onboarding-step-title">Hesap Oluşturma</div>
                        <div class="onboarding-step-desc">Kimlik, iletişim ve fakülte/bölüm bilgilerinizi girerek ilk kaydınızı tamamlayın.</div>
                    </div>
                </li>
                <li class="onboarding-step">
                    <span class="onboarding-step-num">2</span>
                    <div>
                        <div class="onboarding-step-title">Doğrulanmamış Başlangıç Statüsü</div>
                        <div class="onboarding-step-desc">İlk kez kayıt olan kullanıcılar otomatik olarak <strong>Doğrulanmamış (unverified)</strong> rolü ile sisteme dahil olur.</div>
                    </div>
                </li>
                <li class="onboarding-step">
                    <span class="onboarding-step-num">3</span>
                    <div>
                        <div class="onboarding-step-title">Yetkilendirme Kapsamı</div>
                        <div class="onboarding-step-desc">Doğrulama aşaması tamamlandığında öğrenci/mezun iş başvurusu veya akademisyen etkinlik oluşturma yetkileri tanımlanır.</div>
                    </div>
                </li>
            </ul>
        </aside>

        <!-- Main Registration Form Card -->
        <div class="register-card">
            <div style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 22px;">
                <span class="badge-pill badge-crimson" style="margin-bottom: 8px;">Yeni Kullanıcı Kaydı</span>
                <h1 class="card-title" style="font-size: 28px; color: var(--iu-navy);">Üyelik Kayıt Formu</h1>
                <p class="card-subtitle">Portalda ilk kez hesap oluşturmak için aşağıdaki bilgileri eksiksiz doldurunuz.</p>
            </div>

            <!-- Unverified Role Information Banner -->
            <div class="unverified-notice">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <div>
                    <strong>Bilgilendirme — Doğrulama Öncesi Başlangıç Rolü:</strong>
                    Sistemi ilk kez kullanan yeni üyelerin hesapları güvenlik gereği <strong>Doğrulanmamış (unverified)</strong> rolüyle açılır. Bu aşamada profilinizi görüntüleyebilir ve güncelleyebilirsiniz; iş başvurusu yapma veya etkinlik oluşturma gibi rol bazlı yetkiler doğrulama sonrasında aktifleşir.
                </div>
            </div>

            <form action="/register" method="POST" novalidate>
                @csrf

                <!-- Section 1: Account & Credentials -->
                <div class="form-section-heading">
                    <span>1. Hesap ve Kimlik Bilgileri</span>
                    <span style="font-size: 11px; font-weight: 600; color: var(--ink-secondary); text-transform: none;">* Zorunlu Alanlar</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Ad Soyad <span class="required">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Örn: Zeynep Kaya"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                        >
                        @error('name')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="ornek@ogr.iu.edu.tr veya @istanbul.edu.tr"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="password">Şifre <span class="required">*</span></label>
                        <div class="password-input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="En az 8 karakter"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            >
                            <button type="button" class="password-toggle-btn" data-target="password" aria-label="Şifreyi Göster/Gizle">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Şifre Tekrarı <span class="required">*</span></label>
                        <div class="password-input-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Şifrenizi tekrar giriniz"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            >
                            <button type="button" class="password-toggle-btn" data-target="password_confirmation" aria-label="Şifre Tekrarını Göster/Gizle">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Academic Information -->
                <div class="form-section-heading">
                    <span>2. Akademik Bilgiler</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="department">Fakülte / Bölüm <span class="required">*</span></label>
                        <input
                            type="text"
                            id="department"
                            name="department"
                            list="iu-departments"
                            class="form-control @error('department') is-invalid @enderror"
                            placeholder="Örn: Bilgisayar ve Bilişim Teknolojileri Fakültesi"
                            value="{{ old('department') }}"
                            required
                        >
                        <datalist id="iu-departments">
                            <option value="Bilgisayar Mühendisliği"></option>
                            <option value="Hukuk Fakültesi"></option>
                            <option value="İktisat Fakültesi"></option>
                            <option value="İşletme Fakültesi"></option>
                            <option value="İstanbul Tıp Fakültesi"></option>
                            <option value="Edebiyat Fakültesi"></option>
                            <option value="Fen Fakültesi"></option>
                            <option value="İletişim Fakültesi"></option>
                            <option value="Siyasal Bilgiler Fakültesi"></option>
                            <option value="Eczacılık Fakültesi"></option>
                            <option value="Diş Hekimliği Fakültesi"></option>
                        </datalist>
                        @error('department')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="graduation_year">Mezuniyet / Tahmini Mezuniyet Yılı</label>
                        <input
                            type="number"
                            id="graduation_year"
                            name="graduation_year"
                            class="form-control @error('graduation_year') is-invalid @enderror"
                            placeholder="Örn: 2026"
                            min="1950"
                            max="2035"
                            value="{{ old('graduation_year') }}"
                        >
                        <div class="form-help">Akademik personel için boş bırakılabilir.</div>
                        @error('graduation_year')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Professional & Network Details -->
                <div class="form-section-heading">
                    <span>3. Profesyonel Profil Bilgileri (İsteğe Bağlı)</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="current_company">Çalıştığı Kurum / Şirket</label>
                        <input
                            type="text"
                            id="current_company"
                            name="current_company"
                            class="form-control @error('current_company') is-invalid @enderror"
                            placeholder="Örn: ASELSAN, TÜBİTAK veya İstanbul Üniversitesi"
                            value="{{ old('current_company') }}"
                        >
                        @error('current_company')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="job_title">Mevcut Ünvan / Pozisyon</label>
                        <input
                            type="text"
                            id="job_title"
                            name="job_title"
                            class="form-control @error('job_title') is-invalid @enderror"
                            placeholder="Örn: Yazılım Mühendisi, Stajyer, Araştırma Görevlisi"
                            value="{{ old('job_title') }}"
                        >
                        @error('job_title')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="linkedin_url">LinkedIn Profil Bağlantısı</label>
                        <input
                            type="url"
                            id="linkedin_url"
                            name="linkedin_url"
                            class="form-control @error('linkedin_url') is-invalid @enderror"
                            placeholder="https://linkedin.com/in/kullaniciadi"
                            value="{{ old('linkedin_url') }}"
                        >
                        @error('linkedin_url')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="skills">Yetenekler ve Uzmanlık Alanları</label>
                        <input
                            type="text"
                            id="skills"
                            name="skills"
                            class="form-control @error('skills') is-invalid @enderror"
                            placeholder="PHP, Laravel, Veri Analizi, Kamu Hukuku"
                            value="{{ old('skills') }}"
                        >
                        <div class="form-help">Uzmanlık alanlarını virgül ile ayırarak yazabilirsiniz.</div>
                        @error('skills')
                            <div class="field-error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Terms & Consent -->
                <div class="form-group" style="margin-top: 8px;">
                    <label class="terms-box" for="terms">
                        <input type="checkbox" id="terms" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                        <span>
                            İstanbul Üniversitesi Mezun ve Kariyer Portalı üyelik koşullarını, kişisel verilerin korunması (KVKK) aydınlatma metnini okudum ve hesabımın başlangıçta <strong>Doğrulanmamış</strong> statüde oluşturulacağını kabul ediyorum. <span class="required">*</span>
                        </span>
                    </label>
                    @error('terms')
                        <div class="field-error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 28px; padding-top: 22px; border-top: 1px solid var(--border-cream);">
                    <a href="/" class="btn btn-secondary">Ana Sayfaya Dön</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        <span>Hesap Oluştur ve Kaydol</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.password-toggle-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = btn.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });
</script>
@endpush
@endsection
