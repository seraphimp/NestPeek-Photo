@extends('layouts.app')
@section('title', 'My Booking — NestPeek Photo')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Inter:wght@400;500;600&family=DM+Mono&display=swap');

    :root {
        --sky: #0EA5E9;
        --sky-light: #38BDF8;
        --sky-mid: #0369A1;
        --navy: #0C4A6E;
        --navy-mid: #075985;
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

    * {
        box-sizing: border-box;
    }

    .client-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 40px 20px 80px;
    }

    /* ── Page header ── */
    .page-header {
        margin-bottom: 36px;
    }

    .page-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--sky-mid);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .page-eyebrow::before {
        content: '';
        display: inline-block;
        width: 28px;
        height: 1px;
        background: var(--sky-light);
    }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.2rem;
        font-weight: 400;
        color: var(--navy);
        margin: 0 0 4px;
    }

    .page-sub {
        font-size: 0.88rem;
        color: var(--text-muted);
        font-family: 'Inter', sans-serif;
    }

    /* ── Section label ── */
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

    /* ── Booking card ── */
    .booking-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.07);
        margin-bottom: 32px;
    }

    .booking-card-top {
        padding: 24px 28px 20px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        border-bottom: 1px solid var(--border);
    }

    .booking-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
        background: var(--sky-pale);
        flex-shrink: 0;
        border: 1.5px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        overflow: hidden;
    }

    .booking-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .booking-meta {
        flex: 1;
        min-width: 0;
    }

    .booking-num {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        color: var(--slate-mid);
        letter-spacing: 0.1em;
        margin-bottom: 4px;
    }

    .booking-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.25rem;
        font-weight: 400;
        color: var(--navy);
        margin: 0 0 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .booking-details {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-family: 'Inter', sans-serif;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }

    .dot {
        color: var(--slate-light);
    }

    .booking-right {
        text-align: right;
        flex-shrink: 0;
    }

    .booking-amount {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.35rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 7px;
    }

    /* status badge */
    .badge {
        display: inline-block;
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.02em;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.12);
        color: #B45309;
    }

    .badge-confirmed {
        background: rgba(14, 165, 233, 0.12);
        color: #0369A1;
    }

    .badge-deposit_paid {
        background: rgba(6, 182, 212, 0.12);
        color: #0E7490;
    }

    .badge-in_progress {
        background: rgba(59, 130, 246, 0.12);
        color: #1D4ED8;
    }

    .badge-completed {
        background: rgba(34, 197, 94, 0.12);
        color: #15803D;
    }

    .badge-cancelled {
        background: rgba(239, 68, 68, 0.12);
        color: #B91C1C;
    }

    .badge-refunded {
        background: rgba(100, 116, 139, 0.1);
        color: #475569;
    }

    /* ── Countdown strip ── */
    .countdown-strip {
        padding: 22px 28px;
        background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%);
        border-bottom: 1px solid var(--border);
    }

    .countdown-strip.pending-msg {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border-bottom-color: rgba(245, 158, 11, 0.2);
    }

    .countdown-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.62rem;
        letter-spacing: 0.13em;
        text-transform: uppercase;
        color: var(--slate-mid);
        margin-bottom: 14px;
    }

    .countdown-blocks {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .countdown-unit {
        text-align: center;
    }

    .countdown-num {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.4rem;
        font-weight: 400;
        color: var(--navy);
        line-height: 1;
        display: block;
        min-width: 64px;
    }

    .countdown-unit-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--slate);
        display: block;
        margin-top: 5px;
    }

    .countdown-colon {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        color: var(--slate-light);
        line-height: 1;
        padding-bottom: 16px;
        user-select: none;
    }

    .pending-notice {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #92400E;
    }

    .pending-notice-icon {
        width: 36px;
        height: 36px;
        background: rgba(245, 158, 11, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* ── Booking actions ── */
    .booking-actions {
        padding: 16px 28px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn {
        padding: 9px 20px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
    }

    /* ── Empty state ── */
    .empty-card {
        background: var(--sky-faint);
        border: 1.5px dashed rgba(14, 165, 233, 0.25);
        border-radius: 20px;
        padding: 56px 32px;
        text-align: center;
        margin-bottom: 32px;
    }

    .empty-icon {
        width: 68px;
        height: 68px;
        background: var(--sky-pale);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.8rem;
    }

    .empty-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.4rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .empty-sub {
        font-family: 'Inter', sans-serif;
        font-size: 0.86rem;
        color: var(--text-muted);
        margin-bottom: 22px;
    }

    /* ── My Album ── */
    .album-empty {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 40px 28px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .album-empty-icon {
        width: 64px;
        height: 64px;
        background: var(--sky-pale);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 14px;
    }

    .album-empty-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.15rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .album-empty-sub {
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        color: var(--text-muted);
        max-width: 320px;
        line-height: 1.6;
    }

    .album-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 14px;
        margin-top: 4px;
    }

    .album-item {
        border-radius: 14px;
        overflow: hidden;
        background: var(--sky-pale);
        aspect-ratio: 4/3;
        position: relative;
        cursor: pointer;
        border: 1.5px solid var(--border);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .album-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
    }

    .album-item img,
    .album-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .album-item-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(12, 74, 110, 0.7) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.2s;
        display: flex;
        align-items: flex-end;
        padding: 12px;
    }

    .album-item:hover .album-item-overlay {
        opacity: 1;
    }

    .album-item-caption {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

    .album-video-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(12, 74, 110, 0.75);
        color: #fff;
        font-size: 0.62rem;
        font-family: 'DM Mono', monospace;
        letter-spacing: 0.08em;
        padding: 3px 8px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    /* ── CTA Strip ── */
    .cta-strip {
        background: linear-gradient(135deg, #0C4A6E 0%, #0369A1 60%, #0EA5E9 100%);
        border-radius: 20px;
        padding: 26px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 36px;
        position: relative;
        overflow: hidden;
    }

    .cta-strip::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(56, 189, 248, 0.15);
        pointer-events: none;
    }

    .cta-strip-text h3 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.3rem;
        font-weight: 400;
        color: #fff;
        margin: 0 0 4px;
    }

    .cta-strip-text p {
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        color: rgba(255, 255, 255, 0.65);
        margin: 0;
    }

    .cta-strip-btns {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .btn-white {
        padding: 10px 22px;
        background: #fff;
        color: var(--navy);
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s;
    }

    .btn-white:hover {
        transform: translateY(-2px);
    }

    .btn-ghost-white {
        padding: 10px 20px;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        color: #fff;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.83rem;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-ghost-white:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    @media (max-width: 640px) {
        .booking-card-top {
            flex-wrap: wrap;
            gap: 14px;
        }

        .booking-right {
            text-align: left;
        }

        .countdown-num {
            font-size: 1.9rem;
            min-width: 48px;
        }

        .album-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .cta-strip {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

{{-- Page bg tint --}}
<div style="background: linear-gradient(160deg, #F0F9FF 0%, #fff 40%); min-height: 100vh;">
    <div class="client-wrap">

        {{-- Header --}}
        <div class="page-header">
            <p class="page-eyebrow">My Space</p>
            <h1 class="page-title">Hello, {{ explode(' ', $user->name)[0] }}.</h1>
            <p class="page-sub">Your booking and delivered photos &amp; videos, all in one place.</p>
        </div>

        {{-- CTA Strip (only when no bookings) --}}
        @if($bookings->isEmpty())
        <div class="cta-strip" style="margin-bottom:32px">
            <div class="cta-strip-text" style="position:relative;z-index:1">
                <h3>Book your first shoot</h3>
                <p>Browse 2,500+ verified photographers and studios across the Philippines.</p>
            </div>
            <div class="cta-strip-btns">
                <a href="{{ route('creators.index') }}" class="btn-white">Browse Creators</a>
                <a href="{{ route('studios.index') }}" class="btn-ghost-white">Find Studios</a>
            </div>
        </div>
        @endif

        {{-- ── MY BOOKING ── --}}
        <p class="section-label">My Booking</p>

        @forelse($bookings as $booking)
        @php
        $statusClass = 'badge-' . $booking->status;
        $badge = $booking->status_badge;
        $isConfirmed = in_array($booking->status, ['confirmed','deposit_paid','in_progress','completed']);
        $isPending = $booking->status === 'pending';
        $eventDate = \Carbon\Carbon::parse($booking->event_date)->startOfDay();
        $now = \Carbon\Carbon::now()->startOfDay();
        $diffDays = $now->diffInDays($eventDate, false);
        @endphp

        <div class="booking-card">

            {{-- Top info row --}}
            <div class="booking-card-top">

                <div class="booking-avatar">
                    @if($booking->creatorProfile)
                    <img src="{{ $booking->creatorProfile->user->avatar_url }}" alt="">
                    @else
                    🏛️
                    @endif
                </div>

                <div class="booking-meta">
                    <div class="booking-num">{{ $booking->booking_number }}</div>
                    <h2 class="booking-name">{{ $booking->creatorProfile?->display_name ?? $booking->studio?->name ?? 'Unknown' }}</h2>
                    <div class="booking-details">
                        <span>{{ $booking->service->name }}</span>
                        <span class="dot">·</span>
                        <span>{{ $booking->event_date->format('M d, Y') }}</span>
                        @if($booking->start_time)
                        <span class="dot">·</span>
                        <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</span>
                        @endif
                        @if($booking->event_type)
                        <span class="dot">·</span>
                        <span>{{ $booking->event_type }}</span>
                        @endif
                        @if($booking->venue)
                        <span class="dot">·</span>
                        <span>📍 {{ $booking->venue }}</span>
                        @endif
                    </div>
                </div>

                <div class="booking-right">
                    <div class="booking-amount">₱{{ number_format($booking->total_amount) }}</div>
                    <span class="badge {{ $statusClass }}">{{ $badge['label'] }}</span>
                </div>
            </div>

            {{-- Countdown / Pending notice --}}
            @if($isPending)
            <div class="countdown-strip pending-msg">
                <div class="pending-notice">
                    <div class="pending-notice-icon">⏳</div>
                    <div>
                        <strong style="display:block;margin-bottom:2px;font-size:0.88rem">Awaiting photographer confirmation</strong>
                        <span style="font-size:0.8rem;opacity:0.8">The countdown will start once your photographer accepts the booking. Your event is on <strong>{{ $booking->event_date->format('F d, Y') }}</strong>.</span>
                    </div>
                </div>
            </div>
            @elseif($isConfirmed && $diffDays >= 0)
            <div class="countdown-strip">
                <div class="countdown-label">Countdown to your event</div>
                <div class="countdown-blocks"
                    data-event-date="{{ $booking->event_date->format('Y-m-d') }}"
                    data-start-time="{{ $booking->start_time ?? '00:00:00' }}">
                    <div class="countdown-unit">
                        <span class="countdown-num" data-unit="days">--</span>
                        <span class="countdown-unit-label">Days</span>
                    </div>
                    <div class="countdown-colon">:</div>
                    <div class="countdown-unit">
                        <span class="countdown-num" data-unit="hours">--</span>
                        <span class="countdown-unit-label">Hours</span>
                    </div>
                    <div class="countdown-colon">:</div>
                    <div class="countdown-unit">
                        <span class="countdown-num" data-unit="minutes">--</span>
                        <span class="countdown-unit-label">Mins</span>
                    </div>
                    <div class="countdown-colon">:</div>
                    <div class="countdown-unit">
                        <span class="countdown-num" data-unit="seconds">--</span>
                        <span class="countdown-unit-label">Secs</span>
                    </div>
                </div>
            </div>
            @elseif($booking->status === 'completed')
            <div class="countdown-strip" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7);border-bottom-color:rgba(34,197,94,0.2)">
                <div style="display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;font-size:0.85rem;color:#15803D">
                    <div style="width:36px;height:36px;background:rgba(34,197,94,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">✅</div>
                    <div>
                        <strong style="display:block;margin-bottom:2px">Event wrapped!</strong>
                        <span style="opacity:0.8;font-size:0.8rem">Your event on {{ $booking->event_date->format('F d, Y') }} is complete. Check your album below for delivered photos &amp; videos.</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="booking-actions">
                @if($booking->conversation)
                <a href="{{ route('messages.show', $booking->conversation) }}" class="btn btn-outline">
                    💬 Message
                </a>
                @endif
                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary">
                    View Details →
                </a>
            </div>
        </div>

        @empty
        <div class="empty-card">
            <div class="empty-icon">📷</div>
            <h3 class="empty-title">No bookings yet</h3>
            <p class="empty-sub">Once you book a photographer or studio, it will appear here with a live countdown to your event day.</p>
            <a href="{{ route('creators.index') }}" class="btn btn-primary" style="margin-top:4px">Browse Creators</a>
        </div>
        @endforelse

        @if($bookings->hasPages())
        <div style="margin-bottom:32px">{{ $bookings->links() }}</div>
        @endif

        {{-- ── MY ALBUM ── --}}
        <p class="section-label" style="margin-top:8px">My Album</p>

        @php
        $completedBookingsWithAlbum = $bookings->filter(fn($b) => $b->status === 'completed' && $b->albumMedia?->isNotEmpty());
        $allAlbumMedia = $completedBookingsWithAlbum->flatMap(fn($b) => $b->albumMedia ?? collect());
        @endphp

        @if($allAlbumMedia->isEmpty())
        <div class="album-empty">
            <div class="album-empty-icon">🖼️</div>
            <h3 class="album-empty-title">Your photos will appear here</h3>
            <p class="album-empty-sub">Once your photographer delivers your photos and videos after the event, you'll find them here to view and download.</p>
        </div>
        @else
        <div class="album-grid">
            @foreach($allAlbumMedia as $media)
            @php $isVideo = $media->type === 'video'; @endphp
            <div class="album-item" onclick="openMedia('{{ Storage::url($media->file_path) }}', {{ $isVideo ? 'true' : 'false' }})">
                @if($isVideo)
                <video src="{{ Storage::url($media->file_path) }}" muted preload="none"
                    @if($media->thumbnail_path) poster="{{ Storage::url($media->thumbnail_path) }}" @endif></video>
                <div class="album-video-badge">▶ VIDEO</div>
                @else
                <img src="{{ $media->thumbnail_path ? Storage::url($media->thumbnail_path) : Storage::url($media->file_path) }}"
                    alt="{{ $media->caption ?? 'Photo' }}" loading="lazy">
                @endif
                <div class="album-item-overlay">
                    <span class="album-item-caption">{{ $media->caption ?? ($isVideo ? 'Video' : 'Photo') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

{{-- Lightbox --}}
<div id="lb" onclick="closeLB()" style="display:none;position:fixed;inset:0;background:rgba(12,20,32,0.92);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out">
    <img id="lb-img" src="" style="max-width:90vw;max-height:88vh;border-radius:10px;box-shadow:0 24px 64px rgba(0,0,0,0.5);display:none">
    <video id="lb-vid" src="" controls style="max-width:90vw;max-height:88vh;border-radius:10px;box-shadow:0 24px 64px rgba(0,0,0,0.5);display:none"></video>
    <button onclick="closeLB()" style="position:fixed;top:20px;right:24px;background:rgba(255,255,255,0.12);border:none;color:#fff;width:38px;height:38px;border-radius:50%;font-size:1.2rem;cursor:pointer;backdrop-filter:blur(4px)">✕</button>
</div>

<script>
    // ── Countdown engine ──
    function startCountdowns() {
        const blocks = document.querySelectorAll('[data-event-date]');
        blocks.forEach(block => {
            const dateStr = block.dataset.eventDate;
            const timeStr = block.dataset.startTime || '00:00:00';
            const target = new Date(`${dateStr}T${timeStr}`).getTime();

            function tick() {
                const now = Date.now();
                const diff = target - now;

                if (diff <= 0) {
                    block.querySelector('[data-unit="days"]').textContent = '00';
                    block.querySelector('[data-unit="hours"]').textContent = '00';
                    block.querySelector('[data-unit="minutes"]').textContent = '00';
                    block.querySelector('[data-unit="seconds"]').textContent = '00';
                    return;
                }

                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);

                const pad = n => String(n).padStart(2, '0');
                block.querySelector('[data-unit="days"]').textContent = d;
                block.querySelector('[data-unit="hours"]').textContent = pad(h);
                block.querySelector('[data-unit="minutes"]').textContent = pad(m);
                block.querySelector('[data-unit="seconds"]').textContent = pad(s);
            }

            tick();
            setInterval(tick, 1000);
        });
    }

    // ── Lightbox ──
    function openMedia(src, isVideo) {
        const lb = document.getElementById('lb');
        const img = document.getElementById('lb-img');
        const vid = document.getElementById('lb-vid');

        lb.style.display = 'flex';

        if (isVideo) {
            img.style.display = 'none';
            vid.style.display = 'block';
            vid.src = src;
            vid.play();
        } else {
            vid.style.display = 'none';
            img.style.display = 'block';
            img.src = src;
        }
    }

    function closeLB() {
        const lb = document.getElementById('lb');
        lb.style.display = 'none';
        const vid = document.getElementById('lb-vid');
        vid.pause();
        vid.src = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLB();
    });
    document.addEventListener('DOMContentLoaded', startCountdowns);
</script>
@endsection