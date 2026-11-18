@extends('layouts.app')

@php
    $app = $application;
    $statusBadges = [
        'pending'     => ['label' => 'Beklemede', 'class' => 'badge-amber'],
        'reviewing'   => ['label' => 'İnceleniyor', 'class' => 'badge-sapphire'],
        'shortlisted' => ['label' => 'Kısa Liste', 'class' => 'badge-gold'],
        'accepted'    => ['label' => 'Kabul Edildi', 'class' => 'badge-success'],
        'rejected'    => ['label' => 'Reddedildi', 'class' => 'badge-danger'],
    ];
    $sb = $statusBadges[$app->status] ?? ['label' => $app->status, 'class' => 'badge-neutral'];
@endphp

@section('title', "Başvuru Detayı #{$app->id} — Kariyer Kapısı")
@section('meta_description', "Aday başvuru detayı ve değerlendirme durumu.")

@section('content')
<div class="container" style="max-width: 780px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <a href="/applications" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Başvuru Listesine Dön</span>
        </a>

        <form action="/applications/{{ $app->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu başvuru kaydı kalıcı olarak silinsin mi?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                Başvuruyu Sil
            </button>
        </form>
    </div>

    <!-- Application Detail Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <span class="badge-pill {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                    <span class="badge-pill badge-neutral">Başvuru #{{ $app->id }}</span>
                </div>
                <h1 class="card-title" style="font-size: 26px;">
                    {{ $app->jobPosting ? $app->jobPosting->title : 'İlan #' . $app->job_posting_id }}
                </h1>
                <p class="card-subtitle">
                    {{ $app->jobPosting ? $app->jobPosting->company : '' }} bünyesindeki pozisyon için aday başvurusu.
                </p>
            </div>

            <!-- Quick Status Change Form -->
            <form action="/applications/{{ $app->id }}/status" method="POST" style="display: flex; align-items: center; gap: 8px; margin: 0;">
                @csrf
                @method('PATCH')
                <label style="font-size: 12px; font-weight: 700; color: var(--ink-secondary);">Durum:</label>
                <select name="status" class="form-select" style="padding: 6px 12px; font-size: 13px; width: auto;" onchange="this.form.submit();">
                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Beklemede</option>
                    <option value="reviewing" {{ $app->status === 'reviewing' ? 'selected' : '' }}>İnceleniyor</option>
                    <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Kısa Liste</option>
                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Kabul Edildi</option>
                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                </select>
            </form>
        </div>

        <!-- Candidate Profile Matrix -->
        <div style="background: var(--canvas-tint); border: 1px solid var(--border-cream); border-radius: 14px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--iu-navy); color: #FFFFFF; font-family: var(--font-serif); font-size: 20px; font-weight: 700; display: flex; align-items: center; justify-content: center;">
                    {{ mb_substr($app->user ? $app->user->name : 'A', 0, 1) }}
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: var(--iu-navy); margin: 0;">
                        {{ $app->user ? $app->user->name : 'Aday #' . $app->user_id }}
                    </h3>
                    <div style="font-size: 13px; color: var(--ink-secondary);">
                        {{ $app->user ? $app->user->email : '' }} {{ $app->user && $app->user->department ? "• {$app->user->department}" : '' }}
                    </div>
                </div>
            </div>

            @if ($app->user)
                <a href="/users/{{ $app->user->id }}" class="btn btn-secondary btn-sm">
                    Aday Profilini Aç ↗
                </a>
            @endif
        </div>

        <!-- Cover Letter -->
        @if ($app->cover_letter)
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: var(--iu-navy); letter-spacing: 0.5px; margin-bottom: 8px;">
                    Ön Yazı / Motivasyon Mektubu
                </h4>
                <div style="background: #FFFFFF; border: 1px solid var(--border-cream); border-radius: 12px; padding: 18px; font-size: 14px; line-height: 1.6; color: var(--ink-charcoal); white-space: pre-line;">
                    {{ $app->cover_letter }}
                </div>
            </div>
        @endif

        <!-- CV / Resume Link -->
        <div style="margin-bottom: 24px;">
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: var(--iu-navy); letter-spacing: 0.5px; margin-bottom: 8px;">
                Özgeçmiş Belgesi
            </h4>
            @if ($app->resume_url)
                <a href="{{ $app->resume_url }}" target="_blank" rel="noopener" class="btn btn-sapphire btn-sm">
                    Ekli Özgeçmişi Görüntüle ↗
                </a>
            @else
                <span style="font-size: 13.5px; color: var(--ink-secondary);">Bu başvuruya harici özgeçmiş linki eklenmemiştir.</span>
            @endif
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--border-cream); font-size: 12px; color: var(--ink-muted); display: flex; justify-content: space-between; align-items: center;">
            <span>Başvuru Tarihi: {{ \Carbon\Carbon::parse($app->applied_at)->format('d.m.Y H:i:s') }}</span>
            <a href="/job-postings/{{ $app->job_posting_id }}" class="btn btn-secondary btn-sm">İlgili İlanı İncele</a>
        </div>
    </div>

</div>
@endsection
