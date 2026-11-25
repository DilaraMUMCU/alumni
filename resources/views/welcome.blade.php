@extends('layouts.app')

@php
    try {
        $stats = $stats ?? [
            'users_count'         => \App\Models\User::count(),
            'announcements_count' => \App\Models\Announcement::count(),
            'job_postings_count'  => \App\Models\JobPosting::count(),
            'applications_count'  => \App\Models\Application::count(),
        ];
        $latestJobs = $latestJobs ?? \App\Models\JobPosting::with('applications')->latest()->take(4)->get();
        $latestAnnouncements = $latestAnnouncements ?? \App\Models\Announcement::where('is_active', true)->latest()->take(3)->get();
        $spotlightUsers = $spotlightUsers ?? \App\Models\User::where('role', '!=', 'unverified')->latest()->take(4)->get();
    } catch (\Throwable $e) {
        $stats = $stats ?? ['users_count' => 0, 'announcements_count' => 0, 'job_postings_count' => 0, 'applications_count' => 0];
        $latestJobs = $latestJobs ?? collect();
        $latestAnnouncements = $latestAnnouncements ?? collect();
        $spotlightUsers = $spotlightUsers ?? collect();
    }
@endphp

@section('title', 'İstanbul Üniversitesi — Mezun ve Kariyer İletişim Ağı')
@section('meta_description', '1453\'ten günümüze yarım binyılı aşan akademik mirasla İstanbul Üniversitesi mezunları ve öğrencileri arasında kesintisiz profesyonel köprü.')

@push('styles')
<style>
    /* Hero Section Styling */
    .hero-section {
        padding: 30px 0 50px 0;
        text-align: center;
        position: relative;
    }

    .hero-badge-container {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        padding: 6px 16px;
        border-radius: var(--radius-pill);
        box-shadow: var(--shadow-subtle);
        margin-bottom: 24px;
        animation: fadeIn 0.6s ease;
    }

    .hero-badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--iu-crimson);
        box-shadow: 0 0 0 3px var(--iu-crimson-soft);
    }

    .hero-badge-text {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--iu-navy);
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .hero-title {
        font-family: var(--font-serif);
        font-size: 46px;
        line-height: 1.2;
        color: var(--iu-navy);
        max-width: 900px;
        margin: 0 auto 20px auto;
        letter-spacing: -0.025em;
    }

    .hero-title em {
        font-style: italic;
        color: var(--iu-crimson);
        font-weight: 400;
    }

    .hero-subtitle {
        font-size: 17px;
        line-height: 1.6;
        color: var(--ink-secondary);
        max-width: 720px;
        margin: 0 auto 36px auto;
        font-weight: 400;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 50px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 32px;
        }
        .hero-subtitle {
            font-size: 15px;
        }
    }

    /* Stats Grid */
    .stats-card-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 70px;
    }

    @media (max-width: 992px) {
        .stats-card-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 500px) {
        .stats-card-container {
            grid-template-columns: 1fr;
        }
    }

    .stat-box {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-subtle);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-card);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-crimson { background: var(--iu-crimson-soft); color: var(--iu-crimson); }
    .stat-icon-sapphire { background: var(--academic-sapphire-soft); color: var(--academic-sapphire); }
    .stat-icon-gold { background: var(--iu-gold-soft); color: #B8860B; }
    .stat-icon-emerald { background: var(--mint-success-soft); color: #059669; }

    .stat-num {
        font-family: var(--font-serif);
        font-size: 28px;
        font-weight: 700;
        color: var(--iu-navy);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--ink-secondary);
        font-weight: 500;
    }

    /* Section Headers */
    .section-header-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .section-tag {
        font-size: 12px;
        font-weight: 700;
        color: var(--iu-crimson);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: block;
    }

    .section-heading {
        font-family: var(--font-serif);
        font-size: 28px;
        color: var(--iu-navy);
        font-weight: 600;
    }

    /* 4 Module Features Grid */
    .modules-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 80px;
    }

    @media (max-width: 992px) {
        .modules-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .modules-grid {
            grid-template-columns: 1fr;
        }
    }

    .module-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 28px;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .module-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: rgba(138, 21, 56, 0.3);
    }

    .module-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .module-card-title {
        font-family: var(--font-serif);
        font-size: 19px;
        color: var(--iu-navy);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .module-card-desc {
        font-size: 13.5px;
        color: var(--ink-secondary);
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }

    .module-card-link {
        font-size: 13px;
        font-weight: 700;
        color: var(--iu-crimson);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Opportunities & Announcements Dual Grid */
    .dual-showcase-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 32px;
        margin-bottom: 80px;
    }

    @media (max-width: 992px) {
        .dual-showcase-grid {
            grid-template-columns: 1fr;
        }
    }

    .item-list-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .job-item-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .job-item-card:hover {
        border-color: var(--academic-sapphire-border);
        box-shadow: var(--shadow-card);
        transform: translateX(4px);
    }

    .announcement-item-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: 14px;
        padding: 18px;
        box-shadow: var(--shadow-subtle);
        transition: all 0.2s ease;
        text-decoration: none;
        display: block;
    }

    .announcement-item-card:hover {
        border-color: var(--iu-crimson-border);
        box-shadow: var(--shadow-card);
        transform: translateX(4px);
    }

    /* Spotlight Alumni Grid */
    .alumni-spotlight-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 80px;
    }

    @media (max-width: 992px) {
        .alumni-spotlight-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 500px) {
        .alumni-spotlight-grid {
            grid-template-columns: 1fr;
        }
    }

    .alumni-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        text-align: center;
        box-shadow: var(--shadow-card);
        transition: all 0.2s ease;
    }

    .alumni-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
    }

    .alumni-avatar-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--iu-navy) 0%, #1a3675 100%);
        color: #FFFFFF;
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        border: 3px solid #FFFFFF;
        box-shadow: 0 4px 12px rgba(11, 27, 61, 0.15);
    }

    /* Architecture Callout Banner */
    .architecture-banner {
        background: linear-gradient(135deg, var(--iu-navy) 0%, #070D1B 100%);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: var(--radius-hero);
        padding: 44px;
        color: #FFFFFF;
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        flex-wrap: wrap;
    }

    .architecture-banner h3 {
        color: #FFFFFF;
        font-size: 26px;
        margin-bottom: 8px;
    }

    .architecture-banner p {
        color: #94A3B8;
        font-size: 14px;
        max-width: 600px;
        line-height: 1.6;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- 1. Editorial Hero Section -->
    <section class="hero-section">
        <div class="hero-badge-container">
            <span class="hero-badge-dot"></span>
            <span class="hero-badge-text">İstanbul Üniversitesi • 1453'ten Geleceğe</span>
        </div>

        <h1 class="hero-title">
            Köklü bir geçmişten, <em>parlak bir kariyere</em> uzanan köprü.
        </h1>

        <p class="hero-subtitle">
            Yarım binyıllık akademik mirasın gücüyle; mezunlarımızı, akademisyenlerimizi ve geleceğin lider öğrencilerini tek bir profesyonel ekosistemde buluşturuyoruz.
        </p>

        <div class="hero-actions">
            <a href="/register" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                <span>Mezun Ağına Katıl</span>
            </a>
            <a href="/job-postings" class="btn btn-sapphire btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                <span>Kariyer Fırsatları</span>
            </a>
            <a href="/about" class="btn btn-secondary btn-lg">
                <span>Tarihçe & Hakkımızda</span>
            </a>
        </div>
    </section>

    <!-- 2. Live Platform Statistics -->
    <section class="stats-card-container">
        <div class="stat-box">
            <div class="stat-icon stat-icon-crimson">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div>
                <div class="stat-num">{{ $stats['users_count'] ?? 0 }}</div>
                <div class="stat-label">Kayıtlı Mezun & Öğrenci</div>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon stat-icon-sapphire">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            </div>
            <div>
                <div class="stat-num">{{ $stats['job_postings_count'] ?? 0 }}</div>
                <div class="stat-label">Aktif İş & Staj İlanı</div>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon stat-icon-emerald">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            </div>
            <div>
                <div class="stat-num">{{ $stats['applications_count'] ?? 0 }}</div>
                <div class="stat-label">Aday Başvurusu</div>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon stat-icon-gold">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            </div>
            <div>
                <div class="stat-num">{{ $stats['announcements_count'] ?? 0 }}</div>
                <div class="stat-label">Kurumsal Duyuru</div>
            </div>
        </div>
    </section>

    <!-- 3. Core Modules Grid -->
    <section style="margin-bottom: 70px;">
        <div class="section-header-row">
            <div>
                <span class="section-tag">Platform Hizmetleri</span>
                <h2 class="section-heading">Mezun Ekosistemi Modülleri</h2>
            </div>
            <a href="/about" class="btn btn-secondary btn-sm">Sistem Mimarisi ↗</a>
        </div>

        <div class="modules-grid">
            <a href="/users" class="module-card">
                <div class="module-card-icon" style="background: var(--iu-crimson-soft); color: var(--iu-crimson);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <h3 class="module-card-title">Mezun Rehberi</h3>
                <p class="module-card-desc">
                    Fakültelerden mezun binlerce meslektaşınızı keşfedin, sektör ve departman filtreleriyle mentorluk ve iş birliği bağları kurun.
                </p>
                <div class="module-card-link">
                    <span>Rehberi İncele</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>

            <a href="/job-postings" class="module-card">
                <div class="module-card-icon" style="background: var(--academic-sapphire-soft); color: var(--academic-sapphire);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <h3 class="module-card-title">Kariyer Kapısı</h3>
                <p class="module-card-desc">
                    Mezun şirketleri ve kurumsal ortaklar tarafından açılan tam zamanlı pozisyonlar, yarı zamanlı işler ve staj ilanlarına doğrudan ulaşın.
                </p>
                <div class="module-card-link" style="color: var(--academic-sapphire);">
                    <span>İlanları Keşfet</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>

            <a href="/applications" class="module-card">
                <div class="module-card-icon" style="background: var(--mint-success-soft); color: #059669;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <h3 class="module-card-title">Başvuru Takibi</h3>
                <p class="module-card-desc">
                    Başvuru yaptığınız ilanların değerlendirme süreçlerini, kısa liste ve kabul durumlarını şeffaf biçimde tek panelden yönetin.
                </p>
                <div class="module-card-link" style="color: #059669;">
                    <span>Başvuru Paneli</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>

            <a href="/announcements" class="module-card">
                <div class="module-card-icon" style="background: var(--iu-gold-soft); color: #B8860B;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <h3 class="module-card-title">Üniversite Duyuruları</h3>
                <p class="module-card-desc">
                    Rektörlük ve fakültelerimizden mezuniyet buluşmaları, akademik konferanslar ve kariyer zirvelerine dair resmi haberleri anlık takip edin.
                </p>
                <div class="module-card-link" style="color: #B8860B;">
                    <span>Duyuruları Gör</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
        </div>
    </section>

    <!-- 4. Dual Showcase: Latest Job Opportunities & Recent Announcements -->
    <section class="dual-showcase-grid">
        <!-- Col 1: Latest Opportunities -->
        <div>
            <div class="section-header-row" style="margin-bottom: 20px;">
                <div>
                    <span class="section-tag">Kariyer Fırsatları</span>
                    <h2 class="section-heading" style="font-size: 22px;">Son Yayınlanan İlanlar</h2>
                </div>
                <a href="/job-postings" class="btn btn-secondary btn-sm">Tüm İlanlar ({{ $stats['job_postings_count'] ?? 0 }})</a>
            </div>

            <div class="item-list-container">
                @forelse ($latestJobs as $job)
                    <a href="/job-postings/{{ $job->id }}" class="job-item-card">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--canvas-tint); border: 1px solid var(--border-cream); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--iu-navy); font-size: 16px;">
                                {{ mb_substr($job->company ?? 'İÜ', 0, 1) }}
                            </div>
                            <div>
                                <h4 style="font-family: var(--font-sans); font-size: 15px; font-weight: 700; color: var(--iu-navy); margin-bottom: 2px;">
                                    {{ $job->title }}
                                </h4>
                                <div style="font-size: 12.5px; color: var(--ink-secondary); display: flex; gap: 12px; align-items: center;">
                                    <span>{{ $job->company }}</span>
                                    <span>•</span>
                                    <span>{{ $job->location }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="badge-pill {{ $job->employment_type === 'internship' ? 'badge-amber' : ($job->employment_type === 'part-time' ? 'badge-sapphire' : 'badge-crimson') }}">
                                {{ $job->employment_type_label ?? ($job->employment_type === 'internship' ? 'Staj' : ($job->employment_type === 'part-time' ? 'Yarı Zamanlı' : 'Tam Zamanlı')) }}
                            </span>
                            <span class="btn btn-secondary btn-sm" style="padding: 6px 12px; font-size: 12px;">Başvur ↗</span>
                        </div>
                    </a>
                @empty
                    <div class="card" style="text-align: center; padding: 32px; color: var(--ink-secondary);">
                        Henüz aktif bir kariyer ilanı bulunmamaktadır.
                        <div style="margin-top: 12px;">
                            <a href="/job-postings/create" class="btn btn-primary btn-sm">+ İlk İlanı Yayınlayın</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Col 2: Recent Announcements -->
        <div>
            <div class="section-header-row" style="margin-bottom: 20px;">
                <div>
                    <span class="section-tag">Resmi İletişim</span>
                    <h2 class="section-heading" style="font-size: 22px;">Önemli Duyurular</h2>
                </div>
                <a href="/announcements" class="btn btn-secondary btn-sm">Tümü ({{ $stats['announcements_count'] ?? 0 }})</a>
            </div>

            <div class="item-list-container">
                @forelse ($latestAnnouncements as $announcement)
                    <a href="/announcements/{{ $announcement->id }}" class="announcement-item-card">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span class="badge-pill badge-gold">
                                {{ $announcement->category ?? 'Genel' }}
                            </span>
                            <span style="font-size: 11.5px; color: var(--ink-secondary);">
                                {{ $announcement->created_at ? \Carbon\Carbon::parse($announcement->created_at)->format('d.m.Y') : 'Güncel' }}
                            </span>
                        </div>
                        <h4 style="font-family: var(--font-serif); font-size: 16px; color: var(--iu-navy); margin-bottom: 6px; font-weight: 600;">
                            {{ $announcement->title }}
                        </h4>
                        <p style="font-size: 13px; color: var(--ink-secondary); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ strip_tags($announcement->content) }}
                        </p>
                    </a>
                @empty
                    <div class="card" style="text-align: center; padding: 32px; color: var(--ink-secondary);">
                        Henüz yayınlanmış bir duyuru bulunmamaktadır.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. Spotlight Alumni Section -->
    <section style="margin-bottom: 80px;">
        <div class="section-header-row">
            <div>
                <span class="section-tag">Kariyer Başarıları</span>
                <h2 class="section-heading">Öne Çıkan Mezunlarımız</h2>
            </div>
            <a href="/users" class="btn btn-secondary btn-sm">Tüm Mezun Dizini ↗</a>
        </div>

        <div class="alumni-spotlight-grid">
            @forelse ($spotlightUsers as $user)
                <div class="alumni-card">
                    <div class="alumni-avatar-circle">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <h4 style="font-family: var(--font-sans); font-size: 16px; font-weight: 700; color: var(--iu-navy); margin-bottom: 4px;">
                        {{ $user->name }}
                    </h4>
                    <div style="font-size: 13px; font-weight: 600; color: var(--iu-crimson); margin-bottom: 4px;">
                        {{ $user->job_title ?? \App\Models\User::formatRoleLabel($user->role) }}
                    </div>
                    <div style="font-size: 12.5px; color: var(--ink-secondary); margin-bottom: 12px;">
                        {{ $user->current_company ?? $user->department }}
                    </div>
                    @if ($user->graduation_year)
                        <span class="badge-pill badge-neutral" style="font-size: 11px;">
                            {{ $user->graduation_year }} Mezuniyeti
                        </span>
                    @endif
                    <div style="margin-top: 16px;">
                        <a href="/users/{{ $user->id }}" class="btn btn-secondary btn-sm" style="width: 100%;">Profili İncele</a>
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 32px; color: var(--ink-secondary);">
                    Henüz kayıtlı mezun profili bulunmamaktadır.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. Academic Architecture Banner -->
    <section class="architecture-banner">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                <span class="badge-pill badge-gold" style="background: rgba(212, 175, 55, 0.2); color: var(--iu-gold); border-color: rgba(212, 175, 55, 0.4);">
                    RESTful API & Swagger 3.0
                </span>
                <span class="badge-pill" style="background: rgba(255, 255, 255, 0.1); color: #FFFFFF; border: 1px solid rgba(255, 255, 255, 0.2);">
                    MySQL 8.0 & Docker
                </span>
            </div>
            <h3>Geliştiriciler ve Araştırmacılar İçin Açık Standartlar</h3>
            <p>
                Platformumuz, modern yazılım mimarisi ilkelerine uygun olarak tasarlanmıştır. Tüm mezun, iş ilanı ve duyuru verilerine OpenAPI 3.0 uyumlu Swagger dokümantasyonu üzerinden güvenle erişebilirsiniz.
            </p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="/api/swagger" class="btn btn-gold btn-lg">
                <span>Swagger UI Dokümantasyonu ↗</span>
            </a>
            <a href="/DESIGN.md" target="_blank" class="btn btn-secondary btn-lg" style="background: rgba(255, 255, 255, 0.1); color: #FFFFFF; border-color: rgba(255, 255, 255, 0.25);">
                <span>DESIGN.md İncele</span>
            </a>
        </div>
    </section>

</div>
@endsection
