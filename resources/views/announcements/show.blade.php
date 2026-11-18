@extends('layouts.app')

@php
    $aId = is_array($announcement) ? ($announcement['id'] ?? '') : $announcement->id;
    $aTitle = is_array($announcement) ? ($announcement['title'] ?? '') : $announcement->title;
    $aCategory = is_array($announcement) ? ($announcement['category'] ?? 'Genel') : ($announcement->category ?? 'Genel');
    $aContent = is_array($announcement) ? ($announcement['content'] ?? '') : $announcement->content;
    $aAuthor = is_array($announcement) ? ($announcement['author'] ?? 'Rektörlük') : ($announcement->author ?? 'Rektörlük');
    $aTarget = is_array($announcement) ? ($announcement['target_audience'] ?? 'Tümü') : ($announcement->target_audience ?? 'Tümü');
    $aPriority = is_array($announcement) ? ($announcement['priority'] ?? 'Normal') : ($announcement->priority ?? 'Normal');
    $aPinned = is_array($announcement) ? (!empty($announcement['pinned'])) : (!empty($announcement->pinned));
    $aDate = is_array($announcement) ? ($announcement['created_at'] ?? '') : ($announcement->created_at ?? '');
@endphp

@section('title', "{$aTitle} — Duyurular | İstanbul Üniversitesi")
@section('meta_description', "İstanbul Üniversitesi {$aCategory} duyurusu: {$aTitle}")

@section('content')
<div class="container" style="max-width: 820px;">

    <!-- Top Navigation -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <a href="/announcements" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Duyurulara Dön</span>
        </a>

        <div style="display: flex; gap: 8px;">
            <a href="/announcements/{{ $aId }}/edit" class="btn btn-secondary btn-sm">
                <span>Duyuruyu Düzenle</span>
            </a>
            <form action="/announcements/{{ $aId }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu duyuru kalıcı olarak silinsin mi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <span>Sil</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Announcement Article Card -->
    <article class="card" style="padding: 40px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; flex-wrap: wrap;">
            @if ($aPinned)
                <span class="badge-pill badge-gold">Sabitlendi</span>
            @endif
            <span class="badge-pill badge-crimson">{{ $aCategory }}</span>
            @if ($aPriority === 'Acil' || $aPriority === 'Yüksek')
                <span class="badge-pill badge-danger">{{ $aPriority }}</span>
            @endif
            <span class="badge-pill badge-neutral">Hedef Kitle: {{ $aTarget }}</span>
        </div>

        <h1 style="font-size: 32px; color: var(--iu-navy); line-height: 1.25; margin-bottom: 16px;">
            {{ $aTitle }}
        </h1>

        <div style="display: flex; align-items: center; gap: 16px; font-size: 13px; color: var(--ink-secondary); padding-bottom: 20px; border-bottom: 1px solid var(--border-cream); margin-bottom: 28px; flex-wrap: wrap;">
            <span><strong>Yayınlayan:</strong> {{ $aAuthor }}</span>
            <span><strong>Yayın Tarihi:</strong> {{ $aDate ? \Carbon\Carbon::parse($aDate)->format('d.m.Y H:i') : 'Güncel' }}</span>
        </div>

        <div style="font-size: 16px; line-height: 1.8; color: var(--ink-charcoal); white-space: pre-line; margin-bottom: 36px;">
            {{ $aContent }}
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 24px; border-top: 1px solid var(--border-cream); font-size: 12.5px; color: var(--ink-muted); flex-wrap: wrap; gap: 12px;">
            <div>İstanbul Üniversitesi • Rektörlük Basın ve Halkla İlişkiler</div>
            <a href="/announcements" class="btn btn-secondary btn-sm">Tüm Duyurular</a>
        </div>
    </article>

</div>
@endsection
