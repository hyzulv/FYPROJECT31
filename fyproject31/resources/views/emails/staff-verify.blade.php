<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Welcome to Mat Rock Restaurant!</h2>
    <p>Hi {{ $user->name }},</p>
    <p>Your staff account has been created. Please verify your email address by clicking the button below:</p>
    <p>
        <a href="{{ $url }}"
           style="background-color: #420C09; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Verify Email Address
        </a>
    </p>
    <p>If you did not create this account, no further action is required.</p>
    <br>
    <p>Regards,<br>Mat Rock Restaurant</p>
</body>
</html>
