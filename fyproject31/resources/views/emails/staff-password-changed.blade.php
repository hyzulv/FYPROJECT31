<!DOCTYPE html>
<html>
<head>
    <title>Your Password Has Been Updated</title>
</head>
<body>
    <h2>Password Update Notification</h2>
    <p>Hi {{ $user->name }},</p>
    <p>An administrator has changed your account password. Here are your updated login credentials:</p>
    <p>
        <strong>Username:</strong> {{ $user->username }}<br>
        <strong>New Password:</strong> {{ $password }}
    </p>
    <p>Please use the new password to log in to your account. For security reasons, we recommend changing your password after logging in.</p>
    <p>
        <a href="{{ route('login') }}"
           style="background-color: #420C09; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Log In Now
        </a>
    </p>
    <p>If you did not request this change, please contact the administrator immediately.</p>
    <br>
    <p>Regards,<br>Mat Rock Restaurant</p>
</body>
</html>
