<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Note-Nest | Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --blue: #2f307f;
            --red: #dd3226;
            --yellow: #feec57;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
            color: var(--dark);
            scroll-behavior: smooth;
        }

        .navbar {
            background: linear-gradient(135deg, var(--blue), var(--red));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            display: flex;
            align-items: center;
            font-size: 1.4rem;
            gap: 8px;
        }

        .navbar-brand img {
            height: 50px;
        }

        header {
            text-align: center;
            padding: 160px 20px 120px;
            background:
                linear-gradient(rgba(47, 48, 127, 0.7), rgba(221, 50, 38, 0.6)),
                url("{{ asset('images/BACKGROUND VIEWER.jpg') }}") center/cover no-repeat;
            background-attachment: fixed;
            color: white;
            position: relative;
            overflow: hidden;
        }

        header::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
            z-index: 0;
        }

        header h1,
        header h2,
        header p,
        header a,
        header img {
            position: relative;
            z-index: 1;
        }

        .giatmara-center-logo {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.3s ease;
        }

        .giatmara-center-logo:hover {
            transform: scale(1.05);
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 900;
            background: linear-gradient(90deg, var(--yellow), var(--blue), var(--red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            -webkit-text-stroke: 1px black;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6), 0 0 20px rgba(47, 48, 127, 0.5);
        }

        header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #fff;
            opacity: 0.95;
            margin-bottom: 15px;
        }

        header p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .btn-login {
            background: var(--yellow);
            color: var(--blue);
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 25px;
            transition: 0.3s;
            border: none;
        }

        .btn-login:hover {
            background: var(--red);
            color: white;
            transform: translateY(-3px);
        }

        #features {
            background: #fff;
            padding: 80px 0;
        }

        .card-icon {
            font-size: 3rem;
            color: var(--blue);
        }

        #features h5 {
            color: var(--red);
            font-weight: 700;
            margin-top: 15px;
        }

        #features p {
            color: #6c757d;
        }

        .feature-card {
            transition: all 0.3s ease;
            padding: 25px;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 5px solid var(--blue);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            border-top-color: var(--red);
        }

        .about-section {
            background: var(--light);
            padding: 60px 20px;
            text-align: center;
        }

        .about-section h3 {
            color: var(--blue);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .about-section p {
            max-width: 700px;
            margin: 0 auto;
            color: #6c757d;
            font-size: 1.1rem;
        }

        footer {
            background: linear-gradient(135deg, var(--blue), var(--red));
            color: white;
            padding: 25px;
            text-align: center;
            font-weight: 500;
        }

        footer span {
            color: var(--yellow);
            font-weight: 700;
            text-shadow: 0 0 8px rgba(254, 236, 87, 0.7);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            header h2 {
                font-size: 1.3rem;
            }

            .giatmara-center-logo {
                width: 120px;
            }

            .card-icon {
                font-size: 2rem;
            }

            header {
                background-attachment: scroll;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/notenest.png') }}" alt="Note-Nest Logo">
                Note-Nest
            </a>
            <div class="ms-auto">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-login">
                        <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header>
        <img src="{{ asset('images/GMMS_LOGO.png') }}" alt="GIATMARA Logo" class="giatmara-center-logo">
        <h1 class="hero-title">Welcome to Note-Nest</h1>
        <h2>Your All-in-One Academic Note Sharing and Organization System</h2>
        <p>Empowering teachers and students to share, organize, and access notes effortlessly.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-login btn-lg">
                <i class="fas fa-arrow-right-to-bracket me-2"></i>Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-login btn-lg">
                <i class="fas fa-arrow-right-to-bracket me-2"></i>Get Started
            </a>
        @endauth
    </header>

    <!-- FEATURES -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-card">
                        <i class="fas fa-folder-open card-icon mb-3"></i>
                        <h5>Organised Folders</h5>
                        <p>Teachers create subject folders and upload notes in one click.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-card">
                        <i class="fas fa-download card-icon mb-3"></i>
                        <h5>Instant Download</h5>
                        <p>Students download PDF, DOCX, PPT files straight from any folder.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-card">
                        <i class="fas fa-robot card-icon mb-3"></i>
                        <h5>AI Chat Bot</h5>
                        <p>Ask questions about any note — our AI answers instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <div class="about-section">
        <h3>About Note-Nest</h3>
        <p>
            <strong>Note-Nest</strong> helps students and teachers stay connected through a digital
            learning space where sharing and collaboration are effortless.
        </p>
    </div>

    <!-- Footer -->
    <footer>
        <p class="m-0">in collaboration with <span>GIATMARA MUADZAM SHAH</span></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
