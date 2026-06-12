<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGMA - Guidance & Monitoring Assistance</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #20B2AA;
            --primary-dark: #008B8B;
            --accent: #1a3a3a;
            --accent-light: #2d5a5a;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Instrument Sans', system-ui, sans-serif; color: var(--text-dark); overflow-x: hidden; }

        /* ── NAV ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 3rem;
            background: rgba(255,255,255,0.0); transition: all .35s ease;
        }
        .navbar.scrolled {
            background: rgba(255,255,255,0.97); backdrop-filter: blur(16px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.08); padding: .85rem 3rem;
        }
        .nav-brand { display: flex; align-items: center; gap: .85rem; text-decoration: none; }
        .nav-brand img { width: 44px; height: 44px; border-radius: 10px; }
        .nav-brand-name { font-size: 1.35rem; font-weight: 700; letter-spacing: .5px; color: #fff; transition: color .3s; }
        .navbar.scrolled .nav-brand-name { color: var(--text-dark); }
        .nav-brand-sub { font-size: .6rem; font-weight: 500; letter-spacing: .4px; color: rgba(255,255,255,.75); transition: color .3s; }
        .navbar.scrolled .nav-brand-sub { color: var(--primary); }
        .nav-actions { display: flex; align-items: center; gap: 1.25rem; }
        .nav-link-item {
            color: rgba(255,255,255,.85); text-decoration: none; font-size: .9rem; font-weight: 500;
            transition: color .3s; position: relative;
        }
        .navbar.scrolled .nav-link-item { color: var(--text-muted); }
        .nav-link-item:hover { color: #fff; }
        .navbar.scrolled .nav-link-item:hover { color: var(--primary); }
        .nav-link-item::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: var(--primary); transition: width .3s;
        }
        .nav-link-item:hover::after { width: 100%; }
        .btn-nav-login {
            color: #fff; text-decoration: none; font-size: .9rem; font-weight: 600;
            padding: .55rem 1.5rem; border: 1.5px solid rgba(255,255,255,.4); border-radius: 50px;
            transition: all .3s;
        }
        .btn-nav-login:hover { background: rgba(255,255,255,.15); border-color: #fff; }
        .navbar.scrolled .btn-nav-login { color: var(--primary); border-color: var(--primary); }
        .navbar.scrolled .btn-nav-login:hover { background: var(--primary); color: #fff; }
        .btn-nav-cta {
            background: #fff; color: var(--accent); text-decoration: none; font-size: .9rem; font-weight: 600;
            padding: .55rem 1.5rem; border-radius: 50px; transition: all .3s;
            box-shadow: 0 4px 15px rgba(0,0,0,.15);
        }
        .btn-nav-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.2); }
        .navbar.scrolled .btn-nav-cta { background: var(--primary); color: #fff; }
        .navbar.scrolled .btn-nav-cta:hover { background: var(--primary-dark); }
        .nav-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #fff; cursor: pointer; }
        .navbar.scrolled .nav-toggle { color: var(--text-dark); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            background: linear-gradient(160deg, #0f2b2b 0%, #1a3a3a 35%, #2d5a5a 70%, #20B2AA 100%);
        }
        .hero-bg-img {
            position: absolute; inset: 0; z-index: 1;
            background: url('{{ asset("background.jpg") }}') center/cover no-repeat;
            opacity: .18;
        }
        .hero-overlay {
            position: absolute; inset: 0; z-index: 2;
            background:
                radial-gradient(ellipse at 75% 25%, rgba(32,178,170,.25) 0%, transparent 55%),
                radial-gradient(ellipse at 25% 75%, rgba(0,139,139,.2) 0%, transparent 55%);
        }
        .hero-grid-pattern {
            position: absolute; inset: 0; z-index: 3;
            background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        .hero-inner {
            position: relative; z-index: 5; text-align: center;
            max-width: 780px; padding: 2rem;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.1); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.15);
            padding: .45rem 1.25rem; border-radius: 50px; margin-bottom: 2rem;
            font-size: .8rem; color: rgba(255,255,255,.85); font-weight: 500;
        }
        .hero-badge i { color: var(--primary); }
        .hero-h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 700; color: #fff;
            line-height: 1.15; margin-bottom: 1.5rem;
            text-shadow: 0 2px 30px rgba(0,0,0,.25);
        }
        .hero-h1 span { background: linear-gradient(135deg, #20B2AA, #5ce0d8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc {
            font-size: 1.1rem; color: rgba(255,255,255,.78); line-height: 1.75;
            margin-bottom: 2.75rem; max-width: 560px; margin-left: auto; margin-right: auto;
        }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--primary); color: #fff; text-decoration: none;
            padding: .9rem 2.25rem; border-radius: 50px; font-size: 1rem; font-weight: 600;
            transition: all .3s; box-shadow: 0 6px 25px rgba(32,178,170,.4);
        }
        .btn-hero-primary:hover { background: var(--primary-dark); transform: translateY(-3px); box-shadow: 0 10px 35px rgba(32,178,170,.5); }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: .5rem;
            color: rgba(255,255,255,.85); text-decoration: none;
            padding: .9rem 2.25rem; border-radius: 50px; font-size: 1rem; font-weight: 500;
            border: 1.5px solid rgba(255,255,255,.25); transition: all .3s;
        }
        .btn-hero-secondary:hover { border-color: rgba(255,255,255,.5); background: rgba(255,255,255,.08); }
        .hero-curve {
            position: absolute; bottom: -1px; left: 0; right: 0; z-index: 6;
        }
        .hero-curve svg { display: block; width: 100%; }

        /* ── TRUST BAR ── */
        .trust-bar { background: var(--bg-light); padding: 2.5rem 2rem; }
        .trust-inner { max-width: 900px; margin: 0 auto; display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: .6rem; color: var(--text-muted); font-size: .9rem; font-weight: 500; }
        .trust-item i { color: var(--primary); font-size: 1.15rem; }

        /* ── SERVICES ── */
        .services { padding: 6rem 2rem; background: #fff; }
        .section-head { text-align: center; margin-bottom: 3.5rem; }
        .section-label {
            display: inline-block; font-size: .75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1.5px; color: var(--primary); margin-bottom: .75rem;
        }
        .section-h2 { font-size: 2.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: .75rem; }
        .section-desc { font-size: 1rem; color: var(--text-muted); max-width: 520px; margin: 0 auto; line-height: 1.7; }
        .services-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit,minmax(280px,1fr)); gap: 1.75rem; }
        .service-card {
            background: #fff; border: 1px solid #e8ecf0; border-radius: 20px;
            padding: 2.25rem 2rem; transition: all .35s ease; position: relative; overflow: hidden;
        }
        .service-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark)); opacity: 0; transition: opacity .3s;
        }
        .service-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.08); border-color: transparent; }
        .service-card:hover::before { opacity: 1; }
        .service-icon {
            width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.25rem;
            background: linear-gradient(135deg, rgba(32,178,170,.1), rgba(0,139,139,.08));
            color: var(--primary);
        }
        .service-card h3 { font-size: 1.15rem; font-weight: 600; margin-bottom: .6rem; }
        .service-card p { font-size: .9rem; color: var(--text-muted); line-height: 1.65; }

        /* ── HOW IT WORKS ── */
        .how-it-works { padding: 6rem 2rem; background: var(--bg-light); }
        .steps-grid { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: repeat(3,1fr); gap: 2.5rem; position: relative; }
        .steps-grid::before {
            content: ''; position: absolute; top: 40px; left: 15%; right: 15%; height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark)); opacity: .2;
        }
        .step-card { text-align: center; position: relative; }
        .step-num {
            width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 1.1rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 6px 20px rgba(32,178,170,.3); position: relative; z-index: 2;
        }
        .step-card h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: .5rem; }
        .step-card p { font-size: .88rem; color: var(--text-muted); line-height: 1.6; }

        /* ── ABOUT / MISSION ── */
        .about { padding: 6rem 2rem; background: #fff; }
        .about-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
        .about-content h2 { font-size: 2.25rem; font-weight: 700; margin-bottom: 1.5rem; position: relative; }
        .about-content h2::after {
            content: ''; position: absolute; bottom: -8px; left: 0;
            width: 50px; height: 4px; border-radius: 2px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }
        .about-content p { color: var(--text-muted); font-size: .95rem; line-height: 1.75; margin-bottom: 1.25rem; }
        .about-callout {
            background: linear-gradient(135deg, rgba(32,178,170,.06), rgba(0,139,139,.04));
            border-left: 4px solid var(--primary); padding: 1.25rem 1.5rem; border-radius: 0 12px 12px 0; margin: 2rem 0;
        }
        .about-callout p { margin: 0; font-weight: 500; color: var(--text-dark); font-size: .9rem; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .stat-card {
            background: var(--bg-light); border-radius: 16px; padding: 1.75rem 1.5rem; text-align: center;
            border: 1px solid #e8ecf0; transition: all .3s;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 35px rgba(0,0,0,.06); }
        .stat-num { font-size: 2.2rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: .25rem; }
        .stat-lbl { font-size: .8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }

        /* ── CTA ── */
        .cta-section {
            padding: 6rem 2rem;
            background: linear-gradient(160deg, #1a3a3a 0%, #2d5a5a 60%, #20B2AA 100%);
            color: #fff; text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 50% 50%, rgba(32,178,170,.2), transparent 70%);
        }
        .cta-inner { position: relative; z-index: 2; max-width: 600px; margin: 0 auto; }
        .cta-inner h2 { font-size: 2.25rem; font-weight: 700; margin-bottom: 1rem; }
        .cta-inner p { font-size: 1.05rem; opacity: .85; line-height: 1.7; margin-bottom: 2.5rem; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: .5rem;
            background: #fff; color: var(--accent); text-decoration: none;
            padding: .9rem 2.5rem; border-radius: 50px; font-size: 1rem; font-weight: 600;
            transition: all .3s; box-shadow: 0 8px 30px rgba(0,0,0,.2);
        }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.3); }

        /* ── FOOTER ── */
        .footer { background: #0f1f1f; color: rgba(255,255,255,.5); padding: 2.5rem 2rem; text-align: center; font-size: .85rem; }
        .footer a { color: var(--primary); text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 992px) {
            .navbar { padding: 1rem 1.5rem; }
            .navbar.scrolled { padding: .75rem 1.5rem; }
            .nav-toggle { display: block; }
            .nav-actions { display: none; }
            .nav-actions.open {
                display: flex; flex-direction: column; position: absolute;
                top: 100%; left: 0; right: 0; background: #fff;
                padding: 1.5rem; gap: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,.1);
            }
            .nav-actions.open .nav-link-item { color: var(--text-dark); }
            .nav-actions.open .btn-nav-login { color: var(--primary); border-color: var(--primary); }
            .nav-actions.open .btn-nav-cta { background: var(--primary); color: #fff; }
            .about-grid { grid-template-columns: 1fr; gap: 3rem; }
            .steps-grid { grid-template-columns: 1fr; gap: 2rem; }
            .steps-grid::before { display: none; }
        }
        @media (max-width: 640px) {
            .hero-h1 { font-size: 2rem; }
            .hero-desc { font-size: .95rem; }
            .section-h2 { font-size: 1.75rem; }
            .trust-inner { gap: 1.5rem; }
            .services-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: .75rem; }
        }

        /* ── ANIMATIONS ── */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar" id="navbar">
        <a href="#" class="nav-brand">
            <img src="{{ asset('logo.png') }}" alt="SIGMA">
            <div>
                <div class="nav-brand-name">SIGMA</div>
                <div class="nav-brand-sub">Guidance & Monitoring Assistance</div>
            </div>
        </a>
        <button class="nav-toggle" onclick="document.getElementById('navActions').classList.toggle('open')" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="nav-actions" id="navActions">
            <a href="#services" class="nav-link-item">Services</a>
            <a href="#how" class="nav-link-item">How It Works</a>
            <a href="#about" class="nav-link-item">About</a>
            <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
            <a href="{{ route('register') }}" class="btn-nav-cta">Get Started</a>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-bg-img"></div>
        <div class="hero-overlay"></div>
        <div class="hero-grid-pattern"></div>
        <div class="hero-inner fade-up">
            <div class="hero-badge">
                <i class="bi bi-shield-check"></i> Confidential & Secure Platform
            </div>
            <h1 class="hero-h1">Your Concerns <span>Matter</span></h1>
            <p class="hero-desc">
                A safe, confidential space for students to share concerns, connect with counselors, and get the guidance support they need — anytime.
            </p>
            <div class="hero-btns">
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="bi bi-arrow-right-circle"></i> Access Portal
                </a>
                <a href="#services" class="btn-hero-secondary">
                    <i class="bi bi-play-circle"></i> Learn More
                </a>
            </div>
        </div>
        <div class="hero-curve">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none" fill="none">
                <path d="M0 40 C360 100 1080 0 1440 60 L1440 100 L0 100Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    {{-- TRUST BAR --}}
    <div class="trust-bar">
        <div class="trust-inner">
            <div class="trust-item"><i class="bi bi-shield-lock-fill"></i> 100% Confidential</div>
            <div class="trust-item"><i class="bi bi-clock-fill"></i> 24/7 Access</div>
            <div class="trust-item"><i class="bi bi-people-fill"></i> Expert Counselors</div>
            <div class="trust-item"><i class="bi bi-patch-check-fill"></i> DepEd Aligned</div>
        </div>
    </div>

    {{-- SERVICES --}}
    <section id="services" class="services">
        <div class="section-head fade-up">
            <div class="section-label">What We Offer</div>
            <h2 class="section-h2">Comprehensive Guidance Services</h2>
            <p class="section-desc">Designed to support every student's academic, emotional, and personal growth.</p>
        </div>
        <div class="services-grid">
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-chat-square-heart"></i></div>
                <h3>Submit Concerns</h3>
                <p>Share school-related concerns anonymously or identified through a secure, easy-to-use platform.</p>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-calendar2-check"></i></div>
                <h3>Book Appointments</h3>
                <p>Schedule one-on-one counseling sessions with guidance counselors at your preferred date and time.</p>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-file-earmark-medical"></i></div>
                <h3>Incident Reporting</h3>
                <p>Teachers can document and report incidents for prompt counselor review and intervention.</p>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-person-heart"></i></div>
                <h3>Student Referrals</h3>
                <p>Teachers refer students who need extra support directly to the guidance office for follow-up.</p>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-journal-bookmark"></i></div>
                <h3>Intervention Guides</h3>
                <p>Access curated protocols and toolkits for classroom management and learner protection.</p>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon"><i class="bi bi-graph-up-arrow"></i></div>
                <h3>Case Tracking</h3>
                <p>Monitor the status of submitted reports and referrals with real-time progress updates.</p>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section id="how" class="how-it-works">
        <div class="section-head fade-up">
            <div class="section-label">Simple Process</div>
            <h2 class="section-h2">How It Works</h2>
            <p class="section-desc">Getting help is just a few steps away.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card fade-up">
                <div class="step-num">1</div>
                <h3>Log In</h3>
                <p>Access the portal using your school credentials. Students, teachers, and counselors each have their own dashboard.</p>
            </div>
            <div class="step-card fade-up">
                <div class="step-num">2</div>
                <h3>Submit or Schedule</h3>
                <p>Share a concern, book a counseling appointment, or file an incident report — all done securely online.</p>
            </div>
            <div class="step-card fade-up">
                <div class="step-num">3</div>
                <h3>Get Support</h3>
                <p>A counselor reviews your submission, responds, and schedules a session if needed — with full confidentiality.</p>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="about">
        <div class="about-grid">
            <div class="about-content fade-up">
                <h2>About SIGMA</h2>
                <p>
                    SIGMA (Guidance & Monitoring Assistance) is a comprehensive digital platform built for Bulan National High School's CARE Center. It bridges the gap between students and guidance counselors, making support accessible, confidential, and efficient.
                </p>
                <p>
                    From submitting concerns and booking appointments to incident reporting and case tracking, SIGMA empowers the entire school community with tools designed for modern guidance services.
                </p>
                <div class="about-callout">
                    <p><i class="bi bi-quote me-1"></i> Every student deserves a safe space to be heard and a trusted adult to guide them.</p>
                </div>
            </div>
            <div class="stats-grid fade-up">
                <div class="stat-card">
                    <div class="stat-num">200+</div>
                    <div class="stat-lbl">Students Helped</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">24/7</div>
                    <div class="stat-lbl">Always Available</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">100%</div>
                    <div class="stat-lbl">Confidential</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">2</div>
                    <div class="stat-lbl">Expert Counselors</div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="cta-inner fade-up">
            <h2>Ready to Get Started?</h2>
            <p>Access your guidance portal today and take the first step toward getting the support you need.</p>
            <a href="{{ route('login') }}" class="btn-cta">
                <i class="bi bi-box-arrow-in-right"></i> Go to Login
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        &copy; {{ date('Y') }} SIGMA &mdash; Guidance & Monitoring Assistance &bull; Bulan National High School
    </footer>

    <script>
        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 60);
        });
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                const t = document.querySelector(a.getAttribute('href'));
                if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Close mobile menu
                document.getElementById('navActions').classList.remove('open');
            });
        });
        // Intersection Observer for fade-up
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }});
        }, { threshold: 0.15 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>
