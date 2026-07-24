<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Pending Approval - BNHS Care Konek</title>
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
            background: linear-gradient(160deg, #eaf6f0 0%, #e8f4fb 50%, #eef6f0 100%);
            padding: 2rem 1rem;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(13,45,82,.12);
            text-align: center;
        }
        .icon-wrap {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(245,197,24,.15);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.2rem;
            color: #c8960a;
        }
        h1 { font-size: 1.6rem; font-weight: 700; color: #0d2d52; margin-bottom: .6rem; }
        .divider { width: 40px; height: 3px; background: #1e7a4a; border-radius: 3px; margin: 0 auto .75rem; }
        p { font-size: .95rem; color: #475569; line-height: 1.75; margin-bottom: 1rem; }
        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin: 1.5rem 0;
            display: flex; align-items: flex-start; gap: .75rem; text-align: left;
        }
        .info-box i { color: #1e7a4a; font-size: 1.2rem; flex-shrink: 0; margin-top: .1rem; }
        .info-box p { margin: 0; font-size: .88rem; color: #166534; }
        .btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .75rem 2rem;
            background: #1e7a4a; color: #fff;
            border-radius: 50px; font-size: .95rem; font-weight: 600;
            text-decoration: none; transition: all .25s;
            box-shadow: 0 4px 14px rgba(30,122,74,.3);
        }
        .btn:hover { background: #145e38; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(30,122,74,.38); }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap"><i class="bi bi-hourglass-split"></i></div>
        <h1>Account Pending Approval</h1>
        <div class="divider"></div>
        <p>Thank you for registering! Your account has been submitted and is currently awaiting approval from a guidance counselor.</p>
        <p>You will be able to log in once your account has been reviewed and approved.</p>
        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <p>If you need urgent assistance, please visit the guidance office directly or contact your school's guidance counselor.</p>
        </div>
        <a href="{{ route('login') }}" class="btn">
            <i class="bi bi-box-arrow-in-right"></i> Back to Sign In
        </a>
    </div>
</body>
</html>
