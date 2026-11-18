@extends('layouts.app')

@php
    $uId = is_array($user) ? ($user['id'] ?? '') : $user->id;
    $uName = is_array($user) ? ($user['name'] ?? '') : $user->name;
    $uEmail = is_array($user) ? ($user['email'] ?? '') : $user->email;
    $uRole = is_array($user) ? ($user['role'] ?? 'alumni') : ($user->role ?? 'alumni');
    $uDept = is_array($user) ? ($user['department'] ?? '') : ($user->department ?? '');
    $uYear = is_array($user) ? ($user['graduation_year'] ?? '') : ($user->graduation_year ?? '');
    $uTitle = is_array($user) ? ($user['job_title'] ?? '') : ($user->job_title ?? '');
    $uCompany = is_array($user) ? ($user['current_company'] ?? '') : ($user->current_company ?? '');
    $uLinkedIn = is_array($user) ? ($user['linkedin_url'] ?? '') : ($user->linkedin_url ?? '');
    $uSkills = is_array($user) ? ($user['skills'] ?? []) : ($user->skills ?? []);
    if (is_array($uSkills)) {
        $uSkills = implode(', ', $uSkills);
    }
@endphp

@section('title', "{$uName} Profilini Düzenle — İstanbul Üniversitesi")
@section('meta_description', "İstanbul Üniversitesi Mezun Portalı {$uName} profil bilgilerini güncelleme formu.")

@section('content')
<div class="container" style="max-width: 720px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <a href="/users/{{ $uId }}" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Profile Dön</span>
        </a>

        <span class="badge-pill badge-neutral">Kullanıcı #{{ $uId }}</span>
    </div>

    <!-- Edit Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-gold" style="margin-bottom: 6px;">Profil Güncelleme</span>
                <h1 class="card-title" style="font-size: 26px;">{{ $uName }}</h1>
                <p class="card-subtitle">Profil detaylarını, iletişim ve kariyer bilgilerini güncelleyin.</p>
            </div>
        </div>

        <form action="/users/{{ $uId }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="name">Ad Soyad <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required value="{{ old('name', $uName) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email', $uEmail) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="role">Üyelik Rolü <span class="required">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="alumni" {{ old('role', $uRole) === 'alumni' ? 'selected' : '' }}>Mezun</option>
                        <option value="student" {{ old('role', $uRole) === 'student' ? 'selected' : '' }}>Öğrenci</option>
                        <option value="academician" {{ old('role', $uRole) === 'academician' ? 'selected' : '' }}>Akademisyen</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="graduation_year">Mezuniyet Yılı</label>
                    <input type="number" id="graduation_year" name="graduation_year" class="form-control" min="1950" max="2035" value="{{ old('graduation_year', $uYear) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="department">Bölüm / Fakülte</label>
                <input type="text" id="department" name="department" class="form-control" value="{{ old('department', $uDept) }}">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="job_title">Mevcut Ünvan / Pozisyon</label>
                    <input type="text" id="job_title" name="job_title" class="form-control" value="{{ old('job_title', $uTitle) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="current_company">Çalıştığı Kurum / Şirket</label>
                    <input type="text" id="current_company" name="current_company" class="form-control" value="{{ old('current_company', $uCompany) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="linkedin_url">LinkedIn Profil Bağlantısı</label>
                <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $uLinkedIn) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="skills">Yetenekler & Uzmanlık Alanları</label>
                <input type="text" id="skills" name="skills" class="form-control" value="{{ old('skills', $uSkills) }}">
                <div class="form-help">Yetenekleri aralarına virgül koyarak güncelleyebilirsiniz.</div>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/users/{{ $uId }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Değişiklikleri Kaydet</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
