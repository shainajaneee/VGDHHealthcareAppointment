<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VGDH | Modern Healthcare Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&display=swap" rel="stylesheet">

    <style>
        :root {
            --teal:        #0d9488;
            --teal-light:  #14b8a6;
            --teal-dark:   #0f766e;
            --sage:        #4ade80;
            --mint:        #ccfbf1;
            --cream:       #f0fdfa;
            --sand:        #f8fafc;
            --dark:        #0f2a27;
            --muted:       #5f7c79;
            --border:      #d1faf4;
            --white:       #ffffff;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--dark);
            background: var(--white);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'DM Serif Display', serif;
            letter-spacing: -0.02em;
        }

        /* ─── Utility ─────────────────────────────── */
        .text-teal   { color: var(--teal) !important; }
        .bg-cream    { background-color: var(--cream) !important; }
        .section-pad { padding: 96px 0; }

        /* ─── Buttons ─────────────────────────────── */
        .btn-teal {
            background: var(--teal);
            color: #fff;
            border: none;
            padding: 13px 32px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.01em;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
        }
        .btn-teal:hover {
            background: var(--teal-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(13,148,136,0.28);
        }
        .btn-ghost {
            background: transparent;
            color: var(--dark);
            border: 2px solid var(--border);
            padding: 12px 28px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: border-color 0.2s, background 0.2s;
        }
        .btn-ghost:hover {
            border-color: var(--teal);
            background: var(--cream);
            color: var(--teal-dark);
        }

        /* ─── Navbar ──────────────────────────────── */
        .navbar {
            padding: 18px 0;
            background: rgba(255,255,255,0.92) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .navbar-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.6rem;
            color: var(--teal) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            font-weight: 500;
            color: var(--muted) !important;
            padding: 6px 14px !important;
            border-radius: 100px;
            transition: color 0.2s, background 0.2s;
            font-size: 0.93rem;
        }
        .nav-link:hover {
            color: var(--teal) !important;
            background: var(--cream);
        }
        .navbar-toggler {
            border: none;
            padding: 4px 8px;
            color: var(--dark);
        }
        .navbar-toggler:focus { box-shadow: none; }

        /* ─── Hero ────────────────────────────────── */
        .hero-section {
            padding: 100px 0 80px;
            background: linear-gradient(140deg, #f0fdfa 0%, #ffffff 55%, #e6fffa 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -120px; right: -180px;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(20,184,166,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--mint);
            color: var(--teal-dark);
            padding: 7px 16px;
            border-radius: 100px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 22px;
            border: 1px solid rgba(13,148,136,0.15);
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            line-height: 1.12;
            margin-bottom: 20px;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-lead {
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 480px;
            margin-bottom: 36px;
            font-weight: 400;
        }
        .hero-cta-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }
        .hero-img-wrap {
            position: relative;
        }
        .hero-img-wrap img {
            width: 100%;
            border-radius: 28px;
            box-shadow: 0 30px 60px rgba(13,148,136,0.12);
        }
        .stats-chip {
            position: absolute;
            bottom: 24px;
            left: -16px;
            background: white;
            border-radius: 16px;
            padding: 16px 22px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 14px;
            animation: float 4s ease-in-out infinite;
            min-width: 200px;
        }
        .stats-chip .chip-icon {
            width: 46px; height: 46px;
            background: #d1fae5;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #059669;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stats-chip h6 { margin: 0; font-weight: 700; font-size: 0.95rem; }
        .stats-chip small { color: var(--muted); font-size: 0.78rem; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* ─── How it Works ────────────────────────── */
        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            margin-bottom: 50px;
        }
        .step-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 38px 32px;
            height: 100%;
            transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }
        .step-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 60%, rgba(13,148,136,0.04) 100%);
            pointer-events: none;
        }
        .step-card:hover {
            border-color: var(--teal);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(13,148,136,0.12);
        }
        .step-icon {
            width: 64px; height: 64px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.7rem;
            margin: 0 auto 24px;
        }
        .step-num {
            position: absolute;
            top: 20px; right: 22px;
            font-family: 'DM Serif Display', serif;
            font-size: 3.5rem;
            color: rgba(13,148,136,0.06);
            line-height: 1;
            user-select: none;
        }
        .step-card h5 { font-size: 1.1rem; margin-bottom: 10px; }
        .step-card p  { color: var(--muted); font-size: 0.9rem; margin: 0; }

        /* ─── About Section ───────────────────────── */
        .feature-row { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 26px; }
        .feature-icon {
            width: 46px; height: 46px;
            background: var(--cream);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: var(--teal);
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .feature-row h6 { font-family: 'DM Sans', sans-serif; font-weight: 700; margin-bottom: 4px; }
        .feature-row p  { color: var(--muted); font-size: 0.88rem; margin: 0; }

        .info-box {
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 38px 36px;
        }
        .info-box h5 { margin-bottom: 22px; font-size: 1.25rem; }
        .check-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }
        .check-item .ci-icon {
            color: var(--teal);
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .check-item p { margin: 0; font-size: 0.92rem; color: var(--dark); }

        /* ─── History ─────────────────────────────── */
        .timeline-card {
            background: white;
            border-radius: 20px;
            padding: 30px 26px;
            height: 100%;
            border-top: 4px solid var(--teal);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .timeline-card:hover { transform: translateY(-6px); }
        .timeline-card.green-top { border-top-color: #22c55e; }
        .timeline-card .year {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--teal);
            margin-bottom: 10px;
        }
        .timeline-card.green-top .year { color: #22c55e; }
        .timeline-card p { font-size: 0.88rem; color: var(--muted); margin: 0; }

        /* ─── Contact ─────────────────────────────── */
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 28px;
        }
        .contact-icon {
            width: 48px; height: 48px;
            background: var(--cream);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: var(--teal);
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .contact-info-item h6 { font-family: 'DM Sans', sans-serif; font-weight: 700; margin-bottom: 4px; }
        .contact-info-item p  { color: var(--muted); font-size: 0.88rem; margin: 0; }

        .contact-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 38px;
        }
        .contact-card h4 { margin-bottom: 26px; }
        .form-control {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.93rem;
            color: var(--dark);
            transition: border-color 0.2s, box-shadow 0.2s;
            background: var(--sand);
        }
        .form-control:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(13,148,136,0.1);
            outline: none;
            background: white;
        }
        .form-control::placeholder { color: #9ab3b0; }

        /* ─── Footer ──────────────────────────────── */
        footer {
            background: var(--dark);
            color: #7ca8a3;
            padding: 56px 0;
        }
        footer .brand {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: white;
            margin-bottom: 10px;
        }
        footer p { font-size: 0.84rem; opacity: 0.6; margin-bottom: 24px; }
        footer .social-links a {
            color: white;
            font-size: 1.15rem;
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        footer .social-links a:hover { background: var(--teal); }
        .social-links { display: flex; justify-content: center; gap: 10px; }

        /* ─── Modal ───────────────────────────────── */
        .modal-content {
            border: none;
            border-radius: 24px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .modal-body { padding: 44px 40px; }
        .modal-heading { text-align: center; margin-bottom: 36px; }
        .modal-heading h3 { margin-bottom: 6px; }
        .modal-heading p  { color: var(--muted); font-size: 0.93rem; margin: 0; }

        .portal-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 24px;
            border: 2px solid var(--border);
            border-radius: 18px;
            text-decoration: none;
            color: inherit;
            transition: border-color 0.22s, background 0.22s, transform 0.22s;
            margin-bottom: 14px;
        }
        .portal-card:last-child { margin-bottom: 0; }
        .portal-card:hover {
            border-color: var(--teal);
            background: var(--cream);
            transform: scale(1.02);
        }
        .portal-card .p-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .portal-card h6 { font-family: 'DM Sans', sans-serif; font-weight: 700; margin-bottom: 3px; }
        .portal-card small { color: var(--muted); font-size: 0.82rem; }

        /* ─── Mobile-first responsive ─────────────── */
        @media (max-width: 991.98px) {
            .hero-section { padding: 80px 0 60px; }
            .stats-chip    { position: static; margin-top: 18px; width: fit-content; }
            .hero-img-wrap { text-align: center; }
            .section-pad   { padding: 70px 0; }
        }

        @media (max-width: 767.98px) {
            .hero-section  { padding: 72px 0 52px; }
            .hero-badge    { font-size: 0.78rem; }
            .hero-lead     { font-size: 0.97rem; }
            .step-card     { padding: 28px 22px; }
            .info-box      { padding: 28px 24px; }
            .contact-card  { padding: 28px 22px; }
            .modal-body    { padding: 32px 24px; }
            .section-pad   { padding: 60px 0; }
        }

        @media (max-width: 575.98px) {
            .hero-cta-group .btn-teal,
            .hero-cta-group .btn-ghost { width: 100%; text-align: center; }
            .step-icon { width: 56px; height: 56px; font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- ───── NAVBAR ───────────────────────────────────── -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-heart-pulse-fill"></i> VGDH
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2" style="color:var(--dark)"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 pt-3 pt-lg-0">
                <li class="nav-item"><a class="nav-link" href="#how-it-works">How it Works</a></li>
                <li class="nav-item"><a class="nav-link" href="#about-system">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <button class="btn btn-teal" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Access Portal
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ───── HERO ─────────────────────────────────────── -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-badge">
                    <i class="bi bi-stars"></i> NEW: Online Medical Records
                </div>
                <h1 class="hero-title">
                    Modern Care for<br>Your <em>Family.</em>
                </h1>
                <p class="hero-lead">
                    Experience seamless healthcare management. Book appointments with top specialists in just a few clicks.
                </p>
                <div class="hero-cta-group">
                    <button class="btn btn-teal btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Book Now &nbsp;<i class="bi bi-arrow-right-short"></i>
                    </button>
                    <a href="#about-system" class="btn btn-ghost btn-lg">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="hero-img-wrap">
                    <img src="https://img.freepik.com/free-vector/health-professional-team-concept-illustration_114360-1608.jpg" alt="Healthcare Team">
                    <div class="stats-chip d-none d-sm-flex">
                        <div class="chip-icon"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <h6>10k+ Patients</h6>
                            <small>Trusted our care this year</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── HOW IT WORKS ─────────────────────────────── -->
<section id="how-it-works" class="section-pad bg-cream">
    <div class="container text-center">
        <p class="section-label">Process</p>
        <h2 class="section-title">How it Works</h2>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-4">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-icon bg-teal text-white mx-auto" style="background:var(--teal)">
                        <i class="bi bi-person-plus" style="color:white"></i>
                    </div>
                    <h5>Quick Sign Up</h5>
                    <p>Create your health profile in under 2 minutes with secure encryption.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-icon mx-auto" style="background:#ccfbf1">
                        <i class="bi bi-calendar2-week" style="color:var(--teal-dark);font-size:1.7rem"></i>
                    </div>
                    <h5>Request Slot</h5>
                    <p>Select your preferred department and explain your concern to our team.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 mx-auto">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-icon mx-auto" style="background:#dcfce7">
                        <i class="bi bi-shield-check" style="color:#16a34a;font-size:1.7rem"></i>
                    </div>
                    <h5>Confirmed Care</h5>
                    <p>Receive your confirmed schedule and visit with VIP priority.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── ABOUT SYSTEM ─────────────────────────────── -->
<section id="about-system" class="section-pad">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <p class="section-label mb-3">Digital Transformation</p>
                <h2 style="font-size:clamp(1.8rem,4vw,2.8rem);margin-bottom:20px;">A Smarter Way to<br>Manage Your Health</h2>
                <p style="color:var(--muted);margin-bottom:32px;font-size:0.97rem;">
                    The VGDH Patient Portal is a specialized web-based platform designed to streamline healthcare delivery for the residents of Escalante City. This system acts as a digital front door to our medical services, reducing physical queues and improving data accuracy.
                </p>
                <div class="feature-row">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <h6>Secure Records</h6>
                        <p>Encrypted access to your personal health data and history.</p>
                    </div>
                </div>
                <div class="feature-row">
                    <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <h6>Real-time Booking</h6>
                        <p>Schedule consultations without leaving your home.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <h5><i class="bi bi-info-circle-fill me-2" style="color:var(--teal)"></i>System Purpose</h5>
                    <div class="check-item">
                        <i class="bi bi-check2-circle ci-icon"></i>
                        <p><strong>Centralized Management:</strong> A unified hub for both Patients and Hospital Staff.</p>
                    </div>
                    <div class="check-item">
                        <i class="bi bi-check2-circle ci-icon"></i>
                        <p><strong>Transparency:</strong> View available slots and department updates in real-time.</p>
                    </div>
                    <div class="check-item" style="margin-bottom:0">
                        <i class="bi bi-check2-circle ci-icon"></i>
                        <p><strong>Efficiency:</strong> Built with <strong>Laravel</strong> and <strong>PHP</strong> for high-speed processing of medical requests.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── HISTORY ──────────────────────────────────── -->
<section id="history" class="section-pad bg-cream">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-label">Our 60-Year Legacy</p>
            <h2 class="section-title" style="margin-bottom:0">Vicente Gustilo District Hospital</h2>
        </div>
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="timeline-card">
                    <div class="year">1950s</div>
                    <p>Opened as the <strong>Northern Negros Emergency Hospital</strong> to serve the post-war community.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="timeline-card">
                    <div class="year">1964</div>
                    <p>Declared a <strong>National Hospital</strong> under RA No. 4014, named after Congressman Vicente F. Gustilo.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="timeline-card">
                    <div class="year">2008</div>
                    <p>The <strong>modernized district building</strong> was inaugurated to expand capacity and services.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="timeline-card green-top">
                    <div class="year">Today</div>
                    <p>Now a premier <strong>Provincial Government-run</strong> facility for Negros Occidental.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── CONTACT ──────────────────────────────────── -->
<section id="contact" class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <p class="section-label">Reach Out</p>
                <h2 style="font-size:clamp(1.8rem,4vw,2.5rem);margin-bottom:32px;">Get in Touch</h2>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6>Location</h6>
                        <p>Brgy. Hda. Fe, Escalante City, Negros Occidental, 6124.</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6>Phone Number</h6>
                        <p>+63 (034) 123-4567</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact-card">
                    <h4>Send us a Message</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-teal w-100 py-3">Submit Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───── FOOTER ───────────────────────────────────── -->
<footer>
    <div class="container text-center">
        <div class="brand">VGDH</div>
        <p>&copy; 2026 Vicente Gustilo District Hospital. All Rights Reserved.</p>
        <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
        </div>
    </div>
</footer>

<!-- ───── LOGIN MODAL ──────────────────────────────── -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-heading">
                    <h3 id="loginModalLabel">Portal Selection</h3>
                    <p>Choose your access type to continue</p>
                </div>

                <a href="patient_register.php" class="portal-card">
                    <div class="p-icon" style="background:var(--cream)">
                        <i class="bi bi-person-circle" style="color:var(--teal)"></i>
                    </div>
                    <div>
                        <h6>Patient Portal</h6>
                        <small>Book appointments &amp; view records</small>
                    </div>
                    <i class="bi bi-arrow-right ms-auto" style="color:var(--teal)"></i>
                </a>

                <a href="staff_login.php" class="portal-card">
                    <div class="p-icon" style="background:#f1f5f9">
                        <i class="bi bi-shield-lock" style="color:#334155"></i>
                    </div>
                    <div>
                        <h6>Staff Portal</h6>
                        <small>Manage hospital operations</small>
                    </div>
                    <i class="bi bi-arrow-right ms-auto" style="color:var(--muted)"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>