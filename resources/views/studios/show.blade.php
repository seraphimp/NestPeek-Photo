<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $studio->name }} — Studio Dashboard · NestPeek Photo</title>
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
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
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

        /* ── Topbar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
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
            font-size: 0.82rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back {
            font-size: 0.8rem;
            color: var(--slate);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.15s;
        }

        .btn-back:hover {
            background: var(--sky-faint);
            color: var(--navy);
        }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.28);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(14, 165, 233, 0.38);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: transparent;
            color: var(--sky-mid);
            border: 1.5px solid var(--border-mid);
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-ghost:hover {
            background: var(--sky-faint);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: transparent;
            color: var(--red);
            border: 1.5px solid rgba(239, 68, 68, 0.3);
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: var(--red-faint);
        }

        /* ── Hero cover ── */
        .hero {
            position: relative;
            height: 260px;
            background: linear-gradient(135deg, #0C4A6E, #1e3a5f);
            overflow: hidden;
        }

        .hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(12, 74, 110, 0.2) 0%, rgba(12, 74, 110, 0.72) 100%);
        }

        .hero-edit-btn {
            position: absolute;
            bottom: 16px;
            right: 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 7px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .hero-edit-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .status-badge {
            position: absolute;
            top: 18px;
            left: 18px;
            padding: 5px 12px;
            border-radius: 50px;
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .status-badge.verified {
            background: rgba(16, 185, 129, 0.22);
            border: 1px solid rgba(16, 185, 129, 0.45);
            color: #fff;
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.2);
            border: 1px solid rgba(245, 158, 11, 0.4);
            color: #fff;
        }

        .status-badge.draft {
            background: rgba(148, 163, 184, 0.2);
            border: 1px solid rgba(148, 163, 184, 0.4);
            color: #fff;
        }

        /* ── Page wrapper ── */
        .page {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px 80px;
        }

        /* ── Studio identity block ── */
        .identity-block {
            display: flex;
            align-items: flex-end;
            gap: 20px;
            margin-top: -52px;
            position: relative;
            z-index: 10;
            margin-bottom: 24px;
        }

        .studio-logo {
            width: 96px;
            height: 96px;
            border-radius: 20px;
            border: 3px solid #fff;
            background: linear-gradient(135deg, var(--studio), var(--studio-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.14);
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .studio-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .studio-logo:hover .logo-overlay {
            opacity: 1;
        }

        .identity-meta {
            flex: 1;
            padding-bottom: 4px;
        }

        .studio-name {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--navy);
            font-weight: 400;
            line-height: 1.15;
        }

        .studio-tagline {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .studio-meta-row {
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
            font-size: 0.75rem;
            color: var(--slate);
        }

        .identity-actions {
            display: flex;
            gap: 8px;
            padding-bottom: 4px;
            flex-shrink: 0;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flash-warn {
            background: var(--amber-faint);
            border: 1.5px solid rgba(245, 158, 11, 0.3);
            color: #92400E;
        }

        /* ── Stat row ── */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(14, 165, 233, 0.04);
        }

        .stat-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--slate-mid);
            margin-bottom: 8px;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            color: var(--navy);
            line-height: 1;
        }

        .stat-value.green {
            color: var(--green);
        }

        .stat-value.amber {
            color: var(--amber);
        }

        .stat-sub {
            font-size: 0.7rem;
            color: var(--slate-mid);
            margin-top: 5px;
        }

        .stat-delta {
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .stat-delta.up {
            color: var(--green);
        }

        .stat-delta.down {
            color: var(--red);
        }

        /* ── Two-col layout ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 320px;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        /* ── Bookings table ── */
        .booking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .booking-table th {
            font-family: 'DM Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-mid);
            text-align: left;
            padding: 0 0 10px;
            border-bottom: 1px solid var(--border);
        }

        .booking-table td {
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.82rem;
            vertical-align: middle;
        }

        .booking-table tr:last-child td {
            border-bottom: none;
        }

        .booking-client {
            font-weight: 600;
            color: var(--text-main);
        }

        .booking-date {
            color: var(--slate);
            font-size: 0.75rem;
            margin-top: 2px;
        }

        /* Status badges */
        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .status-pending {
            background: var(--amber-faint);
            color: #92400E;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .status-pending::before {
            background: var(--amber);
        }

        .status-confirmed {
            background: var(--green-faint);
            color: #065F46;
            border: 1px solid var(--green-border);
        }

        .status-confirmed::before {
            background: var(--green);
        }

        .status-completed {
            background: var(--sky-faint);
            color: var(--navy);
            border: 1px solid var(--border-mid);
        }

        .status-completed::before {
            background: var(--sky);
        }

        .status-cancelled {
            background: var(--red-faint);
            color: #991B1B;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-cancelled::before {
            background: var(--red);
        }

        .booking-amount {
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            color: var(--sky-mid);
            font-weight: 600;
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
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .rate-val {
            font-family: 'DM Mono', monospace;
            font-size: 0.9rem;
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
            font-size: 0.72rem;
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
            width: 38px;
            height: 38px;
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
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .team-role {
            font-size: 0.7rem;
            color: var(--slate-mid);
            text-transform: capitalize;
        }

        /* ── Services ── */
        .service-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
        }

        .service-row:last-child {
            border-bottom: none;
        }

        .service-name {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .service-desc {
            font-size: 0.73rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .service-price {
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            color: var(--sky-mid);
            font-weight: 600;
            flex-shrink: 0;
            margin-left: 14px;
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
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .review-stars {
            color: var(--amber);
            font-size: 0.82rem;
            letter-spacing: 1px;
        }

        .review-body {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .review-date {
            font-size: 0.68rem;
            color: var(--slate-mid);
            margin-top: 4px;
        }

        /* ── Studio health ── */
        .health-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .health-item:last-child {
            border-bottom: none;
        }

        .health-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .health-dot.ok {
            background: var(--green);
        }

        .health-dot.warn {
            background: var(--amber);
        }

        .health-dot.missing {
            background: var(--slate-light);
        }

        .health-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            flex: 1;
        }

        .health-action {
            font-size: 0.72rem;
            color: var(--sky-mid);
            text-decoration: none;
            font-weight: 600;
        }

        .health-action:hover {
            text-decoration: underline;
        }

        /* ── Quick actions ── */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 4px;
        }

        .qa-btn {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: 14px 16px;
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            text-decoration: none;
            transition: all 0.18s;
            cursor: pointer;
        }

        .qa-btn:hover {
            background: var(--sky-pale);
            border-color: var(--border-mid);
        }

        .qa-icon {
            font-size: 1.1rem;
        }

        .qa-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--navy);
        }

        .qa-sub {
            font-size: 0.65rem;
            color: var(--slate-mid);
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

        /* ── Contact info sidebar ── */
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.8rem;
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
            word-break: break-all;
        }

        /* ── Rating pill ── */
        .rating-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--amber-faint);
            border: 1px solid rgba(245, 158, 11, 0.3);
            padding: 3px 9px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #92400E;
        }

        /* ── Visibility toggle ── */
        .visibility-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0 6px;
        }

        .vis-label {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .vis-label strong {
            color: var(--text-main);
            display: block;
            font-size: 0.84rem;
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toggle-switch {
            position: relative;
            width: 42px;
            height: 23px;
            cursor: pointer;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: var(--slate-light);
            border-radius: 50px;
            transition: background 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 17px;
            height: 17px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: var(--green);
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(19px);
        }

        .toggle-state {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--slate-mid);
        }

        .toggle-state.on {
            color: var(--green);
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0 12px;
        }

        @media(max-width: 900px) {
            .two-col {
                grid-template-columns: 1fr;
            }

            .stat-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width: 600px) {
            .topbar {
                padding: 12px 16px;
            }

            .identity-block {
                flex-direction: column;
                align-items: flex-start;
            }

            .identity-actions {
                padding-bottom: 0;
            }

            .stat-row {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    {{-- Topbar --}}
    <div class="topbar">
        <a href="{{ url('/') }}" class="topbar-brand">
            <div class="logo-box">N</div>
            NestPeek Photo
        </a>
        <div class="topbar-right">
            <a href="{{ route('dashboard') }}" class="btn-back">← Dashboard</a>
            <a href="{{ route('studios.edit', $studio) }}" class="btn-ghost">✏️ Edit Studio</a>
        </div>
    </div>

    {{-- Hero cover --}}
    <div class="hero">
        @if($studio->cover_photo)
        <img src="{{ asset('storage/' . $studio->cover_photo) }}" alt="{{ $studio->name }}">
        @endif
        <div class="hero-overlay"></div>

        {{-- Verification status --}}
        @if($studio->is_verified)
        <span class="status-badge verified">✓ Verified</span>
        @elseif($studio->is_active)
        <span class="status-badge pending">● Active</span>
        @else
        <span class="status-badge draft">○ Draft</span>
        @endif

        <a href="{{ route('studios.edit', $studio) }}" class="hero-edit-btn">
            🖼 Change Cover
        </a>
    </div>

    <div class="page">

        @if(session('success'))
        <div class="flash" style="margin-top:20px">✓ {{ session('success') }}</div>
        @endif

        @unless($studio->is_active)
        <div class="flash flash-warn" style="margin-top:20px">
            ⚠️ Your studio is not visible to clients yet. Complete your profile and set it to active.
        </div>
        @endunless

        {{-- Identity block --}}
        <div class="identity-block">
            <div class="studio-logo">
                @if($studio->logo)
                <img src="{{ asset('storage/' . $studio->logo) }}" alt="{{ $studio->name }} logo">
                @else
                {{ strtoupper(substr($studio->name, 0, 1)) }}
                @endif
                <div class="logo-overlay">Change Logo</div>
            </div>
            <div class="identity-meta">
                <h1 class="studio-name">{{ $studio->name }}</h1>
                @if($studio->tagline)
                <p class="studio-tagline">{{ $studio->tagline }}</p>
                @endif
                <div class="studio-meta-row">
                    <span class="meta-chip">📍 {{ collect([$studio->city, $studio->province])->filter()->implode(', ') ?: '—' }}</span>
                    @if($studio->average_rating > 0)
                    <span class="rating-pill">★ {{ number_format($studio->average_rating, 1) }} · {{ $studio->total_reviews }} {{ Str::plural('review', $studio->total_reviews) }}</span>
                    @endif
                    @if($studio->max_capacity)
                    <span class="meta-chip">👥 Up to {{ $studio->max_capacity }}</span>
                    @endif
                </div>
            </div>
            <div class="identity-actions">
                <a href="{{ route('studios.public', $studio->slug) }}" class="btn-ghost" target="_blank">👁 Preview</a>
                <a href="{{ route('studios.edit', $studio) }}" class="btn-primary">✏️ Edit</a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stat-row">
            <div class="stat-card">
                <p class="stat-label">Total Bookings</p>
                <p class="stat-value">{{ $studio->bookings->count() ?? 0 }}</p>
                <p class="stat-sub">All time</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Pending</p>
                <p class="stat-value amber">{{ $studio->bookings->where('status', 'pending')->count() ?? 0 }}</p>
                <p class="stat-sub">Awaiting confirmation</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Rating</p>
                <p class="stat-value">{{ $studio->average_rating > 0 ? number_format($studio->average_rating, 1) : '—' }}</p>
                <p class="stat-sub">{{ $studio->total_reviews }} {{ Str::plural('review', $studio->total_reviews ?? 0) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Team Members</p>
                <p class="stat-value green">{{ $studio->creators->count() ?? 0 }}</p>
                <p class="stat-sub">Linked creators</p>
            </div>
        </div>

        {{-- Main two-col --}}
        <div class="two-col">

            {{-- LEFT --}}
            <div>

                {{-- Recent bookings --}}
                {{-- Recent bookings --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Recent Bookings</p>
                        @if(isset($studio->bookings) && $studio->bookings->count())
                        <a href="{{ route('bookings.index') }}" style="font-size:0.75rem;color:var(--sky-mid);text-decoration:none;font-weight:600">View all →</a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!isset($studio->bookings) || $studio->bookings->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">📅</div>
                            <p>No bookings yet. Share your studio to get your first one.</p>
                        </div>
                        @else
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studio->bookings->sortByDesc('created_at')->take(6) as $booking)
                                <tr>
                                    <td>
                                        <p class="booking-client">{{ $booking->client->name ?? 'Client' }}</p>
                                        <p class="booking-date">Booked {{ $booking->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td style="color:var(--text-muted);font-size:0.78rem">
                                        {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                                    </td>
                                    <td style="color:var(--text-muted);font-size:0.78rem;text-transform:capitalize">
                                        {{ str_replace('_', ' ', $booking->event_type ?? '—') }}
                                    </td>
                                    <td>
                                        <span class="status status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->total_amount)
                                        <span class="booking-amount">₱{{ number_format($booking->total_amount, 0) }}</span>
                                        @else
                                        <span style="color:var(--slate-mid);font-size:0.75rem">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                        <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                            <form action="{{ route('bookings.accept', $booking) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-success" style="background:var(--green);border:none;color:#fff;padding:4px 10px;border-radius:12px;font-size:0.7rem;font-weight:600;cursor:pointer;transition:all 0.2s;"
                                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                                    ✓ Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.decline', $booking) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-danger" style="background:var(--red);border:none;color:#fff;padding:4px 10px;border-radius:12px;font-size:0.7rem;font-weight:600;cursor:pointer;transition:all 0.2s;"
                                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"
                                                    onclick="return confirm('Are you sure you want to decline this booking?')">
                                                    ✕ Decline
                                                </button>
                                            </form>
                                        </div>
                                        @elseif($booking->status === 'confirmed')
                                        <span style="font-size:0.7rem;color:var(--green);font-weight:600;">✓ Confirmed</span>
                                        @elseif($booking->status === 'cancelled')
                                        <span style="font-size:0.7rem;color:var(--red);font-weight:600;">✕ Cancelled</span>
                                        @elseif($booking->status === 'completed')
                                        <span style="font-size:0.7rem;color:var(--sky-mid);font-weight:600;">✓ Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

                {{-- About --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">About</p>
                        <a href="{{ route('studios.edit', $studio) }}#description" class="health-action">Edit</a>
                    </div>
                    <div class="card-body">
                        @if($studio->description)
                        <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.75">{{ $studio->description }}</p>
                        @else
                        <div class="empty-state" style="padding:12px 0">
                            <p>No description added. <a href="{{ route('studios.edit', $studio) }}" style="color:var(--sky-mid);font-weight:600">Add one →</a></p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Rates --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Rates</p>
                        <a href="{{ route('studios.edit', $studio) }}#rates" class="health-action">Edit</a>
                    </div>
                    <div class="card-body">
                        @if($studio->hourly_rate || $studio->half_day_rate || $studio->full_day_rate)
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
                        @else
                        <div class="empty-state" style="padding:12px 0">
                            <p>No rates set. <a href="{{ route('studios.edit', $studio) }}#rates" style="color:var(--sky-mid);font-weight:600">Add rates →</a></p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Services --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Services</p>
                        <a href="{{ route('studios.services.index', $studio) }}" class="health-action">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($studio->services->isEmpty())
                        <div class="empty-state" style="padding:12px 0">
                            <p>No services added yet. <a href="{{ route('studios.services.create', $studio) }}" style="color:var(--sky-mid);font-weight:600">Add services →</a></p>
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
                            @if($service->price)
                            <span class="service-price">₱{{ number_format($service->price, 0) }}</span>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                {{-- Specializations --}}
                @if(!empty($studio->specializations))
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Specializations</p>
                        <a href="{{ route('studios.edit', $studio) }}#specs" class="health-action">Edit</a>
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
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Team</p>
                        <a href="{{ route('studios.members.index', $studio) }}" class="health-action">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($studio->creators->isEmpty())
                        <div class="empty-state" style="padding:12px 0">
                            <p>No team members linked. <a href="{{ route('studios.members.create', $studio) }}" style="color:var(--sky-mid);font-weight:600">Add team →</a></p>
                        </div>
                        @else
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
                                    @if($creator->pivot->role)
                                    <p class="team-role">{{ str_replace('_', ' ', $creator->pivot->role) }}</p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('creators.show', $creator->slug ?? $creator->id) }}" style="font-size:0.72rem;color:var(--sky-mid);text-decoration:none;font-weight:600">View profile →</a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

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
                            <p>No reviews yet. They'll appear here once clients leave feedback.</p>
                        </div>
                        @else
                        @foreach($studio->reviews->take(5) as $review)
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
                        @if($studio->total_reviews > 5)
                        <div style="text-align:center;padding-top:10px">
                            <a href="{{ route('studios.public', $studio->slug) }}" style="font-size:0.78rem;color:var(--sky-mid);font-weight:600;text-decoration:none">View all {{ $studio->total_reviews }} reviews →</a>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div>

                {{-- Studio visibility --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Visibility</p>
                    </div>
                    <div class="card-body">
                        <div class="visibility-row">
                            <div class="vis-label">
                                <strong>{{ $studio->is_active ? 'Listed & Visible' : 'Hidden from clients' }}</strong>
                                {{ $studio->is_active ? 'Clients can discover and view your studio.' : 'Your studio won\'t appear in search.' }}
                            </div>
                            <form method="POST" action="{{ route('studios.update', $studio) }}">
                                @csrf @method('PUT')
                                {{-- Pass all required fields so update() doesn't wipe them --}}
                                <input type="hidden" name="name" value="{{ $studio->name }}">
                                <input type="hidden" name="address" value="{{ $studio->address }}">
                                <input type="hidden" name="city" value="{{ $studio->city }}">
                                <input type="hidden" name="_toggle_active" value="1">
                                <input type="hidden" name="is_active" value="{{ $studio->is_active ? '0' : '1' }}">
                                <div class="toggle-wrap">
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="this.form.submit()" {{ $studio->is_active ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <span class="toggle-state {{ $studio->is_active ? 'on' : '' }}">
                                        {{ $studio->is_active ? 'On' : 'Off' }}
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Studio health --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Profile Health</p>
                    </div>
                    <div class="card-body">
                        <div class="health-item">
                            <div class="health-dot {{ $studio->logo ? 'ok' : 'missing' }}"></div>
                            <span class="health-label">Studio logo</span>
                            @unless($studio->logo)
                            <a href="{{ route('studios.edit', $studio) }}" class="health-action">Add</a>
                            @endunless
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ $studio->cover_photo ? 'ok' : 'missing' }}"></div>
                            <span class="health-label">Cover photo</span>
                            @unless($studio->cover_photo)
                            <a href="{{ route('studios.edit', $studio) }}" class="health-action">Add</a>
                            @endunless
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ $studio->description ? 'ok' : 'warn' }}"></div>
                            <span class="health-label">Description</span>
                            @unless($studio->description)
                            <a href="{{ route('studios.edit', $studio) }}" class="health-action">Add</a>
                            @endunless
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ ($studio->hourly_rate || $studio->full_day_rate) ? 'ok' : 'warn' }}"></div>
                            <span class="health-label">Rates set</span>
                            @unless($studio->hourly_rate || $studio->full_day_rate)
                            <a href="{{ route('studios.edit', $studio) }}#rates" class="health-action">Add</a>
                            @endunless
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ $studio->phone || $studio->email ? 'ok' : 'warn' }}"></div>
                            <span class="health-label">Contact info</span>
                            @unless($studio->phone || $studio->email)
                            <a href="{{ route('studios.edit', $studio) }}" class="health-action">Add</a>
                            @endunless
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ $studio->services->isNotEmpty() ? 'ok' : 'missing' }}"></div>
                            <span class="health-label">Services listed</span>
                            @if($studio->services->isEmpty())
                            <a href="{{ route('studios.services.index', $studio) }}" class="health-action">Add</a>
                            @endif
                        </div>
                        <div class="health-item">
                            <div class="health-dot {{ $studio->is_verified ? 'ok' : 'missing' }}"></div>
                            <span class="health-label">Verified badge</span>
                            @unless($studio->is_verified)
                            <span style="font-size:0.68rem;color:var(--slate-mid)">Pending</span>
                            @endunless
                        </div>
                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Quick Actions</p>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('studios.edit', $studio) }}" class="qa-btn">
                                <span class="qa-icon">✏️</span>
                                <span class="qa-label">Edit Profile</span>
                                <span class="qa-sub">Update details</span>
                            </a>
                            <a href="{{ route('studios.services.index', $studio) }}" class="qa-btn">
                                <span class="qa-icon">🛠</span>
                                <span class="qa-label">Services</span>
                                <span class="qa-sub">Add or edit</span>
                            </a>
                            <a href="{{ route('studios.members.index', $studio) }}" class="qa-btn">
                                <span class="qa-icon">👥</span>
                                <span class="qa-label">Team</span>
                                <span class="qa-sub">Manage creators</span>
                            </a>
                            <a href="{{ route('bookings.index') }}" class="qa-btn">
                                <span class="qa-icon">📅</span>
                                <span class="qa-label">Bookings</span>
                                <span class="qa-sub">View all</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact info --}}
                <div class="card">
                    <div class="card-header">
                        <p class="section-label">Contact Info</p>
                        <a href="{{ route('studios.edit', $studio) }}" class="health-action">Edit</a>
                    </div>
                    <div class="card-body" style="padding-bottom:14px">
                        @if($studio->phone)
                        <div class="info-row">
                            <span class="info-icon">📞</span>
                            <div>
                                <span class="info-label">Phone</span>
                                <span class="info-value">{{ $studio->phone }}</span>
                            </div>
                        </div>
                        @endif
                        @if($studio->email)
                        <div class="info-row">
                            <span class="info-icon">✉️</span>
                            <div>
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $studio->email }}</span>
                            </div>
                        </div>
                        @endif
                        @if($studio->address)
                        <div class="info-row">
                            <span class="info-icon">📍</span>
                            <div>
                                <span class="info-label">Address</span>
                                <span class="info-value">{{ collect([$studio->address, $studio->city, $studio->province])->filter()->implode(', ') }}</span>
                            </div>
                        </div>
                        @endif
                        @if($studio->max_capacity)
                        <div class="info-row">
                            <span class="info-icon">👥</span>
                            <div>
                                <span class="info-label">Max Capacity</span>
                                <span class="info-value">{{ $studio->max_capacity }} people</span>
                            </div>
                        </div>
                        @endif
                        @if($studio->website)
                        <div class="info-row">
                            <span class="info-icon">🌐</span>
                            <div>
                                <span class="info-label">Website</span>
                                <a href="{{ $studio->website }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.8rem;text-decoration:none">{{ $studio->website }}</a>
                            </div>
                        </div>
                        @endif
                        @if($studio->instagram)
                        <div class="info-row">
                            <span class="info-icon">📸</span>
                            <div>
                                <span class="info-label">Instagram</span>
                                <a href="https://instagram.com/{{ ltrim($studio->instagram,'@') }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.8rem;text-decoration:none">@{{ ltrim($studio->instagram,'@') }}</a>
                            </div>
                        </div>
                        @endif
                        @if($studio->facebook)
                        <div class="info-row">
                            <span class="info-icon">📘</span>
                            <div>
                                <span class="info-label">Facebook</span>
                                <a href="{{ $studio->facebook }}" target="_blank" style="color:var(--sky-mid);font-weight:500;font-size:0.8rem;text-decoration:none">View page →</a>
                            </div>
                        </div>
                        @endif

                        @unless($studio->phone || $studio->email || $studio->website)
                        <div class="empty-state" style="padding:10px 0">
                            <p>No contact info yet. <a href="{{ route('studios.edit', $studio) }}" style="color:var(--sky-mid);font-weight:600">Add now →</a></p>
                        </div>
                        @endunless
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="card" style="border-color:rgba(239,68,68,0.18)">
                    <div class="card-header">
                        <p class="section-label" style="color:rgba(239,68,68,0.6)">Danger Zone</p>
                    </div>
                    <div class="card-body">
                        <p style="font-size:0.78rem;color:var(--text-muted);margin-bottom:12px;line-height:1.55">
                            Deleting your studio is permanent and cannot be undone. All associated bookings and reviews will be removed.
                        </p>
                        <button type="button" class="btn-danger" style="width:100%;justify-content:center;opacity:0.45;cursor:not-allowed" disabled title="Contact support to delete your studio">🗑 Delete Studio</button>
                        <p style="font-size:0.7rem;color:var(--slate-mid);margin-top:8px;text-align:center">Studio deletion is managed by admin. Contact support.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>