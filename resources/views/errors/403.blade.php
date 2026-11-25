@extends('layouts.app')

@section('title', '403 — Yetkisiz İşlem | İstanbul Üniversitesi Mezun Portalı')
@section('meta_description', 'Bu işlemi gerçekleştirmek için gerekli rol yetkisine sahip değilsiniz.')

@section('content')
@php
    $isUnverified = $isUnverified ?? (auth()->check() && auth()->user()->isUnverified());
    $pageTitle = $title ?? ($isUnverified ? 'Hesabınız Henüz Doğrulanmamış' : 'Bu İşlem İçin Yetkiniz Bulunmamaktadır');
    $pageReason = $reason ?? ($isUnverified
        ? 'Hesabınız şu anda Doğrulanmamış (unverified) statüsündedir. Bu işlemi gerçekleştirebilmek için hesap doğrulama sürecinin tamamlanması gerekmektedir.'
        : 'Mevcut kullanıcı rolünüz bu sayfaya erişmek veya bu işlemi gerçekleştirmek için yeterli yetkiye sahip değildir.');
    $currentRole = $currentRoleLabel ?? (auth()->check() ? \App\Models\User::formatRoleLabel(auth()->user()->role) : 'Misafir');
    $requiredRoles = $requiredRoleLabels ?? [];
@endphp

<div class="container" style="max-width: 720px; margin-top: 16px; margin-bottom: 48px;">
    <div class="card" style="padding: 44px 38px; text-align: center;">
        <div style="margin: 0 auto 18px auto; width: 68px; height: 68px; display: flex; align-items: center; justify-content: center;">
            <img src="/images/iu-logo.svg" alt="İstanbul Üniversitesi Logo" style="width: 68px; height: 68px; object-fit: contain;">
        </div>

        <span class="badge-pill {{ $isUnverified ? 'badge-gold' : 'badge-crimson' }}" style="margin-bottom: 12px;">
            {{ $isUnverified ? 'Doğrulama Bekleniyor (403)' : 'Erişim Kısıtlı (403)' }}
        </span>

        <h1 style="font-family: var(--font-serif); font-size: 28px; color: var(--iu-navy); margin-bottom: 12px; line-height: 1.3;">
            {{ $pageTitle }}
        </h1>

        <p style="font-size: 15px; line-height: 1.7; color: var(--ink-charcoal); max-width: 560px; margin: 0 auto 24px auto;">
            {{ $pageReason }}
        </p>

        <!-- Role Comparison Box -->
        <div style="background: var(--canvas-tint); border: 1px solid var(--border-cream); border-radius: 14px; padding: 18px 22px; text-align: left; max-width: 520px; margin: 0 auto 28px auto; font-size: 13.5px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid rgba(12, 23, 84, 0.08);">
                <span style="color: var(--ink-secondary); font-weight: 600;">Mevcut Rolünüz:</span>
                <span class="badge-pill badge-neutral">{{ $currentRole }}</span>
            </div>
            @if (!empty($requiredRoles))
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0 4px 0; flex-wrap: wrap; gap: 8px;">
                    <span style="color: var(--ink-secondary); font-weight: 600;">Bu İşlem İçin Gerekli Rol:</span>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        @foreach ($requiredRoles as $reqRole)
                            <span class="badge-pill badge-crimson">{{ $reqRole }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Safe Navigation Actions -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <a href="/" class="btn btn-primary">Ana Sayfaya Dön</a>
            @auth
                <a href="/profile/settings" class="btn btn-secondary">Profil Ayarlarım</a>
                <a href="/profile/dashboard" class="btn btn-secondary">Kişisel Panelim</a>
            @else
                <a href="/login" class="btn btn-sapphire">Giriş Yap</a>
                <a href="/register" class="btn btn-secondary">Kayıt Ol</a>
            @endauth
        </div>
    </div>
</div>
@endsection
