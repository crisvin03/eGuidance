<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SIGMA Guidance Portal</title>
    
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
        
        .register-container {
            display: flex;
            width: min(900px, 95vw);
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
            margin-bottom: 1.25rem;
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
            font-size: 1.6rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
        }
        
        .brand-description {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.5;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        .brand-features {
            margin-top: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            position: relative;
            z-index: 1;
            list-style: none;
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
        
        .register-panel {
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
        
        .register-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.4rem;
        }
        
        .register-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.875rem;
        }
        
        .form-group {
            margin-bottom: 0.75rem;
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
            padding: 0.65rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 0.95rem;
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
        
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
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
            margin-top: 0.875rem;
            padding-top: 0.875rem;
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
                align-items: flex-start;
                overflow: auto !important;
                height: auto;
                min-height: 100vh;
                padding: 0;
            }
            .register-container {
                flex-direction: column;
                width: 100%;
                border-radius: 0;
                min-height: 100vh;
                overflow: visible;
            }
            .brand-panel {
                padding: 1.25rem 1.5rem;
                text-align: center;
                min-height: auto;
            }
            .brand-logo {
                justify-content: center;
                margin-bottom: 0.5rem;
            }
            .brand-logo img { width: 36px; height: 36px; }
            .brand-logo-text h2 { font-size: 1.2rem; }
            .brand-heading { font-size: 1.1rem; margin-bottom: 0.3rem; }
            .brand-description { font-size: 0.8rem; margin-bottom: 0; }
            .brand-features { display: none; }
            .register-panel { padding: 1.25rem 1.5rem; justify-content: flex-start; }
            .register-title { font-size: 1.3rem; margin-bottom: 0.2rem; }
            .register-subtitle { margin-bottom: 0.75rem; font-size: 0.85rem; }
            .form-group { margin-bottom: 0.6rem; }
            .form-label { margin-bottom: 0.3rem; font-size: 0.85rem; }
            .form-input { padding: 0.55rem 0.875rem; font-size: 0.9rem; border-radius: 10px; }
            .submit-btn { padding: 0.7rem; font-size: 0.95rem; margin-top: 0.25rem; }
            .login-link { margin-top: 0.75rem; padding-top: 0.75rem; font-size: 0.85rem; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Brand Panel -->
        <div class="brand-panel">
            <div class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="SIGMA">
                <div class="brand-logo-text">
                    <h2>SIGMA</h2>
                    <p>Guidance Portal</p>
                </div>
            </div>
            
            <h1 class="brand-heading">Join Our Community</h1>
            <p class="brand-description">
                Create your account and start your journey with our comprehensive guidance and monitoring system.
            </p>
            
            <ul class="brand-features">
                <li>
                    <i class="bi bi-shield-check"></i>
                    <span>Secure & Private</span>
                </li>
                <li>
                    <i class="bi bi-person-check"></i>
                    <span>Personalized Guidance</span>
                </li>
                <li>
                    <i class="bi bi-calendar-check"></i>
                    <span>Easy Appointment Booking</span>
                </li>
                <li>
                    <i class="bi bi-chat-heart"></i>
                    <span>24/7 Support System</span>
                </li>
            </ul>
        </div>
        
        <!-- Register Panel -->
        <div class="register-panel">
            <h2 class="register-title">Create Account</h2>
            <p class="register-subtitle">Fill in your details to get started</p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" 
                           class="form-input @error('name') is-invalid @enderror" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autocomplete="name" 
                           autofocus 
                           placeholder="Enter your full name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" 
                           class="form-input @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           placeholder="your.email@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="student_id" class="form-label">Student ID (Optional)</label>
                    <input id="student_id" type="text" 
                           class="form-input @error('student_id') is-invalid @enderror" 
                           name="student_id" 
                           value="{{ old('student_id') }}" 
                           autocomplete="student-id" 
                           placeholder="e.g., 2024-1234">
                    @error('student_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-toggle">
                        <input id="password" type="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="new-password" 
                               placeholder="Create a strong password">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="password-toggle">
                        <input id="password-confirm" type="password" 
                               class="form-input" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password" 
                               placeholder="Confirm your password">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password-confirm')">
                            <i class="bi bi-eye" id="password-confirm-toggle-icon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">
                    Create Account
                    <i class="bi bi-arrow-right" style="margin-left: 0.5rem;"></i>
                </button>
            </form>
            
            <div class="login-link">
                Already have an account? 
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
        
        // Auto-hide password confirmation mismatch
        document.getElementById('password-confirm').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;
            
            if (confirm && password !== confirm) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>
</html>
