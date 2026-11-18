@extends('layouts.app')

@section('title', 'Mezun & Öğrenci Rehberi — İstanbul Üniversitesi')
@section('meta_description', 'İstanbul Üniversitesi mezun ve öğrenci dizini. Mezunlarımızı keşfedin, kariyer bağlantıları kurun.')

@push('styles')
<style>
    .directory-hero {
        margin-bottom: 32px;
    }

    .directory-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 32px;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .directory-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Live Search & Filter Bar */
    .controls-panel {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 20px 24px;
        box-shadow: var(--shadow-subtle);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 260px;
    }

    .search-input-wrapper svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--ink-muted);
    }

    .search-input-wrapper input {
        padding-left: 40px;
    }

    /* User Grid */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .users-grid {
            grid-template-columns: 1fr;
        }
    }

    .user-profile-card {
        background: #FFFFFF;
        border: 1px solid var(--border-cream);
        border-radius: var(--radius-card);
        padding: 22px;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
    }

    .user-profile-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
        border-color: rgba(138, 21, 56, 0.3);
    }

    .user-card-top {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--iu-navy) 0%, #1e3a8a 100%);
        color: #FFFFFF;
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 2px solid var(--border-cream);
    }

    .user-meta-name {
        font-family: var(--font-sans);
        font-size: 16px;
        font-weight: 700;
        color: var(--iu-navy);
        line-height: 1.25;
    }

    .user-meta-email {
        font-size: 12.5px;
        color: var(--ink-secondary);
        margin-top: 2px;
    }

    .skills-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 14px 0;
    }

    .skill-chip {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: var(--radius-pill);
        background: var(--canvas-tint);
        color: var(--ink-charcoal);
        border: 1px solid var(--border-cream);
    }

    .user-card-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-top: 14px;
        border-top: 1px solid rgba(12, 23, 84, 0.06);
        margin-top: auto;
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Directory Hero -->
    <div class="directory-hero">
        <span class="badge-pill badge-crimson" style="margin-bottom: 8px;">Mezun & Öğrenci Dizini</span>
        <h1 style="font-size: 36px; color: var(--iu-navy); margin-bottom: 8px;">
            Geleceği Şekillendiren <em>İstanbul Üniversitesi</em> Mezunları
        </h1>
        <p style="color: var(--ink-secondary); max-width: 760px;">
            Fakültelerimizden mezun olan binlerce profesyonel ve öğrenciyi keşfedin, kariyer yolculuklarına ortak olun.
        </p>
    </div>

    <!-- Layout: Left Form + Right Grid -->
    <div class="directory-layout">

        <!-- Left Column: Quick User Creation Form -->
        <aside class="card" style="padding: 24px; position: sticky; top: 100px;">
            <div class="card-header" style="margin-bottom: 16px;">
                <div>
                    <span class="badge-pill badge-gold" style="font-size: 10.5px;">Hızlı Kayıt</span>
                    <h3 class="card-title" style="font-size: 18px; margin-top: 4px;">Yeni Profil Kaydı</h3>
                </div>
            </div>

            <form action="/users" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Ad Soyad <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Örn: Dr. Ahmet Yılmaz" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">E-posta Adresi <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Örn: ahmet@istanbul.edu.tr" required value="{{ old('email') }}">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="role">Rol</label>
                        <select id="role" name="role" class="form-select">
                            <option value="alumni" {{ old('role') === 'alumni' ? 'selected' : '' }}>Mezun</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Öğrenci</option>
                            <option value="academician" {{ old('role') === 'academician' ? 'selected' : '' }}>Akademisyen</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="graduation_year">Mezuniyet Yılı</label>
                        <input type="number" id="graduation_year" name="graduation_year" class="form-control" placeholder="2020" min="1950" max="2035" value="{{ old('graduation_year') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="department">Bölüm / Fakülte</label>
                    <input type="text" id="department" name="department" class="form-control" placeholder="Örn: Bilgisayar Mühendisliği" value="{{ old('department') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="job_title">Ünvan / Pozisyon</label>
                    <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Örn: Senior Software Engineer" value="{{ old('job_title') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="current_company">Çalıştığı Kurum</label>
                    <input type="text" id="current_company" name="current_company" class="form-control" placeholder="Örn: ASELSAN / Google" value="{{ old('current_company') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="skills">Yetenekler (Virgülle ayırın)</label>
                    <input type="text" id="skills" name="skills" class="form-control" placeholder="PHP, Laravel, Docker, AI" value="{{ old('skills') }}">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Profili Kaydet</span>
                </button>
            </form>
        </aside>

        <!-- Right Column: Search + Directory Cards -->
        <div>
            <!-- Search & Controls Bar -->
            <div class="controls-panel">
                <div class="search-input-wrapper">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="userLiveSearch" class="form-control" placeholder="İsim, şirket, bölüm veya yetenek ara...">
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="badge-pill badge-neutral" id="userCountBadge">
                        {{ count($users) }} Kayıtlı Üye
                    </span>
                    <a href="/users/create" class="btn btn-secondary btn-sm">+ Detaylı Form</a>
                </div>
            </div>

            <!-- Users Grid -->
            <div class="users-grid" id="usersContainer">
                @forelse ($users as $user)
                    @php
                        $uId = is_array($user) ? ($user['id'] ?? '') : $user->id;
                        $uName = is_array($user) ? ($user['name'] ?? 'İsimsiz') : $user->name;
                        $uEmail = is_array($user) ? ($user['email'] ?? '') : $user->email;
                        $uRole = is_array($user) ? ($user['role'] ?? 'alumni') : ($user->role ?? 'alumni');
                        $uDept = is_array($user) ? ($user['department'] ?? '') : ($user->department ?? '');
                        $uYear = is_array($user) ? ($user['graduation_year'] ?? '') : ($user->graduation_year ?? '');
                        $uTitle = is_array($user) ? ($user['job_title'] ?? '') : ($user->job_title ?? '');
                        $uCompany = is_array($user) ? ($user['current_company'] ?? '') : ($user->current_company ?? '');
                        $uSkills = is_array($user) ? ($user['skills'] ?? []) : ($user->skills ?? []);
                        if (is_string($uSkills)) {
                            $uSkills = array_filter(array_map('trim', explode(',', $uSkills)));
                        }
                    @endphp

                    <div class="user-profile-card user-item-card" data-keywords="{{ strtolower("{$uName} {$uEmail} {$uDept} {$uCompany} {$uTitle} " . implode(' ', (array)$uSkills)) }}">
                        <div>
                            <div class="user-card-top">
                                <div class="user-avatar">
                                    {{ mb_substr($uName, 0, 1) }}
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                        <h3 class="user-meta-name" title="{{ $uName }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $uName }}
                                        </h3>
                                        <span class="badge-pill {{ $uRole === 'student' ? 'badge-amber' : ($uRole === 'academician' ? 'badge-gold' : 'badge-crimson') }}" style="font-size: 10px; padding: 2px 8px;">
                                            {{ $uRole === 'student' ? 'Öğrenci' : ($uRole === 'academician' ? 'Akademisyen' : 'Mezun') }}
                                        </span>
                                    </div>
                                    <div class="user-meta-email">{{ $uEmail }}</div>
                                </div>
                            </div>

                            <div style="font-size: 13px; line-height: 1.5; color: var(--ink-charcoal);">
                                @if ($uTitle || $uCompany)
                                    <div style="font-weight: 600; color: var(--iu-navy); margin-bottom: 2px;">
                                        {{ $uTitle ?: 'Pozisyon Belirtilmedi' }} {{ $uCompany ? "@ {$uCompany}" : '' }}
                                    </div>
                                @endif
                                @if ($uDept)
                                    <div style="color: var(--ink-secondary); font-size: 12.5px;">
                                        {{ $uDept }} {{ $uYear ? "('{$uYear})" : '' }}
                                    </div>
                                @endif
                            </div>

                            @if (!empty($uSkills))
                                <div class="skills-flex">
                                    @foreach (array_slice((array)$uSkills, 0, 4) as $skill)
                                        <span class="skill-chip">{{ $skill }}</span>
                                    @endforeach
                                    @if (count((array)$uSkills) > 4)
                                        <span class="skill-chip">+{{ count((array)$uSkills) - 4 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="user-card-actions">
                            <a href="/users/{{ $uId }}" class="btn btn-secondary btn-sm" style="padding: 5px 12px; font-size: 12px;">
                                Profil Gör ↗
                            </a>
                            <div style="display: flex; gap: 6px;">
                                <a href="/users/{{ $uId }}/edit" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 12px;" title="Düzenle">
                                    Düzenle
                                </a>
                                <form action="/users/{{ $uId }}" method="POST" style="margin: 0;" onsubmit="return confirm('{{ $uName }} profili silinsin mi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 10px; font-size: 12px;" title="Sil">
                                        Sil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px; color: var(--ink-secondary);">
                        <h4 style="font-size: 18px; color: var(--iu-navy); margin-bottom: 6px;">Kayıtlı Profil Bulunamadı</h4>
                        <p style="font-size: 13.5px;">Soldaki formu kullanarak platforma ilk mezunumuzu veya öğrencimizi kaydedebilirsiniz.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('userLiveSearch');
    const userCards = document.querySelectorAll('.user-item-card');
    const badge = document.getElementById('userCountBadge');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            userCards.forEach(card => {
                const keywords = card.getAttribute('data-keywords') || '';
                if (keywords.includes(query)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (badge) {
                badge.textContent = `${visibleCount} Sonuç`;
            }
        });
    }
</script>
@endpush
@endsection
