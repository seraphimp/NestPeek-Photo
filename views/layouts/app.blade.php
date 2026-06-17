<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NestPeek Photo')</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

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
            --border: rgba(14, 165, 233, 0.15);
            --border-mid: rgba(14, 165, 233, 0.3);
            --green: #22C55E;
            --red: #EF4444;
            --radius: 16px;
            --radius-sm: 10px;
            --transition: 0.25s ease;
            --nav-height: 68px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--white);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── NAV ── */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--nav-height);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 32px;
            z-index: 1000;
            gap: 32px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--sky-light), var(--sky));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #fff;
            font-size: 15px;
        }

        .nav-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.22rem;
            color: var(--navy);
            letter-spacing: 0.03em;
        }

        .nav-logo-text span {
            background: linear-gradient(135deg, var(--sky), var(--sky-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .nav-link {
            padding: 7px 14px;
            border-radius: 9px;
            font-size: 0.85rem;
            color: var(--slate);
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--navy);
            background: var(--sky-faint);
        }

        .nav-link.active {
            color: var(--sky-mid);
            background: var(--sky-pale);
            font-weight: 600;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all var(--transition);
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(14, 165, 233, 0.45);
        }

        .btn-ghost {
            border: 1.5px solid var(--border-mid);
            color: var(--navy-mid);
            background: transparent;
        }

        .btn-ghost:hover {
            background: var(--sky-faint);
            border-color: var(--sky);
            color: var(--sky);
        }

        .btn-outline {
            border: 1.5px solid var(--border);
            color: var(--slate);
            background: transparent;
        }

        .btn-outline:hover {
            border-color: var(--border-mid);
            color: var(--navy);
            background: var(--sky-faint);
        }

        .btn-sm {
            padding: 7px 16px;
            font-size: 0.8rem;
            border-radius: 50px;
        }

        /* ── CARDS ── */
        .card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 2px 12px rgba(14, 165, 233, 0.06);
        }

        .card-body {
            padding: 24px;
        }

        /* ── FORMS ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.72rem;
            color: var(--slate);
            margin-bottom: 7px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            color: var(--text-main);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 0.88rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: all var(--transition);
        }

        .form-input:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.12);
            background: var(--white);
        }

        .form-input::placeholder {
            color: var(--slate-light);
        }

        select.form-input {
            cursor: pointer;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        .badge-sky {
            background: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.28);
            color: var(--sky-mid);
        }

        /* ── AVATAR ── */
        .avatar {
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-lg {
            width: 64px;
            height: 64px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.88rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #15803D;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #B91C1C;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 36px;
        }

        .eyebrow {
            font-size: 0.7rem;
            color: var(--sky);
            font-family: 'DM Mono', monospace;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .eyebrow::before {
            content: '';
            display: inline-block;
            width: 22px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1.15;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            max-width: 520px;
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }

        /* ── MAIN ── */
        .main-content {
            padding-top: var(--nav-height);
            min-height: 100vh;
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--sky-faint);
            border-top: 1px solid var(--border);
            padding: 56px 32px 32px;
            margin-top: 80px;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 56px;
            align-items: start;
        }

        .footer-brand p {
            color: var(--slate);
            font-size: 0.83rem;
            margin-top: 14px;
            max-width: 260px;
            line-height: 1.75;
        }

        .footer-col h4 {
            font-size: 0.68rem;
            color: var(--sky-mid);
            font-family: 'DM Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .footer-col a {
            display: block;
            color: var(--slate);
            font-size: 0.83rem;
            text-decoration: none;
            margin-bottom: 10px;
            transition: color var(--transition);
        }

        .footer-col a:hover {
            color: var(--navy);
        }

        .footer-bottom {
            max-width: 1280px;
            margin: 32px auto 0;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            font-size: 0.78rem;
            color: var(--slate-mid);
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flash-msg {
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            animation: slideUp 0.3s ease;
            max-width: 360px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .flash-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #15803D;
        }

        .flash-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #B91C1C;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @yield('styles')
    </style>
</head>

<body>

    {{-- NAV --}}
    <nav class="nav">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="nav-logo-icon">N</div>
            <div class="nav-logo-text">Nest<span>Peek</span></div>
        </a>

        <div class="nav-links">
            <a href="{{ route('creators.index') }}" class="nav-link {{ request()->routeIs('creators.*') ? 'active' : '' }}">Creators</a>
            <a href="{{ route('studios.index') }}" class="nav-link {{ request()->routeIs('studios.*')  ? 'active' : '' }}">Studios</a>
            <a href="{{ route('search') }}" class="nav-link {{ request()->routeIs('search')     ? 'active' : '' }}">Search</a>
        </div>

        <div class="nav-actions">
            @auth
            <a href="{{ route('messages.index') }}" class="nav-link" title="Messages"
                style="display:flex;align-items:center;padding:8px 10px">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Sign Out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
            @endauth
        </div>
    </nav>

    {{-- MAIN --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="nav-logo">
                    <div class="nav-logo-icon">N</div>
                    <div class="nav-logo-text">Nest<span>Peek</span></div>
                </a>
                <p>The premier platform for booking wedding photographers, videographers, and studios across the Philippines.</p>
            </div>
            <div class="footer-col">
                <h4>Discover</h4>
                <a href="{{ route('creators.index') }}">Photographers</a>
                <a href="{{ route('studios.index') }}">Studios</a>
                <a href="{{ route('search') }}">Search</a>
            </div>
            <div class="footer-col">
                <h4>Account</h4>
                @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('bookings.index') }}">My Bookings</a>
                <a href="{{ route('messages.index') }}">Messages</a>
                @else
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
            <div class="footer-col">
                <h4>For Creators</h4>
                <a href="{{ route('register') }}">Join as Creator</a>
                @auth
                @if(auth()->user()->isCreator() || auth()->user()->isStudioOwner())
                <a href="{{ route('creators.edit') }}">Edit Profile</a>
                @endif
                @endauth
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} NestPeek Photo. All rights reserved.</p>
            <p style="font-size:0.72rem">Made with ♥ in the Philippines</p>
        </div>
    </footer>

    {{-- FLASH --}}
    <div class="flash">
        @if(session('success'))
        <div class="flash-msg flash-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="flash-msg flash-error">✕ {{ session('error') }}</div>
        @endif
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.flash-msg').forEach(el => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>

</html>