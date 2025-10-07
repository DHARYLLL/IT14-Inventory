<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALAR Memorial - Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/auth-login.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            height: 600px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(to bottom right, #6ABD3A, #8DD163);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: 100% 100%;
        }

        .logo {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 3px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .tagline {
            font-size: 18px;
            font-weight: 300;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 30px;
        }

        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-text {
            font-size: 24px;
            color: #4a4a4a;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .login-form {
            width: 100%;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #6ABD3A;
            box-shadow: 0 0 0 2px rgba(106, 189, 58, 0.2);
        }

        .login-btn {
            background: #6ABD3A;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            box-shadow: 0 4px 6px rgba(106, 189, 58, 0.2);
        }

        .login-btn:hover {
            background: #5aa330;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(106, 189, 58, 0.3);
        }

        .signup-link {
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 35px;
            line-height: 1.8;
        }

        .signup-link a {
            display: block;
            color: #6ABD3A;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .signup-link a:hover {
            color: #4a9030;
            text-decoration: underline;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }

            .login-left {
                order: 2;
                min-height: 300px;
            }

            .login-right {
                order: 1;
            }
        }

        @media (max-width: 480px) {

            .login-left,
            .login-right {
                padding: 30px;
            }

            .logo {
                font-size: 36px;
            }

            .tagline {
                font-size: 16px;
            }
        }
    </style>
</head>

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

            <form method="POST" action="{{ route('login.post') }}">
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

            <div class="signup-link">
                Don’t have an account?
                <a href="{{ route('register') }}">Sign up now</a>
            </div>
        </div>
    </div>

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
</body>

</html>
