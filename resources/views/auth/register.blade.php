@extends('layouts.authLayout')
@section('title', 'ALAR Memorial - Register')

<body>
    <div class="register-container">
        <div class="register-left">
            <div class="logo">
                <img src="{{ asset('images/alar-logo.png') }}" alt="Alar Memorial Services Logo"
                    style="max-width: 100%; height: auto; border-radius:10px">
            </div>
            <p class="tagline">Honoring lives with dignity, respect, and everlasting memories.</p>
        </div>

        <div class="register-right">
            <h1 class="welcome-text">Create Account</h1>
            <p class="subtitle">Fill in your details to get started</p>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="row">
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <input type="email" name="email" placeholder="Email (optional)">
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <div class="row">
                    <select name="gender" required>
                        <option value="" disabled selected>Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    <input type="date" name="birthdate" required>
                </div>

                <button type="submit" class="register-btn">Create Account</button>
            </form>

            <div class="login-link">
                Already have an account?
                <a href="{{ route('login') }}">Login to your account</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('focus', () => input.style.transform = 'scale(1.02)');
                input.addEventListener('blur', () => input.style.transform = 'scale(1)');
            });

            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('.register-btn');
                const originalText = btn.textContent;
                btn.textContent = 'Creating account...';
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
</body>


