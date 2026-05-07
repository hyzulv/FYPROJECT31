<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MAT ROCK Restaurant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000000;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .bg-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(209, 152, 106, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(209, 152, 106, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(209, 152, 106, 0.06) 0%, transparent 50%);
            z-index: 0;
        }
        .login-container {
            position: relative; z-index: 1; width: 100%; max-width: 420px; padding: 20px;
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-card {
            background: linear-gradient(145deg, #1a1a1a, #111111);
            border: 1px solid rgba(209, 152, 106, 0.3);
            border-radius: 20px; padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .login-header { text-align: center; margin-bottom: 35px; }
        .login-logo {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #d1986a, #b8834f);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 15px; font-size: 2rem;
        }
        .login-header h1 { color: #d1986a; font-size: 1.8rem; margin-bottom: 8px; letter-spacing: 1px; }
        .login-header p { color: #888; font-size: 0.95rem; }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; color: #d1986a; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; opacity: 0.6; }
        .input-wrapper .toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; cursor: pointer; opacity: 0.6; user-select: none; }
        .input-wrapper .toggle-password:hover { opacity: 1; }
        .form-group input {
            width: 100%; padding: 14px 15px 14px 45px; background: #2a2a2a;
            border: 1px solid rgba(209, 152, 106, 0.2); border-radius: 10px;
            color: #ffffff; font-size: 1rem; transition: all 0.3s ease;
        }
        .form-group input::placeholder { color: #666; }
        .form-group input:focus {
            outline: none; border-color: #d1986a; background: #333333;
            box-shadow: 0 0 0 3px rgba(209, 152, 106, 0.1);
        }
        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .remember-me { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .remember-me input[type="checkbox"] { accent-color: #d1986a; width: 16px; height: 16px; cursor: pointer; }
        .remember-me span { color: #aaa; font-size: 0.9rem; }
        .forgot-password { color: #d1986a; font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease; }
        .forgot-password:hover { color: #ffffff; }
        .login-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #d1986a, #b8834f);
            border: none; border-radius: 10px; color: #000000;
            font-size: 1.05rem; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease; letter-spacing: 0.5px;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #e0a97c, #d1986a);
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(209, 152, 106, 0.3);
        }
        .login-btn:active { transform: translateY(0); }
        .back-link { display: block; text-align: center; margin-top: 25px; }
        .back-link a { color: #888; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease; }
        .back-link a:hover { color: #d1986a; }
        .error-message {
            background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545; padding: 12px; border-radius: 8px; margin-bottom: 20px;
            font-size: 0.9rem; text-align: center;
        }
        .success-message {
            background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745; padding: 12px; border-radius: 8px; margin-bottom: 20px;
            font-size: 0.9rem; text-align: center;
        }
        @media (max-width: 480px) {
            .login-card { padding: 30px 25px; }
            .login-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">🍽️</div>
                <h1>MAT ROCK</h1>
                <p>Sign in to your account</p>
            </div>

            @if(session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <span class="icon">👤</span>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Enter your username" required autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="off">
                        <img src="{{ asset('show_password.png') }}" id="toggle-password-icon" class="toggle-password" onclick="togglePassword('password', 'toggle-password-icon')" style="width: 20px; cursor: pointer; opacity: 0.6; position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="rememberCheck" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>

        <div class="back-link">
            <a href="/">← Back to Homepage</a>
        </div>
    </div>

    <script>
    function togglePassword(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.src = "{{ asset('hide_password.png') }}";
        } else {
            input.type = 'password';
            icon.src = "{{ asset('show_password.png') }}";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var usernameInput = document.getElementById('username');
        var passwordInput = document.getElementById('password');
        var rememberCheck = document.getElementById('rememberCheck');

        var savedUsername = localStorage.getItem('remember_username');
        var savedPassword = localStorage.getItem('remember_password');
        var wasRemembered = localStorage.getItem('remember_me') === 'true';

        if (wasRemembered && savedUsername) {
            usernameInput.value = savedUsername;
            passwordInput.value = savedPassword || '';
            rememberCheck.checked = true;
        }

        document.querySelector('form').addEventListener('submit', function() {
            if (rememberCheck.checked) {
                localStorage.setItem('remember_username', usernameInput.value);
                localStorage.setItem('remember_password', passwordInput.value);
                localStorage.setItem('remember_me', 'true');
            } else {
                localStorage.removeItem('remember_me');
                localStorage.removeItem('remember_username');
                localStorage.removeItem('remember_password');
            }
        });
    });
    </script>
</body>
</html>
