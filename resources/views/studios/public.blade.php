@extends('layouts.app')

@section('title', $studio->name . ' — NestPeek Photo')

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
        --amber-faint: rgba(245, 158, 11, 0.08);
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

    /* ── Hero cover ── */
    .pub-hero {
        position: relative;
        height: 320px;
        background: linear-gradient(135deg, #0C4A6E, #1e3a5f);
        overflow: hidden;
    }

    .pub-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pub-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(12, 74, 110, 0.15) 0%, rgba(12, 74, 110, 0.78) 100%);
    }

    .pub-back {
        position: absolute;
        top: 20px;
        left: 24px;
        z-index: 5;
        color: #fff;
        font-size: 0.8rem;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 7px 14px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pub-back:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .status-badge {
        position: absolute;
        top: 20px;
        right: 24px;
        z-index: 5;
        padding: 5px 12px;
        border-radius: 50px;
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: rgba(16, 185, 129, 0.22);
        border: 1px solid rgba(16, 185, 129, 0.45);
        color: #fff;
    }

    /* ── Page wrapper ── */
    .pub-page {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 24px 80px;
    }

    /* ── Identity block ── */
    .pub-identity {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        margin-top: -56px;
        position: relative;
        z-index: 10;
        margin-bottom: 24px;
    }

    .pub-logo {
        width: 100px;
        height: 100px;
        border-radius: 22px;
        border: 3px solid #fff;
        background: linear-gradient(135deg, var(--studio), var(--studio-mid));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 2.3rem;
        flex-shrink: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.14);
        overflow: hidden;
    }

    .pub-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pub-identity-meta {
        flex: 1;
        padding-bottom: 4px;
    }

    .pub-name {
        font-family: 'Playfair Display', serif;
        font-size: 2.1rem;
        color: var(--navy);
        font-weight: 400;
        line-height: 1.15;
    }

    .pub-tagline {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .pub-meta-row {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        color: var(--slate);
    }

    .rating-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--amber-faint);
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 3px 9px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #92400E;
    }

    .pub-identity-actions {
        display: flex;
        gap: 8px;
        padding-bottom: 4px;
        flex-shrink: 0;
    }

    .btn-favorite {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        background: #fff;
        color: var(--text-muted);
        border: 1.5px solid var(--border-mid);
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-favorite.saved {
        color: #DB2777;
        border-color: rgba(219, 39, 119, 0.3);
        background: rgba(219, 39, 119, 0.06);
    }

    .btn-favorite:hover {
        background: var(--sky-faint);
    }

    /* ── Flash ── */
    .flash {
        background: var(--green-faint);
        border: 1.5px solid var(--green-border);
        color: #065F46;
        border-radius: 12px;
        padding: 11px 18px;
        margin-bottom: 20px;
        font-size: 0.83rem;
        font-weight: 500;
    }

    /* ── Two-col layout ── */
    .pub-two-col {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }

    /* ── Card ── */
    .card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.04);
        overflow: hidden;
        margin-bottom: 18px;
    }

    .card-header {
        padding: 18px 22px 0;
    }

    .card-body {
        padding: 16px 22px 20px;
    }

    .section-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.59rem;
        letter-spacing: 0.13em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    /* ── Services ── */
    .service-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid var(--border);
    }

    .service-row:last-child {
        border-bottom: none;
    }

    .service-name {
        font-size: 0.86rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .service-desc {
        font-size: 0.74rem;
        color: var(--text-muted);
        margin-top: 2px;
        line-height: 1.5;
    }

    .service-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .service-price {
        font-family: 'DM Mono', monospace;
        font-size: 0.85rem;
        color: var(--sky-mid);
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-book-service {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 16px;
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        border: none;
        border-radius: 50px;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 3px 10px rgba(14, 165, 233, 0.25);
        transition: all 0.2s;
    }

    .btn-book-service:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(14, 165, 233, 0.35);
    }

    /* ── Rates ── */
    .rate-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .rate-row:last-child {
        border-bottom: none;
    }

    .rate-name {
        font-size: 0.84rem;
        color: var(--text-muted);
    }

    .rate-val {
        font-family: 'DM Mono', monospace;
        font-size: 0.92rem;
        color: var(--navy);
        font-weight: 600;
    }

    .rate-val .curr {
        font-size: 0.72rem;
        color: var(--sky-mid);
        margin-right: 1px;
    }

    /* ── Specs ── */
    .spec-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 4px;
    }

    .spec-tag {
        background: var(--studio-faint);
        border: 1px solid var(--studio-border);
        color: var(--studio-mid);
        padding: 4px 11px;
        border-radius: 50px;
        font-size: 0.74rem;
        font-weight: 600;
    }

    /* ── Team ── */
    .team-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
    }

    .team-row:last-child {
        border-bottom: none;
    }

    .team-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .team-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        flex-shrink: 0;
        overflow: hidden;
    }

    .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-name {
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .team-role {
        font-size: 0.71rem;
        color: var(--slate-mid);
        text-transform: capitalize;
    }

    /* ── Reviews ── */
    .review-row {
        padding: 13px 0;
        border-bottom: 1px solid var(--border);
    }

    .review-row:last-child {
        border-bottom: none;
    }

    .review-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .review-name {
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .review-stars {
        color: var(--amber);
        font-size: 0.84rem;
        letter-spacing: 1px;
    }

    .review-body {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .review-date {
        font-size: 0.69rem;
        color: var(--slate-mid);
        margin-top: 4px;
    }

    /* ── Booking sidebar card ── */
    .booking-card {
        position: sticky;
        top: 24px;
    }

    .booking-card-inner {
        background: linear-gradient(135deg, var(--navy), #0369A1);
        border-radius: 20px;
        padding: 24px 22px;
        color: #fff;
        box-shadow: 0 8px 28px rgba(12, 74, 110, 0.22);
    }

    .booking-headline {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        margin-bottom: 4px;
    }

    .booking-sub {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 18px;
        line-height: 1.5;
    }

    .booking-from-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 18px;
    }

    .booking-from-val {
        font-family: 'DM Mono', monospace;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .booking-from-label {
        font-size: 0.76rem;
        color: rgba(255, 255, 255, 0.65);
    }

    .btn-book-main {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 13px;
        background: #fff;
        color: var(--navy);
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-book-main:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18);
    }

    .btn-book-main:disabled,
    .btn-book-main.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .booking-note {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.55);
        text-align: center;
        margin-top: 10px;
    }

    /* ── Contact info ── */
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid var(--border);
        font-size: 0.82rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-icon {
        font-size: 0.95rem;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
        margin-top: 1px;
    }

    .info-label {
        color: var(--slate-mid);
        font-size: 0.68rem;
        display: block;
    }

    .info-value {
        color: var(--text-main);
        font-weight: 500;
        word-break: break-word;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 24px 0;
        color: var(--slate-mid);
        font-size: 0.8rem;
    }

    .empty-icon {
        font-size: 1.5rem;
        margin-bottom: 6px;
    }

    @media(max-width: 900px) {
        .pub-two-col {
            grid-template-columns: 1fr;
        }

        .booking-card {
            position: static;
        }
    }

    @media(max-width: 600px) {
        .pub-identity {
            flex-direction: column;
            align-items: flex-start;
        }

        .pub-identity-actions {
            padding-bottom: 0;
            width: 100%;
        }

        .btn-favorite {
            width: 100%;
            justify-content: center;
        }
    }
</style>

{{-- Hero cover --}}
<div class="pub-hero">
    @if($studio->cover_photo)
    <img src="{{ asset('storage/' . $studio->cover_photo) }}" alt="{{ $studio->name }}">
    @endif
    <div class="pub-hero-overlay"></div>

    <a href="{{ route('studios.index') }}" class="pub-back">← Back to studios</a>

    @if($studio->is_verified)
    <span class="status-badge">✓ Verified Studio</span>
    @endif
</div>

<div class="pub-page">

    @if(session('success'))
    <div class="flash" style="margin-top:20px">✓ {{ session('success') }}</div>
    @endif

    {{-- Identity block --}}
    <div class="pub-identity">
        <div class="pub-logo">
            @if($studio->logo)
            <img src="{{ asset('storage/' . $studio->logo) }}" alt="{{ $studio->name }} logo">
            @else
            {{ strtoupper(substr($studio->name, 0, 1)) }}
            @endif
        </div>
        <div class="pub-identity-meta">
            <h1 class="pub-name">{{ $studio->name }}</h1>
            @if($studio->tagline)
            <p class="pub-tagline">{{ $studio->tagline }}</p>
            @endif
            <div class="pub-meta-row">
                <span class="meta-chip">📍 {{ collect([$studio->city, $studio->province])->filter()->implode(', ') ?: ($studio->address ?? 'Location not set') }}</span>
                @if($studio->average_rating > 0)
                <span class="rating-pill">★ {{ number_format($studio->average_rating, 1) }} · {{ $studio->total_reviews }} {{ Str::plural('review', $studio->total_reviews) }}</span>
                @endif
                @if($studio->max_capacity)
                <span class="meta-chip">👥 Up to {{ $studio->max_capacity }}</span>
                @endif
            </div>
        </div>
        <div class="pub-identity-actions">
            @auth
            <form method="POST" action="{{ route('favorites.toggle') }}">
                @csrf
                <input type="hidden" name="favorable_type" value="App\Models\Studio">
                <input type="hidden" name="favorable_id" value="{{ $studio->id }}">
                <button type="submit" class="btn-favorite {{ $isFavorited ? 'saved' : '' }}">
                    {{ $isFavorited ? '♥ Saved' : '♡ Save' }}
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-favorite">♡ Save</a>
            @endauth
        </div>
    </div>

    {{-- Main two-col --}}
    <div class="pub-two-col">

        {{-- LEFT --}}
        <div>

            {{-- About --}}
            @if($studio->description)
            <div class="card">
                <div class="card-header">
                    <p class="section-label">About</p>
                </div>
                <div class="card-body">
                    <p style="font-size:0.86rem;color:var(--text-muted);line-height:1.75">{{ $studio->description }}</p>
                </div>
            </div>
            @endif

            {{-- Services (bookable) --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Services</p>
                </div>
                <div class="card-body">
                    @if($studio->services->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🛠</div>
                        <p>No individual services listed. You can still book the studio directly using the rates below.</p>
                    </div>
                    @else
                    @foreach($studio->services as $service)
                    <div class="service-row">
                        <div>
                            <p class="service-name">{{ $service->name }}</p>
                            @if($service->description)
                            <p class="service-desc">{{ $service->description }}</p>
                            @endif
                        </div>
                        <div class="service-right">
                            @if($service->price)
                            <span class="service-price">₱{{ number_format($service->price, 0) }}</span>
                            @endif
                            @auth
                            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" class="btn-book-service">Book →</a>
                            @else
                            <a href="{{ route('login') }}" class="btn-book-service">Book →</a>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            {{-- Rates (informational) --}}
            @if($studio->hourly_rate || $studio->half_day_rate || $studio->full_day_rate)
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Rates</p>
                </div>
                <div class="card-body">
                    @if($studio->hourly_rate)
                    <div class="rate-row">
                        <span class="rate-name">Hourly rate</span>
                        <span class="rate-val"><span class="curr">₱</span>{{ number_format($studio->hourly_rate, 0) }}</span>
                    </div>
                    @endif
                    @if($studio->half_day_rate)
                    <div class="rate-row">
                        <span class="rate-name">Half day (4 hrs)</span>
                        <span class="rate-val"><span class="curr">₱</span>{{ number_format($studio->half_day_rate, 0) }}</span>
                    </div>
                    @endif
                    @if($studio->full_day_rate)
                    <div class="rate-row">
                        <span class="rate-name">Full day (8 hrs)</span>
                        <span class="rate-val"><span class="curr">₱</span>{{ number_format($studio->full_day_rate, 0) }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Specializations --}}
            @if(!empty($studio->specializations))
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Specializations</p>
                </div>
                <div class="card-body">
                    <div class="spec-tags">
                        @foreach($studio->specializations as $spec)
                        <span class="spec-tag">{{ ucwords(str_replace('_', ' ', $spec)) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Team --}}
            @if($studio->creators->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Team</p>
                </div>
                <div class="card-body">
                    @foreach($studio->creators as $creator)
                    <div class="team-row">
                        <div class="team-left">
                            <div class="team-avatar">
                                @if($creator->user && $creator->user->avatar)
                                <img src="{{ asset('storage/' . $creator->user->avatar) }}" alt="{{ $creator->user->name }}">
                                @else
                                {{ strtoupper(substr($creator->user->name ?? '?', 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <p class="team-name">{{ $creator->user->name ?? 'Team Member' }}</p>
                                @if($creator->pivot->role ?? null)
                                <p class="team-role">{{ str_replace('_', ' ', $creator->pivot->role) }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('creators.show', $creator->slug ?? $creator->id) }}" style="font-size:0.74rem;color:var(--sky-mid);text-decoration:none;font-weight:600">View profile →</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Reviews
                        @if($studio->total_reviews > 0)
                        <span style="color:var(--slate-light);margin-left:6px">{{ $studio->total_reviews }}</span>
                        @endif
                    </p>
                </div>
                <div class="card-body">
                    @if($studio->reviews->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">⭐</div>
                        <p>No reviews yet.</p>
                    </div>
                    @else
                    @foreach($studio->reviews->take(8) as $review)
                    <div class="review-row">
                        <div class="review-top">
                            <span class="review-name">{{ $review->reviewer->name ?? 'Client' }}</span>
                            <span class="review-stars">
                                @for($s = 1; $s <= 5; $s++){{ $s <= $review->rating ? '★' : '☆' }}@endfor
                                    </span>
                        </div>
                        @if($review->body)
                        <p class="review-body">{{ $review->body }}</p>
                        @endif
                        @if($review->created_at)
                        <p class="review-date">{{ $review->created_at->format('M j, Y') }}</p>
                        @endif
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div>
            <div class="booking-card">
                <div class="booking-card-inner">
                    <p class="booking-headline">Ready to book?</p>
                    <p class="booking-sub">Send a booking request and {{ $studio->name }} will confirm availability.</p>

                    @php
                    $startingRate = $studio->hourly_rate ?? $studio->full_day_rate ?? $studio->half_day_rate ?? optional($studio->services->sortBy('price')->first())->price;
                    @endphp

                    @if($startingRate)
                    <div class="booking-from-row">
                        <span class="booking-from-val">₱{{ number_format($startingRate, 0) }}</span>
                        <span class="booking-from-label">starting rate</span>
                    </div>
                    @endif

                    @auth
                    @if($studio->services->isNotEmpty())
                    <a href="{{ route('bookings.create', ['service_id' => $studio->services->first()->id]) }}" class="btn-book-main">📅 Book This Studio</a>
                    @else
                    <span class="btn-book-main disabled">No bookable services yet</span>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="btn-book-main">📅 Log in to Book</a>
                    @endauth

                    <p class="booking-note">No payment required to send a request</p>
                </div>
            </div>

            {{-- Contact info --}}
            <div class="card" style="margin-top:18px">
                <div class="card-header">
                    <p class="section-label">Contact Info</p>
                </div>
                <div class="card-body" style="padding-bottom:14px">
                    @if($studio->phone)
                    <div class="info-row">
                        <span class="info-icon">📞</span>
                        <div><span class="info-label">Phone</span><span class="info-value">{{ $studio->phone }}</span></div>
                    </div>
                    @endif
                    @if($studio->email)
                    <div class="info-row">
                        <span class="info-icon">✉️</span>
                        <div><span class="info-label">Email</span><span class="info-value">{{ $studio->email }}</span></div>
                    </div>
                    @endif
                    @if($studio->address)
                    <div class="info-row">
                        <span class="info-icon">📍</span>
                        <div><span class="info-label">Address</span><span class="info-value">{{ collect([$studio->address, $studio->city, $studio->province])->filter()->implode(', ') }}</span></div>
                    </div>
                    @endif
                    @if($studio->website)
                    <div class="info-row">
                        <span class="info-icon">🌐</span>
                        <div><span class="info-label">Website</span><a href="{{ $studio->website }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.82rem;text-decoration:none">{{ $studio->website }}</a></div>
                    </div>
                    @endif
                    @if($studio->instagram)
                    <div class="info-row">
                        <span class="info-icon">📸</span>
                        <div><span class="info-label">Instagram</span><a href="https://instagram.com/{{ ltrim($studio->instagram,'@') }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.82rem;text-decoration:none">@{{ ltrim($studio->instagram,'@') }}</a></div>
                    </div>
                    @endif
                    @if($studio->facebook)
                    <div class="info-row">
                        <span class="info-icon">📘</span>
                        <div><span class="info-label">Facebook</span><a href="{{ $studio->facebook }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.82rem;text-decoration:none">View page →</a></div>
                    </div>
                    @endif

                    @unless($studio->phone || $studio->email || $studio->website)
                    <div class="empty-state" style="padding:10px 0">
                        <p>No contact info provided.</p>
                    </div>
                    @endunless
                </div>
            </div>
        </div>

    </div>
</div>

@endsection