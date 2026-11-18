@extends('layouts.app')

@section('title', "{$job->title} — {$job->company} | Kariyer Kapısı")
@section('meta_description', "{$job->company} tarafından yayınlanan {$job->title} ilanı detayları ve başvuru formu.")

@push('styles')
<style>
    .job-detail-layout {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 32px;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .job-detail-layout {
            grid-template-columns: 1fr;
        }
    }

    .job-main-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 36px;
        box-shadow: var(--shadow-card);
    }

    .job-spec-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin: 24px 0;
    }

    @media (max-width: 500px) {
        .job-spec-grid {
            grid-template-columns: 1fr;
        }
    }

    .job-spec-item {
        background: var(--canvas-tint);
        border: 1px solid var(--border-cream);
        border-radius: 12px;
        padding: 14px 18px;
    }

    .job-spec-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--ink-secondary);
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .job-spec-val {
        font-size: 14.5px;
        color: var(--iu-navy);
        font-weight: 600;
    }

    .applicant-item {
        background: var(--canvas-tint);
        border: 1px solid var(--border-cream);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .applicant-item:hover {
        background: #FFFFFF;
        border-color: rgba(12, 23, 84, 0.15);
        box-shadow: var(--shadow-subtle);
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Top Breadcrumb -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <a href="/job-postings" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>İş İlanlarına Dön</span>
        </a>

        <div style="display: flex; gap: 8px;">
            <a href="/job-postings/{{ $job->id }}/edit" class="btn btn-secondary btn-sm">
                ✏️ İlanı Düzenle
            </a>
            <form action="/job-postings/{{ $job->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu ilan kalıcı olarak silinsin mi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    🗑️ İlanı Sil
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="job-detail-layout">

        <!-- Left Column: Job Description & Specifications -->
        <div class="job-main-card">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 16px; flex-wrap: wrap;">
                <div>
                    <span class="badge-pill {{ $job->employment_type === 'internship' ? 'badge-amber' : ($job->employment_type === 'part-time' ? 'badge-sapphire' : 'badge-crimson') }}" style="margin-bottom: 8px;">
                        {{ $job->employment_type_label ?? ($job->employment_type === 'internship' ? 'Staj' : ($job->employment_type === 'part-time' ? 'Yarı Zamanlı' : 'Tam Zamanlı')) }}
                    </span>
                    <h1 style="font-size: 28px; color: var(--iu-navy); margin-bottom: 4px;">
                        {{ $job->title }}
                    </h1>
                    <div style="font-size: 15px; color: var(--ink-charcoal); font-weight: 600;">
                        🏢 {{ $job->company }} • 📍 {{ $job->location }}
                    </div>
                </div>

                @if ($job->application_url)
                    <a href="{{ $job->application_url }}" target="_blank" rel="noopener" class="btn btn-sapphire">
                        <span>Harici Başvuru Sayfası ↗</span>
                    </a>
                @endif
            </div>

            <!-- Job Spec Matrix -->
            <div class="job-spec-grid">
                <div class="job-spec-item">
                    <div class="job-spec-label">Çalışma Şekli</div>
                    <div class="job-spec-val">
                        {{ $job->employment_type === 'internship' ? 'Staj' : ($job->employment_type === 'part-time' ? 'Yarı Zamanlı' : 'Tam Zamanlı') }}
                    </div>
                </div>

                <div class="job-spec-item">
                    <div class="job-spec-label">Lokasyon</div>
                    <div class="job-spec-val">📍 {{ $job->location }}</div>
                </div>

                <div class="job-spec-item">
                    <div class="job-spec-label">Son Başvuru Tarihi</div>
                    <div class="job-spec-val">
                        {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d.m.Y') : 'Belirtilmedi' }}
                    </div>
                </div>

                <div class="job-spec-item">
                    <div class="job-spec-label">İlanı Yayınlayan</div>
                    <div class="job-spec-val">
                        {{ $job->user ? $job->user->name : 'Kurumsal / Sistem' }}
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-top: 28px;">
                <h3 style="font-family: var(--font-serif); font-size: 20px; color: var(--iu-navy); margin-bottom: 12px;">
                    Pozisyon Detayı ve Aranan Nitelikler
                </h3>
                <div style="font-size: 14.5px; color: var(--ink-charcoal); line-height: 1.7; white-space: pre-line;">
                    {{ $job->description }}
                </div>
            </div>

            <!-- Applicants List -->
            <div style="margin-top: 40px; padding-top: 28px; border-top: 1px solid var(--border-cream);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                    <h3 style="font-family: var(--font-serif); font-size: 20px; color: var(--iu-navy);">
                        Aday Başvuruları
                    </h3>
                    <span class="badge-pill badge-neutral">
                        {{ count($job->applications ?? []) }} Başvuru
                    </span>
                </div>

                @forelse ($job->applications as $app)
                    <div class="applicant-item">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 8px;">
                            <div>
                                <div style="font-weight: 700; color: var(--iu-navy); font-size: 14.5px;">
                                    {{ $app->user ? $app->user->name : 'Aday #' . $app->user_id }}
                                </div>
                                <div style="font-size: 12px; color: var(--ink-secondary);">
                                    {{ $app->user ? $app->user->email : '' }} • Başvuru: {{ \Carbon\Carbon::parse($app->applied_at)->format('d.m.Y H:i') }}
                                </div>
                            </div>

                            @php
                                $statusBadges = [
                                    'pending'     => ['label' => 'Beklemede', 'class' => 'badge-amber'],
                                    'reviewing'   => ['label' => 'İnceleniyor', 'class' => 'badge-sapphire'],
                                    'shortlisted' => ['label' => 'Kısa Listede', 'class' => 'badge-gold'],
                                    'accepted'    => ['label' => 'Kabul Edildi', 'class' => 'badge-success'],
                                    'rejected'    => ['label' => 'Reddedildi', 'class' => 'badge-danger'],
                                ];
                                $sb = $statusBadges[$app->status] ?? ['label' => $app->status, 'class' => 'badge-neutral'];
                            @endphp

                            <span class="badge-pill {{ $sb['class'] }}" style="font-size: 10px;">
                                {{ $sb['label'] }}
                            </span>
                        </div>

                        @if ($app->cover_letter)
                            <p style="font-size: 13px; color: var(--ink-charcoal); line-height: 1.5; margin: 8px 0; background: #FFFFFF; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-cream);">
                                "{{ $app->cover_letter }}"
                            </p>
                        @endif

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 10px; font-size: 12px;">
                            @if ($app->resume_url)
                                <a href="{{ $app->resume_url }}" target="_blank" rel="noopener" style="color: var(--academic-sapphire); font-weight: 600;">
                                    📄 Özgeçmiş (CV) Linki ↗
                                </a>
                            @else
                                <span style="color: var(--ink-muted);">CV eklenmemiş</span>
                            @endif

                            <!-- Quick Status Update Form -->
                            <form action="/applications/{{ $app->id }}/status" method="POST" style="display: flex; align-items: center; gap: 6px; margin: 0;">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select" style="padding: 4px 8px; font-size: 11px; width: auto;" onchange="this.form.submit();">
                                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Beklemede</option>
                                    <option value="reviewing" {{ $app->status === 'reviewing' ? 'selected' : '' }}>İnceleniyor</option>
                                    <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Kısa Liste</option>
                                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Kabul</option>
                                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Red</option>
                                </select>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px; color: var(--ink-secondary); font-size: 13.5px;">
                        Bu ilana henüz aday başvurusu yapılmamıştır.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Quick Application Form -->
        <aside class="card" style="padding: 28px; position: sticky; top: 100px;">
            <div class="card-header" style="margin-bottom: 16px;">
                <div>
                    <span class="badge-pill badge-crimson" style="font-size: 10.5px;">Hemen Başvur</span>
                    <h3 class="card-title" style="font-size: 20px; margin-top: 4px;">Aday Başvuru Formu</h3>
                </div>
            </div>

            <form action="/applications" method="POST">
                @csrf
                <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
                <input type="hidden" name="redirect_to" value="/job-postings/{{ $job->id }}">

                <div class="form-group">
                    <label class="form-label" for="user_id">Başvuran Mezun / Öğrenci <span class="required">*</span></label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="">Lütfen profilinizi seçiniz...</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="resume_url">Özgeçmiş / Portfolyo Bağlantısı</label>
                    <input type="url" id="resume_url" name="resume_url" class="form-control" placeholder="https://drive.google.com/... veya LinkedIn" value="{{ old('resume_url') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="cover_letter">Ön Yazı / Motivasyon Notu</label>
                    <textarea id="cover_letter" name="cover_letter" class="form-control" rows="4" placeholder="Neden bu pozisyona uygun olduğunuzu ve deneyimlerinizi kısaca aktarınız...">{{ old('cover_letter') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Başvuruyu Tamamla</span>
                </button>
            </form>
        </aside>

    </div>

</div>
@endsection
