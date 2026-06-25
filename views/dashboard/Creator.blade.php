<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — NestPeek Photo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Inter:wght@300;400;500;600&family=DM+Mono&display=swap" rel="stylesheet">
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
            --amber-border: rgba(245, 158, 11, 0.25);
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
            --red-border: rgba(239, 68, 68, 0.25);
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
            min-height: 100vh;
            color: var(--text-main);
        }

        /* ── Topbar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-box {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-nav a {
            font-size: 0.82rem;
            color: var(--slate);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }

        .topbar-nav a:hover,
        .topbar-nav a.active {
            background: var(--sky-faint);
            color: var(--navy);
        }

        .topbar-nav a.active {
            color: var(--sky-mid);
            font-weight: 600;
        }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(12, 74, 110, 0.12);
            min-width: 180px;
            overflow: hidden;
            z-index: 200;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 16px;
            font-size: 0.82rem;
            color: var(--text-main);
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.15s;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: var(--sky-faint);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-menu .danger {
            color: var(--red);
        }

        /* ── Layout ── */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
        }

        .page-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 0.63rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--sky-mid);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1.2;
        }

        .page-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
        }

        /* ── Stats grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--sky), var(--sky-mid));
            opacity: 0;
            transition: opacity 0.2s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            font-size: 1.3rem;
            margin-bottom: 10px;
            display: block;
        }

        .stat-value {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.9rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-value .currency {
            font-family: 'DM Mono', monospace;
            font-size: 1rem;
            color: var(--sky-mid);
            vertical-align: middle;
            margin-right: 2px;
        }

        .stat-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        /* ── Two-column layout ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 0;
        }

        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        .card-link {
            font-size: 0.78rem;
            color: var(--sky-mid);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .card-link:hover {
            color: var(--sky);
        }

        .card-body {
            padding: 16px 24px 24px;
        }

        /* ── Booking rows ── */
        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .booking-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            background: var(--sky-faint);
            transition: border-color 0.15s;
        }

        .booking-row:hover {
            border-color: var(--border-mid);
        }

        .booking-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky-pale), var(--sky-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--sky-mid);
            flex-shrink: 0;
        }

        .booking-info {
            flex: 1;
            min-width: 0;
        }

        .booking-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--navy);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .booking-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .booking-right {
            text-align: right;
            flex-shrink: 0;
        }

        .booking-amount {
            font-family: 'DM Mono', monospace;
            font-size: 0.82rem;
            color: var(--navy);
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 0.67rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .badge-pending {
            background: var(--amber-faint);
            color: #92400E;
            border: 1px solid var(--amber-border);
        }

        .badge-confirmed {
            background: var(--sky-faint);
            color: var(--sky-mid);
            border: 1px solid var(--border-mid);
        }

        .badge-completed {
            background: var(--green-faint);
            color: #065F46;
            border: 1px solid var(--green-border);
        }

        .badge-cancelled {
            background: var(--red-faint);
            color: #991B1B;
            border: 1px solid var(--red-border);
        }

        /* ── Review rows ── */
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .review-row {
            padding: 14px 16px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            background: var(--sky-faint);
        }

        .review-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .review-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--navy);
        }

        .review-stars {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .review-body {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ── Portfolio grid ── */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .portfolio-thumb {
            aspect-ratio: 1;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--sky-pale), var(--sky-faint));
            border: 1.5px solid var(--border);
            overflow: hidden;
            position: relative;
        }

        .portfolio-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .portfolio-thumb-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--slate-light);
        }

        /* ── Profile completion banner ── */
        .completion-banner {
            background: linear-gradient(135deg, #0C4A6E 0%, #0369A1 55%, #0EA5E9 100%);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .completion-left {
            flex: 1;
        }

        .completion-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 6px;
        }

        .completion-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.15rem;
            color: #fff;
            margin-bottom: 12px;
        }

        .completion-bar-wrap {
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .completion-bar {
            height: 100%;
            background: #fff;
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .completion-pct {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-outline-white {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.8);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 32px 16px;
            color: var(--slate-mid);
        }

        .empty-state-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 0.83rem;
            color: var(--text-muted);
            margin-bottom: 14px;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border: 1.5px solid var(--border-mid);
            border-radius: 50px;
            color: var(--sky-mid);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            background: none;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: var(--sky-faint);
            border-color: var(--sky);
        }

        /* ── Booking action buttons ── */
        .booking-actions {
            display: flex;
            gap: 6px;
            margin-top: 6px;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.67rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-accept {
            background: var(--green-faint);
            color: #065F46;
            border-color: var(--green-border);
        }

        .btn-accept:hover {
            background: #10B981;
            color: #fff;
            border-color: #10B981;
        }

        .btn-decline {
            background: var(--red-faint);
            color: #991B1B;
            border-color: var(--red-border);
        }

        .btn-decline:hover {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        /* ── Countdown chip ── */
        .booking-countdown {
            margin-top: 6px;
            text-align: right;
        }

        .countdown-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--sky-faint);
            border: 1px solid var(--border-mid);
            border-radius: 20px;
            padding: 3px 10px;
            font-family: 'DM Mono', monospace;
            font-size: 0.67rem;
            color: var(--sky-mid);
            letter-spacing: 0.02em;
        }

        .countdown-chip span[data-unit] {
            font-weight: 600;
            color: var(--navy);
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .two-col {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 560px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .page {
                padding: 20px 16px 60px;
            }

            .topbar {
                padding: 14px 20px;
            }

            .page-header {
                flex-direction: column;
            }

            .portfolio-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>

<body>

    {{-- ── Topbar ── --}}
    <nav class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="logo-box">N</span>
            NestPeek Photo
        </a>
        <div class="topbar-right">
            <nav class="topbar-nav" style="display:flex;gap:4px">
                <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('bookings.index') }}">Bookings</a>
                <a href="{{ route('portfolio.index') }}">Portfolio</a>
                <a href="{{ route('creators.edit') }}">Services</a>
            </nav>
            <div class="dropdown">
                <div class="topbar-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('onboarding.start') }}">Edit Profile</a>
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}">Public Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="danger">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="page">

        {{-- ── Page header ── --}}
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Creator Dashboard</p>
                <h1 class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', $user->name)[0] }}</h1>
                <p class="page-sub">Here's what's happening with your profile today.</p>
            </div>
            <a href="{{ route('creators.edit') }}" class="btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                New Service
            </a>
        </div>

        {{-- ── Profile completion ── --}}
        @php
        $completionScore = 0;
        if ($profile->brand_name) $completionScore += 15;
        if ($profile->tagline) $completionScore += 10;
        if ($user->bio) $completionScore += 20;
        if ($profile->specialization) $completionScore += 15;
        if ($user->instagram || $user->facebook) $completionScore += 10;
        if ($stats['portfolio_count'] > 0) $completionScore += 20;
        if ($profile->starting_price) $completionScore += 10;
        @endphp
        @if($completionScore < 100)
            <div class="completion-banner">
            <div class="completion-left">
                <p class="completion-label">Profile Strength</p>
                <p class="completion-title">Complete your profile to attract more clients</p>
                <div class="completion-bar-wrap">
                    <div class="completion-bar" style="width:{{ $completionScore }}%"></div>
                </div>
                <p class="completion-pct">{{ $completionScore }}% complete</p>
            </div>
            <a href="{{ route('onboarding.start') }}" class="btn-outline-white">
                Complete Profile →
            </a>
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-icon">📅</span>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">⏳</span>
            <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">✅</span>
            <div class="stat-value">{{ $stats['completed_bookings'] }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">💰</span>
            <div class="stat-value">
                <span class="currency">₱</span>{{ number_format($stats['total_revenue'] ?? 0, 0) }}
            </div>
            <div class="stat-label">Total Earned</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">⭐</span>
            <div class="stat-value">{{ number_format($stats['average_rating'] ?? 0, 1) }}</div>
            <div class="stat-label">Avg Rating</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">👁️</span>
            <div class="stat-value">{{ $stats['profile_views'] ?? 0 }}</div>
            <div class="stat-label">Profile Views</div>
        </div>
    </div>

    {{-- ── Two-column ── --}}
    <div class="two-col">

        {{-- LEFT: Bookings + Reviews --}}
        <div>

            {{-- Recent Bookings --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Recent Bookings</p>
                    <a href="{{ route('bookings.index') }}" class="card-link">View all →</a>
                </div>
                <div class="card-body">
                    @if($profile->bookings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <p>No bookings yet. Once clients start booking you, they'll appear here.</p>
                        <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}"
                            class="btn-ghost">Share your profile</a>
                    </div>
                    @else
                    <div class="booking-list">
                        @foreach($profile->bookings->take(5) as $booking)
                        <div class="booking-row">
                            <div class="booking-avatar">
                                {{ strtoupper(substr($booking->client->name ?? 'C', 0, 1)) }}
                            </div>
                            <div class="booking-info">
                                <div class="booking-name">{{ $booking->client->name ?? 'Client' }}</div>
                                <div class="booking-meta">
                                    {{ $booking->service->name ?? 'Service' }}
                                    @if($booking->event_date)
                                    · {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                                    @endif
                                </div>
                            </div>
                            <div class="booking-right">
                                <div class="booking-amount">₱{{ number_format($booking->amount_paid ?? 0, 0) }}</div>
                                <span class="badge badge-{{ $booking->status }}">{{ $booking->status }}</span>
                                @if($booking->status === 'pending')
                                <div class="booking-actions">
                                    <form method="POST" action="{{ route('bookings.accept', $booking->id) }}" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action btn-accept">✓ Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.decline', $booking->id) }}" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action btn-decline">✕ Decline</button>
                                    </form>
                                </div>
                                @elseif(in_array($booking->status, ['confirmed','deposit_paid','in_progress']) && $booking->event_date && \Carbon\Carbon::parse($booking->event_date)->isFuture())
                                <div class="booking-countdown"
                                    data-event-date="{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}"
                                    data-start-time="{{ $booking->start_time ?? '00:00:00' }}">
                                    <span class="countdown-chip">
                                        <span data-unit="days">--</span>d
                                        <span data-unit="hours">--</span>h
                                        <span data-unit="minutes">--</span>m
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Recent Reviews --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Recent Reviews</p>
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}#reviews"
                        class="card-link">View all →</a>
                </div>
                <div class="card-body">
                    @if($profile->reviews->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">⭐</div>
                        <p>No reviews yet. Completed bookings can leave you a review.</p>
                    </div>
                    @else
                    <div class="review-list">
                        @foreach($profile->reviews->take(3) as $review)
                        <div class="review-row">
                            <div class="review-top">
                                <span class="review-name">{{ $review->user->name ?? 'Client' }}</span>
                                <span class="review-stars">
                                    @for($s = 1; $s <= 5; $s++)
                                        {{ $s <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                        </span>
                            </div>
                            @if($review->body)
                            <p class="review-body">{{ $review->body }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT: Profile snapshot + Portfolio --}}
        <div>

            {{-- Profile Snapshot --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <p class="section-label">Your Profile</p>
                    <a href="{{ route('onboarding.start') }}" class="card-link">Edit →</a>
                </div>
                <div class="card-body">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
                        <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--sky-mid));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;font-weight:600;flex-shrink:0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--navy);font-weight:400">
                                {{ $profile->brand_name ?: $user->name }}
                            </div>
                            @if($profile->tagline)
                            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px">{{ $profile->tagline }}</div>
                            @endif
                            @if($profile->specialization)
                            <div style="font-size:0.7rem;color:var(--sky-mid);font-weight:500;margin-top:4px;text-transform:capitalize">
                                {{ str_replace('_', ' ', $profile->specialization) }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                        @if($user->location)
                        <div style="font-size:0.75rem;color:var(--text-muted);display:flex;align-items:center;gap:5px">
                            📍 {{ $user->location }}
                        </div>
                        @endif
                        @if($profile->starting_price)
                        <div style="font-size:0.75rem;color:var(--text-muted);display:flex;align-items:center;gap:5px">
                            💳 Starting ₱{{ number_format($profile->starting_price, 0) }}
                        </div>
                        @endif
                        @if($profile->years_experience)
                        <div style="font-size:0.75rem;color:var(--text-muted);display:flex;align-items:center;gap:5px">
                            🎓 {{ $profile->years_experience }} yrs exp
                        </div>
                        @endif
                        <div style="font-size:0.75rem;display:flex;align-items:center;gap:5px">
                            @php
                            $avail = $profile->availability_status ?? ($profile->is_available ? 'available' : 'unavailable');
                            $dot = match($avail) {
                            'available' => ['color' => 'var(--green)', 'label' => 'Available'],
                            'booked_soon' => ['color' => 'var(--amber)', 'label' => 'Booked Soon'],
                            default => ['color' => 'var(--slate-mid)', 'label' => 'Unavailable'],
                            };
                            @endphp
                            <span style="color:{{ $dot['color'] }}">●</span>
                            <span style="color:{{ $dot['color'] }}">{{ $dot['label'] }}</span>
                        </div>
                    </div>

                    @if($user->bio)
                    <p style="font-size:0.78rem;color:var(--text-muted);margin-top:14px;line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden">
                        {{ $user->bio }}
                    </p>
                    @endif

                    <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border)">
                        <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}"
                            class="btn-ghost" style="width:100%;justify-content:center;font-size:0.8rem">
                            View Public Profile ↗
                        </a>
                    </div>
                </div>
            </div>

            {{-- Portfolio Preview --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">
                        Portfolio
                        <span style="color:var(--slate-light);margin-left:6px">{{ $stats['portfolio_count'] }}</span>
                    </p>
                    <a href="{{ route('portfolio.index') }}" class="card-link">Manage →</a>
                </div>
                <div class="card-body">
                    @if($profile->portfolios->isEmpty())
                    <div class="empty-state" style="padding:20px 0">
                        <div class="empty-state-icon">🖼️</div>
                        <p>Add portfolio photos so clients can see your work.</p>
                        <a href="{{ route('portfolio.index') }}" class="btn-ghost">Upload photos</a>
                    </div>
                    @else
                    <div class="portfolio-grid">
                        @foreach($profile->portfolios->take(6) as $item)
                        <a href="{{ route('portfolio.index') }}"
                            class="portfolio-thumb" style="display:block;text-decoration:none">
                            @if($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}">
                            @else
                            <div class="portfolio-thumb-empty">📷</div>
                            @endif
                        </a>
                        @endforeach
                    </div>
                    @if($stats['portfolio_count'] > 6)
                    <p style="font-size:0.75rem;color:var(--slate-mid);text-align:center;margin-top:12px">
                        +{{ $stats['portfolio_count'] - 6 }} more ·
                        <a href="{{ route('portfolio.index') }}"
                            style="color:var(--sky-mid);text-decoration:none;font-weight:600">Manage all →</a>
                    </p>
                    @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

    </div>{{-- /page --}}

    <script>
        // ── Countdown engine ──
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-event-date]').forEach(function(block) {
                const target = new Date(
                    block.dataset.eventDate + 'T' + (block.dataset.startTime || '00:00:00')
                ).getTime();

                function tick() {
                    const diff = target - Date.now();
                    const pad = n => String(n).padStart(2, '0');
                    if (diff <= 0) {
                        block.querySelector('[data-unit="days"]').textContent = '0';
                        block.querySelector('[data-unit="hours"]').textContent = '00';
                        block.querySelector('[data-unit="minutes"]').textContent = '00';
                        return;
                    }
                    block.querySelector('[data-unit="days"]').textContent = Math.floor(diff / 86400000);
                    block.querySelector('[data-unit="hours"]').textContent = pad(Math.floor((diff % 86400000) / 3600000));
                    block.querySelector('[data-unit="minutes"]').textContent = pad(Math.floor((diff % 3600000) / 60000));
                }

                tick();
                setInterval(tick, 60000);
            });
        });
    </script>

</body>

</html>