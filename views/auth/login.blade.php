<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — NestPeek Photo</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased
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
            --border: rgba(14, 165, 233, 0.18);
            --border-mid: rgba(14, 165, 233, 0.3);
            --red: #EF4444
        }

        body {
            background: var(--sky-pale);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px
        }

        .font-display {
            font-family: 'Playfair Display', serif
        }

        /* Layout */
        .auth-shell {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 600px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 80px rgba(14, 165, 233, 0.2), 0 4px 24px rgba(12, 74, 110, 0.12)
        }

        /* Left panel */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, var(--navy) 0%, var(--navy-mid) 50%, var(--sky-mid) 100%);
            display: none;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px;
            position: relative;
            overflow: hidden
        }

        @media(min-width:900px) {
            .left-panel {
                display: flex
            }
        }

        .left-panel .blob1 {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.13);
            pointer-events: none
        }

        .left-panel .blob2 {
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(14, 165, 233, 0.1);
            pointer-events: none
        }

        .left-panel .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Playfair Display', serif;
            font-size: 16rem;
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
            user-select: none
        }

        .left-panel .top-brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .brand-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.55)
        }

        .brand-name {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.16em;
            text-transform: uppercase
        }

        .photo-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 4px 0
        }

        .photo-grid-item {
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12)
        }

        .photo-grid-item:nth-child(2) {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.13);
            border-color: rgba(255, 255, 255, 0.2)
        }

        .left-panel blockquote {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 400;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.93);
            margin-bottom: 14px;
            font-style: italic;
            position: relative;
            z-index: 2
        }

        .left-panel cite {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.38);
            letter-spacing: 0.14em;
            font-style: normal;
            display: block;
            margin-bottom: 20px;
            position: relative;
            z-index: 2
        }

        .trust-pills {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 8px;
            flex-wrap: wrap
        }

        .trust-pill {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 50px;
            padding: 4px 14px;
            font-size: 0.73rem;
            color: rgba(255, 255, 255, 0.68)
        }

        /* Right panel */
        .right-panel {
            width: 100%;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 40px;
            background: var(--white)
        }

        @media(max-width:899px) {
            .right-panel {
                max-width: 100%
            }
        }

        /* Back link */
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            color: var(--slate-mid);
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.2s
        }

        .back-home:hover {
            color: var(--navy)
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px
        }

        .logo-icon {
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
            font-size: 15px
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--navy);
            letter-spacing: 0.04em
        }

        .logo-text span {
            background: linear-gradient(135deg, var(--sky), var(--sky-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--navy);
            margin-bottom: 6px
        }

        .subtitle {
            color: var(--slate);
            font-size: 0.88rem;
            margin-bottom: 28px
        }

        /* Form */
        .form-group {
            margin-bottom: 18px
        }

        label {
            display: block;
            font-size: 0.72rem;
            color: var(--slate);
            margin-bottom: 7px;
            letter-spacing: 0.07em;
            text-transform: uppercase
        }

        input[type=email],
        input[type=password],
        input[type=text] {
            width: 100%;
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 13px 16px;
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
            outline: none
        }

        input:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.12);
            background: var(--white)
        }

        input::placeholder {
            color: var(--slate-light)
        }

        .password-wrapper {
            position: relative
        }

        .password-wrapper input {
            padding-right: 46px
        }

        .toggle-password {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-mid);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s
        }

        .toggle-password:hover {
            color: var(--navy)
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.84rem;
            color: var(--slate);
            cursor: pointer
        }

        .remember input[type=checkbox] {
            width: 15px;
            height: 15px;
            accent-color: var(--sky);
            cursor: pointer
        }

        .forgot {
            font-size: 0.84rem;
            color: var(--sky);
            text-decoration: none;
            font-weight: 500
        }

        .forgot:hover {
            color: var(--navy-mid)
        }

        .btn-sky {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.04em;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 4px 18px rgba(14, 165, 233, 0.35)
        }

        .btn-sky:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(14, 165, 233, 0.5)
        }

        .btn-sky:active {
            transform: translateY(0)
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 22px 0
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border)
        }

        .divider span {
            font-size: 0.74rem;
            color: var(--slate-mid)
        }

        .register-link {
            text-align: center;
            font-size: 0.84rem;
            color: var(--slate)
        }

        .register-link a {
            color: var(--sky);
            text-decoration: none;
            font-weight: 600;
            margin-left: 3px
        }

        .register-link a:hover {
            color: var(--navy-mid)
        }

        /* Messages */
        .error-msg {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 10px;
            padding: 11px 15px;
            font-size: 0.84rem;
            color: var(--red);
            margin-bottom: 18px
        }

        .field-error {
            font-size: 0.77rem;
            color: var(--red);
            margin-top: 5px
        }

        .status-msg {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.25);
            border-radius: 10px;
            padding: 11px 15px;
            font-size: 0.84rem;
            color: #16A34A;
            margin-bottom: 18px
        }
    </style>
</head>

<body>
    <div class="auth-shell">

        <!-- Left decorative panel -->
        <div class="left-panel">
            <div class="blob1"></div>
            <div class="blob2"></div>
            <div class="watermark">N</div>

            <div class="top-brand">
                <div class="brand-dot"></div>
                <span class="brand-name">NestPeek Photo</span>
            </div>

            <div class="photo-grid">
                <div class="photo-grid-item" style="aspect-ratio:3/4"></div>
                <div class="photo-grid-item" style="aspect-ratio:3/4"></div>
                <div class="photo-grid-item" style="aspect-ratio:3/4"></div>
            </div>

            <div>
                <blockquote>"Every photograph is a certificate of presence."</blockquote>
                <cite>— ROLAND BARTHES</cite>
                <div class="trust-pills">
                    <div class="trust-pill">2,500+ Creators</div>
                    <div class="trust-pill">✓ Verified</div>
                    <div class="trust-pill">12,000+ Bookings</div>
                </div>
            </div>
        </div>

        <!-- Right form panel -->
        <div class="right-panel">
            <a href="/" class="back-home">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to home
            </a>

            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nest<span>Peek</span></div>
            </div>

            <h1>Welcome back</h1>
            <p class="subtitle">Sign in to your NestPeek account</p>

            @if(session('status'))
            <div class="status-msg">{{ session('status') }}</div>
            @endif

            @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required autofocus>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                            placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePw()">
                            <svg id="eye-icon" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-row">
                    <label class="remember">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-sky">Sign In</button>
            </form>

            <div class="divider"><span>or</span></div>

            <div class="register-link">
                Don't have an account?
                <a href="{{ route('register') }}">Create one free</a>
            </div>
        </div>

    </div>

    <script>
        function togglePw() {
            const pw = document.getElementById('password');
            pw.type = pw.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>