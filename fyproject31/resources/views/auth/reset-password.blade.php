<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MAT ROCK Restaurant</title>
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
                radial-gradient(circle at 20% 50%, rgba(207, 44, 33, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(207, 44, 33, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(207, 44, 33, 0.06) 0%, transparent 50%);
            z-index: 0;
        }
        .container {
            position: relative; z-index: 1; width: 100%; max-width: 420px; padding: 20px;
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card {
            background: linear-gradient(145deg, #1a1a1a, #111111);
            border: 1px solid rgba(207, 44, 33, 0.3);
            border-radius: 20px; padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .header { text-align: center; margin-bottom: 30px; }
        .logo {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #cf2c21, #a8231a);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 15px; font-size: 2rem;
        }
        .header h1 { color: #cf2c21; font-size: 1.5rem; margin-bottom: 8px; }
        .header p { color: #888; font-size: 0.9rem; }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; color: #cf2c21; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; opacity: 0.6; }
        .input-wrapper .toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; cursor: pointer; opacity: 0.6; user-select: none; }
        .input-wrapper .toggle-password:hover { opacity: 1; }
        .form-group input {
            width: 100%; padding: 14px 15px 14px 45px; background: #2a2a2a;
            border: 1px solid rgba(207, 44, 33, 0.2); border-radius: 10px;
            color: #ffffff; font-size: 1rem; transition: all 0.3s ease;
        }
        .form-group input::placeholder { color: #666; }
        .form-group input:focus {
            outline: none; border-color: #cf2c21; background: #333333;
            box-shadow: 0 0 0 3px rgba(207, 44, 33, 0.1);
        }
        .btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #cf2c21, #a8231a);
            border: none; border-radius: 10px; color: #000000;
            font-size: 1.05rem; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: linear-gradient(135deg, #dc362a, #cf2c21);
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(207, 44, 33, 0.3);
        }
        .error-message {
            background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;
        }
        .back-link { display: block; text-align: center; margin-top: 20px; }
        .back-link a { color: #cf2c21; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease; }
        .back-link a:hover { color: #ffffff; }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>

    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">🔐</div>
                <h1>Reset Password</h1>
                <p>Enter your new password</p>
            </div>

            @if($errors->any())
            <div class="error-message">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <span class="icon">📧</span>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-wrapper">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="New password (min 6 characters)" required>
                        <img src="{{ asset('show_password.png') }}" id="toggle-password-icon" class="toggle-password" onclick="togglePassword('password', 'toggle-password-icon')" style="width: 20px; filter: brightness(0) invert(1);">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="icon">🔒</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                        <img src="{{ asset('show_password.png') }}" id="toggle-confirm-icon" class="toggle-password" onclick="togglePassword('password_confirmation', 'toggle-confirm-icon')" style="width: 20px; filter: brightness(0) invert(1);">
                    </div>
                </div>

                <button type="submit" class="btn">Reset Password</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">← Back to Login</a>
            </div>
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
    </script>
</body>
</html>
