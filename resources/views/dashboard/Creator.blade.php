<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            min-height: 100vh;
            color: var(--text-main);
        }

        /* ===== TOPBAR - FULLY RESPONSIVE ===== */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            gap: 8px;
            flex-wrap: wrap;
        }

        .topbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1rem;
            font-weight: 400;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
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
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* Mobile hamburger menu */
        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--slate);
            font-size: 1.5rem;
            line-height: 1;
        }

        .topbar-nav {
            display: flex;
            gap: 2px;
            align-items: center;
            flex-wrap: wrap;
        }

        .topbar-nav a {
            font-size: 0.75rem;
            color: var(--slate);
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
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

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link svg {
            width: 14px;
            height: 14px;
        }

        /* Studio nav pill */
        .btn-nav-studio {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--studio-mid);
            background: var(--studio-faint);
            border: 1.5px solid var(--studio-border);
            padding: 4px 10px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-nav-studio svg {
            width: 12px;
            height: 12px;
        }

        .btn-nav-studio:hover {
            background: rgba(124, 58, 237, 0.13);
            border-color: var(--studio);
            color: var(--studio);
        }

        .topbar-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Dropdown menu */
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
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(12, 74, 110, 0.12);
            min-width: 160px;
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
            padding: 8px 14px;
            font-size: 0.78rem;
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

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-wrapper {
            position: relative;
            display: inline-block;
        }

        .notification-bell {
            background: none;
            border: none;
            cursor: pointer;
            color: #64748B;
            padding: 4px;
            border-radius: 50%;
            transition: background 0.2s, color 0.2s;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-bell svg {
            width: 18px;
            height: 18px;
        }

        .notification-bell:hover {
            background: #F0F9FF;
            color: #0369A1;
        }

        .notification-bell .bell-animation {
            animation: bellRing 0.5s ease;
        }

        @keyframes bellRing {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(15deg);
            }

            50% {
                transform: rotate(-15deg);
            }

            75% {
                transform: rotate(10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #EF4444;
            color: white;
            font-size: 0.5rem;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 50%;
            min-width: 16px;
            text-align: center;
            border: 2px solid white;
            line-height: 1.3;
            transition: transform 0.2s ease;
        }

        .notification-badge.pop {
            animation: badgePop 0.3s ease;
        }

        @keyframes badgePop {
            0% {
                transform: scale(0.5);
            }

            60% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .notification-dropdown {
            position: absolute;
            right: -70px;
            top: calc(100% + 8px);
            width: 320px;
            max-height: 400px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            border: 1.5px solid rgba(14, 165, 233, 0.14);
            overflow: hidden;
            z-index: 1000;
            display: none;
        }

        .notification-dropdown.open {
            display: block;
        }

        .dropdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(14, 165, 233, 0.1);
        }

        .dropdown-header h4 {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: #0F172A;
            margin: 0;
        }

        .mark-all-read {
            background: none;
            border: none;
            color: #0EA5E9;
            font-size: 0.65rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: color 0.2s;
        }

        .mark-all-read:hover {
            color: #0369A1;
        }

        .dropdown-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .empty-notification {
            padding: 30px 16px;
            text-align: center;
            color: #94A3B8;
        }

        .empty-icon {
            font-size: 1.8rem;
            display: block;
            margin-bottom: 6px;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 16px;
            transition: background 0.15s;
            position: relative;
            border-bottom: 1px solid rgba(14, 165, 233, 0.05);
            cursor: pointer;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: #F8FAFC;
        }

        .notification-item.unread {
            background: #F0F9FF;
        }

        .notification-item.unread:hover {
            background: #E0F2FE;
        }

        .notification-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #F0F9FF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-message {
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            color: #0F172A;
            margin: 0 0 3px;
            line-height: 1.4;
        }

        .notification-time {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            color: #94A3B8;
            letter-spacing: 0.04em;
        }

        .notification-studio {
            display: inline-block;
            font-size: 0.6rem;
            color: #0369A1;
            background: #F0F9FF;
            padding: 1px 6px;
            border-radius: 8px;
            margin-top: 3px;
        }

        .notification-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #0EA5E9;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .dropdown-footer {
            padding: 10px 16px;
            border-top: 1px solid rgba(14, 165, 233, 0.1);
            text-align: center;
        }

        .dropdown-footer a {
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .dropdown-footer a:hover {
            color: #0369A1;
        }

        /* ===== LAYOUT ===== */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 16px 12px 60px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--sky-mid);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 16px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1.2;
        }

        .page-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .btn-primary {
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

        .btn-primary svg {
            width: 12px;
            height: 12px;
        }

        /* ===== STATS GRID - FULLY RESPONSIVE ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
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
            height: 2px;
            background: linear-gradient(90deg, var(--sky), var(--sky-mid));
            opacity: 0;
            transition: opacity 0.2s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            font-size: 1.1rem;
            margin-bottom: 6px;
            display: block;
        }

        .stat-value {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1;
            margin-bottom: 3px;
        }

        .stat-value .currency {
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            color: var(--sky-mid);
            vertical-align: middle;
            margin-right: 1px;
        }

        .stat-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.5rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        /* ===== TWO-COL LAYOUT ===== */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
            align-items: start;
        }

        /* ===== CARDS ===== */
        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px 0;
            flex-wrap: wrap;
            gap: 6px;
        }

        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        .card-link {
            font-size: 0.72rem;
            color: var(--sky-mid);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .card-link:hover {
            color: var(--sky);
        }

        .card-body {
            padding: 12px 18px 18px;
        }

        /* ===== BOOKING ROWS ===== */
        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .booking-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--sky-faint);
            transition: border-color 0.15s;
            flex-wrap: wrap;
        }

        .booking-row:hover {
            border-color: var(--border-mid);
        }

        .booking-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky-pale), var(--sky-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--sky-mid);
            flex-shrink: 0;
        }

        .booking-info {
            flex: 1;
            min-width: 100px;
        }

        .booking-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--navy);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .booking-meta {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .booking-right {
            text-align: right;
            flex-shrink: 0;
            margin-left: auto;
        }

        .booking-amount {
            font-family: 'DM Mono', monospace;
            font-size: 0.75rem;
            color: var(--navy);
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 16px;
            font-size: 0.58rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-top: 2px;
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

        /* Booking actions */
        .booking-actions {
            display: flex;
            gap: 4px;
            margin-top: 4px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 2px 8px;
            border-radius: 16px;
            font-size: 0.6rem;
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

        /* Countdown */
        .booking-countdown {
            margin-top: 4px;
            text-align: right;
        }

        .countdown-chip {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: var(--sky-faint);
            border: 1px solid var(--border-mid);
            border-radius: 16px;
            padding: 2px 8px;
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            color: var(--sky-mid);
            letter-spacing: 0.02em;
        }

        .countdown-chip span[data-unit] {
            font-weight: 600;
            color: var(--navy);
        }

        /* ===== REVIEW ROWS ===== */
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .review-row {
            padding: 10px 12px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--sky-faint);
        }

        .review-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            flex-wrap: wrap;
            gap: 4px;
        }

        .review-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--navy);
        }

        .review-stars {
            font-size: 0.7rem;
            letter-spacing: 1px;
        }

        .review-body {
            font-size: 0.72rem;
            color: var(--text-muted);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ===== PORTFOLIO ===== */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .portfolio-thumb {
            aspect-ratio: 1;
            border-radius: 10px;
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
            font-size: 1.2rem;
            color: var(--slate-light);
        }

        /* ===== COMPLETION BANNER ===== */
        .completion-banner {
            background: linear-gradient(135deg, #0C4A6E 0%, #0369A1 55%, #0EA5E9 100%);
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .completion-left {
            flex: 1;
            min-width: 180px;
        }

        .completion-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 4px;
        }

        .completion-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 8px;
        }

        .completion-bar-wrap {
            height: 5px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .completion-bar {
            height: 100%;
            background: #fff;
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .completion-pct {
            font-size: 0.68rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-outline-white {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 7px 14px;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            color: #fff;
            font-size: 0.72rem;
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

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 24px 12px;
            color: var(--slate-mid);
        }

        .empty-state-icon {
            font-size: 1.6rem;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border: 1.5px solid var(--border-mid);
            border-radius: 50px;
            color: var(--sky-mid);
            font-size: 0.72rem;
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

        /* ===== STUDIO CARD ===== */
        .studio-card {
            background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);
            border: 1.5px solid var(--studio-border);
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .studio-card::after {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 22px solid rgba(124, 58, 237, 0.08);
            pointer-events: none;
        }

        .studio-card-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--studio-mid);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .studio-card-label::before {
            content: '';
            display: inline-block;
            width: 14px;
            height: 1.5px;
            background: var(--studio);
        }

        .studio-card-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 0.95rem;
            font-weight: 400;
            color: #3B0764;
            margin-bottom: 4px;
        }

        .studio-card-desc {
            font-size: 0.72rem;
            color: #5B21B6;
            line-height: 1.5;
            margin-bottom: 12px;
            opacity: 0.8;
        }

        .studio-pill-row {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .studio-pill {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 0.62rem;
            padding: 2px 8px;
            border-radius: 16px;
            background: rgba(124, 58, 237, 0.08);
            border: 1px solid rgba(124, 58, 237, 0.18);
            color: var(--studio-mid);
            white-space: nowrap;
        }

        .btn-studio {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            background: linear-gradient(135deg, var(--studio), var(--studio-mid));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.28);
            transition: all 0.2s;
        }

        .btn-studio:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.38);
        }

        .studio-booking-tag {
            display: inline-block;
            font-size: 0.5rem;
            padding: 1px 8px;
            border-radius: 10px;
            background: var(--studio-faint);
            color: var(--studio-mid);
            border: 1px solid var(--studio-border);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-left: 4px;
            vertical-align: middle;
        }

        .booking-provider {
            font-size: 0.62rem;
            color: var(--studio-mid);
            font-weight: 500;
        }

        /* ===== MODAL ===== */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(12, 36, 58, 0.48);
            backdrop-filter: blur(3px);
            z-index: 500;
            align-items: flex-end;
            justify-content: center;
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal-sheet {
            background: #fff;
            border-radius: 20px 20px 0 0;
            width: 100%;
            max-width: 600px;
            max-height: 92vh;
            overflow-y: auto;
            padding: 24px 20px 32px;
            box-shadow: 0 -8px 40px rgba(12, 36, 58, 0.18);
            transform: translateY(100%);
            transition: transform 0.38s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .modal-backdrop.open .modal-sheet {
            transform: translateY(0);
        }

        .modal-drag-handle {
            width: 36px;
            height: 4px;
            background: var(--slate-light);
            border-radius: 4px;
            margin: 0 auto 20px;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 10px;
        }

        .modal-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--studio-mid);
            margin-bottom: 2px;
        }

        .modal-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--navy);
        }

        .modal-close {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--slate);
            font-size: 0.85rem;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .modal-close:hover {
            background: var(--sky-faint);
            border-color: var(--border-mid);
            color: var(--navy);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-family: 'DM Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate);
            margin-bottom: 5px;
        }

        .form-label .required {
            color: var(--studio);
            margin-left: 2px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--slate-light);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: var(--text-main);
            background: #FAFCFF;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--studio);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 70px;
            line-height: 1.5;
        }

        .form-hint {
            font-size: 0.65rem;
            color: var(--slate-mid);
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .member-invite-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 8px;
        }

        .member-invite-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .member-invite-row .form-input {
            flex: 1;
        }

        .btn-remove-member {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.5px solid var(--red-border);
            background: var(--red-faint);
            color: var(--red);
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .btn-remove-member:hover {
            background: var(--red);
            color: #fff;
        }

        .btn-add-member {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            color: var(--studio-mid);
            border: 1.5px dashed var(--studio-border);
            background: var(--studio-faint);
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.15s;
            width: 100%;
            justify-content: center;
        }

        .btn-add-member:hover {
            background: rgba(124, 58, 237, 0.12);
            border-color: var(--studio);
        }

        .spec-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 6px;
        }

        .spec-chip {
            position: relative;
        }

        .spec-chip input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .spec-chip label {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 8px;
            border-radius: 8px;
            border: 1.5px solid var(--slate-light);
            font-size: 0.68rem;
            color: var(--slate);
            cursor: pointer;
            background: #FAFCFF;
            transition: all 0.15s;
            user-select: none;
        }

        .spec-chip input:checked+label {
            border-color: var(--studio);
            background: var(--studio-faint);
            color: var(--studio-mid);
            font-weight: 600;
        }

        .spec-chip label:hover {
            border-color: var(--slate-mid);
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            gap: 10px;
            flex-wrap: wrap;
        }

        .modal-footer-note {
            font-size: 0.68rem;
            color: var(--slate-mid);
        }

        .modal-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-cancel {
            padding: 8px 16px;
            border: 1.5px solid var(--slate-light);
            border-radius: 50px;
            background: none;
            color: var(--slate);
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-cancel:hover {
            background: var(--sky-faint);
            border-color: var(--border-mid);
            color: var(--navy);
        }

        /* ===== TOAST ===== */
        .np-toast {
            position: fixed;
            top: 16px;
            right: 16px;
            background: #fff;
            border: 1.5px solid var(--border-mid);
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 8px 32px rgba(12, 74, 110, 0.16);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            color: var(--navy);
            transform: translateX(120%);
            transition: transform 0.3s ease;
            z-index: 2000;
            max-width: 300px;
        }

        .np-toast.show {
            transform: translateX(0);
        }

        .np-toast-icon {
            font-size: 1rem;
        }

        /* ========================================================== */
        /* ===== RESPONSIVE BREAKPOINTS ===== */
        /* ========================================================== */

        /* Tablets and smaller laptops */
        @media (max-width: 1024px) {
            .two-col {
                grid-template-columns: 1fr 300px;
                gap: 14px;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Tablets */
        @media (max-width: 768px) {
            .topbar {
                padding: 10px 12px;
            }

            .topbar-brand {
                font-size: 0.9rem;
            }

            .hamburger {
                display: block;
            }

            .topbar-nav {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                padding: 8px 0;
                gap: 2px;
            }

            .topbar-nav.open {
                display: flex;
            }

            .topbar-nav a {
                padding: 6px 10px;
                font-size: 0.8rem;
                border-radius: 6px;
            }

            .topbar-nav a .nav-text {
                display: inline;
            }

            .topbar-right {
                flex-wrap: wrap;
                gap: 4px;
            }

            .topbar-right .topbar-nav {
                order: 10;
            }

            .two-col {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .stat-card {
                padding: 10px 12px;
            }

            .stat-value {
                font-size: 1.2rem;
            }

            .page {
                padding: 12px 10px 40px;
            }

            .page-title {
                font-size: 1.2rem;
            }

            .completion-banner {
                padding: 14px 16px;
                flex-direction: column;
                align-items: stretch;
            }

            .completion-title {
                font-size: 0.9rem;
            }

            .btn-outline-white {
                align-self: flex-start;
            }

            .booking-row {
                padding: 8px 10px;
                gap: 8px;
            }

            .booking-info {
                min-width: 80px;
            }

            .booking-right {
                width: 100%;
                text-align: left;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                margin-left: 0;
                padding-top: 4px;
                border-top: 1px solid var(--border);
            }

            .booking-actions {
                justify-content: flex-start;
            }

            .booking-countdown {
                text-align: left;
            }

            .notification-dropdown {
                right: -100px;
                width: 280px;
            }

            .modal-sheet {
                padding: 20px 16px 24px;
                max-width: 100%;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .spec-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .studio-card {
                padding: 14px 16px;
            }

            .studio-card-title {
                font-size: 0.85rem;
            }
        }

        /* Mobile phones */
        @media (max-width: 480px) {
            .topbar {
                padding: 8px 10px;
            }

            .topbar-brand {
                font-size: 0.8rem;
            }

            .logo-box {
                width: 24px;
                height: 24px;
                font-size: 0.65rem;
            }

            .btn-nav-studio {
                font-size: 0.6rem;
                padding: 3px 8px;
            }

            .btn-nav-studio .label {
                display: none;
            }

            .topbar-avatar {
                width: 26px;
                height: 26px;
                font-size: 0.6rem;
            }

            .notification-bell svg {
                width: 16px;
                height: 16px;
            }

            .notification-dropdown {
                right: -120px;
                width: 260px;
                max-height: 350px;
            }

            .notification-item {
                padding: 8px 12px;
                gap: 8px;
            }

            .notification-message {
                font-size: 0.72rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }

            .stat-card {
                padding: 8px 10px;
                border-radius: 10px;
            }

            .stat-icon {
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            .stat-value {
                font-size: 1rem;
            }

            .stat-label {
                font-size: 0.45rem;
            }

            .page {
                padding: 8px 8px 30px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                margin-bottom: 12px;
            }

            .page-title {
                font-size: 1rem;
            }

            .page-sub {
                font-size: 0.7rem;
            }

            .btn-primary {
                font-size: 0.7rem;
                padding: 6px 12px;
                justify-content: center;
            }

            .card {
                border-radius: 12px;
                margin-bottom: 10px;
            }

            .card-header {
                padding: 10px 12px 0;
            }

            .card-body {
                padding: 8px 12px 12px;
            }

            .booking-row {
                padding: 6px 8px;
                gap: 6px;
                border-radius: 8px;
            }

            .booking-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.6rem;
            }

            .booking-name {
                font-size: 0.7rem;
            }

            .booking-meta {
                font-size: 0.6rem;
            }

            .booking-amount {
                font-size: 0.68rem;
            }

            .badge {
                font-size: 0.5rem;
                padding: 1px 6px;
            }

            .btn-action {
                font-size: 0.55rem;
                padding: 1px 6px;
            }

            .review-row {
                padding: 8px 10px;
            }

            .review-name {
                font-size: 0.68rem;
            }

            .review-stars {
                font-size: 0.6rem;
            }

            .review-body {
                font-size: 0.65rem;
            }

            .portfolio-grid {
                gap: 6px;
            }

            .portfolio-thumb {
                border-radius: 8px;
            }

            .completion-banner {
                padding: 12px 14px;
                border-radius: 12px;
            }

            .completion-title {
                font-size: 0.8rem;
            }

            .completion-pct {
                font-size: 0.6rem;
            }

            .studio-card {
                padding: 12px 14px;
                border-radius: 12px;
            }

            .studio-card-title {
                font-size: 0.8rem;
            }

            .studio-card-desc {
                font-size: 0.65rem;
            }

            .studio-pill {
                font-size: 0.55rem;
                padding: 1px 6px;
            }

            .btn-studio {
                font-size: 0.7rem;
                padding: 6px 12px;
            }

            .btn-ghost {
                font-size: 0.65rem;
                padding: 4px 10px;
            }

            .modal-sheet {
                padding: 16px 12px 20px;
                border-radius: 16px 16px 0 0;
            }

            .modal-title {
                font-size: 1rem;
            }

            .modal-drag-handle {
                width: 30px;
                height: 3px;
                margin-bottom: 14px;
            }

            .form-input,
            .form-textarea,
            .form-select {
                font-size: 0.75rem;
                padding: 7px 10px;
            }

            .form-label {
                font-size: 0.52rem;
            }

            .form-hint {
                font-size: 0.6rem;
            }

            .spec-grid {
                grid-template-columns: 1fr 1fr;
            }

            .spec-chip label {
                font-size: 0.62rem;
                padding: 4px 6px;
            }

            .modal-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .modal-footer-note {
                font-size: 0.6rem;
            }

            .modal-actions {
                justify-content: stretch;
            }

            .modal-actions .btn-cancel,
            .modal-actions .btn-studio {
                flex: 1;
                justify-content: center;
            }

            .btn-cancel {
                font-size: 0.72rem;
                padding: 6px 12px;
            }

            .np-toast {
                top: 12px;
                right: 12px;
                left: 12px;
                max-width: none;
                font-size: 0.72rem;
                padding: 8px 12px;
            }
        }

        /* Very small phones */
        @media (max-width: 360px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 4px;
            }

            .stat-card {
                padding: 6px 8px;
            }

            .stat-value {
                font-size: 0.9rem;
            }

            .notification-dropdown {
                right: -140px;
                width: 240px;
            }

            .topbar-nav a {
                font-size: 0.7rem;
                padding: 4px 6px;
            }

            .portfolio-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body data-reverb-key="{{ config('reverb.apps.apps.0.key') }}" data-reverb-host="{{ config('reverb.servers.reverb.host') }}" data-reverb-port="{{ config('reverb.servers.reverb.port') }}" data-user-id="{{ auth()->id() }}">

    {{-- Topbar --}}
    <nav class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="logo-box">N</span>
            NestPeek Photo
        </a>
        <div class="topbar-right">
            <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation">
                ☰
            </button>
            <nav class="topbar-nav" id="mobileNav">
                <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('bookings.index') }}">Bookings</a>
                <a href="{{ route('portfolio.index') }}">Portfolio</a>
                <a href="{{ route('creators.edit') }}">Services</a>
                <a href="{{ route('creators.index') }}" class="nav-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Creators
                </a>
            </nav>

            {{-- Notification Dropdown --}}
            <div class="notification-wrapper" id="notificationWrapper">
                <button class="notification-bell" id="notificationBell" aria-label="Notifications">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="dropdown-header">
                        <h4>Notifications</h4>
                        @if($unreadCount > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="mark-all-read">Mark all as read</button>
                        </form>
                        @endif
                    </div>

                    <div class="dropdown-body">
                        @php
                        $notifications = auth()->user()->notifications()->limit(10)->get();
                        @endphp
                        @if($notifications->isEmpty())
                        <div class="empty-notification">
                            <span class="empty-icon">🔔</span>
                            <p>No notifications yet</p>
                        </div>
                        @else
                        @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                            <div class="notification-icon">{{ $notification->data['icon'] ?? '🔔' }}</div>
                            <div class="notification-content">
                                <p class="notification-message">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                @if(isset($notification->data['studio_name']))
                                <span class="notification-studio">🏢 {{ $notification->data['studio_name'] }}</span>
                                @endif
                            </div>
                            @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="notification-dot" title="Mark as read" style="background:none;border:none;cursor:pointer;padding:0;"></button>
                            </form>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="dropdown-footer">
                        <a href="{{ route('notifications.index') }}">View all notifications</a>
                    </div>
                </div>
            </div>

            {{-- Studio Button --}}
            @if(!$studio)
            <button class="btn-nav-studio" onclick="openStudioModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M12 8v8M8 12h8" />
                </svg>
                <span class="label">Create Studio</span>
            </button>
            @else
            <a href="{{ route('studios.show', $studio) }}" class="btn-nav-studio">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M12 8v8M8 12h8" />
                </svg>
                <span class="label">{{ $studio->name }}</span>
            </a>
            @endif

            <div class="dropdown">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('onboarding.start') }}">Edit Profile</a>
                    <a href="{{ route('creators.show', auth()->user()->creatorProfile->slug ?? auth()->user()->creatorProfile->id) }}">Public Profile</a>
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

        {{-- Page header --}}
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Creator Dashboard</p>
                <h1 class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', $user->name)[0] }}</h1>
                <p class="page-sub">Here's what's happening with your profile today.</p>
            </div>
            <a href="{{ route('creators.edit') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h8" />
                </svg>
                New Service
            </a>
        </div>

        {{-- Profile completion --}}
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
            <a href="{{ route('onboarding.start') }}" class="btn-outline-white">Complete Profile →</a>
    </div>
    @endif

    {{-- Stats --}}
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
            <div class="stat-value"><span class="currency">₱</span>{{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
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

    {{-- Two-col --}}
    <div class="two-col">

        {{-- LEFT: Bookings + Studio Bookings + Reviews --}}
        <div>

            {{-- YOUR BOOKINGS --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Your Bookings</p>
                    <a href="{{ route('bookings.index') }}" class="card-link">View all →</a>
                </div>
                <div class="card-body">
                    @if($profile->bookings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <p>No bookings yet. Once clients start booking you, they'll appear here.</p>
                        <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}" class="btn-ghost">Share your profile</a>
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
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-action btn-accept">✓ Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.decline', $booking->id) }}" style="display:inline">
                                        @csrf @method('PATCH')
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

            {{-- STUDIO BOOKINGS --}}
            @if($studio)
            @php
            $creatorIds = $studio->creators->pluck('id')->toArray();
            $studioBookings = App\Models\Booking::where(function($query) use ($studio, $creatorIds) {
            $query->where('studio_id', $studio->id);
            if (!empty($creatorIds)) {
            $query->orWhereIn('creator_profile_id', $creatorIds);
            }
            })
            ->with(['client', 'service', 'creatorProfile.user'])
            ->latest()
            ->get();
            @endphp

            <div class="card" style="border-color: var(--studio-border);">
                <div class="card-header">
                    <p class="section-label">
                        🏢 Studio Bookings
                        <span class="studio-booking-tag">{{ $studio->name }}</span>
                    </p>
                    <a href="{{ route('studios.show', $studio) }}" class="card-link">View Studio →</a>
                </div>
                <div class="card-body">
                    @if($studioBookings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">🏢</div>
                        <p>No studio bookings yet. Clients can book your studio directly or through your team members.</p>
                        <a href="{{ route('studios.show', $studio) }}" class="btn-ghost">Share your studio →</a>
                    </div>
                    @else
                    <div class="booking-list">
                        @foreach($studioBookings->take(5) as $booking)
                        <div class="booking-row" style="border-color: var(--studio-border); background: var(--studio-faint);">
                            <div class="booking-avatar" style="background: linear-gradient(135deg, var(--studio-faint), var(--studio-border)); color: var(--studio-mid);">
                                {{ strtoupper(substr($booking->client->name ?? 'C', 0, 1)) }}
                            </div>
                            <div class="booking-info">
                                <div class="booking-name">
                                    {{ $booking->client->name ?? 'Client' }}
                                    @if($booking->creatorProfile && $booking->creatorProfile->id != $profile->id)
                                    <span class="booking-provider">
                                        · via {{ $booking->creatorProfile->brand_name ?? $booking->creatorProfile->user->name ?? 'Team Member' }}
                                    </span>
                                    @endif
                                </div>
                                <div class="booking-meta">
                                    {{ $booking->service->name ?? 'Service' }}
                                    @if($booking->event_date)
                                    · {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                                    @endif
                                    @if($booking->studio_id)
                                    <span style="display:inline-block;font-size:0.55rem;padding:1px 6px;border-radius:8px;background:var(--studio-faint);color:var(--studio-mid);border:1px solid var(--studio-border);margin-left:4px;">
                                        Direct
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="booking-right">
                                <div class="booking-amount">₱{{ number_format($booking->amount_paid ?? 0, 0) }}</div>
                                <span class="badge badge-{{ $booking->status }}">{{ $booking->status }}</span>
                                @if($booking->status === 'pending')
                                <div class="booking-actions">
                                    <form method="POST" action="{{ route('bookings.accept', $booking->id) }}" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-action btn-accept">✓ Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.decline', $booking->id) }}" style="display:inline">
                                        @csrf @method('PATCH')
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
                    @if($studioBookings->count() > 5)
                    <div style="text-align:center;margin-top:10px;">
                        <a href="{{ route('studios.show', $studio) }}" style="font-size:0.7rem;color:var(--studio-mid);text-decoration:none;font-weight:600;">
                            View all {{ $studioBookings->count() }} studio bookings →
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            <div class="card">
                <div class="card-header">
                    <p class="section-label">Recent Reviews</p>
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}#reviews" class="card-link">View all →</a>
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

        {{-- RIGHT: Studio widget + Profile + Portfolio --}}
        <div>

            {{-- Studio card --}}
            @if($studio)
            <div class="studio-card">
                <p class="studio-card-label">Your Studio</p>
                <p class="studio-card-title">{{ $studio->name }}</p>
                @if($studio->tagline)
                <p class="studio-card-desc">{{ $studio->tagline }}</p>
                @endif
                <div class="studio-pill-row">
                    @if($studio->city)
                    <span class="studio-pill">📍 {{ $studio->city }}</span>
                    @endif
                    <span class="studio-pill">👥 {{ $studio->creators->count() }} {{ Str::plural('member', $studio->creators->count()) }}</span>
                    @if($studio->is_active)
                    <span class="studio-pill">✓ Active</span>
                    @endif
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <a href="{{ route('studios.show', $studio) }}" class="btn-studio" style="flex:1;justify-content:center;min-width:100px;">
                        View Studio
                    </a>
                    <a href="{{ route('studios.edit', $studio) }}" class="btn-ghost" style="flex:1;justify-content:center;min-width:80px;">
                        Edit
                    </a>
                </div>
            </div>
            @else
            <div class="studio-card">
                <p class="studio-card-label">Collaborate</p>
                <p class="studio-card-title">Launch a Studio</p>
                <p class="studio-card-desc">Group your crew — photographers, coordinators, makeup artists, and more — under one bookable brand.</p>
                <div class="studio-pill-row">
                    <span class="studio-pill">📷 Photo</span>
                    <span class="studio-pill">🎤 Hosts</span>
                    <span class="studio-pill">💄 Beauty</span>
                    <span class="studio-pill">🎵 Music</span>
                </div>
                <button class="btn-studio" onclick="openStudioModal()" style="width:100%;justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="4" />
                        <path d="M12 8v8M8 12h8" />
                    </svg>
                    Create a Studio
                </button>
            </div>
            @endif

            {{-- Profile Snapshot --}}
            <div class="card" style="margin-bottom:16px;">
                <div class="card-header">
                    <p class="section-label">Your Profile</p>
                    <a href="{{ route('onboarding.start') }}" class="card-link">Edit →</a>
                </div>
                <div class="card-body">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                        <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--sky-mid));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;font-weight:600;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:0.9rem;color:var(--navy);font-weight:400;">
                                {{ $profile->brand_name ?: $user->name }}
                            </div>
                            @if($profile->tagline)
                            <div style="font-size:0.68rem;color:var(--text-muted);margin-top:2px;">{{ $profile->tagline }}</div>
                            @endif
                            @if($profile->specialization)
                            <div style="font-size:0.65rem;color:var(--sky-mid);font-weight:500;margin-top:3px;text-transform:capitalize;">
                                {{ str_replace('_', ' ', $profile->specialization) }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:0.68rem;color:var(--text-muted);">
                        @if($user->location)
                        <div style="display:flex;align-items:center;gap:4px;">📍 {{ $user->location }}</div>
                        @endif
                        @if($profile->starting_price)
                        <div style="display:flex;align-items:center;gap:4px;">💳 ₱{{ number_format($profile->starting_price, 0) }}</div>
                        @endif
                        @if($profile->years_experience)
                        <div style="display:flex;align-items:center;gap:4px;">🎓 {{ $profile->years_experience }} yrs</div>
                        @endif
                        <div style="display:flex;align-items:center;gap:4px;">
                            @php
                            $avail = $profile->availability_status ?? ($profile->is_available ? 'available' : 'unavailable');
                            $dot = match($avail) {
                            'available' => ['color' => 'var(--green)', 'label' => 'Available'],
                            'booked_soon' => ['color' => 'var(--amber)', 'label' => 'Booked Soon'],
                            default => ['color' => 'var(--slate-mid)','label' => 'Unavailable'],
                            };
                            @endphp
                            <span style="color:{{ $dot['color'] }};">●</span>
                            <span style="color:{{ $dot['color'] }};">{{ $dot['label'] }}</span>
                        </div>
                    </div>

                    @if($user->bio)
                    <p style="font-size:0.7rem;color:var(--text-muted);margin-top:10px;line-height:1.5;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $user->bio }}
                    </p>
                    @endif

                    <div style="margin-top:12px;padding-top:10px;border-top:1px solid var(--border);">
                        <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}"
                            class="btn-ghost" style="width:100%;justify-content:center;font-size:0.72rem;">
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
                        <span style="color:var(--slate-light);margin-left:4px;font-size:0.65rem;">{{ $stats['portfolio_count'] }}</span>
                    </p>
                    <a href="{{ route('portfolio.index') }}" class="card-link">Manage →</a>
                </div>
                <div class="card-body">
                    @if($profile->portfolios->isEmpty())
                    <div class="empty-state" style="padding:16px 0;">
                        <div class="empty-state-icon">🖼️</div>
                        <p>Add portfolio photos so clients can see your work.</p>
                        <a href="{{ route('portfolio.index') }}" class="btn-ghost">Upload photos</a>
                    </div>
                    @else
                    <div class="portfolio-grid">
                        @foreach($profile->portfolios->take(6) as $item)
                        <a href="{{ route('portfolio.index') }}" class="portfolio-thumb" style="display:block;text-decoration:none;">
                            @if($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}">
                            @else
                            <div class="portfolio-thumb-empty">📷</div>
                            @endif
                        </a>
                        @endforeach
                    </div>
                    @if($stats['portfolio_count'] > 6)
                    <p style="font-size:0.68rem;color:var(--slate-mid);text-align:center;margin-top:8px;">
                        +{{ $stats['portfolio_count'] - 6 }} more ·
                        <a href="{{ route('portfolio.index') }}" style="color:var(--sky-mid);text-decoration:none;font-weight:600;">Manage all →</a>
                    </p>
                    @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

    </div>{{-- /page --}}

    {{-- CREATE STUDIO MODAL --}}
    <div class="modal-backdrop" id="studioModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-drag-handle"></div>
            <div class="modal-header">
                <div>
                    <p class="modal-eyebrow">New Studio</p>
                    <h2 class="modal-title" id="modalTitle">Create your Studio</h2>
                </div>
                <button class="modal-close" onclick="closeStudioModal()" aria-label="Close">✕</button>
            </div>

            <form method="POST" action="{{ route('studios.store') }}" enctype="multipart/form-data" id="studioForm">
                @csrf

                @if($errors->any())
                <div style="background:var(--red-faint);border:1.5px solid var(--red-border);border-radius:10px;padding:10px 14px;margin-bottom:12px;">
                    <p style="font-size:0.75rem;color:var(--red);font-weight:600;margin-bottom:4px;">Please fix the following:</p>
                    <ul style="font-size:0.72rem;color:var(--red);padding-left:16px;margin:0;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="studio_name">
                        Studio Name <span class="required">*</span>
                    </label>
                    <input class="form-input" type="text" id="studio_name" name="name"
                        placeholder="e.g. Golden Hour Collective" maxlength="255" required
                        value="{{ old('name') }}">
                    <p class="form-hint">The public brand name clients will see when booking.</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="studio_tagline">Tagline</label>
                    <input class="form-input" type="text" id="studio_tagline" name="tagline"
                        placeholder="One line that captures what your studio does" maxlength="120"
                        value="{{ old('tagline') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="studio_description">About the Studio</label>
                    <textarea class="form-textarea" id="studio_description" name="description"
                        placeholder="Tell clients what makes your team unique — your style, experience, and how you collaborate.">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="studio_address">
                        Street Address <span class="required">*</span>
                    </label>
                    <input class="form-input" type="text" id="studio_address" name="address"
                        placeholder="e.g. 123 Rizal St, Poblacion" maxlength="500" required
                        value="{{ old('address') }}">
                </div>

                <div class="form-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_city">
                            City <span class="required">*</span>
                        </label>
                        <input class="form-input" type="text" id="studio_city" name="city"
                            placeholder="e.g. Iloilo City" maxlength="100" required
                            value="{{ old('city') }}">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_province">Province</label>
                        <input class="form-input" type="text" id="studio_province" name="province"
                            placeholder="e.g. Iloilo" maxlength="100"
                            value="{{ old('province') }}">
                    </div>
                </div>

                <div class="form-row" style="margin-top:14px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_hourly">Hourly Rate (₱)</label>
                        <input class="form-input" type="number" id="studio_hourly" name="hourly_rate"
                            placeholder="e.g. 1500" min="0" value="{{ old('hourly_rate') }}">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_halfday">Half-Day (₱)</label>
                        <input class="form-input" type="number" id="studio_halfday" name="half_day_rate"
                            placeholder="e.g. 8000" min="0" value="{{ old('half_day_rate') }}">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_fullday">Full-Day (₱)</label>
                        <input class="form-input" type="number" id="studio_fullday" name="full_day_rate"
                            placeholder="e.g. 25000" min="0" value="{{ old('full_day_rate') }}">
                    </div>
                </div>

                <div class="form-row" style="margin-top:14px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_phone">Phone</label>
                        <input class="form-input" type="text" id="studio_phone" name="phone"
                            placeholder="e.g. 09XX XXX XXXX" maxlength="20"
                            value="{{ old('phone') }}">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="studio_email">Studio Email</label>
                        <input class="form-input" type="email" id="studio_email" name="email"
                            placeholder="studio@email.com" maxlength="255"
                            value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label" for="studio_capacity">Max Capacity</label>
                    <input class="form-input" type="number" id="studio_capacity" name="max_capacity"
                        placeholder="e.g. 10" min="1" value="{{ old('max_capacity') }}">
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label">
                        Studio Specializations <span class="required">*</span>
                    </label>
                    <div class="spec-grid">
                        @foreach([
                        ['photography', '📷 Photography'],
                        ['videography', '🎬 Videography'],
                        ['coordination', '📋 Coordination'],
                        ['makeup_hair', '💄 Makeup & Hair'],
                        ['hosting_mc', '🎤 Host / MC'],
                        ['music_dj', '🎵 Music / DJ'],
                        ['lighting_sound','💡 Lights & Sound'],
                        ['drone', '🚁 Drone'],
                        ['graphic_design','🎨 Graphic Design'],
                        ] as [$val, $lbl])
                        <div class="spec-chip">
                            <input type="checkbox" id="spec_{{ $val }}" name="specializations[]" value="{{ $val }}"
                                {{ in_array($val, old('specializations', [])) ? 'checked' : '' }}>
                            <label for="spec_{{ $val }}">{{ $lbl }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label">Invite Team Members</label>
                    <p class="form-hint" style="margin-bottom:8px;">Enter NestPeek email addresses — each person will get an invitation to join.</p>
                    <div class="member-invite-list" id="memberList">
                        <div class="member-invite-row">
                            <input class="form-input" type="email" name="member_emails[]"
                                placeholder="teammate@email.com">
                            <button type="button" class="btn-remove-member"
                                onclick="removeMemberRow(this)" title="Remove">−</button>
                        </div>
                    </div>
                    <button type="button" class="btn-add-member" onclick="addMemberRow()">
                        + Add another team member
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label" for="studio_cover">Studio Cover Photo</label>
                    <input class="form-input" type="file" id="studio_cover" name="cover_photo"
                        accept="image/jpeg,image/png,image/webp"
                        style="padding:7px 10px;cursor:pointer;">
                    <p class="form-hint">JPG or PNG, max 5 MB. Displayed on your studio's public page.</p>
                </div>

                <div class="modal-footer">
                    <p class="modal-footer-note">You can edit all details after creation.</p>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeStudioModal()">Cancel</button>
                        <button type="submit" class="btn-studio">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Launch Studio
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Hamburger menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburgerBtn');
            const mobileNav = document.getElementById('mobileNav');

            if (hamburger && mobileNav) {
                hamburger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileNav.classList.toggle('open');
                });

                // Close mobile nav when clicking outside
                document.addEventListener('click', function(e) {
                    if (!hamburger.contains(e.target) && !mobileNav.contains(e.target)) {
                        mobileNav.classList.remove('open');
                    }
                });
            }
        });

        // Notification sound using Web Audio API
        function playNotificationSound() {
            try {
                const audioContext = new(window.AudioContext || window.webkitAudioContext)();

                const notes = [{
                        freq: 523.25,
                        duration: 0.12
                    },
                    {
                        freq: 659.25,
                        duration: 0.12
                    },
                    {
                        freq: 783.99,
                        duration: 0.18
                    },
                ];

                let time = audioContext.currentTime;

                notes.forEach((note, index) => {
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.type = 'sine';
                    oscillator.frequency.value = note.freq;

                    gainNode.gain.setValueAtTime(0.3, time);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, time + note.duration);

                    oscillator.start(time);
                    oscillator.stop(time + note.duration);

                    time += note.duration + 0.02;
                });
            } catch (e) {
                try {
                    const audioContext = new(window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.type = 'sine';
                    oscillator.frequency.value = 800;

                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);

                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.2);
                } catch (e2) {
                    console.log('Audio not supported');
                }
            }
        }

        // Notification dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const bell = document.getElementById('notificationBell');
            const dropdown = document.getElementById('notificationDropdown');

            if (bell && dropdown) {
                bell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('open');
                });

                document.addEventListener('click', function(e) {
                    const wrapper = document.getElementById('notificationWrapper');
                    if (wrapper && !wrapper.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdown.classList.remove('open');
                    }
                });
            }
        });

        // Studio modal functions
        function openStudioModal() {
            document.getElementById('studioModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeStudioModal() {
            document.getElementById('studioModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function handleBackdropClick(e) {
            if (e.target === document.getElementById('studioModal')) closeStudioModal();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeStudioModal();
        });

        // Dynamic team member rows
        function addMemberRow() {
            const list = document.getElementById('memberList');
            const row = document.createElement('div');
            row.className = 'member-invite-row';
            row.innerHTML = `
                <input class="form-input" type="email" name="member_emails[]" placeholder="teammate@email.com">
                <button type="button" class="btn-remove-member" onclick="removeMemberRow(this)" title="Remove">−</button>
            `;
            list.appendChild(row);
            row.querySelector('input').focus();
        }

        function removeMemberRow(btn) {
            const list = document.getElementById('memberList');
            if (list.children.length > 1) {
                btn.closest('.member-invite-row').remove();
            } else {
                btn.closest('.member-invite-row').querySelector('input').value = '';
            }
        }

        // Countdown engine
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

    {{-- REAL-TIME NOTIFICATIONS --}}
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script>
        (function() {
            const reverbKey = document.body.dataset.reverbKey;
            const reverbHost = document.body.dataset.reverbHost;
            const reverbPort = document.body.dataset.reverbPort;
            const userId = document.body.dataset.userId;

            if (!reverbKey || !userId) {
                console.warn('Reverb key or user id missing — live notifications disabled.');
                return;
            }

            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: reverbKey,
                wsHost: reverbHost,
                wsPort: reverbPort,
                wssPort: reverbPort,
                forceTLS: false,
                enabledTransports: ['ws'],
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                },
            });

            window.Echo.private('App.Models.User.' + userId)
                .notification((n) => {
                    playNotificationSound();

                    const bell = document.querySelector('.notification-bell');
                    bell.classList.remove('bell-animation');
                    void bell.offsetWidth;
                    bell.classList.add('bell-animation');

                    bumpBadge();
                    prependNotification(n);
                    showToast(n.message ?? 'New notification', n.icon ?? '🔔');
                });

            function bumpBadge() {
                const bell = document.querySelector('.notification-bell');
                let badge = bell.querySelector('.notification-badge');
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'notification-badge';
                    bell.appendChild(badge);
                    badge.textContent = '1';
                } else {
                    const count = parseInt(badge.textContent || '0', 10) + 1;
                    badge.textContent = count;
                    badge.classList.remove('pop');
                    void badge.offsetWidth;
                    badge.classList.add('pop');
                }
            }

            function prependNotification(n) {
                const body = document.querySelector('.dropdown-body');
                const empty = body.querySelector('.empty-notification');
                if (empty) empty.remove();

                const item = document.createElement('div');
                item.className = 'notification-item unread';
                item.innerHTML = `
                    <div class="notification-icon">${n.icon ?? '🔔'}</div>
                    <div class="notification-content">
                        <p class="notification-message">${n.message ?? 'New notification'}</p>
                        <span class="notification-time">just now</span>
                        ${n.studio_name ? `<span class="notification-studio">🏢 ${n.studio_name}</span>` : ''}
                    </div>
                    <span class="notification-dot"></span>
                `;
                body.prepend(item);
            }

            function showToast(message, icon) {
                const toast = document.createElement('div');
                toast.className = 'np-toast';
                toast.innerHTML = `<span class="np-toast-icon">${icon}</span><span>${message}</span>`;
                document.body.appendChild(toast);
                requestAnimationFrame(() => toast.classList.add('show'));
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }
        })();
    </script>

</body>

</html>