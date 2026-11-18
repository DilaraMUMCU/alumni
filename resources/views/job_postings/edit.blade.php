@extends('layouts.app')

@section('title', "{$job->title} İlanını Düzenle — Kariyer Kapısı")
@section('meta_description', "İstanbul Üniversitesi Kariyer Kapısı {$job->title} ilanı güncelleme formu.")

@section('content')
<div class="container" style="max-width: 780px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <a href="/job-postings/{{ $job->id }}" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>İlana Dön</span>
        </a>

        <span class="badge-pill badge-neutral">İlan #{{ $job->id }}</span>
    </div>

    <!-- Edit Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-sapphire" style="margin-bottom: 6px;">İlan Düzenleme</span>
                <h1 class="card-title" style="font-size: 26px;">{{ $job->title }}</h1>
                <p class="card-subtitle">{{ $job->company }} bünyesindeki pozisyon detaylarını güncelleyin.</p>
            </div>
        </div>

        <form action="/job-postings/{{ $job->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="user_id">İlan Sahibi (Mezun / Şirket Temsilcisi) <span class="required">*</span></label>
                <select id="user_id" name="user_id" class="form-select" required>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id', $job->user_id) == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->current_company ?: $u->department }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="title">Pozisyon / İlan Başlığı <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" required value="{{ old('title', $job->title) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="employment_type">Çalışma Şekli <span class="required">*</span></label>
                    <select id="employment_type" name="employment_type" class="form-select" required>
                        <option value="full-time" {{ old('employment_type', $job->employment_type) === 'full-time' ? 'selected' : '' }}>💼 Tam Zamanlı</option>
                        <option value="internship" {{ old('employment_type', $job->employment_type) === 'internship' ? 'selected' : '' }}>🌱 Stajyer</option>
                        <option value="part-time" {{ old('employment_type', $job->employment_type) === 'part-time' ? 'selected' : '' }}>⏱️ Yarı Zamanlı</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="company">Kurum / Şirket Adı <span class="required">*</span></label>
                    <input type="text" id="company" name="company" class="form-control" required value="{{ old('company', $job->company) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="location">Çalışma Konumu / Lokasyon <span class="required">*</span></label>
                    <input type="text" id="location" name="location" class="form-control" required value="{{ old('location', $job->location) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="deadline">Son Başvuru Tarihi</label>
                    <input type="date" id="deadline" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="application_url">Harici Başvuru URL'i (Varsa)</label>
                    <input type="url" id="application_url" name="application_url" class="form-control" value="{{ old('application_url', $job->application_url) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">İş Tanımı ve Aranan Nitelikler <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="6" required>{{ old('description', $job->description) }}</textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/job-postings/{{ $job->id }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-sapphire btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Değişiklikleri Kaydet</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
