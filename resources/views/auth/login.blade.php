@extends('layouts.app')

@section('title', 'Üye Girişi — İstanbul Üniversitesi Mezun ve Kariyer Portalı')
@section('meta_description', 'İstanbul Üniversitesi Mezun ve Kariyer Portalı oturum açma sayfası.')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 16px; margin-bottom: 48px;">
    <div class="card" style="padding: 40px 36px;">
        <div style="text-align: center; margin-bottom: 26px; padding-bottom: 20px; border-bottom: 1px solid var(--border-cream);">
            <img src="/images/iu-logo.svg" alt="İstanbul Üniversitesi Logo" style="width: 60px; height: 60px; object-fit: contain; margin-bottom: 12px;">
            <h1 class="card-title" style="font-size: 26px; color: var(--iu-navy); margin-bottom: 6px;">Portal Girişi</h1>
            <p class="card-subtitle" style="margin: 0;">E-posta adresiniz ve şifrenizle oturum açın.</p>
        </div>

        <form action="/login" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="ornek@istanbul.edu.tr"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Şifre <span class="required">*</span></label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Şifrenizi giriniz"
                    required
                >
            </div>

            <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 12px;">
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                    <span>Giriş Yap</span>
                </button>
                <a href="/register" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                    <span>Hesabınız yok mu? Yeni Kayıt Oluştur</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
