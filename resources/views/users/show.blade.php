@extends('layouts.app')

@php
    $uId = is_array($user) ? ($user['id'] ?? '') : $user->id;
    $uName = is_array($user) ? ($user['name'] ?? 'İsimsiz') : $user->name;
    $uEmail = is_array($user) ? ($user['email'] ?? '') : $user->email;
    $uRole = is_array($user) ? ($user['role'] ?? 'alumni') : ($user->role ?? 'alumni');
    $uDept = is_array($user) ? ($user['department'] ?? '') : ($user->department ?? '');
    $uYear = is_array($user) ? ($user['graduation_year'] ?? '') : ($user->graduation_year ?? '');
    $uTitle = is_array($user) ? ($user['job_title'] ?? '') : ($user->job_title ?? '');
    $uCompany = is_array($user) ? ($user['current_company'] ?? '') : ($user->current_company ?? '');
    $uLinkedIn = is_array($user) ? ($user['linkedin_url'] ?? '') : ($user->linkedin_url ?? '');
    $uSkills = is_array($user) ? ($user['skills'] ?? []) : ($user->skills ?? []);
    if (is_string($uSkills)) {
        $uSkills = array_filter(array_map('trim', explode(',', $uSkills)));
    }
    $uCreated = is_array($user) ? ($user['created_at'] ?? '') : ($user->created_at ?? '');
@endphp

@section('title', "{$uName} — Mezun Profili | İstanbul Üniversitesi")
@section('meta_description', "{$uName} İstanbul Üniversitesi {$uDept} mezun profil detayları ve profesyonel kariyer bilgileri.")

@push('styles')
<style>
    .profile-container {
        max-width: 840px;
        margin: 0 auto;
    }

    .profile-hero-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 40px;
        box-shadow: var(--shadow-card);
        margin-bottom: 28px;
    }

    .profile-header-flex {
        display: flex;
        align-items: center;
        gap: 28px;
        padding-bottom: 28px;
        border-bottom: 1px solid var(--border-cream);
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .profile-avatar-large {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--iu-navy) 0%, #1e3a8a 100%);
        color: #FFFFFF;
        font-family: var(--font-serif);
        font-size: 32px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(11, 27, 61, 0.2);
        border: 3px solid #FFFFFF;
        flex-shrink: 0;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    @media (max-width: 600px) {
        .profile-info-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-tile {
        background: var(--canvas-tint);
        border: 1px solid var(--border-cream);
        border-radius: 12px;
        padding: 16px 20px;
    }

    .info-tile-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--ink-secondary);
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-tile-val {
        font-size: 15px;
        color: var(--iu-navy);
        font-weight: 600;
    }

    .profile-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 24px;
        border-top: 1px solid var(--border-cream);
    }
</style>
@endpush

@section('content')
<div class="container profile-container">

    <!-- Top Breadcrumb / Navigation -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <a href="/users" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Mezun Rehberine Dön</span>
        </a>

        <div style="display: flex; gap: 8px;">
            <a href="/users/{{ $uId }}/edit" class="btn btn-secondary btn-sm">
                ✏️ Profili Düzenle
            </a>
            <form action="/users/{{ $uId }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu profil kalıcı olarak silinsin mi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    🗑️ Sil
                </button>
            </form>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="profile-hero-card">

        <!-- Header -->
        <div class="profile-header-flex">
            <div class="profile-avatar-large">
                {{ mb_substr($uName, 0, 1) }}
            </div>

            <div style="flex: 1; min-width: 240px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                    <h1 style="font-size: 28px; color: var(--iu-navy); margin: 0;">
                        {{ $uName }}
                    </h1>
                    <span class="badge-pill {{ $uRole === 'student' ? 'badge-amber' : ($uRole === 'academician' ? 'badge-gold' : 'badge-crimson') }}">
                        {{ $uRole === 'student' ? 'Öğrenci' : ($uRole === 'academician' ? 'Akademisyen' : 'Mezun') }}
                    </span>
                    <span class="badge-pill badge-neutral" style="font-size: 11px;">#{{ $uId }}</span>
                </div>

                <div style="font-size: 16px; font-weight: 600; color: var(--iu-crimson); margin-bottom: 4px;">
                    {{ $uTitle ?: 'Pozisyon Belirtilmedi' }}
                </div>

                <div style="font-size: 14px; color: var(--ink-secondary);">
                    {{ $uCompany ? "🏢 {$uCompany}" : '' }} {{ $uDept ? "• 🏛️ {$uDept}" : '' }}
                </div>
            </div>

            @if ($uLinkedIn)
                <div>
                    <a href="{{ $uLinkedIn }}" target="_blank" rel="noopener" class="btn btn-sapphire btn-sm">
                        <span>LinkedIn Profili ↗</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Info Grid -->
        <div class="profile-info-grid">
            <div class="info-tile">
                <div class="info-tile-label">E-Posta Adresi</div>
                <div class="info-tile-val">
                    <a href="mailto:{{ $uEmail }}" style="color: var(--academic-sapphire);">{{ $uEmail }}</a>
                </div>
            </div>

            <div class="info-tile">
                <div class="info-tile-label">Bölüm / Fakülte</div>
                <div class="info-tile-val">{{ $uDept ?: 'Belirtilmedi' }}</div>
            </div>

            <div class="info-tile">
                <div class="info-tile-label">Mezuniyet Yılı</div>
                <div class="info-tile-val">
                    @if ($uYear)
                        🎓 {{ $uYear }}
                    @else
                        Belirtilmedi
                    @endif
                </div>
            </div>

            <div class="info-tile">
                <div class="info-tile-label">Çalıştığı Kurum</div>
                <div class="info-tile-val">{{ $uCompany ?: 'Belirtilmedi' }}</div>
            </div>
        </div>

        <!-- Skills Section -->
        @if (!empty($uSkills))
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 14px; font-weight: 700; text-transform: uppercase; color: var(--iu-navy); letter-spacing: 0.5px; margin-bottom: 12px;">
                    Uzmanlık ve Yetenekler
                </h3>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach ((array)$uSkills as $skill)
                        <span class="badge-pill badge-neutral" style="font-size: 12px; padding: 6px 14px;">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Footer / Timestamps -->
        <div class="profile-actions-bar">
            <div style="font-size: 12px; color: var(--ink-muted);">
                Kayıt Tarihi: {{ $uCreated ? \Carbon\Carbon::parse($uCreated)->format('d.m.Y H:i') : 'Kayıtlı' }}
            </div>
            <a href="/users" class="btn btn-secondary btn-sm">Listeye Dön</a>
        </div>

    </div>

</div>
@endsection
