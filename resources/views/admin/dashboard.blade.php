@extends('layouts.app')

@section('title', 'Yönetim Paneli (Admin) — İstanbul Üniversitesi Mezun Portalı')
@section('meta_description', 'İstanbul Üniversitesi Mezun ve Kariyer Portalı merkezi yönetim ve veri manipülasyon paneli.')

@push('styles')
<style>
    .admin-hero {
        background: var(--iu-navy);
        color: #FFFFFF;
        border-radius: var(--radius-hero);
        padding: 32px 36px;
        margin-bottom: 28px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .admin-hero h1 {
        font-family: var(--font-serif);
        font-size: 28px;
        color: #FFFFFF;
        margin: 6px 0 6px 0;
    }

    .admin-hero p {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.78);
        margin: 0;
    }

    .admin-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    @media (max-width: 992px) {
        .admin-kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 540px) {
        .admin-kpi-grid {
            grid-template-columns: 1fr;
        }
    }

    .admin-kpi-card {
        background: var(--surface-card);
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 20px 22px;
        box-shadow: var(--shadow-subtle);
    }

    .admin-kpi-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--ink-secondary);
        margin-bottom: 8px;
    }

    .admin-kpi-value {
        font-family: var(--font-serif);
        font-size: 32px;
        font-weight: 700;
        color: var(--iu-navy);
        line-height: 1.1;
    }

    .admin-kpi-sub {
        font-size: 12px;
        color: var(--ink-secondary);
        margin-top: 6px;
    }

    .admin-section-card {
        background: var(--surface-card);
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 28px 30px;
        margin-bottom: 28px;
        box-shadow: var(--shadow-card);
    }

    .admin-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-cream);
    }

    .admin-section-title {
        font-family: var(--font-serif);
        font-size: 21px;
        color: var(--iu-navy);
        margin: 0;
    }

    .admin-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .admin-table th {
        text-align: left;
        padding: 11px 12px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--ink-secondary);
        border-bottom: 2px solid var(--border-cream);
        white-space: nowrap;
    }

    .admin-table td {
        padding: 13px 12px;
        border-bottom: 1px solid var(--border-cream);
        vertical-align: middle;
        color: var(--ink-charcoal);
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .admin-table tr:hover td {
        background: var(--surface-card-subtle);
    }

    .inline-action-form {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0;
    }

    .inline-select {
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid var(--border-cream);
        background: #FFFFFF;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--iu-navy);
        cursor: pointer;
    }

    .admin-filter-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .badge-navy {
        background: rgba(11, 27, 61, 0.1);
        color: var(--iu-navy);
        border: 1px solid rgba(11, 27, 61, 0.22);
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Admin Header Banner -->
    <section class="admin-hero">
        <div>
            <span class="badge-pill badge-gold" style="background: rgba(212, 175, 55, 0.18); color: var(--iu-gold); border-color: rgba(212, 175, 55, 0.45);">
                Yönetici Yetkisi Aktif • RBAC Korumalı
            </span>
            <h1>İstanbul Üniversitesi Yönetim Paneli</h1>
            <p>
                Aktif Yönetici: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}) —
                Kullanıcı rollerini, iş ilanlarını, aday başvurularını ve duyuruları buradan doğrudan yönetebilirsiniz.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="/users/create" class="btn btn-gold btn-sm">Yeni Kullanıcı Ekle</a>
            <a href="/job-postings/create" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.12); color: #fff; border-color: rgba(255,255,255,0.25);">Yeni İlan</a>
            <a href="/announcements/create" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.12); color: #fff; border-color: rgba(255,255,255,0.25);">Yeni Duyuru</a>
        </div>
    </section>

    <!-- Live System KPIs -->
    <section class="admin-kpi-grid">
        <div class="admin-kpi-card">
            <div class="admin-kpi-label">Toplam Kullanıcı</div>
            <div class="admin-kpi-value">{{ $stats['total_users'] }}</div>
            <div class="admin-kpi-sub">
                {{ $stats['students_count'] }} Öğrenci • {{ $stats['alumni_count'] }} Mezun • {{ $stats['academics_count'] }} Akademisyen • {{ $stats['admins_count'] }} Yönetici
            </div>
        </div>

        <div class="admin-kpi-card" style="border-left: 4px solid var(--iu-gold);">
            <div class="admin-kpi-label">Doğrulama Bekleyen (Unverified)</div>
            <div class="admin-kpi-value" style="color: var(--iu-crimson);">{{ $stats['unverified_users'] }}</div>
            <div class="admin-kpi-sub">Rol ataması bekleyen yeni kayıtlı hesaplar</div>
        </div>

        <div class="admin-kpi-card">
            <div class="admin-kpi-label">Kariyer İlanları & Başvurular</div>
            <div class="admin-kpi-value">{{ $stats['jobs_count'] }} / {{ $stats['applications_count'] }}</div>
            <div class="admin-kpi-sub">Aktif iş ilanı ve toplam aday başvurusu</div>
        </div>

        <div class="admin-kpi-card">
            <div class="admin-kpi-label">Kurumsal Duyurular</div>
            <div class="admin-kpi-value">{{ $stats['announcements_count'] }}</div>
            <div class="admin-kpi-sub">Yayındaki ve arşivdeki tüm duyurular</div>
        </div>
    </section>

    <!-- 1. User & Role Management Section -->
    <section class="admin-section-card" id="users-section">
        <div class="admin-section-header">
            <div>
                <h2 class="admin-section-title">Kullanıcı ve Rol Yönetimi</h2>
                <p style="font-size: 13px; color: var(--ink-secondary); margin-top: 4px;">
                    Doğrulanmamış hesapları onaylayıp rol atayabilir veya mevcut kullanıcı rollerini doğrudan değiştirebilirsiniz.
                </p>
            </div>
            <span class="badge-pill badge-neutral">{{ $users->count() }} Kayıt Listeleniyor</span>
        </div>

        <div class="admin-filter-row">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="/admin" class="filter-pill {{ empty($roleFilter) ? 'active' : '' }}">Tümü</a>
                <a href="/admin?role=unverified" class="filter-pill {{ $roleFilter === 'unverified' ? 'active' : '' }}">Doğrulanmamış ({{ $stats['unverified_users'] }})</a>
                <a href="/admin?role=student" class="filter-pill {{ $roleFilter === 'student' ? 'active' : '' }}">Öğrenci</a>
                <a href="/admin?role=alumni" class="filter-pill {{ $roleFilter === 'alumni' ? 'active' : '' }}">Mezun</a>
                <a href="/admin?role=academics" class="filter-pill {{ $roleFilter === 'academics' ? 'active' : '' }}">Akademisyen</a>
                <a href="/admin?role=admin" class="filter-pill {{ $roleFilter === 'admin' ? 'active' : '' }}">Yönetici</a>
            </div>

            <form action="/admin" method="GET" style="display: flex; gap: 8px; align-items: center;">
                @if ($roleFilter)
                    <input type="hidden" name="role" value="{{ $roleFilter }}">
                @endif
                <input type="text" name="search" class="form-control" style="padding: 7px 12px; font-size: 13px; width: 230px;" placeholder="Ad, e-posta veya bölüm ara..." value="{{ $search }}">
                <button type="submit" class="btn btn-sapphire btn-sm">Ara</button>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı</th>
                        <th>Fakülte / Bölüm</th>
                        <th>Mevcut Rol</th>
                        <th>Rol Değiştir / Doğrula</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td style="font-family: var(--font-mono); font-size: 12px; color: var(--ink-secondary);">#{{ $u->id }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--iu-navy);">{{ $u->name }}</div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">{{ $u->email }}</div>
                            </td>
                            <td>
                                <div>{{ $u->department ?: 'Belirtilmedi' }}</div>
                                @if ($u->graduation_year)
                                    <div style="font-size: 11.5px; color: var(--ink-secondary);">Mezuniyet: {{ $u->graduation_year }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-pill {{ \App\Models\User::formatRoleBadgeClass($u->role) }}" style="font-size: 11px;">
                                    {{ \App\Models\User::formatRoleLabel($u->role) }}
                                </span>
                            </td>
                            <td>
                                <form action="/admin/users/{{ $u->id }}/role" method="POST" class="inline-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="inline-select" aria-label="Kullanıcı Rolü">
                                        <option value="unverified" {{ $u->role === 'unverified' ? 'selected' : '' }}>Doğrulanmamış</option>
                                        <option value="student" {{ $u->role === 'student' ? 'selected' : '' }}>Öğrenci</option>
                                        <option value="alumni" {{ $u->role === 'alumni' ? 'selected' : '' }}>Mezun</option>
                                        <option value="academics" {{ in_array($u->role, ['academics', 'academician'], true) ? 'selected' : '' }}>Akademisyen</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Yönetici</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px; font-size: 12px;">Güncelle</button>
                                </form>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="/users/{{ $u->id }}/edit" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;">Düzenle</a>
                                @if ((int) $u->id !== (int) auth()->id())
                                    <form action="/admin/users/{{ $u->id }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Bu kullanıcıyı kalıcı olarak silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px; font-size: 12px;">Sil</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 28px; color: var(--ink-secondary);">
                                Seçilen filtrelere uygun kullanıcı bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 2. Candidate Applications Manipulation -->
    <section class="admin-section-card" id="applications-section">
        <div class="admin-section-header">
            <div>
                <h2 class="admin-section-title">Aday Başvuru Yönetimi</h2>
                <p style="font-size: 13px; color: var(--ink-secondary); margin-top: 4px;">
                    Tüm kariyer başvurularının değerlendirme aşamalarını buradan güncelleyebilirsiniz.
                </p>
            </div>
            <span class="badge-pill badge-neutral">{{ $applications->count() }} Başvuru</span>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Aday</th>
                        <th>İlan & Kurum</th>
                        <th>Durum Güncelle</th>
                        <th style="text-align: right;">Detay</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td style="font-family: var(--font-mono); font-size: 12px;">#{{ $app->id }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--iu-navy);">{{ $app->user->name ?? 'Bilinmiyor' }}</div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">{{ $app->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $app->jobPosting->title ?? 'İlan Silinmiş' }}</div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">{{ $app->jobPosting->company ?? '' }}</div>
                            </td>
                            <td>
                                <form action="/admin/applications/{{ $app->id }}/status" method="POST" class="inline-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="inline-select">
                                        <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Beklemede</option>
                                        <option value="reviewing" {{ $app->status === 'reviewing' ? 'selected' : '' }}>İnceleniyor</option>
                                        <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Kısa Listede</option>
                                        <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Kabul Edildi</option>
                                        <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                    </select>
                                    <button type="submit" class="btn btn-sapphire btn-sm" style="padding: 6px 12px; font-size: 12px;">Kaydet</button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="/applications/{{ $app->id }}" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;">İncele</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: var(--ink-secondary);">Kayıtlı başvuru bulunmamaktadır.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 3. Announcements Manipulation -->
    <section class="admin-section-card" id="announcements-section">
        <div class="admin-section-header">
            <div>
                <h2 class="admin-section-title">Duyuru Yönetimi</h2>
                <p style="font-size: 13px; color: var(--ink-secondary); margin-top: 4px;">
                    Duyuruları başa sabitleyebilir, yayından kaldırabilir veya silebilirsiniz.
                </p>
            </div>
            <a href="/announcements/create" class="btn btn-primary btn-sm">Yeni Duyuru Yayınla</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık & Kategori</th>
                        <th>Durum</th>
                        <th style="text-align: right;">Hızlı İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $ann)
                        <tr>
                            <td style="font-family: var(--font-mono); font-size: 12px;">#{{ $ann->id }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--iu-navy);">{{ $ann->title }}</div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">{{ $ann->category }} • {{ $ann->author }}</div>
                            </td>
                            <td>
                                @if ($ann->pinned)
                                    <span class="badge-pill badge-gold" style="font-size: 11px;">Sabitli</span>
                                @endif
                                <span class="badge-pill {{ $ann->is_active ? 'badge-crimson' : 'badge-neutral' }}" style="font-size: 11px;">
                                    {{ $ann->is_active ? 'Yayında' : 'Arşivde' }}
                                </span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <form action="/admin/announcements/{{ $ann->id }}/toggle" method="POST" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="field" value="pinned">
                                    <button type="submit" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;">
                                        {{ $ann->pinned ? 'Sabiti Kaldır' : 'Sabitle' }}
                                    </button>
                                </form>
                                <form action="/admin/announcements/{{ $ann->id }}/toggle" method="POST" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="field" value="is_active">
                                    <button type="submit" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;">
                                        {{ $ann->is_active ? 'Arşivle' : 'Yayınla' }}
                                    </button>
                                </form>
                                <form action="/admin/announcements/{{ $ann->id }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Bu duyuru silinsin mi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px; font-size: 12px;">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 24px; color: var(--ink-secondary);">Kayıtlı duyuru bulunmamaktadır.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 4. Job Postings Manipulation -->
    <section class="admin-section-card" id="jobs-section">
        <div class="admin-section-header">
            <div>
                <h2 class="admin-section-title">İş ve Staj İlanı Yönetimi</h2>
                <p style="font-size: 13px; color: var(--ink-secondary); margin-top: 4px;">
                    Yayınlanan kariyer ilanlarını inceleyebilir, düzenleyebilir veya kaldırabilirsiniz.
                </p>
            </div>
            <a href="/job-postings/create" class="btn btn-primary btn-sm">Yeni İlan Ekle</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pozisyon & Kurum</th>
                        <th>Yayınlayan</th>
                        <th>Başvuru</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobPostings as $job)
                        <tr>
                            <td style="font-family: var(--font-mono); font-size: 12px;">#{{ $job->id }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--iu-navy);">{{ $job->title }}</div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">{{ $job->company }} • {{ $job->city ?? 'Belirtilmedi' }}</div>
                            </td>
                            <td style="font-size: 12.5px;">{{ $job->user->name ?? 'Sistem' }}</td>
                            <td><span class="badge-pill badge-neutral">{{ $job->applications->count() }} Aday</span></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="/job-postings/{{ $job->id }}/edit" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;">Düzenle</a>
                                <form action="/admin/job-postings/{{ $job->id }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Bu iş ilanı kalıcı olarak silinsin mi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px; font-size: 12px;">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: var(--ink-secondary);">Kayıtlı iş ilanı bulunmamaktadır.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
