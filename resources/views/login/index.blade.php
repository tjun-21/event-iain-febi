<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Febi Event</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Logo and Branding -->
            <div class="login-logo">
                <div class="logo-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h1 class="login-title">Febi Event</h1>
                <p class="login-subtitle">Welcome back! Please sign in to your account</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group has-label">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email address"
                        value="{{ old('email') }}"
                        required>
                    <i class="fas fa-envelope input-icon"></i>
                    @error('email')
                    <div class="field-error" style="color: #FF6B6B; font-size: 0.85rem; margin-top: 5px; font-weight: 500;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group has-label">
                    <label for="password" class="form-label">Password</label>
                    <input type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required>
                    <button type="button" class="password-toggle">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                    @error('password')
                    <div class="field-error" style="color: #FF6B6B; font-size: 0.85rem; margin-top: 5px; font-weight: 500;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    Sign In
                </button>

                <!-- Forgot Password -->
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>Or continue with</span>
            </div>

            <!-- Social Login -->
            <div class="social-login">
                <a href="#" class="btn-social google">
                    <i class="fab fa-google"></i>
                    Google
                </a>
                <a href="#" class="btn-social facebook">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </a>
            </div>

            <!-- Register Link -->
            <div class="register-link">
                Don't have an account?
                <a href="{{ route('register') }}">Sign up here</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>

    @stack('scripts')
</body>

</html>