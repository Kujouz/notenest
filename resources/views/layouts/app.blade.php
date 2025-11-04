<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Note-Nest') }}</title>

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Global Red/Blue Theme -->
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, var(--blue), var(--red));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-custom .navbar-brand img {
            height: 45px;
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar-custom .nav-link:hover {
            color: var(--yellow) !important;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--blue), var(--red));
            color: white;
            padding: 20px 0;
            margin-top: auto;
            text-align: center;
            font-weight: 500;
        }

        footer span {
            color: var(--yellow);
            font-weight: 700;
            text-shadow: 0 0 8px rgba(254, 236, 87, 0.7);
        }

        /* Chatbot button */
        .chatbot-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--red);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            z-index: 1050;
        }

        .chatbot-toggle:hover {
            background: var(--blue);
            transform: scale(1.05);
        }

        /* Chatbot Offcanvas */
        .offcanvas-custom {
            width: 500px;
            background: #fff;
            border-left: 3px solid var(--red);
        }

        .offcanvas-header {
            background: linear-gradient(135deg, var(--blue), var(--red));
            color: white;
        }

        /* Premium Navbar Styling */
        .navbar {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .btn {
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-warning {
            background: #ffd700;
            color: #000;
            border: none;
        }

        .btn-warning:hover {
            background: #ffc107;
        }

        .btn-outline-light {
            border-color: #ffffff;
            color: #ffffff;
        }

        .btn-outline-light:hover {
            background: #ffffff;
            color: #212529;
        }

        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            margin: 0.25rem;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #212529;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .d-md-inline {
                display: none !important;
            }

            .btn-sm {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Global Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3"
        style="background: linear-gradient(135deg, #2f307f, #dd3226); box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/notenest.png') }}" alt="Note-Nest Logo" height="45">
                <span class="fw-bold">Note-Nest</span>
            </a>

            <!-- Right Side: Buttons + Profile Dropdown -->
            <div class="d-flex align-items-center gap-2">
                @guest
                    <!-- Show only Login and Register on login page -->
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                @endguest

                @auth
                    <!-- Show Dashboard, Quiz Page, Assignments, and Profile Dropdown for logged-in users -->
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm px-3 fw-semibold me-2"
                        style="border-radius: 8px; font-size: 0.9rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>

                    <a href="{{ route('quizzes.index') }}" class="btn btn-warning btn-sm px-3 fw-semibold me-2"
                        style="border-radius: 8px; font-size: 0.9rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <i class="fas fa-clipboard-list me-1"></i>Quiz Page
                    </a>

                    @if(auth()->user()->role === 'teacher')
                        <a href="{{ route('assignments.index') }}" class="btn btn-outline-light btn-sm px-3 fw-semibold me-2"
                            style="border-radius: 8px; font-size: 0.9rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <i class="fas fa-tasks me-1"></i>Assignments
                        </a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.9rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture"
                                    style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; font-weight: bold;">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end"
                            style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); min-width: 200px;">
                            <li><a class="dropdown-item" href="profile" style="font-size: 0.9rem;"><i
                                        class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings" style="font-size: 0.9rem;"><i
                                        class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><a class="dropdown-item" href="help" style="font-size: 0.9rem;"><i
                                        class="fas fa-question-circle me-2"></i>Help Center</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="font-size: 0.9rem;">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer>
        <p class="m-0">in collaboration with <span>GIATMARA MUADZAM SHAH</span></p>
    </footer>

    <!-- Chatbot -->
    @auth
        <button class="chatbot-toggle" data-bs-toggle="offcanvas" data-bs-target="#chatBotSidebar">
            <i class="fas fa-robot"></i>
        </button>

        <div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="chatBotSidebar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">
                    <i class="fas fa-robot me-2"></i>Note-Nest AI Assistant
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body p-0">
                @php
                    $username = urlencode(Auth::user()->name ?? 'Guest');
                @endphp

                <iframe id="JotFormIFrame-AI" title="Note-Nest AI Assistant" allowtransparency="true"
                    allow="geolocation; microphone; camera; fullscreen"
                    src="https://agent.jotform.com/0199c71f56fa7ad0b73300d27f16df668ffb?embedMode=iframe&background=1&shadow=1&user_name={{ $username }}"
                    frameborder="0" style="max-width:100%; height:650px; border:none; width:100%;"></iframe>

                <script src="https://cdn.jotfor.ms/s/umd/latest/for-form-embed-handler.js"></script>
                <script>
                    window.jotformEmbedHandler("iframe[src*='jotform']", "https://www.jotform.com");
                </script>
            </div>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
