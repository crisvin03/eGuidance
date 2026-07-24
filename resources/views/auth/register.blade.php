<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - BNHS Care Konek</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: #e8f0f7;
        }

        /* ── CARD ── */
        .register-container {
            position: relative;
            z-index: 10;
            display: flex;
            width: min(860px, 94vw);
            max-height: calc(100vh - 2.5rem);
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(10,40,80,.18), 0 4px 16px rgba(10,40,80,.08);
        }

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

        .dot-grid {
            position: absolute;
            z-index: 1;
            opacity: .55;
            background-image: radial-gradient(circle, #a0b4cc 1px, transparent 1px);
            background-size: 18px 18px;
        }
        .dot-grid-tl { width: 140px; height: 160px; top: 6%; left: 2%; }
        .dot-grid-br { width: 140px; height: 160px; bottom: 6%; right: 2%; }

        .wave-blob {
            position: absolute;
            z-index: 1;
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

        /* ── LEFT BRAND PANEL ── */
        .brand-panel {
            flex: 0 0 42%;
            background: linear-gradient(170deg, #f4f9f4 0%, #e8f5ec 60%, #d4eeda 100%);
            padding: 2rem 2rem 0;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

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
            margin-bottom: 1rem;
        }
        .brand-logo img {
            width: 48px; height: 48px;
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
            margin-bottom: 1rem;
        }

        .brand-heading {
            font-size: 1.65rem;
            font-weight: 700;
            color: #0d2d52;
            line-height: 1.2;
            margin-bottom: .6rem;
        }
        .brand-heading span { color: #1e7a4a; }

        .brand-desc {
            font-size: .84rem;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 1.1rem;
        }

        .brand-features { display: flex; flex-direction: column; gap: .7rem; margin-bottom: 5.5rem; }
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
        .bf-icon.teal  { background: rgba(32,178,170,.12); color: #0e9e97; }
        .bf-title { font-size: .88rem; font-weight: 700; color: #1e293b; line-height: 1.2; }
        .bf-sub   { font-size: .78rem; color: #64748b; margin-top: .1rem; }

        /* ── RIGHT REGISTER PANEL ── */
        .register-panel {
            flex: 1;
            padding: 1.75rem 2.25rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .register-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #0d2d52;
            margin-bottom: .25rem;
        }
        .register-title::after {
            content: '';
            display: block;
            width: 38px; height: 3px;
            background: #1e7a4a;
            border-radius: 3px;
            margin-top: .35rem;
        }
        .register-subtitle {
            font-size: .85rem;
            color: #64748b;
            margin-top: .5rem;
            margin-bottom: 1rem;
        }

        .form-group { margin-bottom: .65rem; }
        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: .3rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: .9rem;
            font-size: .95rem;
            color: #1e7a4a;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: .62rem 1rem .62rem 2.5rem;
            border: 1.5px solid #d1dbe8;
            border-radius: 10px;
            font-size: .88rem;
            font-family: inherit;
            background: #fff;
            color: #1e293b;
            transition: border-color .25s, box-shadow .25s;
        }
        .form-input.no-icon { padding-left: 1rem; }
        .form-input::placeholder { color: #a0aec0; }
        .form-input:focus {
            outline: none;
            border-color: #1e7a4a;
            box-shadow: 0 0 0 3px rgba(30,122,74,.12);
        }
        .form-input.is-invalid { border-color: #e74c3c; }
        .invalid-feedback { color: #e74c3c; font-size: .78rem; margin-top: .25rem; display: block; }

        .pw-toggle-btn {
            position: absolute;
            right: .85rem;
            background: none; border: none;
            color: #94a3b8; cursor: pointer;
            font-size: .95rem; padding: .2rem;
            transition: color .2s;
        }
        .pw-toggle-btn:hover { color: #1e7a4a; }

        .submit-btn {
            width: 100%;
            padding: .75rem;
            background: #1e7a4a;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: .93rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-top: .3rem;
            transition: background .25s, transform .2s, box-shadow .25s;
            box-shadow: 0 4px 16px rgba(30,122,74,.3);
        }
        .submit-btn:hover {
            background: #145e38;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30,122,74,.38);
        }

        .or-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: .75rem 0;
            color: #94a3b8;
            font-size: .8rem;
        }
        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .login-link {
            text-align: center;
            font-size: .85rem;
            color: #475569;
        }
        .login-link a {
            color: #1e7a4a;
            text-decoration: none;
            font-weight: 700;
            transition: color .2s;
        }
        .login-link a:hover { color: #145e38; }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            body { height: 100dvh; min-height: unset; padding: 0; overflow: hidden; align-items: center; justify-content: center; background: linear-gradient(160deg, #d4ede8 0%, #cce8f4 60%, #d6eee6 100%); }
            .bg-photo, .dot-grid, .wave-blob, .leaf { display: none; }
            .register-container {
                flex-direction: column;
                width: calc(100% - 2rem); max-width: 420px;
                max-height: calc(100dvh - 2rem);
                margin: 0 auto;
                border-radius: 24px;
                box-shadow: 0 8px 40px rgba(13,45,82,.14), 0 2px 10px rgba(13,45,82,.08);
                overflow: hidden;
            }
            .brand-panel { display: none; }
            .register-panel { padding: 1.5rem 1.5rem 1.25rem; overflow-y: hidden; }
            .register-title { font-size: 1.4rem; margin-bottom: .15rem; }
            .register-title::after { margin-top: .3rem; }
            .register-subtitle { font-size: .8rem; margin-top: .4rem; margin-bottom: .75rem; }
            .form-group { margin-bottom: .5rem; }
            .form-label { font-size: .78rem; margin-bottom: .25rem; }
            .form-input { padding: .55rem .9rem .55rem 2.4rem; font-size: .85rem; border-radius: 9px; }
            .input-icon { font-size: .88rem; left: .85rem; }
            .pw-toggle-btn { font-size: .88rem; right: .75rem; }
            .submit-btn { padding: .7rem; font-size: .9rem; margin-top: .25rem; border-radius: 9px; }
            .or-divider { margin: .65rem 0; font-size: .78rem; }
            .login-link { font-size: .82rem; }
        }
        @media (max-width: 480px) {
            body { padding: 0; }
            .register-container { width: calc(100% - 1.5rem); max-height: calc(100dvh - 1.5rem); }
            .register-panel { padding: 1.35rem 1.25rem 1.1rem; }
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

    <div class="register-container">

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

            <h2 class="brand-heading">Join Our <span>Community!</span></h2>
            <p class="brand-desc">
                Create your account and start your journey with our comprehensive guidance and support system.
            </p>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="bf-icon green"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="bf-title">Secure &amp; Private</div>
                        <div class="bf-sub">Your data is always protected.</div>
                    </div>
                </div>
                <div class="brand-feature">
                    <div class="bf-icon blue"><i class="bi bi-person-check"></i></div>
                    <div>
                        <div class="bf-title">Personalized Guidance</div>
                        <div class="bf-sub">Support tailored just for you.</div>
                    </div>
                </div>
                <div class="brand-feature">
                    <div class="bf-icon gold"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="bf-title">Easy Appointments</div>
                        <div class="bf-sub">Book sessions in seconds.</div>
                    </div>
                </div>
                <div class="brand-feature">
                    <div class="bf-icon teal"><i class="bi bi-chat-heart"></i></div>
                    <div>
                        <div class="bf-title">24/7 Support</div>
                        <div class="bf-sub">We're here whenever you need us.</div>
                    </div>
                </div>
            </div>

            <div class="brand-wave">
                <svg viewBox="0 0 400 90" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,40 C80,80 160,0 240,50 C320,100 360,30 400,50 L400,90 L0,90 Z"
                          fill="rgba(100,160,220,0.35)"/>
                    <path d="M0,60 C60,20 140,80 220,40 C300,0 360,60 400,40 L400,90 L0,90 Z"
                          fill="rgba(100,160,220,0.20)"/>
                </svg>
            </div>
        </div>

        {{-- RIGHT REGISTER PANEL --}}
        <div class="register-panel">
            <h2 class="register-title">Create Account</h2>
            <p class="register-subtitle">Fill in your details to get started</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input id="name" type="text"
                               class="form-input @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autocomplete="name" autofocus
                               placeholder="Enter your full name">
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input id="email" type="email"
                               class="form-input @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email"
                               placeholder="your.email@example.com">
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="student_id" class="form-label">Employee ID <span style="color:#94a3b8;font-weight:400;">(Optional)</span></label>
                    <div class="input-wrap">
                        <i class="bi bi-card-text input-icon"></i>
                        <input id="student_id" type="text"
                               class="form-input @error('student_id') is-invalid @enderror"
                               name="student_id" value="{{ old('student_id') }}"
                               autocomplete="student-id"
                               placeholder="e.g., EMP-2024-001">
                    </div>
                    @error('student_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input id="password" type="password"
                               class="form-input @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="Create a strong password">
                        <button type="button" class="pw-toggle-btn" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input id="password-confirm" type="password"
                               class="form-input"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Confirm your password">
                        <button type="button" class="pw-toggle-btn" onclick="togglePassword('password-confirm')">
                            <i class="bi bi-eye" id="password-confirm-toggle-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="bi bi-person-plus"></i> Create Account
                </button>
            </form>

            <div class="or-divider">or</div>
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
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

        document.getElementById('password-confirm').addEventListener('input', function () {
            const match = this.value === document.getElementById('password').value;
            this.style.borderColor = this.value && !match ? '#ef4444' : '';
        });
    </script>
</body>
</html>
