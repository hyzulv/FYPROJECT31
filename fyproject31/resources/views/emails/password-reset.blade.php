<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <h2>Password Reset Request</h2>
    <p>Hi {{ $user->name }},</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        <a href="{{ url('reset-password/' . $token . '?email=' . urlencode($email)) }}"
           style="background-color: #420C09; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Reset Password
        </a>
    </p>
    <p>This password reset link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    <br>
    <p>Regards,<br>Mat Rock Restaurant</p>
</body>
</html>
