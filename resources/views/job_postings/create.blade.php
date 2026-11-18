@extends('layouts.app')

@section('title', 'Yeni Kariyer İlanı Yayınla — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi Kariyer Kapısı yeni iş veya staj ilanı yayınlama formu.')

@section('content')
<div class="container" style="max-width: 780px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="/job-postings" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>İlanlara Dön</span>
        </a>
    </div>

    <!-- Create Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-sapphire" style="margin-bottom: 6px;">İlan Yönetimi</span>
                <h1 class="card-title" style="font-size: 26px;">Yeni Kariyer / Staj İlanı</h1>
                <p class="card-subtitle">Mezunlarımız ve öğrencilerimiz için yeni bir istihdam veya staj fırsatı oluşturun.</p>
            </div>
        </div>

        <form action="/job-postings" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="user_id">İlan Sahibi (Mezun / Şirket Temsilcisi) <span class="required">*</span></label>
                <select id="user_id" name="user_id" class="form-select" required>
                    <option value="">Lütfen ilan sahibini seçiniz...</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->current_company ?: $u->department }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="title">Pozisyon / İlan Başlığı <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Örn: Senior Backend Developer" required value="{{ old('title') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="employment_type">Çalışma Şekli <span class="required">*</span></label>
                    <select id="employment_type" name="employment_type" class="form-select" required>
                        <option value="full-time" {{ old('employment_type') === 'full-time' ? 'selected' : '' }}>Tam Zamanlı</option>
                        <option value="internship" {{ old('employment_type') === 'internship' ? 'selected' : '' }}>Stajyer</option>
                        <option value="part-time" {{ old('employment_type') === 'part-time' ? 'selected' : '' }}>Yarı Zamanlı</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="company">Kurum / Şirket Adı <span class="required">*</span></label>
                    <input type="text" id="company" name="company" class="form-control" placeholder="Örn: İstanbul Üniversitesi Teknokent" required value="{{ old('company') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="location">Çalışma Konumu / Lokasyon <span class="required">*</span></label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Örn: İstanbul (Hibrit / Maslak)" required value="{{ old('location') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="deadline">Son Başvuru Tarihi</label>
                    <input type="date" id="deadline" name="deadline" class="form-control" value="{{ old('deadline') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="application_url">Harici Başvuru URL'i (Varsa)</label>
                    <input type="url" id="application_url" name="application_url" class="form-control" placeholder="https://careers.sirket.com/ilan/123" value="{{ old('application_url') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">İş Tanımı ve Aranan Nitelikler <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="6" placeholder="Pozisyonun sorumlulukları, aranan teknik yetkinlikler ve yan haklar..." required>{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/job-postings" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-sapphire btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>İlanı Yayına Al</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
