<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALAR Memorial - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            height: 650px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .register-left {
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

        .register-left::before {
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

        .register-right {
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
            margin-bottom: 25px;
            font-size: 14px;
        }

        form {
            width: 100%;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #6ABD3A;
            box-shadow: 0 0 0 2px rgba(106, 189, 58, 0.2);
        }

        .register-btn {
            background: #6ABD3A;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            box-shadow: 0 4px 6px rgba(106, 189, 58, 0.2);
        }

        .register-btn:hover {
            background: #5aa330;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(106, 189, 58, 0.3);
        }

        .login-link {
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 25px;
            line-height: 1.8;
        }

        .login-link a {
            display: block;
            color: #6ABD3A;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #4a9030;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                height: auto;
            }

            .register-left {
                order: 2;
                min-height: 300px;
            }

            .register-right {
                order: 1;
            }
        }
    </style>
</head>

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

</html>
