@extends('layouts.app')

@section('title', 'Kariyer ve Staj Kapısı — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi mezunları ve öğrencileri için tam zamanlı iş, staj ve proje fırsatları.')

@push('styles')
<style>
    .jobs-hero {
        margin-bottom: 32px;
    }

    .jobs-controls-panel {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-subtle);
        margin-bottom: 28px;
    }

    .jobs-filter-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .jobs-search-form {
        display: flex;
        gap: 12px;
        flex: 1;
        min-width: 300px;
    }

    .jobs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    @media (max-width: 900px) {
        .jobs-grid {
            grid-template-columns: 1fr;
        }
    }

    .job-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
    }

    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
        border-color: rgba(29, 78, 216, 0.35);
    }

    .job-card-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }

    .company-logo-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--canvas-tint);
        border: 1px solid var(--border-cream);
        color: var(--iu-navy);
        font-family: var(--font-serif);
        font-size: 19px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .job-card-title {
        font-family: var(--font-sans);
        font-size: 17px;
        font-weight: 700;
        color: var(--iu-navy);
        line-height: 1.3;
        margin-bottom: 4px;
    }

    .job-card-company {
        font-size: 13.5px;
        color: var(--ink-charcoal);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .job-meta-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 14px 0;
        font-size: 12px;
        color: var(--ink-secondary);
    }

    .job-card-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid rgba(12, 23, 84, 0.06);
        margin-top: auto;
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Hero Header -->
    <div class="jobs-hero">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <span class="badge-pill badge-sapphire" style="margin-bottom: 8px;">Kariyer Kapısı</span>
                <h1 style="font-size: 36px; color: var(--iu-navy); margin-bottom: 8px;">
                    İş ve Staj <em>Fırsatları</em>
                </h1>
                <p style="color: var(--ink-secondary); max-width: 700px;">
                    İstanbul Üniversitesi mezunları ve kurumsal ortaklar tarafından açılan profesyonel kariyer pozisyonları.
                </p>
            </div>

            <a href="/job-postings/create" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Yeni İlan Yayınla</span>
            </a>
        </div>
    </div>

    <!-- Controls & Filter Pills -->
    <div class="jobs-controls-panel">
        <div class="filter-pills-bar" style="margin-bottom: 18px;">
            <a href="/job-postings" class="filter-pill {{ !request('employment_type') ? 'active' : '' }}">
                <span>Tüm İlanlar</span>
                <span style="font-size: 11px; opacity: 0.8;">({{ count($jobs) }})</span>
            </a>
            <a href="/job-postings?employment_type=full-time{{ request('search') ? '&search='.urlencode(request('search')) : '' }}" class="filter-pill {{ request('employment_type') === 'full-time' ? 'active' : '' }}">
                <span>Tam Zamanlı</span>
            </a>
            <a href="/job-postings?employment_type=internship{{ request('search') ? '&search='.urlencode(request('search')) : '' }}" class="filter-pill {{ request('employment_type') === 'internship' ? 'active' : '' }}">
                <span>Staj</span>
            </a>
            <a href="/job-postings?employment_type=part-time{{ request('search') ? '&search='.urlencode(request('search')) : '' }}" class="filter-pill {{ request('employment_type') === 'part-time' ? 'active' : '' }}">
                <span>Yarı Zamanlı</span>
            </a>
        </div>

        <form action="/job-postings" method="GET" class="jobs-filter-row">
            @if (request('employment_type'))
                <input type="hidden" name="employment_type" value="{{ request('employment_type') }}">
            @endif

            <div class="jobs-search-form">
                <input type="text" name="search" class="form-control" placeholder="Pozisyon adı, şirket veya şehir ara..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sapphire">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Filtrele</span>
                </button>
            </div>

            @if (request('search') || request('employment_type'))
                <a href="/job-postings" class="btn btn-secondary btn-sm">Filtreleri Temizle</a>
            @endif
        </form>
    </div>

    <!-- Jobs Grid -->
    <div class="jobs-grid">
        @forelse ($jobs as $job)
            <div class="job-card">
                <div>
                    <div class="job-card-header">
                        <div class="company-logo-avatar">
                            {{ mb_substr($job->company, 0, 1) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <h3 class="job-card-title">
                                    <a href="/job-postings/{{ $job->id }}" style="color: var(--iu-navy);">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <span class="badge-pill {{ $job->employment_type === 'internship' ? 'badge-amber' : ($job->employment_type === 'part-time' ? 'badge-sapphire' : 'badge-crimson') }}" style="font-size: 10.5px;">
                                    {{ $job->employment_type_label ?? ($job->employment_type === 'internship' ? 'Staj' : ($job->employment_type === 'part-time' ? 'Yarı Zamanlı' : 'Tam Zamanlı')) }}
                                </span>
                            </div>
                            <div class="job-card-company">
                                <span>{{ $job->company }}</span>
                                <span>•</span>
                                <span>{{ $job->location }}</span>
                            </div>
                        </div>
                    </div>

                    <p style="font-size: 13.5px; color: var(--ink-secondary); line-height: 1.5; margin-bottom: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $job->description }}
                    </p>

                    <div class="job-meta-chips">
                        @if ($job->deadline)
                            <span class="badge-pill badge-neutral" style="font-size: 11px;">
                                Son Başvuru: {{ \Carbon\Carbon::parse($job->deadline)->format('d.m.Y') }}
                            </span>
                        @endif

                        <span class="badge-pill badge-neutral" style="font-size: 11px;">
                            {{ count($job->applications ?? []) }} Başvuru
                        </span>

                        @if ($job->user)
                            <span class="badge-pill badge-neutral" style="font-size: 11px;">
                                İlan Sahibi: {{ $job->user->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="job-card-actions">
                    <div style="display: flex; gap: 8px;">
                        <a href="/job-postings/{{ $job->id }}" class="btn btn-secondary btn-sm">
                            İncele & Başvur ↗
                        </a>
                        <a href="/applications/create?job_posting_id={{ $job->id }}" class="btn btn-primary btn-sm">
                            Hızlı Başvur
                        </a>
                    </div>

                    <div style="display: flex; gap: 6px;">
                        <a href="/job-postings/{{ $job->id }}/edit" class="btn btn-secondary btn-sm" style="padding: 5px 10px;" title="Düzenle">
                            Düzenle
                        </a>
                        <form action="/job-postings/{{ $job->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu ilan kalıcı olarak silinsin mi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px;" title="Sil">
                                Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px; color: var(--ink-secondary);">
                <h4 style="font-size: 18px; color: var(--iu-navy); margin-bottom: 6px;">Aktif İlan Bulunamadı</h4>
                <p style="font-size: 13.5px; margin-bottom: 16px;">Arama kriterlerinize uygun ilan bulunmamaktadır.</p>
                <a href="/job-postings/create" class="btn btn-primary btn-sm">+ Yeni İlan Ekleyin</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
