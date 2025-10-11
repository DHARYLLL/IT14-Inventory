@extends('layouts.authLayout')
@section('title', 'ALAR Memorial - Sing In')

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo">
                <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo"
                    style="max-width: 100%; height: auto; border-radius:10px">
            </div>
            <p class="tagline">Honoring lives with dignity, respect, and everlasting memories.</p>
        </div>

        <div class="login-right">
            <h1 class="welcome-text">Sign In</h1>
            <p class="subtitle">Enter your credentials to access your account</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <button type="submit" class="login-btn">Sign In</button>
            </form>

            {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            const inputs = document.querySelectorAll('input');

            inputs.forEach(input => {
                input.addEventListener('focus', () => input.parentElement.style.transform = 'scale(1.02)');
                input.addEventListener('blur', () => input.parentElement.style.transform = 'scale(1)');
            });

            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('.login-btn');
                const originalText = btn.textContent;
                btn.textContent = 'Signing in...';
                btn.style.opacity = '0.8';
                btn.disabled = true;

                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.opacity = '1';
                    btn.disabled = false;
                }, 2000);
            });
        });
    </script>
--}}
</body>
