@extends('layouts.app')

@section('title', '404 — Sayfa Bulunamadı | İstanbul Üniversitesi')
@section('meta_description', 'İstenen kaynak veya sayfa bulunamadı. Guardian 404 koruma kalkanı.')

@push('styles')
<style>
    .guardian-container {
        max-width: 760px;
        margin: 20px auto 40px auto;
        text-align: center;
    }

    .guardian-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-hero);
        padding: 44px 36px;
        box-shadow: var(--shadow-card);
    }

    .guardian-emblem-badge {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--iu-crimson) 0%, var(--iu-crimson-hover) 100%);
        color: #FFFFFF;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        border: 3px solid var(--iu-gold);
        box-shadow: 0 8px 24px rgba(138, 21, 56, 0.25);
    }

    .guardian-code {
        font-family: var(--font-serif);
        font-size: 64px;
        font-weight: 700;
        color: var(--iu-crimson);
        line-height: 1;
        letter-spacing: -2px;
        margin-bottom: 6px;
    }

    .diagnostic-panel {
        background: var(--canvas-tint);
        border: 1px solid var(--border-cream);
        border-radius: 14px;
        padding: 20px;
        text-align: left;
        margin: 24px 0;
        font-family: var(--font-mono);
        font-size: 13px;
    }

    .diagnostic-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid rgba(12, 23, 84, 0.06);
    }

    .diagnostic-row:last-child {
        border-bottom: none;
    }

    .diagnostic-label {
        color: var(--ink-secondary);
        font-weight: 600;
    }

    .diagnostic-val {
        color: var(--iu-navy);
        font-weight: 600;
        word-break: break-all;
    }

    /* Countdown bar */
    .countdown-bar-container {
        background: rgba(12, 23, 84, 0.08);
        height: 6px;
        border-radius: var(--radius-pill);
        overflow: hidden;
        margin: 20px 0;
    }

    .countdown-bar-fill {
        background: linear-gradient(90deg, var(--iu-crimson), var(--iu-gold));
        height: 100%;
        width: 100%;
        transition: width 1s linear;
    }
</style>
@endpush

@section('content')
<div class="container guardian-container">

    <div class="guardian-card">
        <!-- University Heritage Seal -->
        <div class="guardian-emblem-badge">
            <span style="font-family: var(--font-serif); font-size: 26px; font-weight: 700; line-height: 1;">İÜ</span>
            <span style="font-size: 10px; font-weight: 800; color: var(--iu-gold); line-height: 1; margin-top: 2px;">1453</span>
        </div>

        <div class="guardian-code">404</div>

        <h1 style="font-size: 28px; color: var(--iu-navy); margin-bottom: 8px;">
            Aradığınız Kaynak <em>Bulunamadı</em>
        </h1>

        <p style="color: var(--ink-secondary); max-width: 580px; margin: 0 auto 16px auto; font-size: 14.5px;">
            Talep ettiğiniz web sayfası veya kaynak sunucuda mevcut değil. Güvenlik ve rota bütünlüğü için Guardian kalkanı devreye girdi.
        </p>

        <!-- Redirect Countdown Progress Bar -->
        <div style="max-width: 480px; margin: 0 auto;">
            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; color: var(--ink-secondary); font-weight: 600;">
                <span>Ana Sayfaya Otomatik Yönlendirme:</span>
                <span id="countdownText" style="color: var(--iu-crimson); font-weight: 700;">5 saniye</span>
            </div>
            <div class="countdown-bar-container">
                <div class="countdown-bar-fill" id="countdownFill"></div>
            </div>
            <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 20px;">
                <button type="button" id="pauseBtn" class="btn btn-secondary btn-sm" style="font-size: 11.5px; padding: 4px 12px;">
                    ⏸️ Geri Sayımı Durdur
                </button>
            </div>
        </div>

        <!-- Diagnostic Inspector Panel -->
        <div class="diagnostic-panel">
            <div class="diagnostic-row">
                <span class="diagnostic-label">Talep Edilen Yol (Path):</span>
                <span class="diagnostic-val" style="color: var(--iu-crimson);">{{ $path ?? request()->getRequestUri() }}</span>
            </div>
            <div class="diagnostic-row">
                <span class="diagnostic-label">HTTP Metodu:</span>
                <span class="diagnostic-val">{{ $method ?? request()->method() }}</span>
            </div>
            <div class="diagnostic-row">
                <span class="diagnostic-label">Hata Zamanı:</span>
                <span class="diagnostic-val">{{ $timestamp ?? date('Y-m-d H:i:s') }}</span>
            </div>
            <div class="diagnostic-row">
                <span class="diagnostic-label">Sistem Bildirimi:</span>
                <span class="diagnostic-val" style="font-family: var(--font-sans); font-size: 12px;">{{ $reason ?? 'Kaynak sunucuda bulunamadı.' }}</span>
            </div>
        </div>

        <!-- Safe Navigation Pills -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 24px;">
            <a href="/" class="btn btn-primary btn-lg">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Hemen Ana Sayfaya Dön</span>
            </a>
            <a href="/users" class="btn btn-secondary">
                🎓 Mezun Dizini
            </a>
            <a href="/job-postings" class="btn btn-secondary">
                💼 Kariyer İlanları
            </a>
            <a href="/announcements" class="btn btn-secondary">
                📢 Duyurular
            </a>
        </div>
    </div>

</div>

@push('scripts')
<script>
    let timeLeft = 5;
    let isPaused = false;
    const countdownText = document.getElementById('countdownText');
    const countdownFill = document.getElementById('countdownFill');
    const pauseBtn = document.getElementById('pauseBtn');

    const timer = setInterval(() => {
        if (!isPaused) {
            timeLeft--;
            if (countdownText) countdownText.textContent = `${timeLeft} saniye`;
            if (countdownFill) countdownFill.style.width = `${(timeLeft / 5) * 100}%`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = '/';
            }
        }
    }, 1000);

    if (pauseBtn) {
        pauseBtn.addEventListener('click', () => {
            isPaused = !isPaused;
            if (isPaused) {
                pauseBtn.innerHTML = '▶️ Devam Ettir';
                pauseBtn.classList.add('btn-primary');
                pauseBtn.classList.remove('btn-secondary');
            } else {
                pauseBtn.innerHTML = '⏸️ Geri Sayımı Durdur';
                pauseBtn.classList.remove('btn-primary');
                pauseBtn.classList.add('btn-secondary');
            }
        });
    }
</script>
@endpush
@endsection
