<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio — NestPeek Photo</title>
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
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
            --red-border: rgba(239, 68, 68, 0.25);
            --amber: #F59E0B;
            --amber-faint: rgba(245, 158, 11, 0.08);
            --amber-border: rgba(245, 158, 11, 0.25);
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

        .topbar-nav {
            display: flex;
            gap: 4px;
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

        .dropdown:hover .dropdown-menu {
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

        /* ── Page ── */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }

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

        /* ── Buttons ── */
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

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border: 1.5px solid var(--red-border);
            border-radius: 50px;
            color: #991B1B;
            background: var(--red-faint);
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }

        .btn-danger:hover {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        /* ── Flash ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 14px;
            font-size: 0.83rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .flash-success {
            background: var(--green-faint);
            color: #065F46;
            border: 1px solid var(--green-border);
        }

        .flash-error {
            background: var(--red-faint);
            color: #991B1B;
            border: 1px solid var(--red-border);
        }

        /* ── Stats bar ── */
        .stats-bar {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.05);
        }

        .stat-pill-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--navy);
        }

        .stat-pill-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        /* ── Filter bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-chip {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--slate);
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            text-decoration: none;
        }

        .filter-chip:hover,
        .filter-chip.active {
            background: var(--sky-faint);
            border-color: var(--sky-mid);
            color: var(--sky-mid);
        }

        .filter-chip.active {
            background: var(--sky-mid);
            color: #fff;
            border-color: var(--sky-mid);
        }

        /* ── Grid ── */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .portfolio-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s;
            position: relative;
        }

        .portfolio-card:hover {
            box-shadow: 0 8px 32px rgba(14, 165, 233, 0.12);
            border-color: var(--border-mid);
            transform: translateY(-2px);
        }

        /* Cover image area */
        .card-cover {
            position: relative;
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--sky-pale), var(--sky-faint));
            overflow: hidden;
        }

        .card-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .portfolio-card:hover .card-cover img {
            transform: scale(1.04);
        }

        .card-cover-empty {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--slate-light);
        }

        /* Image count chip */
        .img-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(12, 74, 110, 0.75);
            backdrop-filter: blur(4px);
            color: #fff;
            border-radius: 20px;
            padding: 3px 10px;
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
        }

        /* Featured badge */
        .featured-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            border-radius: 20px;
            padding: 3px 10px;
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Draft badge */
        .draft-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--amber-faint);
            color: #92400E;
            border: 1px solid var(--amber-border);
            border-radius: 20px;
            padding: 3px 10px;
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* Card body */
        .card-body {
            padding: 16px;
        }

        .card-category {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--sky-mid);
            margin-bottom: 5px;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 400;
            color: var(--navy);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .card-meta {
            font-size: 0.72rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .card-meta span {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        /* Card actions */
        .card-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            background: var(--sky-faint);
        }

        .card-actions .spacer {
            flex: 1;
        }

        /* ── Upload / Add modal trigger ── */
        .upload-zone {
            border: 2px dashed var(--border-mid);
            border-radius: 18px;
            padding: 40px 24px;
            text-align: center;
            background: var(--sky-faint);
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            margin-bottom: 32px;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--sky);
            background: var(--sky-pale);
        }

        .upload-zone-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .upload-zone h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 400;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .upload-zone p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(12, 74, 110, 0.4);
            backdrop-filter: blur(4px);
            z-index: 500;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 620px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 24px 64px rgba(12, 74, 110, 0.2);
            animation: slideUp 0.2s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(16px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 28px 0;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: var(--navy);
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--slate);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }

        .modal-close:hover {
            background: var(--sky-faint);
            border-color: var(--sky-mid);
            color: var(--navy);
        }

        .modal-body {
            padding: 20px 28px 28px;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-label span {
            color: var(--slate-mid);
            font-weight: 400;
            margin-left: 4px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--text-main);
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
            line-height: 1.55;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Image drop zone inside modal */
        .img-dropzone {
            border: 2px dashed var(--border-mid);
            border-radius: 12px;
            padding: 28px 16px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            background: var(--sky-faint);
        }

        .img-dropzone:hover,
        .img-dropzone.dragover {
            border-color: var(--sky);
            background: var(--sky-pale);
        }

        .img-dropzone input[type="file"] {
            display: none;
        }

        .img-dropzone-icon {
            font-size: 1.6rem;
            margin-bottom: 8px;
        }

        .img-dropzone p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .img-dropzone strong {
            color: var(--sky-mid);
        }

        /* Preview thumbnails */
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 12px;
        }

        .preview-thumb {
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background: var(--sky-pale);
            border: 1.5px solid var(--border);
        }

        .preview-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-thumb-remove {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(12, 74, 110, 0.7);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Form toggles */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .toggle-label {
            font-size: 0.82rem;
            color: var(--text-main);
            font-weight: 500;
        }

        .toggle-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .toggle {
            position: relative;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: var(--slate-light);
            cursor: pointer;
            transition: background 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            left: 3px;
            top: 3px;
            transition: transform 0.2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }

        .toggle input:checked+.toggle-slider {
            background: var(--sky);
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        .form-error {
            font-size: 0.73rem;
            color: var(--red);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Delete confirmation modal ── */
        .confirm-modal {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            padding: 28px;
            text-align: center;
            box-shadow: 0 24px 64px rgba(12, 74, 110, 0.2);
            animation: slideUp 0.2s ease;
        }

        .confirm-icon {
            font-size: 2rem;
            margin-bottom: 12px;
        }

        .confirm-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .confirm-body {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.55;
        }

        .confirm-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 64px 24px;
            color: var(--slate-mid);
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }

        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .empty-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        /* ── Progress bar (upload) ── */
        .upload-progress {
            display: none;
            margin-top: 14px;
        }

        .upload-progress.visible {
            display: block;
        }

        .progress-bar-wrap {
            height: 4px;
            background: var(--sky-pale);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--sky), var(--sky-mid));
            border-radius: 10px;
            transition: width 0.3s ease;
            width: 0%;
        }

        .progress-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            color: var(--slate-mid);
            margin-top: 5px;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .portfolio-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 560px) {
            .portfolio-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 14px 20px;
            }

            .page {
                padding: 20px 16px 60px;
            }

            .page-header {
                flex-direction: column;
            }

            .modal {
                border-radius: 20px 20px 0 0;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                max-width: none;
                max-height: 85vh;
            }

            .modal-overlay {
                align-items: flex-end;
                padding: 0;
            }

            .stats-bar {
                gap: 8px;
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
            <nav class="topbar-nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('bookings.index') }}">Bookings</a>
                <a href="{{ route('portfolio.index') }}" class="active">Portfolio</a>
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

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="flash flash-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error') || $errors->any())
        <div class="flash flash-error">
            ✕ {{ session('error') ?? $errors->first() }}
        </div>
        @endif

        {{-- ── Page header ── --}}
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Portfolio Management</p>
                <h1 class="page-title">Your Portfolio</h1>
                <p class="page-sub">Showcase your best work to attract the right clients.</p>
            </div>
            <button class="btn-primary" onclick="openModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Add Project
            </button>
        </div>

        {{-- ── Stats bar ── --}}
        <div class="stats-bar">
            <div class="stat-pill">
                <span class="stat-pill-value">{{ $portfolios->total() }}</span>
                <span class="stat-pill-label">Projects</span>
            </div>
            <div class="stat-pill">
                <span class="stat-pill-value">{{ $portfolios->sum(fn($p) => $p->media_count ?? 0) }}</span>
                <span class="stat-pill-label">Photos</span>
            </div>
            <div class="stat-pill">
                <span class="stat-pill-value">{{ $portfolios->where('is_published', true)->count() }}</span>
                <span class="stat-pill-label">Published</span>
            </div>
            <div class="stat-pill">
                <span class="stat-pill-value">{{ $portfolios->where('is_featured', true)->count() }}</span>
                <span class="stat-pill-label">Featured</span>
            </div>
        </div>

        {{-- ── Filter chips ── --}}
        @php
        $categories = $portfolios->pluck('category')->filter()->unique()->values();
        $activeFilter = request('category');
        @endphp
        @if($categories->count() > 1)
        <div class="filter-bar">
            <a href="{{ route('portfolio.index') }}"
                class="filter-chip {{ !$activeFilter ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
            <a href="{{ route('portfolio.index', ['category' => $cat]) }}"
                class="filter-chip {{ $activeFilter === $cat ? 'active' : '' }}">
                {{ ucfirst(str_replace('_', ' ', $cat)) }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- ── Portfolio grid ── --}}
        @if($portfolios->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🖼️</div>
            <h2 class="empty-title">No projects yet</h2>
            <p class="empty-sub">Add your first portfolio project to start attracting clients.</p>
            <button class="btn-primary" onclick="openModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Add your first project
            </button>
        </div>
        @else
        <div class="portfolio-grid">
            @foreach($portfolios as $item)
            <div class="portfolio-card">

                {{-- Cover --}}
                <div class="card-cover">
                    @if($item->cover_image)
                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}">
                    @else
                    <div class="card-cover-empty">📷</div>
                    @endif

                    @if($item->is_featured)
                    <span class="featured-badge">★ Featured</span>
                    @endif

                    @if(!$item->is_published)
                    <span class="draft-badge">Draft</span>
                    @endif

                    @php $mediaCount = $item->media_count ?? $item->media->count(); @endphp
                    @if($mediaCount > 1)
                    <span class="img-count">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="m3 9 4-4 4 4 4-4 4 4" />
                            <path d="m3 15 4 4 4-4 4 4 4-4" />
                        </svg>
                        {{ $mediaCount }}
                    </span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="card-body">
                    @if($item->category)
                    <p class="card-category">{{ str_replace('_', ' ', $item->category) }}</p>
                    @endif
                    <h3 class="card-title">{{ $item->title }}</h3>
                    <div class="card-meta">
                        @if($item->location)
                        <span>📍 {{ $item->location }}</span>
                        @endif
                        @if($item->shoot_date)
                        <span>📅 {{ $item->shoot_date->format('M Y') }}</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card-actions">
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}#portfolio"
                        target="_blank" class="btn-ghost" style="font-size:0.75rem;padding:5px 12px">
                        ↗ View
                    </a>
                    <span class="spacer"></span>
                    <button class="btn-danger" onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->title) }}')">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4h6v2" />
                        </svg>
                        Delete
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($portfolios->hasPages())
        <div style="display:flex;justify-content:center;margin-top:8px">
            {{ $portfolios->links() }}
        </div>
        @endif
        @endif

    </div>{{-- /page --}}


    {{-- ══════════════════════════════
     ADD PROJECT MODAL
════════════════════════════════ --}}
    <div class="modal-overlay" id="addModal" onclick="closeOnOverlay(event)">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Add New Project</h2>
                <button class="modal-close" onclick="closeModal()">✕</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('portfolios.store') }}" enctype="multipart/form-data" id="portfolioForm">
                    @csrf

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label" for="title">Project Title</label>
                        <input type="text" id="title" name="title"
                            class="form-input" placeholder="e.g. Maria & Juan's Wedding"
                            value="{{ old('title') }}" required>
                        @error('title')<p class="form-error">✕ {{ $message }}</p>@enderror
                    </div>

                    {{-- Category + Shoot Date --}}
                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="category">Category</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach([
                                'wedding' => 'Wedding',
                                'prenuptial' => 'Prenuptial',
                                'debut' => 'Debut / 18th Birthday',
                                'baptism' => 'Baptism',
                                'corporate' => 'Corporate Event',
                                'portrait' => 'Portrait / Headshot',
                                'family' => 'Family',
                                'maternity' => 'Maternity',
                                'product' => 'Product / Commercial',
                                'other' => 'Other',
                                ] as $val => $label)
                                <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category')<p class="form-error">✕ {{ $message }}</p>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="shoot_date">Shoot Date <span>optional</span></label>
                            <input type="date" id="shoot_date" name="shoot_date"
                                class="form-input" value="{{ old('shoot_date') }}">
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="form-group" style="margin-top:18px">
                        <label class="form-label" for="location">Location <span>optional</span></label>
                        <input type="text" id="location" name="location"
                            class="form-input" placeholder="e.g. Bacolod City, Negros Occidental"
                            value="{{ old('location') }}">
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label" for="description">Description <span>optional</span></label>
                        <textarea id="description" name="description"
                            class="form-textarea"
                            placeholder="Tell clients about this shoot — the vibe, venue, story...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Images --}}
                    <div class="form-group">
                        <label class="form-label">Photos <span>up to 20, max 10 MB each</span></label>
                        <div class="img-dropzone" id="dropzone" onclick="document.getElementById('images').click()">
                            <input type="file" id="images" name="images[]"
                                accept="image/*" multiple
                                onchange="handleFiles(this.files)">
                            <div class="img-dropzone-icon">📸</div>
                            <p><strong>Click to upload</strong> or drag and drop<br>JPG, PNG, WEBP</p>
                        </div>
                        <div class="preview-grid" id="previewGrid"></div>
                        @error('images')<p class="form-error">✕ {{ $message }}</p>@enderror
                        @error('images.*')<p class="form-error">✕ {{ $message }}</p>@enderror

                        <div class="upload-progress" id="uploadProgress">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" id="progressBar"></div>
                            </div>
                            <p class="progress-label" id="progressLabel">Uploading…</p>
                        </div>
                    </div>

                    {{-- Toggles --}}
                    <div class="form-group">
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">Publish immediately</div>
                                <div class="toggle-sub">Visible on your public profile</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_published" value="1" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">Mark as featured</div>
                                <div class="toggle-sub">Highlighted at the top of your portfolio</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_featured" value="1">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px">
                        <button type="button" class="btn-ghost" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Add Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════
     DELETE CONFIRMATION MODAL
════════════════════════════════ --}}
    <div class="modal-overlay" id="deleteModal" onclick="closeOnOverlay(event)">
        <div class="confirm-modal">
            <div class="confirm-icon">🗑️</div>
            <h3 class="confirm-title">Delete this project?</h3>
            <p class="confirm-body" id="deleteModalBody">
                This will permanently remove the project and all its photos. This action cannot be undone.
            </p>
            <div class="confirm-actions">
                <button class="btn-ghost" onclick="closeDeleteModal()">Keep it</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        Delete forever
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        // ── Modal open/close ──
        function openModal() {
            document.getElementById('addModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('addModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function closeOnOverlay(e) {
            if (e.target === e.currentTarget) {
                e.currentTarget.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
            }
        });

        // ── Re-open modal on validation error ──
        @if($errors -> any())
        document.addEventListener('DOMContentLoaded', openModal);
        @endif

        // ── Delete modal ──
        function confirmDelete(id, title) {
            document.getElementById('deleteModalBody').textContent =
                `"${title}" and all its photos will be permanently removed. This cannot be undone.`;
            document.getElementById('deleteForm').action =
                `{{ url('portfolios') }}/${id}`;
            document.getElementById('deleteModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ── Image preview ──
        let selectedFiles = [];

        function handleFiles(files) {
            const newFiles = Array.from(files);
            selectedFiles = [...selectedFiles, ...newFiles].slice(0, 20);
            renderPreviews();
            syncFileInput();
        }

        function renderPreviews() {
            const grid = document.getElementById('previewGrid');
            grid.innerHTML = '';
            selectedFiles.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const thumb = document.createElement('div');
                    thumb.className = 'preview-thumb';
                    thumb.innerHTML = `
                    <img src="${e.target.result}" alt="">
                    <button type="button" class="preview-thumb-remove" onclick="removeFile(${i})">✕</button>
                `;
                    grid.appendChild(thumb);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderPreviews();
            syncFileInput();
        }

        function syncFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            document.getElementById('images').files = dt.files;
        }

        // ── Drag and drop ──
        const dropzone = document.getElementById('dropzone');
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        // ── Upload progress simulation ──
        document.getElementById('portfolioForm').addEventListener('submit', function() {
            const prog = document.getElementById('uploadProgress');
            const bar = document.getElementById('progressBar');
            const lbl = document.getElementById('progressLabel');
            if (selectedFiles.length === 0) return;

            prog.classList.add('visible');
            document.getElementById('submitBtn').disabled = true;

            let pct = 0;
            const iv = setInterval(() => {
                pct = Math.min(pct + Math.random() * 15, 90);
                bar.style.width = pct + '%';
                lbl.textContent = `Uploading ${selectedFiles.length} photo${selectedFiles.length > 1 ? 's' : ''}…`;
            }, 300);

            // Clean up on form submit (real progress would come from XHR)
            setTimeout(() => clearInterval(iv), 8000);
        });
    </script>

</body>

</html>