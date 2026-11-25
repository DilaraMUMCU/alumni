@extends('layouts.app')

@section('title', 'Profil ve Hesap Ayarları — İstanbul Üniversitesi Mezun Portalı')
@section('meta_description', 'Kişisel profil bilgileri, yetkinlikler ve hesap güvenliği ayarları.')

@push('styles')
<style>
    .profile-settings-layout {
        display: grid;
        grid-template-columns: 310px 1fr;
        gap: 28px;
        align-items: start;
        max-width: 1120px;
        margin: 8px auto 40px auto;
    }

    @media (max-width: 920px) {
        .profile-settings-layout {
            grid-template-columns: 1fr;
        }
    }

    .profile-sidebar-card {
        background: var(--surface-card);
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 28px 24px;
        box-shadow: var(--shadow-card);
        position: sticky;
        top: 100px;
    }

    @media (max-width: 920px) {
        .profile-sidebar-card {
            position: static;
        }
    }

    .profile-avatar-lg {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--iu-navy);
        color: var(--iu-gold);
        border: 2px solid var(--iu-gold);
        font-family: var(--font-serif);
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px auto;
    }

    .profile-side-nav {
        list-style: none;
        padding: 0;
        margin: 22px 0 0 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .profile-side-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--ink-charcoal);
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .profile-side-link:hover {
        background: var(--canvas-tint);
        color: var(--iu-crimson);
    }

    .profile-side-link.active {
        background: var(--iu-crimson-soft);
        color: var(--iu-crimson);
        border: 1px solid var(--iu-crimson-border);
    }

    .capability-list {
        list-style: none;
        padding: 0;
        margin: 14px 0 0 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 12.5px;
    }

    .capability-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 10px;
        border-radius: 8px;
        background: var(--surface-card-subtle);
        border: 1px solid var(--border-cream);
    }

    .settings-form-card {
        background: var(--surface-card);
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 34px 36px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-card);
    }

    @media (max-width: 640px) {
        .settings-form-card {
            padding: 24px 20px;
        }
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

    .badge-navy {
        background: rgba(11, 27, 61, 0.1);
        color: var(--iu-navy);
        border: 1px solid rgba(11, 27, 61, 0.22);
    }
</style>
@endpush

@section('content')
@php
    $skillsStr = is_array($user->skills) ? implode(', ', $user->skills) : (string) ($user->skills ?? '');
@endphp

<div class="container">
    <div class="profile-settings-layout">

        <!-- Left User Sidebar -->
        <aside class="profile-sidebar-card">
            <div style="text-align: center; padding-bottom: 18px; border-bottom: 1px solid var(--border-cream);">
                <div class="profile-avatar-lg">{{ mb_substr($user->name, 0, 1) }}</div>
                <h2 style="font-size: 19px; color: var(--iu-navy); margin-bottom: 4px;">{{ $user->name }}</h2>
                <div style="font-size: 12.5px; color: var(--ink-secondary); margin-bottom: 10px;">{{ $user->email }}</div>
                <span class="badge-pill {{ \App\Models\User::formatRoleBadgeClass($user->role) }}">
                    {{ \App\Models\User::formatRoleLabel($user->role) }}
                </span>
            </div>

            <ul class="profile-side-nav">
                <li>
                    <a href="/profile/settings" class="profile-side-link active">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Profil ve Hesap Ayarları</span>
                    </a>
                </li>
                <li>
                    <a href="/profile/dashboard" class="profile-side-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Kişisel Aktivite Panelim</span>
                    </a>
                </li>
                <li>
                    <a href="/users/{{ $user->id }}" class="profile-side-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Herkese Açık Profilim</span>
                    </a>
                </li>
                @if ($user->isAdmin())
                    <li>
                        <a href="/admin" class="profile-side-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Admin Yönetim Paneli</span>
                        </a>
                    </li>
                @endif
            </ul>

            <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--border-cream);">
                <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ink-secondary);">
                    Rol Yetkilerim
                </div>
                <ul class="capability-list">
                    <li class="capability-item">
                        <span>İş Başvurusu</span>
                        <strong style="color: {{ $user->canApplyToJobs() ? 'var(--mint-success)' : 'var(--ink-muted)' }};">
                            {{ $user->canApplyToJobs() ? 'Aktif' : 'Kapalı' }}
                        </strong>
                    </li>
                    <li class="capability-item">
                        <span>İlan Yayınlama</span>
                        <strong style="color: {{ $user->canPublishJobs() ? 'var(--mint-success)' : 'var(--ink-muted)' }};">
                            {{ $user->canPublishJobs() ? 'Aktif' : 'Kapalı' }}
                        </strong>
                    </li>
                    <li class="capability-item">
                        <span>Etkinlik Oluşturma</span>
                        <strong style="color: {{ $user->canCreateEvents() ? 'var(--mint-success)' : 'var(--ink-muted)' }};">
                            {{ $user->canCreateEvents() ? 'Aktif' : 'Kapalı' }}
                        </strong>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Right Settings Forms -->
        <div>
            @if ($user->isUnverified())
                <div style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 20px; margin-bottom: 22px; background: var(--canvas-tint); border: 1px solid var(--iu-gold-border); border-left: 4px solid var(--iu-gold); border-radius: 14px; font-size: 13.5px; color: var(--ink-charcoal);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="color: var(--iu-crimson); flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div>
                        <strong>Doğrulama Bekleniyor (Unverified):</strong>
                        Profil bilgilerinizi ve şifrenizi güncelleyebilirsiniz. İş başvurusu veya rol bazlı yetkiler doğrulama süreci tamamlandığında aktifleşecektir.
                    </div>
                </div>
            @endif

            <!-- Card 1: Personal & Academic Profile Settings -->
            <div class="settings-form-card">
                <div style="border-bottom: 1px solid var(--border-cream); padding-bottom: 16px; margin-bottom: 22px;">
                    <span class="badge-pill badge-crimson" style="margin-bottom: 6px;">Kişisel Bilgiler</span>
                    <h1 style="font-size: 24px; color: var(--iu-navy); margin: 0;">Profil Ayarları</h1>
                    <p style="font-size: 13.5px; color: var(--ink-secondary); margin-top: 4px;">
                        İletişim, fakülte ve kariyer bilgilerinizi güncel tutun.
                    </p>
                </div>

                <form action="/profile/settings" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="name">Ad Soyad <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="department">Fakülte / Bölüm <span class="required">*</span></label>
                            <input type="text" id="department" name="department" class="form-control" required value="{{ old('department', $user->department) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="graduation_year">Mezuniyet Yılı</label>
                            <input type="number" id="graduation_year" name="graduation_year" class="form-control" min="1950" max="2035" value="{{ old('graduation_year', $user->graduation_year) }}">
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="current_company">Çalıştığı Kurum / Şirket</label>
                            <input type="text" id="current_company" name="current_company" class="form-control" value="{{ old('current_company', $user->current_company) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="job_title">Ünvan / Pozisyon</label>
                            <input type="text" id="job_title" name="job_title" class="form-control" value="{{ old('job_title', $user->job_title) }}">
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="linkedin_url">LinkedIn Profil Bağlantısı</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/..." value="{{ old('linkedin_url', $user->linkedin_url) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sistem Rolü (Salt Okunur)</label>
                            <input type="text" class="form-control" value="{{ \App\Models\User::formatRoleLabel($user->role) }} ({{ $user->role }})" disabled style="background: var(--canvas-tint); cursor: not-allowed;">
                            <div class="form-help">Rol değişiklikleri yalnızca doğrulama veya sistem yöneticisi tarafından yapılır.</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="skills">Yetenekler ve Uzmanlık Alanları</label>
                        <input type="text" id="skills" name="skills" class="form-control" placeholder="PHP, Laravel, Veri Bilimi" value="{{ old('skills', $skillsStr) }}">
                        <div class="form-help">Yetenekleri virgül ile ayırarak yazabilirsiniz.</div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--border-cream);">
                        <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                    </div>
                </form>
            </div>

            <!-- Card 2: Password & Security Settings -->
            <div class="settings-form-card">
                <div style="border-bottom: 1px solid var(--border-cream); padding-bottom: 16px; margin-bottom: 22px;">
                    <span class="badge-pill badge-neutral" style="margin-bottom: 6px;">Hesap Güvenliği</span>
                    <h2 style="font-size: 21px; color: var(--iu-navy); margin: 0;">Şifre Güncelleme</h2>
                    <p style="font-size: 13px; color: var(--ink-secondary); margin-top: 4px;">
                        Hesabınızı korumak için en az 8 karakterli güçlü bir şifre belirleyin.
                    </p>
                </div>

                <form action="/profile/password" method="POST">
                    @csrf
                    @method('PATCH')

                    @if (!empty($user->password))
                        <div class="form-group">
                            <label class="form-label" for="current_password">Mevcut Şifre <span class="required">*</span></label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password">
                        </div>
                    @endif

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="password">Yeni Şifre <span class="required">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" required minlength="8" autocomplete="new-password" placeholder="En az 8 karakter">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Yeni Şifre Tekrarı <span class="required">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8" autocomplete="new-password" placeholder="Yeni şifreyi tekrar girin">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--border-cream);">
                        <button type="submit" class="btn btn-sapphire">Şifreyi Güncelle</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
