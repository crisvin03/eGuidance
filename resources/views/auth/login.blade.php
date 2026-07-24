<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - BNHS Care Konek</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: #e8f0f7;
        }

        /* Full-bleed school photo */
        .bg-photo {
            position: absolute;
            inset: 0;
            background: url('{{ asset("background1.png") }}') center / cover no-repeat;
            z-index: 0;
        }
        .bg-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(220, 235, 248, 0.45);
        }

        /* Decorative dot grids */
        .dot-grid {
            position: absolute;
            z-index: 1;
            opacity: .55;
            background-image: radial-gradient(circle, #a0b4cc 1px, transparent 1px);
            background-size: 18px 18px;
        }
        .dot-grid-tl { width: 140px; height: 160px; top: 6%; left: 2%; }
        .dot-grid-br { width: 140px; height: 160px; bottom: 6%; right: 2%; }

        /* Decorative wave blobs */
        .wave-blob {
            position: absolute;
            z-index: 1;
            border-radius: 50%;
            filter: blur(0px);
        }
        .wave-blue {
            width: 420px; height: 220px;
            bottom: -40px; left: -60px;
            background: linear-gradient(135deg, rgba(100,160,220,.55) 0%, rgba(140,190,240,.35) 100%);
            border-radius: 60% 40% 50% 50% / 40% 50% 50% 60%;
        }
        .wave-gold {
            width: 200px; height: 130px;
            bottom: -20px; right: 8%;
            background: linear-gradient(135deg, rgba(245,197,24,.75) 0%, rgba(255,210,60,.55) 100%);
            border-radius: 50% 50% 40% 60% / 60% 40% 60% 40%;
        }

        /* Leaf decorations */
        .leaf {
            position: absolute;
            z-index: 2;
            opacity: .7;
            font-size: 5rem;
            color: rgba(80,160,100,.5);
            pointer-events: none;
            user-select: none;
        }
        .leaf-left  { bottom: 18%; left: 6%; transform: rotate(-20deg); }
        .leaf-right { bottom: 18%; right: 6%; transform: rotate(15deg) scaleX(-1); }

        /* ── CARD ── */
        .login-container {
            position: relative;
            z-index: 10;
            display: flex;
            width: min(860px, 94vw);
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(10,40,80,.18), 0 4px 16px rgba(10,40,80,.08);
        }

        /* ── LEFT BRAND PANEL ── */
        .brand-panel {
            flex: 0 0 42%;
            background: linear-gradient(170deg, #f4f9f4 0%, #e8f5ec 60%, #d4eeda 100%);
            padding: 2.75rem 2.25rem 0;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        /* wave at bottom of brand panel */
        .brand-wave {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 90px;
            overflow: hidden;
        }
        .brand-wave svg { width: 100%; height: 100%; }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: 1.6rem;
        }
        .brand-logo img {
            width: 52px; height: 52px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,.12);
        }
        .brand-logo-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0d2d52;
            line-height: 1.1;
        }
        .brand-logo-sub {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #1e7a4a;
        }

        .brand-divider {
            width: 38px; height: 3px;
            background: #1e7a4a;
            border-radius: 3px;
            margin-bottom: 1.4rem;
        }

        .brand-heading {
            font-size: 1.85rem;
            font-weight: 700;
            color: #0d2d52;
            line-height: 1.2;
            margin-bottom: .85rem;
        }
        .brand-heading span { color: #1e7a4a; }

        .brand-desc {
            font-size: .88rem;
            color: #475569;
            line-height: 1.65;
            margin-bottom: 1.75rem;
        }

        /* Feature rows */
        .brand-features { display: flex; flex-direction: column; gap: .9rem; margin-bottom: 6rem; }
        .brand-feature {
            display: flex;
            align-items: flex-start;
            gap: .85rem;
        }
        .bf-icon {
            width: 38px; height: 38px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .bf-icon.green { background: rgba(30,122,74,.12); color: #1e7a4a; }
        .bf-icon.blue  { background: rgba(46,123,207,.12); color: #2e7bcf; }
        .bf-icon.gold  { background: rgba(245,197,24,.20); color: #c8960a; }
        .bf-title { font-size: .88rem; font-weight: 700; color: #1e293b; line-height: 1.2; }
        .bf-sub   { font-size: .78rem; color: #64748b; margin-top: .1rem; }

        /* ── RIGHT LOGIN PANEL ── */
        .login-panel {
            flex: 1;
            padding: 2.75rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            font-size: 1.9rem;
            font-weight: 700;
            color: #0d2d52;
            margin-bottom: .3rem;
        }
        .login-title::after {
            content: '';
            display: block;
            width: 42px; height: 3px;
            background: #1e7a4a;
            border-radius: 3px;
            margin-top: .45rem;
        }
        .login-subtitle {
            font-size: .88rem;
            color: #64748b;
            margin-top: .65rem;
            margin-bottom: 1.75rem;
        }

        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: .45rem;
        }

        /* Input with leading icon */
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: .95rem;
            font-size: 1rem;
            color: #1e7a4a;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: .75rem 1rem .75rem 2.6rem;
            border: 1.5px solid #d1dbe8;
            border-radius: 10px;
            font-size: .93rem;
            font-family: inherit;
            background: #fff;
            color: #1e293b;
            transition: border-color .25s, box-shadow .25s;
        }
        .form-input::placeholder { color: #a0aec0; }
        .form-input:focus {
            outline: none;
            border-color: #1e7a4a;
            box-shadow: 0 0 0 3px rgba(30,122,74,.12);
        }
        .form-input.is-invalid { border-color: #e74c3c; }
        .invalid-feedback { color: #e74c3c; font-size: .82rem; margin-top: .35rem; display: block; }

        /* Password toggle */
        .pw-toggle-btn {
            position: absolute;
            right: .9rem;
            background: none; border: none;
            color: #94a3b8; cursor: pointer;
            font-size: 1rem; padding: .2rem;
            transition: color .2s;
        }
        .pw-toggle-btn:hover { color: #1e7a4a; }

        /* Options row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
        }
        .form-check { display: flex; align-items: center; gap: .5rem; cursor: pointer; }
        .form-check-input {
            width: 16px; height: 16px;
            border: 1.5px solid #d1dbe8;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #1e7a4a;
        }
        .form-check-label { font-size: .85rem; color: #475569; cursor: pointer; }
        .forgot-link {
            font-size: .85rem;
            font-weight: 600;
            color: #1e7a4a;
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: #145e38; }

        /* Sign-in button */
        .btn-login {
            width: 100%;
            padding: .85rem;
            background: #1e7a4a;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: .97rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            transition: background .25s, transform .2s, box-shadow .25s;
            box-shadow: 0 4px 16px rgba(30,122,74,.3);
        }
        .btn-login:hover {
            background: #145e38;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30,122,74,.38);
        }

        /* Divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin: 1.2rem 0;
            color: #94a3b8;
            font-size: .82rem;
        }
        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Register prompt */
        .register-prompt {
            text-align: center;
            font-size: .88rem;
            color: #475569;
        }
        .register-link {
            color: #1e7a4a;
            text-decoration: none;
            font-weight: 700;
            transition: color .2s;
        }
        .register-link:hover { color: #145e38; }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            body {
                min-height: 100vh;
                padding: 2.5rem 1.25rem 3rem;
                overflow-y: auto;
                align-items: center;
                justify-content: center;
                background: linear-gradient(160deg, #d4ede8 0%, #cce8f4 60%, #d6eee6 100%);
            }
            .bg-photo, .dot-grid, .wave-blob, .leaf { display: none; }
            .login-container {
                flex-direction: column;
                width: 100%;
                max-width: 420px;
                margin: 0 auto;
                border-radius: 24px;
                box-shadow: 0 8px 40px rgba(13,45,82,.14), 0 2px 10px rgba(13,45,82,.08);
            }
            .brand-panel { display: none; }
            .login-panel { padding: 2.25rem 1.75rem 2rem; }
        }
        @media (max-width: 480px) {
            body { padding: 1.5rem 1rem 2.5rem; }
            .login-panel { padding: 2rem 1.25rem 1.75rem; }
        }
    </style>
</head>
<body>

    <div class="bg-photo"></div>
    <div class="dot-grid dot-grid-tl"></div>
    <div class="dot-grid dot-grid-br"></div>
    <div class="wave-blob wave-blue"></div>
    <div class="wave-blob wave-gold"></div>
    <div class="leaf leaf-left"><i class="bi bi-flower1"></i></div>
    <div class="leaf leaf-right"><i class="bi bi-flower1"></i></div>

    <div class="login-container">

        {{-- LEFT BRAND PANEL --}}
        <div class="brand-panel">
            <div class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="BNHS Care Konek">
                <div>
                    <div class="brand-logo-name">Care Konek</div>
                    <div class="brand-logo-sub">BNHS Referral &amp; Case Management</div>
                </div>
            </div>

            <div class="brand-divider"></div>

            <h2 class="brand-heading">Welcome <span>Back!</span></h2>
            <p class="brand-desc">
                Access your account to manage concerns,<br>
                schedule appointments, and connect<br>
                with guidance counselors.
            </p>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="bf-icon green"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="bf-title">Secure &amp; Confidential</div>
                        <div class="bf-sub">Your privacy is our priority.</div>
                    </div>
                </div>
                <div class="brand-feature">
                    <div class="bf-icon blue"><i class="bi bi-clock"></i></div>
                    <div>
                        <div class="bf-title">24/7 Access</div>
                        <div class="bf-sub">Support anytime, anywhere.</div>
                    </div>
                </div>
                <div class="brand-feature">
                    <div class="bf-icon gold"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="bf-title">Professional Support</div>
                        <div class="bf-sub">Guidance you can trust.</div>
                    </div>
                </div>
            </div>

            {{-- Bottom wave --}}
            <div class="brand-wave">
                <svg viewBox="0 0 400 90" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,40 C80,80 160,0 240,50 C320,100 360,30 400,50 L400,90 L0,90 Z"
                          fill="rgba(100,160,220,0.35)"/>
                    <path d="M0,60 C60,20 140,80 220,40 C300,0 360,60 400,40 L400,90 L0,90 Z"
                          fill="rgba(100,160,220,0.20)"/>
                </svg>
            </div>
        </div>

        {{-- RIGHT LOGIN PANEL --}}
        <div class="login-panel">
            <h1 class="login-title">Sign In</h1>
            <p class="login-subtitle">Enter your credentials to access your account</p>

            @if(session('approval_pending'))
                <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:10px;padding:.85rem 1rem;margin-bottom:1.2rem;display:flex;align-items:flex-start;gap:.65rem;font-size:.85rem;color:#92400e;">
                    <i class="bi bi-hourglass-split" style="flex-shrink:0;margin-top:.1rem;"></i>
                    <span>Your account is pending approval by a counselor. You'll be notified once approved.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input id="email"
                               type="email"
                               class="form-input @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus
                               placeholder="Enter your email">
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input id="password"
                               type="password"
                               class="form-input @error('password') is-invalid @enderror"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your password">
                        <button type="button" class="pw-toggle-btn" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="form-check">
                        <input type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}
                               class="form-check-input">
                        <span class="form-check-label">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>

                @if (Route::has('register'))
                    <div class="or-divider">or</div>
                    <div class="register-prompt">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="register-link">Create account</a>
                    </div>
                @endif
            </form>
        </div>

    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon  = document.getElementById(fieldId + '-toggle-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>
