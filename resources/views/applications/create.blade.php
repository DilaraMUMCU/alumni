@extends('layouts.app')

@section('title', 'Yeni İş / Staj Başvurusu — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi Kariyer Kapısı doğrudan pozisyon başvurusu formu.')

@section('content')
<div class="container" style="max-width: 720px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="/applications" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Başvuru Paneline Dön</span>
        </a>
    </div>

    <!-- Create Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-mint" style="background: var(--mint-success-soft); color: #065F46; border: 1px solid var(--mint-success-border); margin-bottom: 6px;">
                    Aday Başvurusu
                </span>
                <h1 class="card-title" style="font-size: 26px;">Yeni Kariyer Başvurusu Yap</h1>
                <p class="card-subtitle">İlgilendiğiniz pozisyona mezun veya öğrenci profilinizle doğrudan başvuruda bulunun.</p>
            </div>
        </div>

        <form action="/applications" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="job_posting_id">Başvurulacak Pozisyon / İlan <span class="required">*</span></label>
                <select id="job_posting_id" name="job_posting_id" class="form-select" required>
                    <option value="">Lütfen başvurmak istediğiniz ilanı seçiniz...</option>
                    @foreach ($jobPostings as $job)
                        <option value="{{ $job->id }}" {{ (old('job_posting_id', $selectedJobId) == $job->id) ? 'selected' : '' }}>
                            {{ $job->title }} — {{ $job->company }} ({{ $job->location }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Başvuran Profil (Oturumunuz)</label>
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 16px; background: var(--canvas-tint); border: 1px solid var(--border-cream); border-radius: 12px;">
                    <div>
                        <div style="font-weight: 700; color: var(--iu-navy); font-size: 14.5px;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 12.5px; color: var(--ink-secondary);">{{ auth()->user()->email }} {{ auth()->user()->department ? "• " . auth()->user()->department : '' }}</div>
                    </div>
                    <span class="badge-pill {{ \App\Models\User::formatRoleBadgeClass(auth()->user()->role) }}" style="font-size: 11px;">
                        {{ \App\Models\User::formatRoleLabel(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="resume_url">Özgeçmiş / CV / Portfolyo Bağlantısı</label>
                <input type="url" id="resume_url" name="resume_url" class="form-control" placeholder="https://drive.google.com/... veya LinkedIn profili" value="{{ old('resume_url') }}">
                <div class="form-help">Google Drive, Dropbox, GitHub veya kişisel web sitenizin bağlantısını ekleyebilirsiniz.</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="cover_letter">Ön Yazı / Motivasyon Mektubu</label>
                <textarea id="cover_letter" name="cover_letter" class="form-control" rows="5" placeholder="Pozisyona olan ilginizi, yetkinliklerinizi ve kuruma katabileceğiniz değerleri açıklayınız...">{{ old('cover_letter') }}</textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/applications" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Başvuruyu Gönder</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
