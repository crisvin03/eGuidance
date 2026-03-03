<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGMA - Guidance & Monitoring Assistance</title>
    
    @vite(['resources/css/app.css'])
    
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #20B2AA;
            --secondary-color: #008B8B;
            --accent-color: #1a3a3a;
            --light-accent: #2d5a5a;
            --text-dark: #2C3E50;
            --text-light: #666;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, var(--light-accent) 100%);
            --gradient-hero: linear-gradient(135deg, #1a3a3a 0%, #2d5a5a 50%, #3d7a7a 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            color: var(--text-dark);
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            z-index: 1000;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .header.scrolled {
            padding: 0.75rem 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }
        
        .logo-icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        
        .logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .logo-main {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: 0.5px;
        }
        
        .logo-subtitle {
            font-size: 0.7rem;
            color: var(--primary-color);
            font-weight: 500;
            letter-spacing: 0.3px;
        }
        
        /* Navigation */
        .nav {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-login {
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .btn-login:hover {
            color: var(--primary-color);
        }
        
        .btn-book {
            background: var(--gradient-primary);
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(32, 178, 170, 0.4);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background: var(--gradient-hero);
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 80% 20%, rgba(255,180,120,0.15) 0%, transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(255,200,150,0.1) 0%, transparent 50%);
            z-index: 1;
        }
        
        .hands-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 50px 50px, 30px 30px;
            z-index: 2;
        }
        
        .hero-content {
            position: relative;
            z-index: 3;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 20px rgba(0,0,0,0.2);
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            line-height: 1.7;
            margin-bottom: 3rem;
            font-weight: 400;
        }
        
        .btn-learn {
            display: inline-block;
            background: white;
            color: var(--accent-color);
            padding: 1rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        
        .btn-learn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }
        
        /* Bottom curve */
        .hero-curve {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: var(--bg-light);
            z-index: 4;
            clip-path: ellipse(70% 100% at 50% 100%);
        }
        
        /* Features Section */
        .features {
            background: var(--bg-light);
            padding: 4rem 2rem;
            position: relative;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }
        
        .section-subtitle {
            font-size: 1rem;
            color: var(--text-light);
            max-width: 550px;
            margin: 0 auto;
        }
        
        .features-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: var(--bg-white);
            padding: 2rem;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.25);
        }
        
        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }
        
        .feature-desc {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        /* About Section */
        .about {
            background: var(--bg-white);
            padding: 5rem 2rem;
            position: relative;
        }
        
        .about-container {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .about-content {
            position: relative;
        }
        
        .about-content h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .about-content h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }
        
        .about-content p {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-weight: 400;
        }
        
        .about-highlight {
            background: linear-gradient(135deg, rgba(32, 178, 170, 0.08) 0%, rgba(26, 58, 58, 0.08) 100%);
            padding: 1.5rem;
            border-radius: 16px;
            border-left: 4px solid var(--primary-color);
            margin: 2rem 0;
        }
        
        .about-highlight p {
            margin: 0;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        
        .about-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        
        .stat-item {
            background: linear-gradient(135deg, var(--bg-light) 0%, rgba(255,255,255,0.8) 100%);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
            position: relative;
            overflow: hidden;
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.1);
        }
        
        .stat-item:hover::before {
            opacity: 1;
        }
        
        .stat-number {
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .stat-label {
            color: var(--text-light);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .about-image {
            display: none;
        }
        
        /* Contact Section */
        .contact {
            background: var(--gradient-primary);
            padding: 6rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .contact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 70%, rgba(255,200,150,0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(255,180,120,0.1) 0%, transparent 40%);
            z-index: 1;
        }
        
        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .contact h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .contact h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: white;
            border-radius: 2px;
            opacity: 0.8;
        }
        
        .contact-subtitle {
            font-size: 1.1rem;
            margin-bottom: 4rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .contact-item {
            background: rgba(255,255,255,0.12);
            padding: 2.5rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            transition: all 0.4s ease;
            border: 1px solid rgba(255,255,255,0.15);
            position: relative;
            overflow: hidden;
        }
        
        .contact-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .contact-item:hover {
            transform: translateY(-8px);
            background: rgba(255,255,255,0.18);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .contact-item:hover::before {
            opacity: 1;
        }
        
        .contact-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            display: block;
            transition: transform 0.3s ease;
        }
        
        .contact-item:hover .contact-icon {
            transform: scale(1.1);
        }
        
        .contact-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .contact-info {
            opacity: 0.9;
            font-size: 0.95rem;
            line-height: 1.6;
            font-weight: 400;
        }
        
        .contact-form-container {
            background: rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 3rem;
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255,255,255,0.1);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .contact-form-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
            border-radius: 26px;
            z-index: -1;
        }
        
        .contact-form h3 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .contact-form p {
            text-align: center;
            opacity: 0.8;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.1);
        }
        
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255,255,255,0.5);
        }
        
        .btn-submit {
            background: white;
            color: var(--accent-color);
            border: none;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.95);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .about-container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            
            .about-content h2 {
                font-size: 2rem;
            }
            
            .contact h2 {
                font-size: 2rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .about-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('logo.png') }}" alt="SIGMA Logo" style="width: 50px; height: 50px; border-radius: 8px;">
            <div class="logo-text">
                <span class="logo-main">SIGMA</span>
                <span class="logo-subtitle">Guidance & Monitoring Assistance</span>
            </div>
        </div>
        
        <nav class="nav">
            <div class="nav-links">
                <a href="#services">Services</a>
                <a href="#about">About</a>
            </div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            </div>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hands-bg"></div>
        <div class="hero-content">
            <h1 class="hero-title">Your Concerns Matter.</h1>
            <p class="hero-subtitle">
                A safe and confidential space where students<br>
                can share school-related concerns and receive<br>
                guidance support.
            </p>
            <a href="{{ route('login') }}" class="btn-learn">Book now</a>
        </div>
        <div class="hero-curve"></div>
    </section>
    
    <!-- Features Section -->
    <section id="services" class="features">
        <div class="section-header">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive guidance and support services designed to help students thrive</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📝</div>
                <h3 class="feature-title">Submit Concerns</h3>
                <p class="feature-desc">Students can easily submit concerns anonymously or with their identity through our secure platform.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3 class="feature-title">Schedule Appointments</h3>
                <p class="feature-desc">Book counseling sessions with guidance counselors at your convenience with flexible scheduling options.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3 class="feature-title">Confidential Support</h3>
                <p class="feature-desc">All concerns and communications are kept strictly confidential to ensure student privacy and trust.</p>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-container">
            <div class="about-content">
                <h2>About SIGMA</h2>
                <p>
                    SIGMA (Guidance & Monitoring Assistance) is a comprehensive online platform designed to provide students with a safe and confidential space to express their concerns and receive professional guidance support.
                </p>
                <p>
                    Our mission is to bridge the gap between students and guidance counselors, making it easier for students to seek help when they need it most. We believe that every student deserves access to quality guidance and support services.
                </p>
                <p>
                    Through our user-friendly interface, students can easily submit their concerns, schedule appointments with counselors, and track their progress - all while maintaining complete privacy and confidentiality.
                </p>
            </div>
            <div class="about-stats">
                <div class="stat-item">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Students Helped</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Confidential</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2</div>
                    <div class="stat-label">Expert Counselors</div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
