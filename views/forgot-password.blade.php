<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password — NestPeek Photo</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            background: #0A0A0F;
            color: #F5F0E8;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px
        }

        .card {
            background: #12121A;
            border: 1px solid #2A2A3F;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            justify-content: center
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #9A7A2E, #C9A84C, #E8C878);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #0A0A0F;
            font-size: 14px
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem
        }

        .logo-text span {
            background: linear-gradient(135deg, #C9A84C, #E8C878);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 400;
            text-align: center;
            margin-bottom: 8px
        }

        p {
            color: #8B8BA0;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 28px;
            line-height: 1.6
        }

        label {
            display: block;
            font-size: 0.75rem;
            color: #8B8BA0;
            margin-bottom: 7px
        }

        input {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid #2A2A3F;
            color: #F5F0E8;
            border-radius: 12px;
            padding: 13px 16px;
            font-size: 0.88rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            margin-bottom: 20px
        }

        input:focus {
            border-color: #C9A84C;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.1)
        }

        input::placeholder {
            color: #8B8BA0
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #9A7A2E, #C9A84C, #E8C878);
            color: #0A0A0F;
            border: none;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.83rem;
            color: #8B8BA0;
            text-decoration: none
        }

        .back span {
            color: #C9A84C
        }

        .status {
            background: rgba(46, 204, 113, 0.1);
            border: 1px solid rgba(46, 204, 113, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.83rem;
            color: #2ecc71;
            margin-bottom: 20px;
            text-align: center
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon">N</div>
            <div class="logo-text">Nest<span>Peek</span></div>
        </div>
        <h1>Reset password</h1>
        <p>Enter your email and we'll send you a link to reset your password.</p>

        @if(session('status'))
        <div class="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            @error('email')<p style="color:#e74c3c;font-size:0.78rem;margin-top:-14px;margin-bottom:14px">{{ $message }}</p>@enderror
            <button type="submit" class="btn">Send Reset Link</button>
        </form>

        <a href="{{ route('login') }}" class="back">← Back to <span>Sign In</span></a>
    </div>
</body>

</html>