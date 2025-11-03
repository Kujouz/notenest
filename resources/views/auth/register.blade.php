@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: radial-gradient(circle at top left, #4030a0, #171d74);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 430px;
        }

        .register-header {
            background: linear-gradient(135deg, #c71d1d, #3a0ca3);
            color: white;
            text-align: center;
            padding: 35px 20px 25px;
        }

        .register-header img {
            width: 60px;
            margin-bottom: 10px;
        }

        .register-header h3 {
            font-weight: 700;
            font-size: 1.6rem;
            color: #ffdf4a;
            margin-bottom: 5px;
        }

        .register-header small {
            color: #f1f1f1;
            font-weight: 500;
        }

        .register-body {
            padding: 35px 30px 30px;
        }

        .register-body h4 {
            color: #2f307f;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #2f307f;
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .input-group-text {
            background-color: #ffdf4a;
            border: none;
            color: #333;
            font-weight: 600;
            border-radius: 10px 0 0 10px;
        }

        .btn-register {
            background: linear-gradient(135deg, #2f307f, #c71d1d);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
        }

        .login-text {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .login-text a {
            color: #c71d1d;
            font-weight: 600;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .password-strength {
            height: 6px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #ff4d4d, #ff9505, #4bb543);
            transition: width 0.3s ease;
            border-radius: 6px;
        }
    </style>

    <div class="register-container">
        <div class="register-card">
            <!-- HEADER -->
            <div class="register-header">
                <img src="{{ asset('images/notenest.png') }}" alt="NoteNest Logo">
                <h3>Note-Nest</h3>
                <small>Share & Discover Knowledge</small>
            </div>

            <!-- BODY -->
            <div class="register-body">
                <h4>Create Your Account</h4>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- ID Number -->
                    <div class="mb-3">
                        <label for="id_number" class="form-label fw-semibold">ID Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input id="id_number" type="text" class="form-control @error('id_number') is-invalid @enderror"
                                name="id_number" value="{{ old('id_number') }}" placeholder="e.g. 19DDT23F1072 or TCH001"
                                required>
                            @error('id_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Create a password"
                                required>
                            <button type="button" class="input-group-text password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Password strength bar -->
                        <div class="password-strength mt-2">
                            <div id="passwordStrengthBar" class="password-strength-bar"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Enter a password</small>

                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                placeholder="Re-enter password" required>
                            <button type="button" class="input-group-text password-toggle"><i
                                    class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus me-2"></i> Create Account
                    </button>

                    <div class="login-text mt-3">
                        Already have an account? <a href="{{ route('login') }}">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const strengthBar = document.getElementById("passwordStrengthBar");
            const strengthText = document.getElementById("passwordStrengthText");

            const toggleButtons = document.querySelectorAll('.password-toggle');
            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.closest('.input-group').querySelector('input');
                    const icon = this.querySelector('i');
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.replace("fa-eye", "fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.replace("fa-eye-slash", "fa-eye");
                    }
                });
            });

            passwordInput.addEventListener("input", function () {
                const val = passwordInput.value;
                let strength = 0;

                if (val.length >= 8) strength += 25;
                if (/[A-Z]/.test(val)) strength += 25;
                if (/[0-9]/.test(val)) strength += 25;
                if (/[^A-Za-z0-9]/.test(val)) strength += 25;

                strengthBar.style.width = strength + "%";

                if (strength < 25) {
                    strengthBar.style.background = "#ff4d4d";
                    strengthText.textContent = "Very Weak";
                    strengthText.className = "text-danger small";
                } else if (strength < 50) {
                    strengthBar.style.background = "#ff9505";
                    strengthText.textContent = "Weak";
                    strengthText.className = "text-warning small";
                } else if (strength < 75) {
                    strengthBar.style.background = "#ffc107";
                    strengthText.textContent = "Good";
                    strengthText.className = "text-info small";
                } else {
                    strengthBar.style.background = "#4bb543";
                    strengthText.textContent = "Strong";
                    strengthText.className = "text-success small";
                }
            });
        });
    </script>

@endsection
