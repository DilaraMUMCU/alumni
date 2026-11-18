@extends('layouts.app')

@section('title', 'Kariyer Başvuruları Takip Paneli — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi Kariyer Kapısı aday iş ve staj başvuruları değerlendirme ve takip paneli.')

@push('styles')
<style>
    .apps-hero {
        margin-bottom: 32px;
    }

    .apps-controls-panel {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-subtle);
        margin-bottom: 28px;
    }

    .apps-table-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13.5px;
    }

    .custom-table th {
        background: var(--canvas-tint);
        color: var(--iu-navy);
        font-weight: 700;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-cream);
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .custom-table td {
        padding: 16px 18px;
        border-bottom: 1px solid rgba(12, 23, 84, 0.06);
        color: var(--ink-charcoal);
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: #FDFBF8;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Hero Header -->
    <div class="apps-hero">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <span class="badge-pill badge-mint" style="background: var(--mint-success-soft); color: #065F46; border: 1px solid var(--mint-success-border); margin-bottom: 8px;">
                    Aday Başvuruları
                </span>
                <h1 style="font-size: 36px; color: var(--iu-navy); margin-bottom: 8px;">
                    İş ve Staj <em>Başvuru Takibi</em>
                </h1>
                <p style="color: var(--ink-secondary); max-width: 700px;">
                    Yayınlanan pozisyonlara gelen aday başvurularını inceleyin, değerlendirme durumlarını yönetin.
                </p>
            </div>

            <a href="/applications/create" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Yeni Başvuru Gönder</span>
            </a>
        </div>
    </div>

    <!-- Status Filter Pills & Dropdown Controls -->
    <div class="apps-controls-panel">
        <div class="filter-pills-bar" style="margin-bottom: 18px;">
            <a href="/applications" class="filter-pill {{ !request('status') ? 'active' : '' }}">
                <span>Tüm Başvurular ({{ count($applications) }})</span>
            </a>
            <a href="/applications?status=pending" class="filter-pill {{ request('status') === 'pending' ? 'active' : '' }}">
                <span>Beklemede</span>
            </a>
            <a href="/applications?status=reviewing" class="filter-pill {{ request('status') === 'reviewing' ? 'active' : '' }}">
                <span>İnceleniyor</span>
            </a>
            <a href="/applications?status=shortlisted" class="filter-pill {{ request('status') === 'shortlisted' ? 'active' : '' }}">
                <span>Kısa Liste</span>
            </a>
            <a href="/applications?status=accepted" class="filter-pill {{ request('status') === 'accepted' ? 'active' : '' }}">
                <span>Kabul</span>
            </a>
            <a href="/applications?status=rejected" class="filter-pill {{ request('status') === 'rejected' ? 'active' : '' }}">
                <span>Reddedildi</span>
            </a>
        </div>

        <form action="/applications" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <div style="flex: 1; min-width: 220px;">
                <select name="job_posting_id" class="form-select" onchange="this.form.submit();">
                    <option value="">Tüm İlanlara Göre Filtrele...</option>
                    @foreach ($jobPostings as $jp)
                        <option value="{{ $jp->id }}" {{ request('job_posting_id') == $jp->id ? 'selected' : '' }}>
                            {{ $jp->title }} ({{ $jp->company }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 220px;">
                <select name="user_id" class="form-select" onchange="this.form.submit();">
                    <option value="">Adaya Göre Filtrele...</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (request('status') || request('job_posting_id') || request('user_id'))
                <a href="/applications" class="btn btn-secondary btn-sm">Filtreleri Temizle</a>
            @endif
        </form>
    </div>

    <!-- Applications Table Card -->
    <div class="apps-table-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Aday (Mezun / Öğrenci)</th>
                        <th>Başvurulan İlan & Kurum</th>
                        <th>Özgeçmiş / Not</th>
                        <th>Başvuru Tarihi</th>
                        <th>Değerlendirme Durumu</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        @php
                            $statusBadges = [
                                'pending'     => ['label' => 'Beklemede', 'class' => 'badge-amber'],
                                'reviewing'   => ['label' => 'İnceleniyor', 'class' => 'badge-sapphire'],
                                'shortlisted' => ['label' => 'Kısa Liste', 'class' => 'badge-gold'],
                                'accepted'    => ['label' => 'Kabul Edildi', 'class' => 'badge-success'],
                                'rejected'    => ['label' => 'Reddedildi', 'class' => 'badge-danger'],
                            ];
                            $sb = $statusBadges[$app->status] ?? ['label' => $app->status, 'class' => 'badge-neutral'];
                        @endphp
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--canvas-tint); border: 1px solid var(--border-cream); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--iu-navy); font-size: 14px;">
                                        {{ mb_substr($app->user ? $app->user->name : 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--iu-navy);">
                                            @if ($app->user)
                                                <a href="/users/{{ $app->user->id }}" style="color: inherit;">
                                                    {{ $app->user->name }}
                                                </a>
                                            @else
                                                Aday #{{ $app->user_id }}
                                            @endif
                                        </div>
                                        <div style="font-size: 12px; color: var(--ink-secondary);">
                                            {{ $app->user ? $app->user->email : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if ($app->jobPosting)
                                    <div style="font-weight: 600; color: var(--iu-navy);">
                                        <a href="/job-postings/{{ $app->jobPosting->id }}" style="color: inherit;">
                                            {{ $app->jobPosting->title }}
                                        </a>
                                    </div>
                                    <div style="font-size: 12px; color: var(--ink-secondary);">
                                        {{ $app->jobPosting->company }} • {{ $app->jobPosting->location }}
                                    </div>
                                @else
                                    <span style="color: var(--ink-muted);">Silinmiş İlan #{{ $app->job_posting_id }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($app->resume_url)
                                    <div>
                                        <a href="{{ $app->resume_url }}" target="_blank" rel="noopener" style="color: var(--academic-sapphire); font-weight: 600; font-size: 12.5px;">
                                            Özgeçmiş Belgesi ↗
                                        </a>
                                    </div>
                                @endif
                                @if ($app->cover_letter)
                                    <div style="font-size: 12px; color: var(--ink-secondary); max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $app->cover_letter }}">
                                        "{{ $app->cover_letter }}"
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div style="font-size: 12.5px; color: var(--ink-charcoal);">
                                    {{ \Carbon\Carbon::parse($app->applied_at)->format('d.m.Y') }}
                                </div>
                                <div style="font-size: 11px; color: var(--ink-muted);">
                                    {{ \Carbon\Carbon::parse($app->applied_at)->format('H:i') }}
                                </div>
                            </td>

                            <td>
                                <form action="/applications/{{ $app->id }}/status" method="POST" style="margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                                    @csrf
                                    @method('PATCH')
                                    <span class="badge-pill {{ $sb['class'] }}" style="font-size: 10px;">
                                        {{ $sb['label'] }}
                                    </span>
                                    <select name="status" class="form-select" style="padding: 4px 8px; font-size: 11px; width: auto;" onchange="this.form.submit();">
                                        <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Beklemede</option>
                                        <option value="reviewing" {{ $app->status === 'reviewing' ? 'selected' : '' }}>İnceleniyor</option>
                                        <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Kısa Liste</option>
                                        <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Kabul</option>
                                        <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Reddet</option>
                                    </select>
                                </form>
                            </td>

                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="/applications/{{ $app->id }}" class="btn btn-secondary btn-sm" style="padding: 5px 10px;" title="İncele">
                                        İncele
                                    </a>
                                    <form action="/applications/{{ $app->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu başvuru kaydı kalıcı olarak silinsin mi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px;" title="Sil">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px; color: var(--ink-secondary);">
                                <h4 style="font-size: 17px; color: var(--iu-navy); margin-bottom: 4px;">Başvuru Bulunamadı</h4>
                                <p style="font-size: 13px;">Seçilen kriterlere uygun başvuru kaydı bulunmamaktadır.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
