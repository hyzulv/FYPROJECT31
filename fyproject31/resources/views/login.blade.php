<?php
session_start();

require_once __DIR__ . '/includes/staff_data.php';
staff_seed_if_missing();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $user = staff_find_user($username);

    if ($user && hash_equals((string)($user['password'] ?? ''), $password)) {
        $isVerified = !array_key_exists('emailVerified', $user) || !empty($user['emailVerified']);
        if (!$isVerified) {
            $token = staff_generate_verify_token();
            staff_set_user_verify_token($username, $token);
            $email = trim((string)($user['email'] ?? ''));
            staff_send_verification_email($email, $username, $token);
            $_SESSION['pending_verify_user'] = $username;
            header('Location: verify_email.php');
            exit();
        }
        $_SESSION['user'] = $username;
        $_SESSION['role'] = (string)($user['role'] ?? 'staff');
        header('Location: dashboard.php');
        exit();
    }
    $error_message = "Invalid username or password!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mat Rock - Staff Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 0, 0, 0.6);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        .particle:nth-child(1) { left: 10%; animation-duration: 12s; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-duration: 18s; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-duration: 15s; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-duration: 20s; animation-delay: 1s; }
        .particle:nth-child(5) { left: 50%; animation-duration: 14s; animation-delay: 3s; }
        .particle:nth-child(6) { left: 60%; animation-duration: 16s; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-duration: 13s; animation-delay: 2s; }
        .particle:nth-child(8) { left: 80%; animation-duration: 19s; animation-delay: 4s; }
        .particle:nth-child(9) { left: 90%; animation-duration: 17s; animation-delay: 1s; }

        @keyframes float {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) scale(1);
                opacity: 0;
            }
        }

        /* Main login container */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box {
            background: rgba(30, 30, 30, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo and header */
        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #FF0000, #CC0000);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.4);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 10px 30px rgba(255, 0, 0, 0.4);
            }
            50% {
                box-shadow: 0 10px 40px rgba(255, 0, 0, 0.6);
            }
        }

        .logo-container img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .login-header h1 {
            color: #FF0000;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-header h2 {
            color: #CCCCCC;
            font-size: 16px;
            font-weight: 400;
            margin-bottom: 0;
        }

        /* Error message */
        .error-message {
            background: rgba(255, 0, 0, 0.15);
            border: 1px solid rgba(255, 0, 0, 0.4);
            color: #FF6666;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            animation: shake 0.5s ease-in-out;
            display: <?php echo !empty($error_message) ? 'block' : 'none'; ?>;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Form styling */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        .input-group label {
            display: block;
            color: #FF0000;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            background: rgba(43, 43, 43, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #FFFFFF;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: #FF0000;
            background: rgba(43, 43, 43, 1);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.15);
        }

        .input-wrapper input::placeholder {
            color: #666666;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666666;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .input-wrapper input:focus ~ .input-icon {
            color: #FF0000;
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666666;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
            padding: 0;
        }

        .password-toggle:hover {
            color: #FF0000;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(255, 0, 0, 0.3);
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #FF1a1a 0%, #FF0000 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 5px 20px rgba(255, 0, 0, 0.3);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-footer p {
            color: #666666;
            font-size: 13px;
        }

        .login-footer a {
            color: #FF0000;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #FF6666;
        }

        /* Decorative elements */
        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 2px solid rgba(255, 0, 0, 0.3);
        }

        .corner-decoration.top-left {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
            border-radius: 20px 0 0 0;
        }

        .corner-decoration.top-right {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 20px 0 0;
        }

        .corner-decoration.bottom-left {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 20px;
        }

        .corner-decoration.bottom-right {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 20px 0;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-box {
                padding: 30px 25px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .logo-container img {
                width: 40px;
                height: 40px;
            }
        }

        /* Glow effect on hover */
        .login-box::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #FF0000, transparent, #FF0000, transparent, #FF0000);
            background-size: 400%;
            border-radius: 22px;
            z-index: -1;
            animation: glow 20s linear infinite;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .login-box:hover::before {
            opacity: 0.3;
        }

        @keyframes glow {
            0% { background-position: 0 0; }
            50% { background-position: 400% 0; }
            100% { background-position: 0 0; }
        }
    </style>
</head>
<body>
    <!-- Animated particles background -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <!-- Corner decorations -->
            <div class="corner-decoration top-left"></div>
            <div class="corner-decoration top-right"></div>
            <div class="corner-decoration bottom-left"></div>
            <div class="corner-decoration bottom-right"></div>

            <div class="login-header">
                <div class="logo-container">
                    <img src="restaurant-icon.png" alt="Mat Rock Logo">
                </div>
                <h1>MAT ROCK</h1>
                <h2>Staff / Admin Login</h2>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form class="login-form" action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username" 
                            required 
                            autocomplete="username"
                        >
                        <span class="input-icon">👤</span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            required 
                            autocomplete="current-password"
                        >
                        <span class="input-icon">🔒</span>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Login
                </button>
            </form>

            <div class="login-footer">
                <p><a href="#">Forgot Password?</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.innerHTML = '🔒';
            } else {
                passwordInput.type = 'password';
                toggleBtn.innerHTML = '👁️';
            }
        }

        // Add input focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('focused');
            });
        });

        // Auto-hide error message after 5 seconds
        setTimeout(() => {
            const errorMsg = document.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.style.transition = 'opacity 0.5s ease';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.style.display = 'none', 500);
            }
        }, 5000);
    </script>
</body>
</html>