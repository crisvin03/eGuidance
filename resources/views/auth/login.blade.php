<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIGMA Guidance Portal</title>
    
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
            overflow-y: auto;
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
        
        .login-container {
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
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
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
        
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .logo-icon {
            width: 55px;
            height: 55px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-icon svg {
            width: 32px;
            height: 32px;
            fill: white;
        }
        
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        
        .brand-name {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .brand-subtitle {
            font-size: 0.7rem;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }
        
        .brand-heading {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        
        .brand-description {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .brand-features {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .brand-feature {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.9rem;
        }
        
        .brand-feature i {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .login-panel {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #666;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
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
        }
        
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.4rem;
        }
        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #20B2AA;
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
        }
        
        .forgot-link {
            color: #20B2AA;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #008B8B;
        }
        
        .btn-login {
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
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(32,178,170,0.4);
        }
        
        .register-prompt {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .register-prompt p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .register-link {
            color: #20B2AA;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link:hover {
            color: #008B8B;
        }
        
        .back-link {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            color: #20B2AA;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: #008B8B;
        }
        
        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding: 1rem;
                overflow-y: auto;
            }
            .login-container {
                flex-direction: column;
                width: 100%;
                max-width: 480px;
                margin: 1rem auto;
                border-radius: 16px;
                min-height: auto;
            }
            .brand-panel {
                padding: 2rem 1.5rem;
                text-align: center;
                min-height: auto;
            }
            .brand-logo {
                justify-content: center;
                margin-bottom: 1rem;
            }
            .brand-heading { font-size: 1.4rem; margin-bottom: 0.5rem; }
            .brand-description { font-size: 0.9rem; margin-bottom: 1rem; }
            .brand-features { display: none; }
            .login-panel {
                padding: 2rem 1.5rem;
            }
            .login-title { font-size: 1.4rem; }
            .back-link { position: static; margin-bottom: 1rem; display: inline-flex; }
        }
        @media (max-width: 480px) {
            body { padding: 0; overflow-y: auto; align-items: flex-start; }
            .login-container {
                border-radius: 0;
                min-height: 100vh;
                max-width: 100%;
                margin: 0;
            }
            .brand-panel { padding: 1.25rem 1.5rem; }
            .login-panel { padding: 1.5rem; }
            .form-group { margin-bottom: 1rem; }
            .form-input { padding: 0.75rem; font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-panel">
            <div class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="SIGMA Logo" style="width: 55px; height: 55px; border-radius: 12px;">
                <div class="brand-text">
                    <span class="brand-name">SIGMA</span>
                    <span class="brand-subtitle">Guidance & Monitoring Assistance</span>
                </div>
            </div>
            
            <h2 class="brand-heading">Welcome Back</h2>
            <p class="brand-description">
                Access your account to manage concerns, schedule appointments, and connect with guidance counselors.
            </p>
            
            <div class="brand-features">
                <div class="brand-feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Secure & Confidential</span>
                </div>
                <div class="brand-feature">
                    <i class="bi bi-clock"></i>
                    <span>24/7 Access</span>
                </div>
                <div class="brand-feature">
                    <i class="bi bi-person-check"></i>
                    <span>Professional Support</span>
                </div>
            </div>
        </div>
        
        <div class="login-panel">
            <a href="{{ url('/') }}" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Back to Home
            </a>
            
            <div class="login-header">
                <h1 class="login-title">Sign In</h1>
                <p class="login-subtitle">Enter your credentials to access your account</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" 
                           type="email" 
                           class="form-input @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="Enter your email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" 
                           type="password" 
                           class="form-input @error('password') is-invalid @enderror" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Enter your password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-options">
                    <label class="form-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                        <span class="form-check-label">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
                
                @if (Route::has('register'))
                    <div class="register-prompt">
                        <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">Create account</a></p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
