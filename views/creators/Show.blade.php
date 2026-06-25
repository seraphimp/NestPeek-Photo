@extends('layouts.app')
@section('title', $creatorProfile->display_name . ' — NestPeek Photo')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Inter:wght@400;500;600&family=DM+Mono&display=swap');

    :root {
        --sky: #0EA5E9;
        --sky-light: #38BDF8;
        --sky-mid: #0369A1;
        --navy: #0C4A6E;
        --white: #FFFFFF;
        --sky-faint: #F0F9FF;
        --sky-pale: #E0F2FE;
        --slate: #64748B;
        --slate-mid: #94A3B8;
        --slate-light: #CBD5E1;
        --text-main: #0F172A;
        --text-muted: #475569;
        --border: rgba(14, 165, 233, 0.14);
        --border-mid: rgba(14, 165, 233, 0.28);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* ── Hero ── */
    .hero {
        position: relative;
        height: 340px;
        background: linear-gradient(160deg, #0C4A6E 0%, #0369A1 55%, #0EA5E9 100%);
        overflow: hidden;
    }

    .hero-cover {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.35;
    }

    .hero-blob {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    /* ── Profile card ── */
    .profile-card {
        max-width: 980px;
        margin: -80px auto 0;
        padding: 0 24px;
        position: relative;
        z-index: 2;
    }

    .profile-inner {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 24px;
        padding: 28px 32px 24px;
        box-shadow: 0 8px 32px rgba(14, 165, 233, 0.1);
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .profile-avatar {
        width: 92px;
        height: 92px;
        border-radius: 20px;
        object-fit: cover;
        background: var(--sky-pale);
        border: 3px solid #fff;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.2);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        flex: 1;
        min-width: 0;
    }

    .profile-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.63rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--sky-mid);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 400;
        color: var(--navy);
        margin: 0 0 6px;
        line-height: 1.2;
    }

    .profile-tagline {
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-bottom: 12px;
        font-style: italic;
    }

    .profile-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 20px;
        background: var(--sky-faint);
        color: var(--sky-mid);
        border: 1px solid var(--border-mid);
    }

    .chip-green {
        background: rgba(34, 197, 94, 0.1);
        color: #15803D;
        border-color: rgba(34, 197, 94, 0.25);
    }

    .chip-amber {
        background: rgba(245, 158, 11, 0.1);
        color: #B45309;
        border-color: rgba(245, 158, 11, 0.25);
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
        align-items: flex-end;
    }

    .profile-price {
        text-align: right;
        margin-bottom: 4px;
    }

    .profile-price-num {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.6rem;
        font-weight: 400;
        color: var(--navy);
        display: block;
        line-height: 1;
    }

    .profile-price-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        font-weight: 500;
        padding: 10px 22px;
        border-radius: 50px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        box-shadow: 0 4px 14px rgba(14, 165, 233, 0.35);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.45);
    }

    .btn-outline {
        border: 1.5px solid var(--border-mid);
        color: var(--slate);
        background: transparent;
    }

    .btn-outline:hover {
        border-color: var(--sky);
        color: var(--sky);
        background: var(--sky-faint);
    }

    .btn-fav {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 50%;
        border: 1.5px solid var(--border-mid);
        background: transparent;
        color: var(--slate-mid);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-fav:hover,
    .btn-fav.active {
        border-color: #FB7185;
        color: #FB7185;
        background: rgba(251, 113, 133, 0.08);
    }

    /* ── Main layout ── */
    .page-body {
        max-width: 980px;
        margin: 32px auto 80px;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 28px;
        align-items: start;
    }

    /* ── Section ── */
    .section {
        margin-bottom: 28px;
    }

    .section-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.62rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--slate-mid);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Stats ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 28px;
    }

    .stat-box {
        background: var(--sky-faint);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 18px 16px;
        text-align: center;
    }

    .stat-num {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 400;
        color: var(--navy);
        display: block;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-lbl {
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate);
    }

    /* ── Bio ── */
    .bio-text {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.75;
    }

    /* ── Tags ── */
    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag {
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        padding: 5px 13px;
        border-radius: 20px;
        background: var(--sky-pale);
        color: var(--sky-mid);
        border: 1px solid var(--border-mid);
    }

    /* ── Portfolio ── */
    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .portfolio-item {
        border-radius: 14px;
        overflow: hidden;
        aspect-ratio: 4/3;
        background: var(--sky-pale);
        position: relative;
        cursor: pointer;
        border: 1.5px solid var(--border);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .portfolio-item:first-child {
        grid-column: span 2;
        grid-row: span 2;
        aspect-ratio: unset;
    }

    .portfolio-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.14);
    }

    .portfolio-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .portfolio-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(12, 74, 110, 0.75) 0%, transparent 55%);
        opacity: 0;
        transition: opacity 0.2s;
        display: flex;
        align-items: flex-end;
        padding: 14px;
    }

    .portfolio-item:hover .portfolio-overlay {
        opacity: 1;
    }

    .portfolio-overlay-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 0.9rem;
        color: #fff;
        font-style: italic;
    }

    .portfolio-empty {
        background: var(--sky-faint);
        border: 1.5px dashed rgba(14, 165, 233, 0.25);
        border-radius: 16px;
        padding: 40px 24px;
        text-align: center;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--slate-mid);
    }

    /* ── Services ── */
    .service-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .service-card:hover {
        border-color: var(--border-mid);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.08);
    }

    .service-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--sky-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .service-info {
        flex: 1;
        min-width: 0;
    }

    .service-name {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 3px;
    }

    .service-desc {
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .service-price {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.1rem;
        color: var(--navy);
        flex-shrink: 0;
        text-align: right;
    }

    .service-price-type {
        display: block;
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem;
        color: var(--slate-mid);
        letter-spacing: 0.08em;
    }

    .services-empty {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--slate-mid);
        font-style: italic;
        padding: 16px 0;
    }

    /* ── Reviews ── */
    .review-card {
        background: var(--sky-faint);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 10px;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .review-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--sky-pale);
        flex-shrink: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .review-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .review-reviewer {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--navy);
    }

    .review-date {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        color: var(--slate-mid);
        letter-spacing: 0.08em;
        margin-left: auto;
    }

    .review-stars {
        color: #F59E0B;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .review-body {
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        color: var(--text-muted);
        line-height: 1.65;
    }

    .reviews-empty {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--slate-mid);
        font-style: italic;
        padding: 12px 0;
    }

    /* ── Sidebar cards ── */
    .sidebar-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 22px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(14, 165, 233, 0.06);
    }

    .sidebar-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 14px;
    }

    .sidebar-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .sidebar-row-icon {
        font-size: 1rem;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
        margin-top: 1px;
    }

    .sidebar-social {
        display: flex;
        gap: 8px;
        margin-top: 6px;
    }

    .social-link {
        padding: 7px 14px;
        border: 1.5px solid var(--border-mid);
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        color: var(--slate);
        text-decoration: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .social-link:hover {
        border-color: var(--sky);
        color: var(--sky);
        background: var(--sky-faint);
    }

    /* ── Booking CTA ── */
    .book-cta {
        background: linear-gradient(135deg, #0C4A6E 0%, #0369A1 60%, #0EA5E9 100%);
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        position: sticky;
        top: 24px;
    }

    .book-cta h3 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.15rem;
        font-weight: 400;
        color: #fff;
        margin: 0 0 6px;
    }

    .book-cta p {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.65);
        margin: 0 0 18px;
    }

    .book-cta .btn-white {
        display: block;
        padding: 12px;
        background: #fff;
        color: var(--navy);
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
        transition: transform 0.2s;
    }

    .book-cta .btn-white:hover {
        transform: translateY(-1px);
    }

    .book-cta .btn-ghost {
        display: block;
        padding: 10px;
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        color: rgba(255, 255, 255, 0.85);
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        text-decoration: none;
        transition: background 0.2s;
    }

    .book-cta .btn-ghost:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ── Lightbox ── */
    #lb {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(10, 18, 28, 0.93);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }

    #lb.open {
        display: flex;
    }

    #lb img {
        max-width: 90vw;
        max-height: 88vh;
        border-radius: 10px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.5);
    }

    #lb-close {
        position: fixed;
        top: 18px;
        right: 22px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 1.1rem;
        cursor: pointer;
        backdrop-filter: blur(4px);
    }

    @media (max-width: 768px) {
        .page-body {
            grid-template-columns: 1fr;
        }

        .profile-inner {
            flex-wrap: wrap;
        }

        .profile-actions {
            flex-direction: row;
            align-items: center;
            width: 100%;
        }

        .portfolio-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .portfolio-item:first-child {
            grid-column: span 2;
            grid-row: span 1;
        }

        .stats-row {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .hero {
            height: 220px;
        }

        .profile-card {
            margin-top: -60px;
        }

        .book-cta {
            position: static;
        }
    }
</style>

{{-- Hero --}}
<div class="hero">
    @if($creatorProfile->cover_photo)
    <img class="hero-cover" src="{{ $creatorProfile->cover_photo_url }}" alt="">
    @endif
    <div class="hero-blob" style="top:-80px;right:-80px;width:320px;height:320px;background:rgba(56,189,248,0.12)"></div>
    <div class="hero-blob" style="bottom:-60px;left:20%;width:200px;height:200px;background:rgba(255,255,255,0.05)"></div>
</div>

{{-- Profile card --}}
<div class="profile-card">
    <div class="profile-inner">

        <div class="profile-avatar">
            @if($creatorProfile->user->avatar)
            <img src="{{ asset('storage/' . $creatorProfile->user->avatar) }}" alt="{{ $creatorProfile->display_name }}">
            @else
            📷
            @endif
        </div>

        <div class="profile-info">
            <p class="profile-eyebrow">
                <span style="display:inline-block;width:20px;height:1px;background:var(--sky-light)"></span>
                {{ $creatorProfile->specialization_label }}
            </p>
            <h1 class="profile-name">{{ $creatorProfile->display_name }}</h1>
            @if($creatorProfile->tagline)
            <p class="profile-tagline">"{{ $creatorProfile->tagline }}"</p>
            @endif
            <div class="profile-chips">
                @if($creatorProfile->is_available)
                <span class="chip chip-green">✓ Available</span>
                @else
                <span class="chip chip-amber">Unavailable</span>
                @endif
                @if($creatorProfile->years_experience > 0)
                <span class="chip">{{ $creatorProfile->years_experience }}yr exp</span>
                @endif
                @if($creatorProfile->user->location)
                <span class="chip">📍 {{ $creatorProfile->user->location }}</span>
                @endif
                @if($creatorProfile->average_rating > 0)
                <span class="chip">⭐ {{ number_format($creatorProfile->average_rating, 1) }}</span>
                @endif
                @if($creatorProfile->travels_internationally)
                <span class="chip">✈ Travels internationally</span>
                @endif
            </div>
        </div>

        <div class="profile-actions">
            @if($creatorProfile->starting_price)
            <div class="profile-price">
                <span class="profile-price-num">₱{{ number_format($creatorProfile->starting_price) }}</span>
                <span class="profile-price-label">Starting price</span>
            </div>
            @endif
            <div style="display:flex;gap:8px;align-items:center">
                @auth
                <button class="btn-fav {{ $isFavorited ? 'active' : '' }}"
                    id="fav-btn"
                    onclick="toggleFavorite({{ $creatorProfile->id }})"
                    title="{{ $isFavorited ? 'Remove from favorites' : 'Save to favorites' }}">
                    {{ $isFavorited ? '♥' : '♡' }}
                </button>
                @endauth
                {{-- FIX: use JS smooth scroll instead of bare anchor --}}
                <button class="btn btn-primary" onclick="scrollToBook()">Book Now</button>
            </div>
        </div>

    </div>
</div>

{{-- Page body --}}
<div class="page-body">

    {{-- ── LEFT COLUMN ── --}}
    <div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-box">
                <span class="stat-num">{{ $creatorProfile->total_bookings }}</span>
                <span class="stat-lbl">Shoots Done</span>
            </div>
            <div class="stat-box">
                <span class="stat-num">{{ $creatorProfile->average_rating > 0 ? number_format($creatorProfile->average_rating, 1) : '—' }}</span>
                <span class="stat-lbl">Avg Rating</span>
            </div>
            <div class="stat-box">
                <span class="stat-num">{{ $creatorProfile->total_reviews }}</span>
                <span class="stat-lbl">Reviews</span>
            </div>
        </div>

        {{-- About --}}
        @if($creatorProfile->user->bio)
        <div class="section">
            <p class="section-label">About</p>
            <p class="bio-text">{{ $creatorProfile->user->bio }}</p>
        </div>
        @endif

        {{-- Portfolio --}}
        <div class="section">
            <p class="section-label">Portfolio</p>
            @if($creatorProfile->portfolios->isNotEmpty())
            @php
            $allMedia = $creatorProfile->portfolios
            ->flatMap(fn($p) => $p->media)
            ->filter(fn($m) => $m->type === 'image');
            @endphp
            @if($allMedia->isNotEmpty())
            <div class="portfolio-grid">
                @foreach($allMedia->take(7) as $media)
                <div class="portfolio-item" onclick="openLB('{{ asset('storage/' . $media->file_path) }}')">
                    <img src="{{ $media->thumbnail_path ? asset('storage/' . $media->thumbnail_path) : asset('storage/' . $media->file_path) }}"
                        alt="{{ $media->caption ?? 'Portfolio photo' }}" loading="lazy">
                    <div class="portfolio-overlay">
                        <span class="portfolio-overlay-title">{{ $media->caption ?? $creatorProfile->portfolios->firstWhere('id', $media->portfolio_id)?->title ?? '' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="portfolio-empty">No photos uploaded yet.</div>
            @endif
            @else
            <div class="portfolio-empty">Portfolio coming soon.</div>
            @endif
        </div>

        {{-- Services --}}
        <div class="section">
            <p class="section-label">Services</p>
            @forelse($creatorProfile->services as $service)
            <div class="service-card">
                <div class="service-icon">
                    {{ match($service->category) {
                            'wedding_package'  => '💍',
                            'portrait_session' => '🤍',
                            'event_coverage'   => '🎉',
                            'video_production' => '🎬',
                            'studio_rental'    => '🏛️',
                            'coordination'     => '📋',
                            default            => '📷',
                        } }}
                </div>
                <div class="service-info">
                    <div class="service-name">{{ $service->name }}</div>
                    @if($service->description)
                    <div class="service-desc">{{ Str::limit($service->description, 80) }}</div>
                    @elseif($service->inclusions)
                    <div class="service-desc">{{ Str::limit($service->inclusions, 80) }}</div>
                    @endif
                </div>
                <div class="service-price">
                    ₱{{ number_format($service->price) }}
                    <span class="service-price-type">
                        {{ $service->price_type === 'per_hour' ? '/hr' : ($service->duration_hours ? $service->duration_hours . 'hrs' : 'fixed') }}
                    </span>
                </div>
            </div>
            @empty
            <p class="services-empty">No services listed yet.</p>
            @endforelse
        </div>

        {{-- Skills & Styles --}}
        @if($creatorProfile->skills || $creatorProfile->styles || $creatorProfile->equipment)
        <div class="section">
            <p class="section-label">Skills &amp; Style</p>
            @if($creatorProfile->styles)
            <p style="font-family:'DM Mono',monospace;font-size:0.6rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);margin-bottom:8px">Style</p>
            <div class="tag-list" style="margin-bottom:14px">
                @foreach($creatorProfile->styles as $style)
                <span class="tag">{{ $style }}</span>
                @endforeach
            </div>
            @endif
            @if($creatorProfile->skills)
            <p style="font-family:'DM Mono',monospace;font-size:0.6rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);margin-bottom:8px">Skills</p>
            <div class="tag-list" style="margin-bottom:14px">
                @foreach($creatorProfile->skills as $skill)
                <span class="tag">{{ $skill }}</span>
                @endforeach
            </div>
            @endif
            @if($creatorProfile->equipment)
            <p style="font-family:'DM Mono',monospace;font-size:0.6rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);margin-bottom:8px">Equipment</p>
            <div class="tag-list">
                @foreach($creatorProfile->equipment as $item)
                <span class="tag">{{ $item }}</span>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        {{-- Reviews --}}
        <div class="section">
            <p class="section-label">Reviews</p>
            @forelse($creatorProfile->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-avatar">
                        @if($review->reviewer?->avatar)
                        <img src="{{ asset('storage/' . $review->reviewer->avatar) }}" alt="">
                        @else
                        👤
                        @endif
                    </div>
                    <span class="review-reviewer">{{ $review->reviewer?->name ?? 'Anonymous' }}</span>
                    <span class="review-date">{{ $review->created_at->format('M Y') }}</span>
                </div>
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                        </div>
                        @if($review->title)
                        <p style="font-family:'Inter',sans-serif;font-size:0.85rem;font-weight:600;color:var(--navy);margin-bottom:5px">{{ $review->title }}</p>
                        @endif
                        <p class="review-body">{{ $review->content }}</p>
                </div>
                @empty
                <p class="reviews-empty">No reviews yet — be the first to book and share your experience.</p>
                @endforelse
            </div>

        </div>
        {{-- end left column --}}

        {{-- ── RIGHT SIDEBAR ── --}}
        <div>

            {{-- Book CTA — this is the scroll target --}}
            <div class="book-cta" id="book">
                <h3>Ready to book?</h3>
                <p>{{ $creatorProfile->availability_note ?? 'Check availability and send a booking request.' }}</p>
                @auth
                @if($creatorProfile->services->isNotEmpty())
                <a href="{{ route('bookings.create', ['service_id' => $creatorProfile->services->first()->id]) }}" class="btn-white">
                    📅 Request Booking
                </a>
                @else
                <span class="btn-white" style="opacity:0.6;cursor:not-allowed">No services listed</span>
                @endif
                {{-- Message link if conversations exist --}}
                @if(isset($conversation))
                <a href="{{ route('messages.show', $conversation) }}" class="btn-ghost">💬 Send a message</a>
                @endif
                @else
                <a href="{{ route('login') }}" class="btn-white">Sign in to Book</a>
                <a href="{{ route('register') }}" class="btn-ghost">Create account</a>
                @endauth
            </div>

            {{-- Details card --}}
            <div class="sidebar-card">
                <p class="sidebar-title">Details</p>
                @if($creatorProfile->user->location)
                <div class="sidebar-row">
                    <span class="sidebar-row-icon">📍</span>
                    <span>{{ $creatorProfile->user->location }}</span>
                </div>
                @endif
                @if($creatorProfile->service_areas)
                <div class="sidebar-row">
                    <span class="sidebar-row-icon">🗺️</span>
                    <span>Covers: {{ implode(', ', $creatorProfile->service_areas) }}</span>
                </div>
                @endif
                @if($creatorProfile->years_experience > 0)
                <div class="sidebar-row">
                    <span class="sidebar-row-icon">🏅</span>
                    <span>{{ $creatorProfile->years_experience }} years experience</span>
                </div>
                @endif
                @if($creatorProfile->user->instagram || $creatorProfile->user->facebook)
                <div class="sidebar-social">
                    @if($creatorProfile->user->instagram)
                    <a href="https://instagram.com/{{ ltrim($creatorProfile->user->instagram, '@') }}" target="_blank" class="social-link">
                        Instagram
                    </a>
                    @endif
                    @if($creatorProfile->user->facebook)
                    <a href="{{ $creatorProfile->user->facebook }}" target="_blank" class="social-link">
                        Facebook
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Studios card --}}
            @if($creatorProfile->studios->isNotEmpty())
            <div class="sidebar-card">
                <p class="sidebar-title">Part of</p>
                @foreach($creatorProfile->studios as $studio)
                <a href="{{ route('studios.show', $studio->slug) }}"
                    style="display:flex;align-items:center;gap:12px;text-decoration:none;padding:8px 0;border-bottom:1px solid var(--border)">
                    <div style="width:38px;height:38px;border-radius:10px;background:var(--sky-pale);overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1.2rem">
                        @if($studio->logo)
                        <img src="{{ asset('storage/' . $studio->logo) }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                        🏛️
                        @endif
                    </div>
                    <div>
                        <div style="font-family:'Inter',sans-serif;font-size:0.85rem;font-weight:600;color:var(--navy)">{{ $studio->name }}</div>
                        <div style="font-family:'Inter',sans-serif;font-size:0.75rem;color:var(--slate)">{{ $studio->city }}</div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

        </div>
        {{-- end sidebar --}}

    </div>
    {{-- end page-body --}}

    {{-- Lightbox --}}
    <div id="lb" onclick="closeLB()">
        <img id="lb-img" src="" alt="">
        <button id="lb-close" onclick="closeLB()">✕</button>
    </div>

    <script>
        // ── Smooth scroll to booking CTA ──────────────────────────
        function scrollToBook() {
            const el = document.getElementById('book');
            if (!el) return;
            const offset = 24; // gap from viewport top
            const top = el.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        }

        // ── Lightbox ──────────────────────────────────────────────
        function openLB(src) {
            document.getElementById('lb-img').src = src;
            document.getElementById('lb').classList.add('open');
        }

        function closeLB() {
            document.getElementById('lb').classList.remove('open');
            document.getElementById('lb-img').src = '';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLB();
        });

        // ── Favourite toggle ──────────────────────────────────────
        @auth
        async function toggleFavorite(creatorId) {
            const btn = document.getElementById('fav-btn');
            try {
                const res = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        favorable_type: 'creator',
                        favorable_id: creatorId
                    }),
                });
                const data = await res.json();
                if (data.favorited) {
                    btn.textContent = '♥';
                    btn.classList.add('active');
                } else {
                    btn.textContent = '♡';
                    btn.classList.remove('active');
                }
            } catch (e) {
                console.error('Favorite toggle failed', e);
            }
        }
        @endauth
    </script>

    @endsection