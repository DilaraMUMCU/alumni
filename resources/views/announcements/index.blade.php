@extends('layouts.app')

@section('title', 'Kurumsal Duyurular — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi Rektörlüğü ve fakültelerimizden mezuniyet, kariyer ve etkinlik duyuruları.')

@push('styles')
<style>
    .announcements-hero {
        margin-bottom: 32px;
    }

    .announcements-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 32px;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .announcements-layout {
            grid-template-columns: 1fr;
        }
    }

    .announcement-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
        transition: all 0.25s ease;
        position: relative;
    }

    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-card-hover);
        border-color: rgba(138, 21, 56, 0.3);
    }

    .announcement-card.is-pinned {
        border-left: 4px solid var(--iu-gold);
    }

    .announcement-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .announcement-title {
        font-family: var(--font-serif);
        font-size: 20px;
        color: var(--iu-navy);
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .announcement-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12.5px;
        color: var(--ink-secondary);
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .announcement-content-excerpt {
        font-size: 14px;
        color: var(--ink-charcoal);
        line-height: 1.6;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Hero Header -->
    <div class="announcements-hero">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <span class="badge-pill badge-gold" style="margin-bottom: 8px;">Kurumsal İletişim</span>
                <h1 style="font-size: 36px; color: var(--iu-navy); margin-bottom: 8px;">
                    Üniversite & Fakülte <em>Duyuruları</em>
                </h1>
                <p style="color: var(--ink-secondary); max-width: 700px;">
                    Rektörlük, mezunlar ofisi ve fakültelerimizden etkinlik, kariyer zirveleri ve akademik duyurular.
                </p>
            </div>

            <a href="/announcements/create" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Yeni Duyuru Yayınla</span>
            </a>
        </div>
    </div>

    <!-- Layout: Left Creation Card + Right List -->
    <div class="announcements-layout">

        <!-- Left Column: Quick Announcement Creator -->
        <aside class="card" style="padding: 24px; position: sticky; top: 100px;">
            <div class="card-header" style="margin-bottom: 16px;">
                <div>
                    <span class="badge-pill badge-crimson" style="font-size: 10.5px;">Hızlı Yayın</span>
                    <h3 class="card-title" style="font-size: 18px; margin-top: 4px;">Duyuru Paylaş</h3>
                </div>
            </div>

            <form action="/announcements" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Duyuru Başlığı <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Örn: 2026 Mezuniyet Töreni" required value="{{ old('title') }}">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
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
                        <label class="form-label" for="priority">Öncelik</label>
                        <select id="priority" name="priority" class="form-select">
                            <option value="Normal">Normal</option>
                            <option value="Yüksek">Yüksek</option>
                            <option value="Acil">Acil</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="author">Yayınlayan Birim</label>
                        <input type="text" id="author" name="author" class="form-control" placeholder="Örn: Rektörlük" value="{{ old('author') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="target_audience">Hedef Kitle</label>
                        <select id="target_audience" name="target_audience" class="form-select">
                            <option value="Tümü">Tümü</option>
                            <option value="Mezunlar">Mezunlar</option>
                            <option value="Öğrenciler">Öğrenciler</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Duyuru İçeriği <span class="required">*</span></label>
                    <textarea id="content" name="content" class="form-control" rows="4" placeholder="Duyuru metnini giriniz..." required>{{ old('content') }}</textarea>
                </div>

                <div style="margin-bottom: 18px; display: flex; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="pinned" value="1" {{ old('pinned') ? 'checked' : '' }}>
                        <span>Başa Sabitle</span>
                    </label>

                    <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Aktif Yayın</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Duyuruyu Yayınla</span>
                </button>
            </form>
        </aside>

        <!-- Right Column: Announcements List -->
        <div>
            <!-- Filter Pills -->
            <div class="filter-pills-bar">
                <button class="filter-pill active" onclick="filterAnnouncements('all')">
                    Tüm Duyurular ({{ count($announcements) }})
                </button>
                <button class="filter-pill" onclick="filterAnnouncements('Etkinlik')">Etkinlik</button>
                <button class="filter-pill" onclick="filterAnnouncements('Kariyer')">Kariyer</button>
                <button class="filter-pill" onclick="filterAnnouncements('Akademik')">Akademik</button>
                <button class="filter-pill" onclick="filterAnnouncements('Genel')">Genel</button>
            </div>

            <!-- List -->
            <div id="announcementsList">
                @forelse ($announcements as $ann)
                    @php
                        $aId = is_array($ann) ? ($ann['id'] ?? '') : $ann->id;
                        $aTitle = is_array($ann) ? ($ann['title'] ?? '') : $ann->title;
                        $aCategory = is_array($ann) ? ($ann['category'] ?? 'Genel') : ($ann->category ?? 'Genel');
                        $aContent = is_array($ann) ? ($ann['content'] ?? '') : $ann->content;
                        $aAuthor = is_array($ann) ? ($ann['author'] ?? 'Rektörlük') : ($ann->author ?? 'Rektörlük');
                        $aTarget = is_array($ann) ? ($ann['target_audience'] ?? 'Tümü') : ($ann->target_audience ?? 'Tümü');
                        $aPriority = is_array($ann) ? ($ann['priority'] ?? 'Normal') : ($ann->priority ?? 'Normal');
                        $aPinned = is_array($ann) ? (!empty($ann['pinned'])) : (!empty($ann->pinned));
                        $aDate = is_array($ann) ? ($ann['created_at'] ?? '') : ($ann->created_at ?? '');
                    @endphp

                    <article class="announcement-card {{ $aPinned ? 'is-pinned' : '' }} ann-item" data-category="{{ $aCategory }}">
                        <div class="announcement-header">
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                @if ($aPinned)
                                    <span class="badge-pill badge-gold" style="font-size: 10px;">
                                        SABİTLENDİ
                                    </span>
                                @endif
                                <span class="badge-pill badge-crimson" style="font-size: 10.5px;">
                                    {{ $aCategory }}
                                </span>
                                @if ($aPriority === 'Acil' || $aPriority === 'Yüksek')
                                    <span class="badge-pill badge-danger" style="font-size: 10px;">
                                        {{ $aPriority }}
                                    </span>
                                @endif
                                <span class="badge-pill badge-neutral" style="font-size: 10.5px;">
                                    Hedef Kitle: {{ $aTarget }}
                                </span>
                            </div>

                            <div style="font-size: 12px; color: var(--ink-secondary);">
                                {{ $aDate ? \Carbon\Carbon::parse($aDate)->format('d.m.Y H:i') : '' }}
                            </div>
                        </div>

                        <h2 class="announcement-title">
                            <a href="/announcements/{{ $aId }}" style="color: inherit;">
                                {{ $aTitle }}
                            </a>
                        </h2>

                        <div class="announcement-meta">
                            <span>{{ $aAuthor }}</span>
                        </div>

                        <div class="announcement-content-excerpt">
                            {{ strip_tags($aContent) }}
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-top: 14px; border-top: 1px solid rgba(12, 23, 84, 0.06);">
                            <a href="/announcements/{{ $aId }}" class="btn btn-secondary btn-sm">
                                Devamını Oku ↗
                            </a>

                            <div style="display: flex; gap: 6px;">
                                <a href="/announcements/{{ $aId }}/edit" class="btn btn-secondary btn-sm" style="padding: 5px 10px;" title="Düzenle">
                                    Düzenle
                                </a>
                                <form action="/announcements/{{ $aId }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu duyuru kalıcı olarak silinsin mi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px;" title="Sil">
                                        Sil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="card" style="text-align: center; padding: 48px; color: var(--ink-secondary);">
                        <h4 style="font-size: 18px; color: var(--iu-navy); margin-bottom: 6px;">Duyuru Bulunamadı</h4>
                        <p style="font-size: 13.5px;">Soldaki formu kullanarak üniversitemiz için ilk duyuruyu yayınlayabilirsiniz.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function filterAnnouncements(category) {
        const pills = document.querySelectorAll('.filter-pill');
        pills.forEach(p => p.classList.remove('active'));
        event.target.classList.add('active');

        const items = document.querySelectorAll('.ann-item');
        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
