@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background: linear-gradient(135deg, #4b145b 0%, #c33c2d 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 80px);
        padding: 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        background: #fff;
    }

    .login-header {
        background: linear-gradient(135deg, #4b145b 0%, #c33c2d 100%);
        color: white;
        text-align: center;
        padding: 35px 20px 25px;
        border-bottom: 0;
    }

    .login-header img {
        width: 70px;
        margin-bottom: 10px;
    }

    .login-header h2 {
        font-weight: 700;
        font-size: 1.6rem;
    }

    .login-body {
        padding: 35px 30px 30px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #4b145b;
        box-shadow: 0 0 0 0.25rem rgba(75, 20, 91, 0.15);
    }

    .input-group-text {
        background-color: transparent;
        border: none;
        color: #555;
    }

    .btn-login {
        background: linear-gradient(90deg, #ffd86a, #ff512f);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        color: #333;
        padding: 12px;
        transition: 0.3s;
        width: 100%;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
    }

    .forgot-link {
        font-size: 0.9rem;
        text-decoration: none;
        color: #4b145b;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .register-text {
        text-align: center;
        margin-top: 15px;
        font-size: 0.95rem;
    }

    .register-text a {
        color: #4b145b;
        font-weight: 600;
        text-decoration: none;
    }

    .register-text a:hover {
        text-decoration: underline;
    }

    footer {
        text-align: center;
        color: white;
        font-size: 0.9rem;
        margin-top: 20px;
    }

    footer span {
        color: #ffdd55;
        font-weight: 700;
    }

    .password-toggle {
        cursor: pointer;
        color: #666;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/notenest.png') }}" alt="NoteNest Logo">
            <div>Access your notes and resources</div>
        </div>

        <div class="login-body">
            <h4 class="text-center fw-bold text-primary mb-2">Welcome</h4>
            <p class="text-center text-muted mb-4">Sign in to continue to your account</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               placeholder="Enter your email" required autofocus>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" placeholder="Enter your password" required>
                        <span class="input-group-text password-toggle" id="togglePassword"><i class="fas fa-eye"></i></span>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>

                <div class="register-text">
                    Don’t have an account? <a href="{{ route('register') }}">Register now</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
