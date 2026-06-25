<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — NestPeek Photo</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased
        }

        :root {
            --gold: #C9A84C;
            --gold-light: #E8C878;
            --gold-dark: #9A7A2E;
            --obsidian: #0A0A0F;
            --ink: #12121A;
            --ink-light: #1C1C2A;
            --ink-border: #2A2A3F;
            --mist: #8B8BA0;
            --ivory: #F5F0E8
        }

        body {
            background: var(--obsidian);
            color: var(--ivory);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px
        }

        .container {
            width: 100%;
            max-width: 560px
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            justify-content: center
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--obsidian);
            font-size: 16px
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem
        }

        .logo-text span {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .card {
            background: var(--ink);
            border: 1px solid var(--ink-border);
            border-radius: 24px;
            padding: 40px
        }

        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 6px;
            text-align: center
        }

        .subtitle {
            color: var(--mist);
            font-size: 0.88rem;
            text-align: center;
            margin-bottom: 32px
        }

        /* Role selector */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 28px
        }

        .role-option {
            position: relative
        }

        .role-option input[type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0
        }

        .role-card {
            border: 1px solid var(--ink-border);
            border-radius: 14px;
            padding: 16px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.02)
        }

        .role-card:hover {
            border-color: rgba(201, 168, 76, 0.4);
            background: rgba(201, 168, 76, 0.05)
        }

        .role-option input:checked+.role-card {
            border-color: var(--gold);
            background: rgba(201, 168, 76, 0.1)
        }

        .role-icon {
            font-size: 1.6rem;
            margin-bottom: 8px
        }

        .role-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ivory)
        }

        .role-desc {
            font-size: 0.7rem;
            color: var(--mist);
            margin-top: 3px;
            line-height: 1.3
        }

        .form-group {
            margin-bottom: 18px
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px
        }

        label {
            display: block;
            font-size: 0.75rem;
            color: var(--mist);
            margin-bottom: 7px;
            letter-spacing: 0.04em
        }

        input[type=email],
        input[type=password],
        input[type=text],
        input[type=tel] {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--ink-border);
            color: var(--ivory);
            border-radius: 12px;
            padding: 13px 16px;
            font-size: 0.88rem;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
            outline: none
        }

        input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.1);
            background: rgba(255, 255, 255, 0.06)
        }

        input::placeholder {
            color: var(--mist)
        }

        .password-wrapper {
            position: relative
        }

        .password-wrapper input {
            padding-right: 48px
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--mist);
            cursor: pointer
        }

        .toggle-pw:hover {
            color: var(--ivory)
        }

        .strength-bar {
            height: 3px;
            border-radius: 2px;
            margin-top: 8px;
            background: var(--ink-border);
            overflow: hidden
        }

        .strength-fill {
            height: 100%;
            border-radius: 2px;
            transition: all 0.3s;
            width: 0
        }

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 20px 0;
            font-size: 0.83rem;
            color: var(--mist)
        }

        .terms input[type=checkbox] {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            accent-color: var(--gold);
            flex-shrink: 0;
            cursor: pointer
        }

        .terms a {
            color: var(--gold);
            text-decoration: none
        }

        .terms a:hover {
            color: var(--gold-light)
        }

        .btn-gold {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            color: var(--obsidian);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4)
        }

        .login-link {
            text-align: center;
            font-size: 0.85rem;
            color: var(--mist);
            margin-top: 20px
        }

        .login-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500
        }

        .error-msg {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #e74c3c;
            margin-bottom: 20px
        }

        .field-error {
            font-size: 0.78rem;
            color: #e74c3c;
            margin-top: 5px
        }

        .section-label {
            font-size: 0.7rem;
            font-family: 'DM Mono', monospace;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 14px
        }

        .divider-line {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 168, 76, 0.2), transparent);
            margin: 24px 0
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="logo">
            <div class="logo-icon">N</div>
            <div class="logo-text">Nest<span>Peek</span> Photo</div>
        </div>

        <div class="card">
            <h1>Create your account</h1>
            <p class="subtitle">Join thousands of creators and clients on NestPeek Photo</p>

            @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Role Selection -->
                <p class="section-label">I am joining as a...</p>
                <div class="role-grid">
                    <label class="role-option">
                        <input type="radio" name="role" value="client"
                            {{ old('role', 'client') === 'client' ? 'checked' : '' }}>
                        <div class="role-card">
                            <div class="role-icon">🔍</div>
                            <div class="role-name">Client</div>
                            <div class="role-desc">Looking to book photographers</div>
                        </div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="creator"
                            {{ old('role') === 'creator' ? 'checked' : '' }}>
                        <div class="role-card">
                            <div class="role-icon">📷</div>
                            <div class="role-name">Creator</div>
                            <div class="role-desc">Photographer, videographer or editor</div>
                        </div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="studio_owner"
                            {{ old('role') === 'studio_owner' ? 'checked' : '' }}>
                        <div class="role-card">
                            <div class="role-icon">🏛️</div>
                            <div class="role-name">Studio</div>
                            <div class="role-desc">Own or manage a studio space</div>
                        </div>
                    </label>
                </div>
                @error('role')<p class="field-error">{{ $message }}</p>@enderror

                <div class="divider-line"></div>
                <p class="section-label">Your information</p>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Maria Santos" required>
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="maria@example.com" required>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <!-- Password -->
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password"
                                placeholder="••••••••" required oninput="checkStrength(this.value)">
                            <button type="button" class="toggle-pw" onclick="togglePw('password')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="••••••••" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <label class="terms">
                    <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>. I understand how NestPeek Photo handles my data.</span>
                </label>
                @error('terms')<p class="field-error" style="margin-top:-10px;margin-bottom:12px">{{ $message }}</p>@enderror

                <button type="submit" class="btn-gold">Create Account</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>

    <script>
        function togglePw(id) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }

        function checkStrength(val) {
            const fill = document.getElementById('strength-fill');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const colors = ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71'];
            const widths = ['25%', '50%', '75%', '100%'];
            fill.style.width = score ? widths[score - 1] : '0';
            fill.style.background = score ? colors[score - 1] : 'transparent';
        }
    </script>
</body>

</html>