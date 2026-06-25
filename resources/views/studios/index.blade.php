@extends('layouts.app')

@section('title', 'Browse Studios — NestPeek Photo')

@section('content')

<style>
    :root {
        --sky: #0EA5E9;
        --sky-light: #38BDF8;
        --sky-mid: #0369A1;
        --navy: #0C4A6E;
        --sky-faint: #F0F9FF;
        --sky-pale: #E0F2FE;
        --slate: #64748B;
        --slate-mid: #94A3B8;
        --slate-light: #CBD5E1;
        --text-main: #0F172A;
        --text-muted: #475569;
        --border: rgba(14, 165, 233, 0.14);
        --border-mid: rgba(14, 165, 233, 0.28);
        --green: #10B981;
        --green-faint: rgba(16, 185, 129, 0.08);
        --green-border: rgba(16, 185, 129, 0.25);
        --amber: #F59E0B;
        --studio: #7C3AED;
        --studio-faint: rgba(124, 58, 237, 0.07);
        --studio-border: rgba(124, 58, 237, 0.22);
        --studio-mid: #6D28D9;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #F8FBFF;
        color: var(--text-main);
    }

    /* ── Page hero ── */
    .browse-hero {
        background: linear-gradient(135deg, var(--navy) 0%, #0369A1 60%, #0284C7 100%);
        padding: 56px 24px 0;
        position: relative;
        overflow: hidden;
    }

    .browse-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        border: 60px solid rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }

    .browse-hero::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: 30%;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        border: 40px solid rgba(255, 255, 255, 0.03);
        pointer-events: none;
    }

    .hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.62rem;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--sky-light);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .hero-eyebrow::before {
        content: '';
        display: inline-block;
        width: 22px;
        height: 1px;
        background: var(--sky-light);
        opacity: 0.6;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.6rem;
        font-weight: 400;
        color: #fff;
        line-height: 1.18;
        margin-bottom: 12px;
    }

    .hero-title em {
        font-style: italic;
        color: var(--sky-light);
    }

    .hero-sub {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.65);
        max-width: 460px;
        line-height: 1.6;
        margin-bottom: 32px;
    }

    /* ── Search bar in hero ── */
    .hero-search {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 16px 16px 0 0;
        padding: 18px 20px;
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .search-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
        min-width: 140px;
    }

    .search-field label {
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.55);
    }

    .search-input {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 10px;
        padding: 10px 13px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
        width: 100%;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.38);
    }

    .search-input:focus {
        border-color: rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.18);
    }

    .search-input option {
        background: var(--navy);
        color: #fff;
    }

    .btn-search {
        padding: 10px 24px;
        background: #fff;
        color: var(--navy);
        border: none;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
        align-self: flex-end;
        height: 40px;
    }

    .btn-search:hover {
        background: var(--sky-pale);
    }

    /* ── Main layout ── */
    .browse-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 28px 24px 80px;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* ── Filter sidebar ── */
    .filter-sidebar {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 22px;
        position: sticky;
        top: 80px;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .filter-title {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    .filter-clear {
        font-size: 0.72rem;
        color: var(--sky-mid);
        text-decoration: none;
        font-weight: 600;
    }

    .filter-clear:hover {
        text-decoration: underline;
    }

    .filter-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }

    .filter-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate-mid);
        display: block;
        margin-bottom: 10px;
    }

    .filter-input {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid var(--slate-light);
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        color: var(--text-main);
        background: #FAFCFF;
        outline: none;
        transition: border-color 0.15s;
    }

    .filter-input:focus {
        border-color: var(--sky);
    }

    .price-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .spec-check-grid {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .spec-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .spec-check input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: var(--sky-mid);
        cursor: pointer;
        flex-shrink: 0;
    }

    .btn-apply {
        width: 100%;
        padding: 11px;
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 18px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
    }

    .btn-apply:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
    }

    /* ── Results area ── */
    .results-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
    }

    .results-count {
        font-size: 0.85rem;
        color: var(--slate);
    }

    .results-count strong {
        color: var(--text-main);
        font-weight: 600;
    }

    .sort-select {
        padding: 7px 12px;
        border: 1.5px solid var(--border-mid);
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        color: var(--text-main);
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    /* ── Active filters strip ── */
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--sky-pale);
        border: 1px solid var(--border-mid);
        color: var(--sky-mid);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 600;
        text-decoration: none;
    }

    .filter-chip .remove {
        color: var(--slate-mid);
        font-size: 0.8rem;
    }

    /* ── Studio card grid ── */
    .studio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    /* ── Studio card ── */
    .studio-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.04);
        transition: all 0.22s;
        position: relative;
    }

    .studio-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(14, 165, 233, 0.12);
        border-color: var(--border-mid);
    }

    .card-image {
        height: 195px;
        background: linear-gradient(135deg, var(--sky-pale), #dbeafe);
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .studio-card:hover .card-image img {
        transform: scale(1.04);
    }

    .card-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        opacity: 0.3;
    }

    /* Badges on image */
    .card-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 50px;
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .badge-verified {
        background: rgba(16, 185, 129, 0.22);
        border: 1px solid rgba(16, 185, 129, 0.45);
        color: #fff;
        backdrop-filter: blur(6px);
    }

    .badge-featured {
        background: rgba(245, 158, 11, 0.22);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #fff;
        backdrop-filter: blur(6px);
    }

    .card-save {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(6px);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        transition: all 0.15s;
        color: var(--slate-mid);
        text-decoration: none;
    }

    .card-save:hover,
    .card-save.saved {
        color: #EF4444;
        background: #fff;
    }

    /* Studio logo on card */
    .card-logo {
        position: absolute;
        bottom: -18px;
        left: 16px;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 2px solid #fff;
        background: linear-gradient(135deg, var(--studio), var(--studio-mid));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 400;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Card body */
    .card-body {
        padding: 26px 18px 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 4px;
        line-height: 1.25;
    }

    .card-loc {
        font-size: 0.74rem;
        color: var(--slate);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Specialization pills */
    .card-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 12px;
    }

    .card-spec {
        background: var(--studio-faint);
        border: 1px solid var(--studio-border);
        color: var(--studio-mid);
        padding: 2px 8px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 600;
    }

    .card-spec.more {
        background: var(--sky-faint);
        border-color: var(--border-mid);
        color: var(--slate-mid);
    }

    /* Rating */
    .card-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.76rem;
        color: var(--slate);
        margin-bottom: 12px;
    }

    .card-stars {
        color: var(--amber);
        font-size: 0.78rem;
        letter-spacing: 0.5px;
    }

    /* Footer of card */
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid var(--border);
        gap: 10px;
    }

    .card-rate {
        flex: 1;
    }

    .card-rate-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        color: var(--navy);
        line-height: 1;
    }

    .card-rate-value .curr {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        color: var(--sky-mid);
        margin-right: 1px;
    }

    .card-rate-label {
        font-size: 0.65rem;
        color: var(--slate-mid);
        margin-top: 2px;
    }

    .btn-book {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 3px 10px rgba(14, 165, 233, 0.28);
        transition: all 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-book:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(14, 165, 233, 0.38);
    }

    /* ── Empty state ── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 72px 24px;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 14px;
    }

    .empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: var(--navy);
        margin-bottom: 8px;
        font-weight: 400;
    }

    .empty-sub {
        font-size: 0.85rem;
        color: var(--slate);
    }

    /* ── Pagination ── */
    .pagination-wrap {
        margin-top: 36px;
        display: flex;
        justify-content: center;
    }

    @media(max-width: 900px) {
        .browse-body {
            grid-template-columns: 1fr;
        }

        .filter-sidebar {
            position: static;
        }

        .hero-search {
            border-radius: 14px;
        }
    }

    @media(max-width: 560px) {
        .hero-title {
            font-size: 1.9rem;
        }

        .studio-grid {
            grid-template-columns: 1fr;
        }

        .browse-body {
            padding: 20px 16px 60px;
        }
    }
</style>

{{-- ── Hero ── --}}
<div class="browse-hero">
    <div class="hero-inner">
        <p class="hero-eyebrow">Discover Spaces</p>
        <h1 class="hero-title">
            Find the perfect<br>
            <em>photography studio</em>
        </h1>
        <p class="hero-sub">
            Browse professional studios available for your shoots, events, and creative projects.
        </p>

        {{-- Inline quick-search --}}
        <form method="GET" action="{{ route('studios.index') }}" class="hero-search">
            <div class="search-field">
                <label>Location</label>
                <input class="search-input" type="text" name="location"
                    value="{{ request('location') }}" placeholder="City or region…">
            </div>
            <div class="search-field" style="max-width:160px">
                <label>Budget / hr (₱)</label>
                <input class="search-input" type="number" name="max_price"
                    value="{{ request('max_price') }}" placeholder="Max rate">
            </div>
            <div class="search-field" style="max-width:180px">
                <label>Specialization</label>
                <select class="search-input" name="spec">
                    <option value="">Any type</option>
                    @foreach(['photography','videography','coordination','makeup_hair','hosting_mc','music_dj','lighting_sound','drone'] as $s)
                    <option value="{{ $s }}" {{ request('spec') === $s ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_',' ',$s)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
</div>

{{-- ── Browse body ── --}}
<div class="browse-body">

    {{-- FILTER SIDEBAR --}}
    <aside class="filter-sidebar">
        <form method="GET" action="{{ route('studios.index') }}" id="filterForm">

            <div class="filter-header">
                <span class="filter-title">Filters</span>
                <a href="{{ route('studios.index') }}" class="filter-clear">Clear all</a>
            </div>

            {{-- Location --}}
            <div class="filter-section">
                <label class="filter-label">Location</label>
                <input class="filter-input" type="text" name="location"
                    value="{{ request('location') }}" placeholder="City or region…">
            </div>

            {{-- Price range --}}
            <div class="filter-section">
                <label class="filter-label">Hourly Rate (₱)</label>
                <div class="price-row">
                    <input class="filter-input" type="number" name="min_price"
                        value="{{ request('min_price') }}" placeholder="Min">
                    <input class="filter-input" type="number" name="max_price"
                        value="{{ request('max_price') }}" placeholder="Max">
                </div>
            </div>

            {{-- Specializations --}}
            <div class="filter-section">
                <label class="filter-label">Specialization</label>
                <div class="spec-check-grid">
                    @foreach([
                    ['photography', '📷 Photography'],
                    ['videography', '🎬 Videography'],
                    ['coordination', '📋 Coordination'],
                    ['makeup_hair', '💄 Makeup & Hair'],
                    ['hosting_mc', '🎤 Host / MC'],
                    ['music_dj', '🎵 Music / DJ'],
                    ['lighting_sound', '💡 Lights & Sound'],
                    ['drone', '🚁 Drone'],
                    ] as [$val, $lbl])
                    <label class="spec-check">
                        <input type="checkbox" name="specs[]" value="{{ $val }}"
                            {{ in_array($val, request('specs', [])) ? 'checked' : '' }}>
                        {{ $lbl }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Verified only --}}
            <div class="filter-section">
                <label class="spec-check">
                    <input type="checkbox" name="verified" value="1"
                        {{ request('verified') ? 'checked' : '' }}>
                    ✓ Verified only
                </label>
            </div>

            <button type="submit" class="btn-apply">Apply Filters</button>

        </form>
    </aside>

    {{-- RESULTS --}}
    <div>

        {{-- Results header --}}
        <div class="results-header">
            <p class="results-count">
                <strong>{{ $studios->total() }}</strong> {{ Str::plural('studio', $studios->total()) }} found
                @if(request('location'))
                near <strong>{{ request('location') }}</strong>
                @endif
            </p>
            <select class="sort-select" name="sort" onchange="this.form && this.form.submit()"
                form="filterForm">
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest first</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top rated</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>

        {{-- Active filter chips --}}
        @if(request()->hasAny(['location','min_price','max_price','specs','verified','spec']))
        <div class="active-filters">
            @if(request('location'))
            <a href="{{ request()->fullUrlWithoutParameters(['location']) }}" class="filter-chip">
                📍 {{ request('location') }} <span class="remove">×</span>
            </a>
            @endif
            @if(request('min_price') || request('max_price'))
            <a href="{{ request()->fullUrlWithoutParameters(['min_price','max_price']) }}" class="filter-chip">
                ₱{{ request('min_price','0') }}–{{ request('max_price','∞') }} <span class="remove">×</span>
            </a>
            @endif
            @if(request('verified'))
            <a href="{{ request()->fullUrlWithoutParameters(['verified']) }}" class="filter-chip">
                ✓ Verified <span class="remove">×</span>
            </a>
            @endif
            @foreach(request('specs', []) as $chip)
            <a href="{{ request()->fullUrlWithoutParameters(['specs']) }}" class="filter-chip">
                {{ ucwords(str_replace('_',' ',$chip)) }} <span class="remove">×</span>
            </a>
            @endforeach
        </div>
        @endif

        {{-- Studio grid --}}
        <div class="studio-grid">

            @forelse($studios as $studio)

            <div class="studio-card" style="cursor:default">
                {{-- Image --}}
                <div class="card-image">
                    @if($studio->cover_photo)
                    <img src="{{ asset('storage/'.$studio->cover_photo) }}" alt="{{ $studio->name }}">
                    @else
                    <div class="card-image-placeholder">🏢</div>
                    @endif

                    {{-- Badges --}}
                    @if($studio->is_verified)
                    <span class="card-badge badge-verified">✓ Verified</span>
                    @elseif($studio->is_featured)
                    <span class="card-badge badge-featured">⭐ Featured</span>
                    @endif

                    {{-- Save / favorite --}}
                    @auth
                    <form method="POST" action="{{ route('favorites.toggle') }}" style="display:contents">
                        @csrf
                        <input type="hidden" name="favorable_type" value="App\Models\Studio">
                        <input type="hidden" name="favorable_id" value="{{ $studio->id }}">
                        <button type="submit" class="card-save {{ isset($favoriteIds) && in_array($studio->id, $favoriteIds) ? 'saved' : '' }}"
                            title="{{ isset($favoriteIds) && in_array($studio->id, $favoriteIds) ? 'Remove from saved' : 'Save studio' }}">
                            {{ isset($favoriteIds) && in_array($studio->id, $favoriteIds) ? '♥' : '♡' }}
                        </button>
                    </form>
                    @endauth

                    {{-- Studio logo chip --}}
                    <div class="card-logo">
                        @if($studio->logo)
                        <img src="{{ asset('storage/'.$studio->logo) }}" alt="{{ $studio->name }}">
                        @else
                        {{ strtoupper(substr($studio->name, 0, 1)) }}
                        @endif
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body">
                    <h3 class="card-name">{{ $studio->name }}</h3>

                    <p class="card-loc">
                        📍 {{ collect([$studio->city, $studio->province])->filter()->implode(', ') ?: ($studio->address ?? 'Location not set') }}
                    </p>

                    {{-- Specialization pills (max 3 + overflow) --}}
                    @if(!empty($studio->specializations))
                    <div class="card-specs">
                        @foreach(array_slice($studio->specializations, 0, 3) as $spec)
                        <span class="card-spec">{{ ucwords(str_replace('_',' ',$spec)) }}</span>
                        @endforeach
                        @if(count($studio->specializations) > 3)
                        <span class="card-spec more">+{{ count($studio->specializations) - 3 }}</span>
                        @endif
                    </div>
                    @endif

                    {{-- Rating --}}
                    @if($studio->average_rating > 0)
                    <div class="card-rating">
                        <span class="card-stars">
                            @for($s = 1; $s <= 5; $s++){{ $s <= round($studio->average_rating) ? '★' : '☆' }}@endfor
                                </span>
                                {{ number_format($studio->average_rating, 1) }}
                                <span style="color:var(--slate-light)">·</span>
                                {{ $studio->total_reviews }} {{ Str::plural('review', $studio->total_reviews) }}
                    </div>
                    @endif

                    {{-- Card footer: rate + CTA --}}
                    <div class="card-footer">
                        <div class="card-rate">
                            @if($studio->hourly_rate)
                            <div class="card-rate-value">
                                <span class="curr">₱</span>{{ number_format($studio->hourly_rate, 0) }}
                            </div>
                            <div class="card-rate-label">per hour</div>
                            @elseif($studio->full_day_rate)
                            <div class="card-rate-value">
                                <span class="curr">₱</span>{{ number_format($studio->full_day_rate, 0) }}
                            </div>
                            <div class="card-rate-label">full day</div>
                            @else
                            <div class="card-rate-value" style="font-size:0.85rem;font-family:'Inter',sans-serif;color:var(--slate-mid)">Contact for rate</div>
                            @endif
                        </div>
                        <a href="{{ route('studios.public', $studio) }}" class="btn-book">
                            View & Book →
                        </a>
                    </div>
                </div>
            </div>

            @empty

            <div class="empty-state">
                <div class="empty-icon">🏢</div>
                <h3 class="empty-title">No studios found</h3>
                <p class="empty-sub">Try adjusting your filters or search a different location.</p>
            </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if($studios->hasPages())
        <div class="pagination-wrap">
            {{ $studios->links() }}
        </div>
        @endif

    </div>
</div>

@endsection