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
    $aActive = is_array($announcement) ? (!empty($announcement['is_active'])) : (!empty($announcement->is_active));
@endphp

@section('title', "{$aTitle} Düzenle — Duyurular | İstanbul Üniversitesi")
@section('meta_description', "İstanbul Üniversitesi duyuru güncelleme formu.")

@section('content')
<div class="container" style="max-width: 760px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <a href="/announcements/{{ $aId }}" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Duyuruya Dön</span>
        </a>

        <span class="badge-pill badge-neutral">Duyuru #{{ $aId }}</span>
    </div>

    <!-- Edit Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-gold" style="margin-bottom: 6px;">Duyuru Güncelleme</span>
                <h1 class="card-title" style="font-size: 26px;">{{ $aTitle }}</h1>
                <p class="card-subtitle">Duyuru başlığını, kategorisini veya içeriğini güncelleyin.</p>
            </div>
        </div>

        <form action="/announcements/{{ $aId }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="title">Duyuru Başlığı <span class="required">*</span></label>
                <input type="text" id="title" name="title" class="form-control" required value="{{ old('title', $aTitle) }}">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="category">Kategori <span class="required">*</span></label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="event" {{ old('category', $aCategory) === 'event' ? 'selected' : '' }}>Etkinlik</option>
                        <option value="career" {{ old('category', $aCategory) === 'career' ? 'selected' : '' }}>Kariyer</option>
                        <option value="mentorship" {{ old('category', $aCategory) === 'mentorship' ? 'selected' : '' }}>Mentorluk</option>
                        <option value="academic" {{ old('category', $aCategory) === 'academic' ? 'selected' : '' }}>Akademik</option>
                        <option value="general" {{ old('category', $aCategory) === 'general' ? 'selected' : '' }}>Genel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="priority">Öncelik Derecesi</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="normal" {{ old('priority', $aPriority) === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="important" {{ old('priority', $aPriority) === 'important' ? 'selected' : '' }}>Yüksek / Önemli</option>
                        <option value="urgent" {{ old('priority', $aPriority) === 'urgent' ? 'selected' : '' }}>Acil</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="author">Yayınlayan Birim / Fakülte <span class="required">*</span></label>
                    <input type="text" id="author" name="author" class="form-control" required value="{{ old('author', $aAuthor) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="target_audience">Hedef Kitle</label>
                    <select id="target_audience" name="target_audience" class="form-select">
                        <option value="all" {{ old('target_audience', $aTarget) === 'all' ? 'selected' : '' }}>Tümü</option>
                        <option value="alumni" {{ old('target_audience', $aTarget) === 'alumni' ? 'selected' : '' }}>Yalnızca Mezunlar</option>
                        <option value="students" {{ old('target_audience', $aTarget) === 'students' ? 'selected' : '' }}>Yalnızca Öğrenciler</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="content">Duyuru Tam Metni <span class="required">*</span></label>
                <textarea id="content" name="content" class="form-control" rows="7" required>{{ old('content', $aContent) }}</textarea>
            </div>

            <div style="display: flex; gap: 24px; margin-bottom: 24px; padding: 14px 18px; background: var(--canvas-tint); border-radius: 12px; border: 1px solid var(--border-cream);">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="pinned" value="1" {{ old('pinned', $aPinned) ? 'checked' : '' }}>
                    <span>Ana Sayfa ve Listede Başa Sabitle</span>
                </label>

                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $aActive) ? 'checked' : '' }}>
                    <span>Yayında (Aktif)</span>
                </label>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/announcements/{{ $aId }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Değişiklikleri Kaydet</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
