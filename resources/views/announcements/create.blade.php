@extends('layouts.app')

@section('title', 'Yeni Duyuru Yayınla — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi yeni kurumsal duyuru oluşturma formu.')

@section('content')
<div class="container" style="max-width: 760px;">

    <!-- Top Breadcrumb -->
    <div style="margin-bottom: 24px;">
        <a href="/announcements" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Duyuru Paneline Dön</span>
        </a>
    </div>

    <!-- Create Card -->
    <div class="card" style="padding: 36px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-cream); padding-bottom: 20px; margin-bottom: 24px;">
            <div>
                <span class="badge-pill badge-gold" style="margin-bottom: 6px;">İletişim & Yayın</span>
                <h1 class="card-title" style="font-size: 26px;">Yeni Duyuru Oluştur</h1>
                <p class="card-subtitle">Üniversite, mezuniyet, kariyer veya akademik etkinlik duyurusu yayınlayın.</p>
            </div>
        </div>

        <form action="/announcements" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="title">Duyuru Başlığı <span class="required">*</span></label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Örn: 2026 Bahar Kariyer ve Mezuniyet Zirvesi" required value="{{ old('title') }}">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="category">Kategori <span class="required">*</span></label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="Etkinlik" {{ old('category') === 'Etkinlik' ? 'selected' : '' }}>Etkinlik</option>
                        <option value="Kariyer" {{ old('category') === 'Kariyer' ? 'selected' : '' }}>Kariyer</option>
                        <option value="Akademik" {{ old('category') === 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Genel" {{ old('category') === 'Genel' ? 'selected' : '' }}>Genel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="priority">Öncelik Derecesi</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="Normal" {{ old('priority') === 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Yüksek" {{ old('priority') === 'Yüksek' ? 'selected' : '' }}>Yüksek</option>
                        <option value="Acil" {{ old('priority') === 'Acil' ? 'selected' : '' }}>Acil</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="author">Yayınlayan Birim / Fakülte <span class="required">*</span></label>
                    <input type="text" id="author" name="author" class="form-control" placeholder="Örn: Rektörlük Basın Müşavirliği" required value="{{ old('author', 'İstanbul Üniversitesi Rektörlüğü') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="target_audience">Hedef Kitle</label>
                    <select id="target_audience" name="target_audience" class="form-select">
                        <option value="Tümü" {{ old('target_audience') === 'Tümü' ? 'selected' : '' }}>Tümü (Mezunlar & Öğrenciler)</option>
                        <option value="Mezunlar" {{ old('target_audience') === 'Mezunlar' ? 'selected' : '' }}>Yalnızca Mezunlar</option>
                        <option value="Öğrenciler" {{ old('target_audience') === 'Öğrenciler' ? 'selected' : '' }}>Yalnızca Öğrenciler</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="content">Duyuru Tam Metni <span class="required">*</span></label>
                <textarea id="content" name="content" class="form-control" rows="7" placeholder="Duyuru metni, etkinlik tarihi, kayıt koşulları ve diğer detaylar..." required>{{ old('content') }}</textarea>
            </div>

            <div style="display: flex; gap: 24px; margin-bottom: 24px; padding: 14px 18px; background: var(--canvas-tint); border-radius: 12px; border: 1px solid var(--border-cream);">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="pinned" value="1" {{ old('pinned') ? 'checked' : '' }}>
                    <span>Ana Sayfa ve Listede Başa Sabitle</span>
                </label>

                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Yayında (Aktif)</span>
                </label>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid var(--border-cream);">
                <a href="/announcements" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Duyuruyu Yayınla</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
