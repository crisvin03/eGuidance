<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BNHS Care Konek - Referral &amp; Case Management System</title>
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ url('/') }}">
    <meta property="og:title"        content="BNHS Care Konek - Referral & Case Management System">
    <meta property="og:description"  content="A safe, confidential space for students to share concerns, connect with counselors, and get the guidance support they need.">
    <meta property="og:image"        content="{{ asset('logo.png') }}">
    <meta property="og:image:width"  content="500">
    <meta property="og:image:height" content="500">
    <meta property="og:site_name"    content="BNHS Care Konek">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="BNHS Care Konek - Referral & Case Management System">
    <meta name="twitter:description" content="A safe, confidential space for students to share concerns, connect with counselors, and get the guidance support they need.">
    <meta name="twitter:image"       content="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --navy:#0d2d52; --green:#1e7a4a; --green-dark:#145e38; --gold:#f5c518;
            --accent:#1a3a3a;
            --text-dark:#0d2d52; --text-body:#3d5a7a; --text-muted:#64748b;
            --bg-page:#edf2f7; --bg-light:#f8fafc;
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{font-family:'Instrument Sans',system-ui,sans-serif;color:var(--text-dark);overflow-x:hidden;-webkit-font-smoothing:antialiased;background:#fff;}

        /* NAVBAR */
        .navbar{position:fixed;top:0;left:0;right:0;z-index:200;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 3rem;background:rgba(255,255,255,.97);backdrop-filter:blur(16px);border-bottom:1px solid rgba(13,45,82,.07);box-shadow:0 2px 16px rgba(13,45,82,.06);transition:padding .3s;}
        .nav-brand{display:flex;align-items:center;gap:.85rem;text-decoration:none;}
        .nav-brand img{width:44px;height:44px;border-radius:10px;}
        .nav-brand-name{font-size:1.2rem;font-weight:700;color:var(--navy);letter-spacing:-.3px;}
        .nav-brand-sub{font-size:.6rem;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--text-muted);}
        .nav-actions{display:flex;align-items:center;gap:2.25rem;}
        .nav-link-item{color:var(--text-body);text-decoration:none;font-size:.92rem;font-weight:500;transition:color .2s;position:relative;padding:.3rem 0;}
        .nav-link-item:hover{color:var(--navy);}
        .nav-link-item::after{content:'';position:absolute;bottom:0;left:0;width:0;height:2px;background:var(--green);border-radius:2px;transition:width .3s;}
        .nav-link-item:hover::after{width:100%;}
        .btn-nav-login{color:var(--green);text-decoration:none;font-size:.92rem;font-weight:600;padding:.55rem 1.6rem;border:2px solid var(--green);border-radius:50px;transition:all .25s;}
        .btn-nav-login:hover{background:var(--green);color:#fff;}
        .btn-nav-cta{background:var(--gold);color:var(--navy);text-decoration:none;font-size:.92rem;font-weight:700;padding:.55rem 1.6rem;border-radius:50px;transition:all .25s;box-shadow:0 4px 14px rgba(245,197,24,.35);}
        .btn-nav-cta:hover{background:#d4a800;transform:translateY(-2px);box-shadow:0 8px 22px rgba(245,197,24,.45);}
        .nav-toggle{display:none;background:none;border:none;font-size:1.7rem;color:var(--navy);cursor:pointer;}

        /* HERO */
        .hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--bg-page);padding-top:72px;}
        .hero-photo{position:absolute;inset:0;z-index:1;background:url('{{ asset("background1.png") }}') center/cover no-repeat;opacity:.5;}
        .hero-wash{position:absolute;inset:0;z-index:2;background:linear-gradient(to bottom,rgba(237,242,247,.4) 0%,rgba(237,242,247,.2) 45%,rgba(237,242,247,.6) 100%);}
        .hero-float{position:absolute;z-index:4;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(255,255,255,.75);backdrop-filter:blur(8px);box-shadow:0 4px 20px rgba(0,0,0,.10);}
        .hero-float-heart{width:58px;height:58px;top:32%;left:8%;}
        .hero-float-chat{width:56px;height:56px;top:34%;right:8%;}
        .hero-float-heart i{font-size:1.5rem;color:var(--gold);}
        .hero-float-chat i{font-size:1.4rem;color:var(--text-muted);}
        .hero-inner{position:relative;z-index:10;text-align:center;max-width:780px;padding:4rem 2rem 4rem;}
        .hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.85);backdrop-filter:blur(8px);border:1px solid rgba(30,122,74,.2);padding:.45rem 1.25rem;border-radius:50px;margin-bottom:2rem;font-size:.8rem;color:var(--green);font-weight:600;box-shadow:0 2px 12px rgba(0,0,0,.07);}
        .hero-badge i{color:var(--green);}
        .hero-h1{font-size:clamp(2.2rem,5vw,3.8rem);font-weight:700;color:var(--navy);line-height:1.1;margin-bottom:.1rem;}
        .hero-h1-green{font-size:clamp(2.2rem,5vw,3.8rem);font-weight:700;color:var(--green);line-height:1.15;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:center;gap:.4rem;}
        .hero-h1-green .heart-icon{font-size:clamp(1.2rem,2.5vw,1.8rem);color:var(--gold);}
        .hero-desc{font-size:1.1rem;color:var(--text-dark);line-height:1.75;margin-bottom:2.75rem;max-width:560px;margin-left:auto;margin-right:auto;}
        .hero-btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;}
        .btn-hero-primary{display:inline-flex;align-items:center;gap:.5rem;background:var(--green);color:#fff;text-decoration:none;padding:.9rem 2.25rem;border-radius:50px;font-size:1rem;font-weight:600;transition:all .3s;box-shadow:0 6px 22px rgba(30,122,74,.35);}
        .btn-hero-primary:hover{background:var(--green-dark);transform:translateY(-3px);box-shadow:0 10px 32px rgba(30,122,74,.45);}
        .btn-hero-secondary{display:inline-flex;align-items:center;gap:.5rem;color:var(--navy);text-decoration:none;padding:.9rem 2.25rem;border-radius:50px;font-size:1rem;font-weight:500;border:1.5px solid rgba(13,45,82,.22);background:rgba(255,255,255,.65);backdrop-filter:blur(8px);transition:all .3s;}
        .btn-hero-secondary:hover{border-color:var(--navy);background:rgba(255,255,255,.88);}

        /* IN-HERO TRUST CARDS */
        .hero-trust{display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-top:3rem;width:100%;max-width:720px;margin-left:auto;margin-right:auto;}
        .hero-trust-item{display:flex;flex-direction:row;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:14px;background:rgba(255,255,255,.85);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.7);box-shadow:0 2px 12px rgba(0,0,0,.07);text-align:left;transition:all .3s;}
        .hero-trust-item:hover{background:rgba(255,255,255,.96);transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.10);}
        .hero-trust-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
        .hero-trust-icon.green{background:rgba(30,122,74,.12);color:var(--green);}
        .hero-trust-icon.blue{background:rgba(46,123,207,.12);color:#2e7bcf;}
        .hero-trust-icon.gold{background:rgba(245,197,24,.2);color:#c8960a;}
        .hero-trust-icon.teal{background:rgba(30,122,74,.12);color:var(--green);}
        .hero-trust-title{font-size:.78rem;font-weight:700;line-height:1.2;}
        .hero-trust-title.green{color:var(--green);}
        .hero-trust-title.blue{color:#2e7bcf;}
        .hero-trust-title.gold{color:#c8960a;}
        .hero-trust-title.teal{color:var(--green);}
        .hero-trust-desc{font-size:.7rem;color:#475569;line-height:1.4;margin-top:.1rem;}

        /* SERVICES */
        .services{padding:6rem 2rem;background:linear-gradient(160deg,#eaf6f0 0%,#e8f4fb 50%,#eef6f0 100%);position:relative;overflow:hidden;border-bottom:1px solid rgba(13,45,82,.08);}
        .services::before{content:'';position:absolute;top:-80px;left:-60px;width:320px;height:320px;border-radius:50%;background:radial-gradient(ellipse,rgba(30,122,74,.13) 0%,transparent 70%);pointer-events:none;}
        .services::after{content:'';position:absolute;bottom:-60px;right:-40px;width:260px;height:260px;border-radius:50%;background:rgba(46,123,207,.07);pointer-events:none;}
        .svc-deco-circle-sm{display:none;}
        .svc-deco-circle-lg{display:none;}
        .svc-deco-dot-tr{display:none;}
        .svc-wave-bl{display:none;}
        .svc-wave-gold{display:none;}
        .svc-leaf-left{display:none;}
        .svc-leaf-right{display:none;}

        .section-head{text-align:center;margin-bottom:3rem;position:relative;z-index:2;}
        .section-label{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.9);border:1px solid rgba(30,122,74,.2);border-radius:50px;padding:.45rem 1.1rem;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--green);margin-bottom:1rem;box-shadow:0 2px 10px rgba(0,0,0,.06);}
        .section-label i{font-size:.85rem;}
        .section-h2{font-size:2.4rem;font-weight:800;color:var(--navy);margin-bottom:.75rem;}
        .section-h2 .green{color:var(--green);}
        .section-desc{font-size:.95rem;color:var(--text-muted);max-width:480px;margin:0 auto;line-height:1.75;}

        .services-grid{max-width:1060px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;position:relative;z-index:2;}
        .service-card{background:rgba(255,255,255,.92);border:1px solid rgba(255,255,255,.8);border-radius:20px;padding:2rem 1.75rem 1.75rem;transition:all .35s ease;position:relative;overflow:hidden;box-shadow:0 2px 16px rgba(13,45,82,.06);backdrop-filter:blur(6px);}
        /* colored top bar per row - green row 1, blue row 2 via nth-child */
        .service-card::before{content:'';position:absolute;top:0;left:1.75rem;width:40px;height:3px;border-radius:0 0 3px 3px;transition:width .3s;}
        .service-card:nth-child(1)::before,.service-card:nth-child(2)::before{background:var(--green);}
        .service-card:nth-child(3)::before{background:#c8960a;}
        .service-card:nth-child(4)::before,.service-card:nth-child(5)::before{background:#2e7bcf;}
        .service-card:nth-child(6)::before{background:#c8960a;}
        .service-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(13,45,82,.1);border-color:rgba(255,255,255,.95);}
        .service-card:hover::before{width:60px;}
        .service-icon{width:58px;height:58px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1.25rem;}
        .service-icon.green{background:rgba(30,122,74,.1);color:var(--green);}
        .service-icon.blue{background:rgba(46,123,207,.1);color:#2e7bcf;}
        .service-icon.gold{background:rgba(245,197,24,.18);color:#c8960a;}
        .service-card h3{font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:.55rem;}
        .service-card p{font-size:.875rem;color:var(--text-muted);line-height:1.7;margin:0;}
        .service-card-leaf{position:absolute;bottom:.85rem;right:1rem;font-size:1.8rem;color:rgba(30,122,74,.12);pointer-events:none;}

        /* HOW IT WORKS */
        .how-it-works{padding:6rem 2rem;background:linear-gradient(160deg,#eaf6f0 0%,#e8f4fb 50%,#eef6f0 100%);position:relative;overflow:hidden;border-top:1px solid rgba(13,45,82,.08);border-bottom:1px solid rgba(13,45,82,.08);}
        .how-it-works::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 10% 50%,rgba(30,122,74,.04) 0%,transparent 60%),radial-gradient(ellipse at 90% 50%,rgba(46,123,207,.04) 0%,transparent 60%);pointer-events:none;}
        .how-wave-bl{display:none;}
        .how-wave-gold{display:none;}
        .how-deco-circle{display:none;}
        .steps-wrap{max-width:1000px;margin:0 auto;position:relative;z-index:2;}
        /* connector line between cards */
        .steps-connector{display:flex;align-items:center;gap:0;margin-bottom:2.5rem;padding:0 4%;}
        .steps-connector-dot{width:10px;height:10px;border-radius:50%;background:var(--green);flex-shrink:0;}
        .steps-connector-line{flex:1;height:2px;background:linear-gradient(90deg,var(--green),rgba(30,122,74,.15));}
        .steps-connector-dot-end{width:10px;height:10px;border-radius:50%;background:rgba(30,122,74,.2);flex-shrink:0;}
        .steps-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.75rem;position:relative;}
        .steps-grid::before{display:none;}
        .step-card{position:relative;background:#fff;border-radius:20px;padding:2.25rem 1.75rem 2rem;border:1px solid #e8ecf0;box-shadow:0 2px 16px rgba(13,45,82,.06);transition:all .35s;overflow:hidden;}
        .step-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:20px 20px 0 0;background:linear-gradient(90deg,var(--green),var(--green-dark));opacity:0;transition:opacity .3s;}
        .step-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(13,45,82,.10);border-color:rgba(30,122,74,.18);}
        .step-card:hover::before{opacity:1;}
        .step-bg-num{position:absolute;top:-10px;right:12px;font-size:6rem;font-weight:800;color:rgba(30,122,74,.055);line-height:1;pointer-events:none;user-select:none;}
        .step-icon-wrap{width:54px;height:54px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.25rem;background:linear-gradient(135deg,rgba(30,122,74,.1),rgba(30,122,74,.06));color:var(--green);}
        .step-num-badge{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:var(--green);color:#fff;font-size:.72rem;font-weight:700;margin-bottom:.75rem;}
        .step-card h3{font-size:1.1rem;font-weight:700;color:var(--navy);margin-bottom:.6rem;}
        .step-card p{font-size:.875rem;color:var(--text-muted);line-height:1.7;margin:0;}

        /* ABOUT */
        .about{padding:5rem 2rem;background:linear-gradient(160deg,#eaf6f0 0%,#e8f4fb 50%,#eef6f0 100%);position:relative;overflow:hidden;border-bottom:1px solid rgba(13,45,82,.08);}
        .about-wave-bl{display:none;}
        .about-wave-gold{display:none;}
        .about-deco-leaf{position:absolute;bottom:0;left:-20px;width:180px;opacity:.18;pointer-events:none;}
        .about-deco-dot{position:absolute;top:8%;right:2%;width:120px;height:120px;background-image:radial-gradient(circle,#a0b4cc 1.5px,transparent 1.5px);background-size:16px 16px;opacity:.45;pointer-events:none;}
        .about-grid{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:end;}

        /* left */
        .about-label{display:inline-flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #e2e8f0;border-radius:50px;padding:.4rem 1rem;font-size:.78rem;font-weight:600;color:var(--text-muted);margin-bottom:1.5rem;box-shadow:0 2px 8px rgba(0,0,0,.05);}
        .about-label i{color:var(--green);}
        .about-h2{font-size:2.5rem;font-weight:800;color:var(--navy);line-height:1.15;margin-bottom:.6rem;}
        .about-h2 .green{color:var(--green);}
        .about-divider{width:48px;height:4px;background:var(--green);border-radius:4px;margin-bottom:1.5rem;}
        .about-content p{color:var(--text-muted);font-size:.93rem;line-height:1.8;margin-bottom:1.1rem;}
        .about-callout{background:#fff;border-left:4px solid var(--green);padding:1.1rem 1.4rem;border-radius:0 12px 12px 0;margin-top:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,.05);display:flex;align-items:flex-start;gap:.85rem;}
        .about-callout-icon{font-size:1.6rem;color:#c8960a;line-height:1;flex-shrink:0;margin-top:.1rem;}
        .about-callout p{margin:0;font-weight:700;color:var(--navy);font-size:.93rem;line-height:1.5;}

        /* right */
        .about-right{display:flex;flex-direction:column;gap:1.25rem;}
        .about-photo{width:100%;height:auto;object-fit:contain;border-radius:18px;box-shadow:0 8px 28px rgba(13,45,82,.13);display:block;}
        .stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
        .stat-card{background:#fff;border-radius:16px;padding:1.25rem 1.4rem;border:1px solid #e8ecf0;display:flex;align-items:center;gap:1rem;transition:all .3s;}
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(0,0,0,.07);}
        .stat-icon{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;}
        .stat-icon.green{background:rgba(30,122,74,.10);color:var(--green);}
        .stat-icon.blue{background:rgba(46,123,207,.10);color:#2e7bcf;}
        .stat-icon.gold{background:rgba(245,197,24,.18);color:#c8960a;}
        .stat-icon.purple{background:rgba(124,77,255,.10);color:#7c4dff;}
        .stat-body{}
        .stat-num{font-size:1.9rem;font-weight:800;line-height:1;display:block;}
        .stat-num.green{color:var(--green);}
        .stat-num.blue{color:#2e7bcf;}
        .stat-num.gold{color:#c8960a;}
        .stat-num.purple{color:#7c4dff;}
        .stat-lbl{font-size:.7rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;margin-top:.2rem;display:block;}
        .stat-underline{width:28px;height:3px;border-radius:3px;margin-top:.4rem;}
        .stat-underline.green{background:var(--green);}
        .stat-underline.blue{background:#2e7bcf;}
        .stat-underline.gold{background:#c8960a;}
        .stat-underline.purple{background:#7c4dff;}

        .about-commitment{background:#fff;border-radius:16px;padding:1.1rem 1.4rem;border:1px solid #e8ecf0;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 10px rgba(0,0,0,.05);}
        .about-commitment-icon{width:42px;height:42px;border-radius:50%;background:rgba(30,122,74,.10);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--green);flex-shrink:0;}
        .about-commitment p{margin:0;font-size:.85rem;color:var(--text-muted);line-height:1.6;}

        /* FOOTER */
        .site-footer{background:linear-gradient(145deg,#e8f4f8 0%,#eef6f0 50%,#e8f2fa 100%);color:var(--text-dark);padding:4rem 2rem 0;position:relative;overflow:hidden;}
        .footer-deco{position:absolute;pointer-events:none;}
        .footer-deco-tl{top:-40px;left:-30px;width:180px;height:180px;border-radius:50%;background:radial-gradient(ellipse,rgba(30,122,74,.12) 0%,transparent 70%);}
        .footer-deco-br{bottom:60px;right:-20px;width:140px;height:140px;border-radius:50%;background:rgba(46,123,207,.08);}
        .footer-deco-circle{top:30px;right:38%;width:80px;height:80px;border-radius:50%;background:rgba(30,122,74,.07);border:2px solid rgba(30,122,74,.12);}
        .footer-main{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1.2fr 1fr;gap:3.5rem;align-items:end;position:relative;z-index:2;padding-bottom:3rem;}
        .footer-logo-row{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;}
        .footer-logo-img{width:64px;height:64px;border-radius:16px;}
        .footer-brand-bnhs{font-size:1.5rem;font-weight:800;color:#0d2d52;line-height:1;}
        .footer-brand-cc{font-size:1.5rem;font-weight:800;color:#0d2d52;line-height:1.2;}
        .footer-brand-cc span{color:#1e7a4a;}
        .footer-subtitle{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#64748b;margin-bottom:1.1rem;}
        .footer-desc{font-size:.9rem;line-height:1.75;color:#475569;max-width:380px;margin-bottom:1.5rem;}
        .footer-pills{display:flex;gap:.65rem;flex-wrap:wrap;}
        .footer-pill{display:inline-flex;align-items:center;gap:.4rem;padding:.4rem 1rem;border-radius:50px;font-size:.8rem;font-weight:600;border:1.5px solid;}
        .footer-pill.green{color:#1e7a4a;border-color:rgba(30,122,74,.3);background:rgba(30,122,74,.06);}
        .footer-pill.blue{color:#1e5aaa;border-color:rgba(46,123,207,.3);background:rgba(46,123,207,.06);}
        .footer-pill.gold{color:#9a6800;border-color:rgba(245,197,24,.4);background:rgba(245,197,24,.1);}
        /* contact � no card, bare on background */
        .footer-contact-card{background:transparent;border:none;padding:0;}
        .footer-contact-header{display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(13,45,82,.1);}
        .footer-contact-icon-box{width:44px;height:44px;border-radius:12px;background:rgba(30,122,74,.12);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--green);}
        .footer-contact-title{font-size:1rem;font-weight:700;color:#0d2d52;}
        .footer-contact-sub{font-size:.8rem;color:#64748b;}
        .footer-contact-list{display:flex;flex-direction:column;gap:1.1rem;}
        .footer-contact-row{display:flex;align-items:flex-start;gap:.9rem;}
        .fci{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0;}
        .fci-green{background:rgba(30,122,74,.12);color:#1e7a4a;}
        .fci-blue{background:rgba(46,123,207,.12);color:#1e5aaa;}
        .fci-gold{background:rgba(245,197,24,.2);color:#9a6800;}
        .fci-main{font-size:.9rem;font-weight:600;color:#1e293b;line-height:1.3;}
        .fci-sub{font-size:.78rem;color:#64748b;margin-top:.1rem;}
        .footer-bottom-bar{max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:center;gap:2rem;padding:1.5rem 0 1.75rem;border-top:1px solid rgba(13,45,82,.1);position:relative;z-index:2;flex-wrap:wrap;text-align:center;}
        .footer-bottom-left{display:flex;align-items:center;gap:.85rem;}
        .footer-bottom-logo{width:44px;height:44px;border-radius:10px;}
        .footer-bottom-copy{font-size:.88rem;font-weight:700;color:#0d2d52;}
        .footer-bottom-sub{font-size:.75rem;color:#64748b;}
        .footer-bottom-divider{width:1px;height:36px;background:rgba(13,45,82,.12);flex-shrink:0;}
        .footer-bottom-tagline{display:flex;align-items:center;gap:.6rem;font-size:.88rem;color:#1e7a4a;font-weight:500;font-style:italic;}
        .footer-tagline-icon{width:30px;height:30px;border-radius:50%;background:rgba(30,122,74,.1);display:flex;align-items:center;justify-content:center;font-size:.85rem;color:#1e7a4a;}

        /* RESPONSIVE */
        @media(max-width:992px){
            .navbar{padding:1rem 1.5rem;}
            .nav-toggle{display:block;}
            .nav-actions{display:none;}
            .nav-actions.open{display:flex;flex-direction:column;position:absolute;top:100%;left:0;right:0;background:rgba(255,255,255,.98);backdrop-filter:blur(16px);padding:2rem 1.5rem;gap:1.25rem;box-shadow:0 8px 32px rgba(13,45,82,.12);border-top:1px solid rgba(13,45,82,.07);}
            .nav-actions.open .nav-link-item{color:var(--text-body);text-align:center;}
            .nav-actions.open .btn-nav-login,.nav-actions.open .btn-nav-cta{text-align:center;}
            .about-grid{grid-template-columns:1fr;gap:2.5rem;}
            .about{padding:4rem 1.25rem;}
            .steps-grid{grid-template-columns:1fr;gap:1.5rem;}
            .steps-connector{display:none;}
            .hero-trust{grid-template-columns:repeat(2,1fr);}
            .footer-main{grid-template-columns:1fr;gap:2rem;}
            .footer-bottom-bar{flex-direction:column;align-items:center;gap:1rem;text-align:center;}
            .footer-bottom-left{justify-content:center;}
            .footer-bottom-divider{display:none;}
        }
        @media(max-width:640px){
            .hero-float{display:none;}
            .hero-h1{font-size:2rem;}
            .hero-h1-green{font-size:2rem;}
            .hero-desc{font-size:.95rem;}
            .hero-trust{grid-template-columns:repeat(2,1fr);}
            .section-h2{font-size:1.75rem;}
            .services-grid{grid-template-columns:1fr;}
            .about{padding:3rem 1rem;}
            .about-grid{gap:1.75rem;}
            .about-h2{font-size:1.9rem;}
            .about-photo-wrap{height:200px;}
            .stats-grid{grid-template-columns:1fr 1fr;gap:.65rem;}
            .stat-card{padding:1rem 1rem;}
            .stat-num{font-size:1.5rem;}
            .stat-icon{width:34px;height:34px;font-size:.9rem;}
            .footer-bottom-bar{justify-content:center;text-align:center;}
        }
        @media(max-width:400px){
            .stats-grid{grid-template-columns:1fr;}
        }

        /* ANIMATIONS */
        .fade-up{opacity:0;transform:translateY(30px);transition:opacity .7s ease,transform .7s ease;}
        .fade-up.visible{opacity:1;transform:translateY(0);}
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar" id="navbar">
        <a href="#" class="nav-brand">
            <img src="{{ asset('logo.png') }}" alt="BNHS Care Konek">
            <div>
                <div class="nav-brand-name">Care Konek</div>
                <div class="nav-brand-sub" style="color:var(--green);">BNHS Referral &amp; Case Management</div>
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
        <div class="hero-photo"></div>
        <div class="hero-wash"></div>
        <div class="hero-float hero-float-heart"><i class="bi bi-heart"></i></div>
        <div class="hero-float hero-float-chat"><i class="bi bi-chat-dots"></i></div>

        <div class="hero-inner fade-up">
            <div class="hero-badge">
                <i class="bi bi-shield-check"></i> Confidential &amp; Secure Platform
            </div>
            <h1 class="hero-h1">Your Concerns</h1>
            <div class="hero-h1-green">
                Matter <i class="bi bi-heart heart-icon"></i>
            </div>
            <p class="hero-desc">
                See a learner who needs support? Refer their concern through Care Konek for timely, confidential, and appropriate assistance.
            </p>
            <div class="hero-btns">
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="bi bi-arrow-right-circle"></i> Access Portal
                </a>
                <a href="#services" class="btn-hero-secondary">
                    <i class="bi bi-play-circle"></i> Learn More
                </a>
            </div>

            {{-- Trust cards inside hero --}}
            <div class="hero-trust">
                <div class="hero-trust-item">
                    <div class="hero-trust-icon green"><i class="bi bi-patch-check-fill"></i></div>
                    <div>
                        <div class="hero-trust-title green">Confidential</div>
                        <div class="hero-trust-desc">Your privacy is our top priority.</div>
                    </div>
                </div>
                <div class="hero-trust-item">
                    <div class="hero-trust-icon blue"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="hero-trust-title blue">Supportive</div>
                        <div class="hero-trust-desc">Connect with caring counselors.</div>
                    </div>
                </div>
                <div class="hero-trust-item">
                    <div class="hero-trust-icon gold"><i class="bi bi-heart-fill"></i></div>
                    <div>
                        <div class="hero-trust-title gold">Accessible</div>
                        <div class="hero-trust-desc">Get support anytime, anywhere.</div>
                    </div>
                </div>
                <div class="hero-trust-item">
                    <div class="hero-trust-icon teal"><i class="bi bi-stars"></i></div>
                    <div>
                        <div class="hero-trust-title teal">Empowering</div>
                        <div class="hero-trust-desc">Resources to help you grow and thrive.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section id="services" class="services">
        <div class="svc-deco-circle-sm"></div>
        <div class="svc-deco-circle-lg"></div>
        <div class="svc-deco-dot-tr"></div>
        <div class="svc-wave-bl"></div>
        <div class="svc-wave-gold"></div>
        <div class="svc-leaf-left"><i class="bi bi-flower1"></i></div>
        <div class="svc-leaf-right"><i class="bi bi-flower1"></i></div>

        <div class="section-head fade-up">
            <div class="section-label"><i class="bi bi-people-fill"></i> What We Offer</div>
            <h2 class="section-h2">Comprehensive <span class="green">Guidance</span> Services</h2>
            <p class="section-desc">Designed to support every student's academic, emotional, and personal growth.</p>
        </div>

        <div class="services-grid">
            <div class="service-card fade-up">
                <div class="service-icon green"><i class="bi bi-chat-heart"></i></div>
                <h3>Submit Concerns</h3>
                <p>Share school-related concerns anonymously or identified through a secure, easy-to-use platform.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon blue"><i class="bi bi-calendar2-check"></i></div>
                <h3>Book Appointments</h3>
                <p>Schedule one-on-one counseling sessions with guidance counselors at your preferred date and time.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon gold"><i class="bi bi-file-earmark-text"></i></div>
                <h3>Incident Reporting</h3>
                <p>Teachers can document and report incidents for prompt counselor review and intervention.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon green"><i class="bi bi-people-fill"></i></div>
                <h3>Student Referrals</h3>
                <p>Teachers refer students who need extra support directly to the guidance office for follow-up.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon blue"><i class="bi bi-journal-bookmark-fill"></i></div>
                <h3>Intervention Guides</h3>
                <p>Access curated protocols and toolkits for classroom management and learner protection.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
            <div class="service-card fade-up">
                <div class="service-icon gold"><i class="bi bi-graph-up-arrow"></i></div>
                <h3>Case Tracking</h3>
                <p>Monitor the status of submitted reports and referrals with real-time progress updates.</p>
                <div class="service-card-leaf"><i class="bi bi-flower2"></i></div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section id="how" class="how-it-works">
        <div class="how-deco-circle"></div>
        <div class="how-wave-bl"></div>
        <div class="how-wave-gold"></div>
        <div class="section-head fade-up">
            <div class="section-label"><i class="bi bi-signpost-2-fill"></i> Simple Process</div>
            <h2 class="section-h2">How It <span class="green">Works</span></h2>
            <p class="section-desc">Getting help is just a few steps away.</p>
        </div>
        <div class="steps-wrap">
            <div class="steps-connector fade-up">
                <div class="steps-connector-dot"></div>
                <div class="steps-connector-line"></div>
                <div class="steps-connector-dot-end"></div>
            </div>
            <div class="steps-grid">
                <div class="step-card fade-up">
                    <div class="step-bg-num">1</div>
                    <div class="step-num-badge">1</div>
                    <div class="step-icon-wrap"><i class="bi bi-box-arrow-in-right"></i></div>
                    <h3>Log In</h3>
                    <p>Access the portal using your school credentials to get started quickly and securely.</p>
                </div>
                <div class="step-card fade-up">
                    <div class="step-bg-num">2</div>
                    <div class="step-num-badge">2</div>
                    <div class="step-icon-wrap"><i class="bi bi-pencil-square"></i></div>
                    <h3>Submit or Schedule</h3>
                    <p>Share a concern, book a counseling appointment, or file an incident report &mdash; all done securely online.</p>
                </div>
                <div class="step-card fade-up">
                    <div class="step-bg-num">3</div>
                    <div class="step-num-badge">3</div>
                    <div class="step-icon-wrap"><i class="bi bi-heart-pulse"></i></div>
                    <h3>Get Support</h3>
                    <p>A counselor reviews your submission, responds, and schedules a session if needed &mdash; with full confidentiality.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="about">
        <div class="about-wave-bl"></div>
        <div class="about-wave-gold"></div>
        <div class="about-deco-dot"></div>

        <div class="about-grid">

            {{-- LEFT: text --}}
            <div class="about-content fade-up">
                <h2 class="about-h2">About BNHS<br>
                    <span class="green">Care Konek</span>
                </h2>
                <div class="about-divider"></div>

                <p>BNHS Care Konek is a digital referral and case management system of Bulan National High School designed to help teachers efficiently identify, refer, and coordinate support for learners who may require guidance, psychosocial, child protection, or other appropriate interventions.</p>

                <p>Through the platform, teachers can submit learner referrals, document relevant concerns, and connect learners with the appropriate school personnel and support services. It also supports organized case documentation, monitoring, follow-up, and coordination to help ensure that learner concerns are addressed in a timely, confidential, and systematic manner.</p>

                <div class="about-callout">
                    <span class="about-callout-icon"><i class="bi bi-quote"></i></span>
                    <p>BNHS Care Konek strengthens the link between teachers and learner support services, providing a more accessible and coordinated process for ensuring that learners who need help are identified, referred, and supported.</p>
                </div>
            </div>

            {{-- RIGHT: photo + stats --}}
            <div class="about-right fade-up">
                <img src="{{ asset('cover.jpg') }}" alt="BNHS Care Konek" class="about-photo">

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-body">
                            <span class="stat-num green">200+</span>
                            <span class="stat-lbl">Students Helped</span>
                            <div class="stat-underline green"></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-clock-fill"></i></div>
                        <div class="stat-body">
                            <span class="stat-num blue">24/7</span>
                            <span class="stat-lbl">Always Available</span>
                            <div class="stat-underline blue"></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon gold"><i class="bi bi-shield-fill"></i></div>
                        <div class="stat-body">
                            <span class="stat-num gold">100%</span>
                            <span class="stat-lbl">Confidential</span>
                            <div class="stat-underline gold"></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="bi bi-person-badge-fill"></i></div>
                        <div class="stat-body">
                            <span class="stat-num purple">2</span>
                            <span class="stat-lbl">Expert Counselors</span>
                            <div class="stat-underline purple"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-deco footer-deco-tl"></div>
        <div class="footer-deco footer-deco-br"></div>
        <div class="footer-deco footer-deco-circle"></div>

        <div class="footer-main fade-up">
            <div>
                <div class="footer-logo-row">
                    <img src="{{ asset('logo.png') }}" alt="BNHS Care Konek" class="footer-logo-img">
                    <div>
                        <div class="footer-brand-bnhs">BNHS</div>
                        <div class="footer-brand-cc">Care <span>Konek</span></div>
                    </div>
                </div>
                <div class="footer-subtitle" style="color:var(--green);">Referral &amp; Case Management System</div>
                <p class="footer-desc">Connecting teachers to learner support.
BNHS Care Konek provides teachers with a secure and accessible platform to refer learners who may need guidance, psychosocial, child protection, or other support services. It enables organized referral, case monitoring, follow-up, and coordination to help ensure that every learner concern receives timely and appropriate attention.</p>
                <div class="footer-pills">
                    <span class="footer-pill green"><i class="bi bi-lock-fill"></i> Confidential</span>
                    <span class="footer-pill blue"><i class="bi bi-shield-fill"></i> Secure Platform</span>
                    <span class="footer-pill gold"><i class="bi bi-mortarboard-fill"></i> DepEd-Aligned</span>
                </div>
            </div>

            <div class="footer-contact-card">
                <div class="footer-contact-header">
                    <div class="footer-contact-icon-box"><i class="bi bi-headset"></i></div>
                    <div>
                        <div class="footer-contact-title">Contact &amp; Support</div>
                        <div class="footer-contact-sub">We're here to help you 24/7</div>
                    </div>
                </div>
                <div class="footer-contact-list">
                    <div class="footer-contact-row">
                        <div class="fci fci-green"><i class="bi bi-geo-alt-fill"></i></div>
                        <div><div class="fci-main">Bulan National High School</div><div class="fci-sub">Zone 8, T. De Castro Street, Bulan, Sorsogon</div></div>
                    </div>
                    <div class="footer-contact-row">
                        <div class="fci fci-blue"><i class="bi bi-envelope-fill"></i></div>
                        <div class="fci-main">302190@deped.gov.ph</div>
                    </div>
                    <div class="footer-contact-row">
                        <div class="fci fci-gold"><i class="bi bi-telephone-fill"></i></div>
                        <div class="fci-main">(056) 211 0828</div>
                    </div>
                    <div class="footer-contact-row">
                        <div class="fci fci-green"><i class="bi bi-clock-fill"></i></div>
                        <div><div class="fci-main">Monday &ndash; Friday</div><div class="fci-sub">8:00 AM &ndash; 5:00 PM</div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom-bar">
            <div class="footer-bottom-left">
                <div>
                    <div class="footer-bottom-copy">&copy; {{ date('Y') }} BNHS Care Konek</div>
                    <div class="footer-bottom-sub">Referral &amp; Case Management System</div>
                </div>
            </div>
            <div class="footer-bottom-divider"></div>
            <div class="footer-bottom-tagline">
                <div class="footer-tagline-icon"><i class="bi bi-heart-fill"></i></div>
                <span>Supporting Student Wellness, Safety, and Success.</span>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                const t = document.querySelector(a.getAttribute('href'));
                if (t) t.scrollIntoView({ behavior:'smooth', block:'start' });
                document.getElementById('navActions').classList.remove('open');
            });
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }});
        }, { threshold: 0.12 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>
