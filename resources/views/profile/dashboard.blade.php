@extends('layouts.app')

@section('title', 'Kişisel Aktivite Panelim — İstanbul Üniversitesi Mezun Portalı')
@section('meta_description', 'Kullanıcıya özel kariyer başvuruları, yayınlanan ilanlar ve etkinlik kayıtları.')

@section('content')
<div class="container" style="max-width: 1080px;">

    <!-- Top Personal Header -->
    <div class="card" style="padding: 30px 34px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 18px;">
        <div>
            <span class="badge-pill {{ \App\Models\User::formatRoleBadgeClass($user->role) }}" style="margin-bottom: 8px;">
                {{ \App\Models\User::formatRoleLabel($user->role) }}
            </span>
            <h1 style="font-size: 28px; color: var(--iu-navy); margin: 0 0 6px 0;">
                Hoş Geldiniz, {{ $user->name }}
            </h1>
            <p style="font-size: 13.5px; color: var(--ink-secondary); margin: 0;">
                {{ $user->department }} {{ $user->current_company ? "• {$user->current_company}" : '' }}
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="/profile/settings" class="btn btn-primary btn-sm">Profil Ayarları</a>
            <a href="/users/{{ $user->id }}" class="btn btn-secondary btn-sm">Açık Profilim</a>
            @if ($user->isAdmin())
                <a href="/admin" class="btn btn-gold btn-sm">Admin Paneli</a>
            @endif
        </div>
    </div>

    <!-- User Summary Stats -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 26px;">
        <div class="card" style="padding: 20px 24px;">
            <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--ink-secondary);">Başvurularım</div>
            <div style="font-family: var(--font-serif); font-size: 30px; font-weight: 700; color: var(--iu-navy); margin-top: 6px;">
                {{ $user->applications->count() }}
            </div>
        </div>
        <div class="card" style="padding: 20px 24px;">
            <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--ink-secondary);">Yayınladığım İlanlar</div>
            <div style="font-family: var(--font-serif); font-size: 30px; font-weight: 700; color: var(--iu-navy); margin-top: 6px;">
                {{ $user->jobPostings->count() }}
            </div>
        </div>
        <div class="card" style="padding: 20px 24px;">
            <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--ink-secondary);">Etkinlik Kayıtlarım</div>
            <div style="font-family: var(--font-serif); font-size: 30px; font-weight: 700; color: var(--iu-navy); margin-top: 6px;">
                {{ $user->events->count() }}
            </div>
        </div>
    </div>

    @if ($user->isUnverified())
        <div class="card" style="padding: 26px 30px; border-left: 4px solid var(--iu-gold); background: var(--canvas-tint); margin-bottom: 24px;">
            <h2 style="font-size: 18px; color: var(--iu-navy); margin-bottom: 6px;">Doğrulama Bekleniyor</h2>
            <p style="font-size: 13.5px; color: var(--ink-charcoal); margin: 0 0 14px 0;">
                Hesabınız şu anda <strong>Doğrulanmamış (unverified)</strong> statüsündedir. Doğrulama tamamlanana kadar profil bilgilerinizi güncelleyebilir, ilanları ve duyuruları inceleyebilirsiniz.
            </p>
            <a href="/profile/settings" class="btn btn-primary btn-sm">Profil Bilgilerimi Tamamla</a>
        </div>
    @endif

    <!-- My Job Applications (Students / Alumni / All with applications) -->
    @if ($user->canApplyToJobs() || $user->applications->isNotEmpty())
        <div class="card" style="padding: 28px 30px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border-cream);">
                <h2 style="font-size: 20px; color: var(--iu-navy); margin: 0;">İş ve Staj Başvurularım</h2>
                @if ($user->canApplyToJobs())
                    <a href="/applications/create" class="btn btn-primary btn-sm">Yeni Başvuru Yap</a>
                @endif
            </div>

            @forelse ($user->applications as $app)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid var(--border-cream); flex-wrap: wrap; gap: 10px;">
                    <div>
                        <div style="font-weight: 700; color: var(--iu-navy);">{{ $app->jobPosting->title ?? 'İlan' }}</div>
                        <div style="font-size: 12.5px; color: var(--ink-secondary);">{{ $app->jobPosting->company ?? '' }}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="badge-pill badge-neutral">{{ ucfirst($app->status) }}</span>
                        <a href="/applications/{{ $app->id }}" class="btn btn-secondary btn-sm">Detay</a>
                    </div>
                </div>
            @empty
                <p style="font-size: 13.5px; color: var(--ink-secondary); margin: 0;">Henüz bir iş veya staj başvurunuz bulunmamaktadır.</p>
            @endforelse
        </div>
    @endif

    <!-- My Published Job Postings (Alumni / Admin) -->
    @if ($user->canPublishJobs() || $user->jobPostings->isNotEmpty())
        <div class="card" style="padding: 28px 30px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border-cream);">
                <h2 style="font-size: 20px; color: var(--iu-navy); margin: 0;">Yayınladığım Kariyer İlanları</h2>
                <a href="/job-postings/create" class="btn btn-primary btn-sm">Yeni İlan Yayınla</a>
            </div>

            @forelse ($user->jobPostings as $job)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid var(--border-cream); flex-wrap: wrap; gap: 10px;">
                    <div>
                        <div style="font-weight: 700; color: var(--iu-navy);">{{ $job->title }}</div>
                        <div style="font-size: 12.5px; color: var(--ink-secondary);">{{ $job->company }} • {{ $job->city ?? 'Belirtilmedi' }}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="badge-pill badge-crimson">{{ $job->applications->count() }} Başvuru</span>
                        <a href="/job-postings/{{ $job->id }}/edit" class="btn btn-secondary btn-sm">Düzenle</a>
                    </div>
                </div>
            @empty
                <p style="font-size: 13.5px; color: var(--ink-secondary); margin: 0;">Henüz yayınladığınız bir iş ilanı bulunmamaktadır.</p>
            @endforelse
        </div>
    @endif

</div>
@endsection
