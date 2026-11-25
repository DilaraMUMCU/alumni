@extends('layouts.app')

@section('title', 'Yeni Mezun / Öğrenci Kaydı — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi Mezun ve Kariyer Portalı yeni profil oluşturma formu.')

@section('content')
<div class="container" style="max-width: 720px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="/users" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Mezun Rehberine Dön</span>
        </a>
    </div>

    <!-- Registration Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-crimson" style="margin-bottom: 6px;">Kayıt İşlemleri</span>
                <h1 class="card-title" style="font-size: 26px;">Yeni Mezun veya Öğrenci Profili</h1>
                <p class="card-subtitle">İstanbul Üniversitesi topluluğuna katılmak veya yeni profil tanımlamak için aşağıdaki bilgileri doldurun.</p>
            </div>
        </div>

        <form action="/users" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="name">Ad Soyad <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Örn: Dr. Ahmet Yılmaz" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Örn: ahmet@istanbul.edu.tr" required value="{{ old('email') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="role">Üyelik Rolü <span class="required">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="unverified" {{ old('role') === 'unverified' ? 'selected' : '' }}>Doğrulanmamış</option>
                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Öğrenci</option>
                        <option value="alumni" {{ old('role', 'alumni') === 'alumni' ? 'selected' : '' }}>Mezun</option>
                        <option value="academics" {{ in_array(old('role'), ['academics', 'academician'], true) ? 'selected' : '' }}>Akademisyen</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Yönetici</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="graduation_year">Mezuniyet Yılı</label>
                    <input type="number" id="graduation_year" name="graduation_year" class="form-control" placeholder="2022" min="1950" max="2035" value="{{ old('graduation_year') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="department">Bölüm / Fakülte</label>
                <input type="text" id="department" name="department" class="form-control" placeholder="Örn: Hukuk Fakültesi / Bilgisayar Mühendisliği" value="{{ old('department') }}">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="job_title">Mevcut Ünvan / Pozisyon</label>
                    <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Örn: Avukat / Yazılım Mühendisi" value="{{ old('job_title') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="current_company">Çalıştığı Kurum / Şirket</label>
                    <input type="text" id="current_company" name="current_company" class="form-control" placeholder="Örn: ASELSAN / Google" value="{{ old('current_company') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="linkedin_url">LinkedIn Profil Bağlantısı</label>
                <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/kullaniciadi" value="{{ old('linkedin_url') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="skills">Yetenekler & Uzmanlık Alanları</label>
                <input type="text" id="skills" name="skills" class="form-control" placeholder="Hukuk, Bilişim Hukuku veya Python, Cloud, AI" value="{{ old('skills') }}">
                <div class="form-help">Yetenekleri aralarına virgül koyarak yazabilirsiniz.</div>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/users" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Profili Oluştur ve Kaydet</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
