<!DOCTYPE html>
<html>
<head>
    <title>Your Email Has Been Updated</title>
</head>
<body>
    <h2>Email Update Notification</h2>
    <p>Hi {{ $user->name }},</p>
    <p>An administrator has updated your account email address to <strong>{{ $user->email }}</strong>.</p>
    <p>Please verify your new email address by clicking the button below:</p>
    <p>
        <a href="{{ $url }}"
           style="background-color: #420C09; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Verify Email Address
        </a>
    </p>
    <p>If you did not request this change, please contact the administrator immediately.</p>
    <br>
    <p>Regards,<br>Mat Rock Restaurant</p>
</body>
</html>
