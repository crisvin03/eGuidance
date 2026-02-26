<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - SIGMA Guidance Portal</title>
    
    @vite(['resources/css/app.css'])
    
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a3a3a 0%, #2d5a5a 50%, #3d7a7a 100%);
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 80% 20%, rgba(255,180,120,0.15) 0%, transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(255,200,150,0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .reset-container {
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 500px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .brand-panel {
            flex: 1;
            background: linear-gradient(180deg, #20B2AA 0%, #008B8B 100%);
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .brand-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 70%, rgba(255,200,150,0.2) 0%, transparent 50%);
            pointer-events: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .brand-logo img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: white;
            padding: 8px;
        }
        
        .brand-logo-text h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 2px;
        }
        
        .brand-logo-text p {
            font-size: 0.7rem;
            margin: 0;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }
        
        .brand-heading {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .brand-description {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .brand-features {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            position: relative;
            z-index: 1;
        }
        
        .brand-features li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.9rem;
        }
        
        .brand-features i {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .reset-panel {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .back-link {
            position: absolute;
            top: 1.5rem;
            left: 2.5rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: #1a3a3a;
        }
        
        .reset-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }
        
        .reset-subtitle {
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #2C3E50;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #20B2AA;
            background: white;
            box-shadow: 0 0 0 4px rgba(32,178,170,0.1);
        }
        
        .form-input.is-invalid {
            border-color: #e74c3c;
            background: #fef2f2;
        }
        
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.3s ease;
        }
        
        .password-toggle-btn:hover {
            color: #1a3a3a;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background: #ef4444; width: 33%; }
        .strength-medium { background: #f59e0b; width: 66%; }
        .strength-strong { background: #22c55e; width: 100%; }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #20B2AA 0%, #008B8B 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(32,178,170,0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(32,178,170,0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: #20B2AA;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: #008B8B;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                align-items: stretch;
                padding: 0;
                min-height: 100vh;
            }
            .reset-container {
                flex-direction: column;
                width: 100%;
                max-width: 100%;
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            .brand-panel {
                padding: 1.5rem 1rem;
                text-align: center;
                min-height: auto;
            }
            .brand-logo {
                justify-content: center;
                margin-bottom: 0.75rem;
            }
            .brand-heading { font-size: 1.3rem; margin-bottom: 0.5rem; }
            .brand-description { font-size: 0.85rem; margin-bottom: 0.75rem; }
            .brand-features { display: none; }
            .reset-panel {
                padding: 1.5rem 1rem;
                flex: 1;
            }
            .reset-title { font-size: 1.3rem; }
            .reset-subtitle { margin-bottom: 1rem; }
            .form-group { margin-bottom: 1rem; }
            .back-link { position: static; margin-bottom: 0.75rem; display: inline-flex; }
        }
        
        @media (max-width: 480px) {
            body { padding: 0; align-items: stretch; }
            .reset-container {
                border-radius: 0;
                min-height: 100vh;
                max-width: 100%;
            }
            .brand-panel { padding: 1rem; }
            .reset-panel { padding: 1rem; }
            .form-group { margin-bottom: 0.875rem; }
            .form-input { padding: 0.625rem; font-size: 0.9rem; }
            .reset-title { font-size: 1.2rem; }
            .reset-subtitle { margin-bottom: 0.75rem; }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <!-- Brand Panel -->
        <div class="brand-panel">
            <div class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="SIGMA">
                <div class="brand-logo-text">
                    <h2>SIGMA</h2>
                    <p>Guidance Portal</p>
                </div>
            </div>
            
            <h1 class="brand-heading">Create New Password</h1>
            <p class="brand-description">
                Almost there! Choose a strong password to secure your account and keep your data safe.
            </p>
            
            <ul class="brand-features">
                <li>
                    <i class="bi bi-shield-check"></i>
                    <span>Strong Security</span>
                </li>
                <li>
                    <i class="bi bi-key"></i>
                    <span>Encrypted Storage</span>
                </li>
                <li>
                    <i class="bi bi-check2-all"></i>
                    <span>Instant Activation</span>
                </li>
                <li>
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Change Anytime</span>
                </li>
            </ul>
        </div>
        
        <!-- Reset Panel -->
        <div class="reset-panel">
            <a href="{{ route('login') }}" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Back to Login
            </a>
            
            <h2 class="reset-title">Reset Password</h2>
            <p class="reset-subtitle">Enter your new password below</p>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" 
                           class="form-input @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus 
                           placeholder="your.email@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-toggle">
                        <input id="password" type="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="new-password" 
                               placeholder="Create a strong password"
                               onkeyup="checkPasswordStrength(this.value)">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-toggle-icon"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strength-bar"></div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirm New Password</label>
                    <div class="password-toggle">
                        <input id="password-confirm" type="password" 
                               class="form-input @error('password_confirmation') is-invalid @enderror" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password" 
                               placeholder="Confirm your new password"
                               onkeyup="checkPasswordMatch()">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password-confirm')">
                            <i class="bi bi-eye" id="password-confirm-toggle-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="bi bi-check-circle"></i>
                    Reset Password
                </button>
            </form>
            
            <div class="login-link">
                Remember your password? 
                <a href="{{ route('login') }}">Sign In</a>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-toggle-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
        
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.style.width = '0';
            } else if (strength <= 1) {
                strengthBar.classList.add('strength-weak');
            } else if (strength === 2) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password-confirm').value;
            
            if (confirm && password !== confirm) {
                document.getElementById('password-confirm').style.borderColor = '#ef4444';
            } else {
                document.getElementById('password-confirm').style.borderColor = '';
            }
        }
    </script>
</body>
</html>
