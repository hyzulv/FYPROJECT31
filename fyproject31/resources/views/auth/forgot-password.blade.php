<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - MAT ROCK Restaurant</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icons/restaurant-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #FFFFFF;
            color: #222222;
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
                radial-gradient(circle at 20% 50%, rgba(66, 12, 9, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(66, 12, 9, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(66, 12, 9, 0.05) 0%, transparent 50%);
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
            background: #FFFFFF;
            border: 2px solid #420C09;
            border-radius: 20px; padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(66, 12, 9, 0.12);
        }
        .header { text-align: center; margin-bottom: 30px; }
        .logo {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #420C09, #300806);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 15px; font-size: 2rem;
        }
        .header h1 { color: #420C09; font-size: 1.5rem; margin-bottom: 8px; }
        .header p { color: #666; font-size: 0.9rem; }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; color: #420C09; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-wrapper .icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; opacity: 0.5; }
        .form-group input {
            width: 100%; padding: 14px 15px 14px 45px; background: #f5f5f5;
            border: 1px solid #ddd; border-radius: 10px;
            color: #222222; font-size: 1rem; transition: all 0.3s ease;
        }
        .form-group input::placeholder { color: #999; }
        .form-group input:focus {
            outline: none; border-color: #420C09; background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(66, 12, 9, 0.1);
        }
        .btn {
            width: 100%; padding: 14px;
            background: #420C09;
            border: none; border-radius: 10px; color: #FFFFFF;
            font-size: 1.05rem; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease; letter-spacing: 0.5px;
        }
        .btn:hover {
            background: #300806;
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(66, 12, 9, 0.3);
        }
        .back-link { display: block; text-align: center; margin-top: 20px; }
        .back-link a { color: #420C09; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease; }
        .back-link a:hover { color: #300806; }
        .error-message {
            background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;
        }
        .success-message {
            background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;
        }
        .info-box {
            background: rgba(66, 12, 9, 0.04); border: 1px solid rgba(66, 12, 9, 0.12);
            border-radius: 10px; padding: 15px; margin-bottom: 25px;
        }
        .info-box p { color: #666; font-size: 0.85rem; line-height: 1.5; }
        .success-steps {
            background: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40, 167, 69, 0.15);
            border-radius: 10px; padding: 15px; margin-top: 20px;
        }
        .success-steps h4 { color: #28a745; margin-bottom: 10px; }
        .success-steps ol { color: #666; font-size: 0.85rem; line-height: 1.8; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>

    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">🔑</div>
                <h1>Forgot Password?</h1>
                <p>Enter your email to receive a reset link</p>
            </div>

            @if(session('status'))
            <div class="success-message">{{ session('status') }}</div>
            <div class="success-steps">
                <h4>Next Steps:</h4>
                <ol>
                    <li>Check your email inbox (and spam folder)</li>
                    <li>Click the password reset link in the email</li>
                    <li>Set a new password</li>
                    <li>Return to login page</li>
                </ol>
            </div>
            @endif

            @if($errors->any())
            <div class="error-message">{{ $errors->first() }}</div>
            @endif

            <div class="info-box">
                <p>We will send a password reset link to your registered Gmail address. Click the link in the email to reset your password.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <span class="icon">📧</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required>
                    </div>
                </div>

                <button type="submit" class="btn">Send Reset Link</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">← Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
