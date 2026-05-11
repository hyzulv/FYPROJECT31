<!DOCTYPE html>
<html>
<head><title>Contact Message</title></head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px;">
        <h2 style="color: #420C09;">New Contact Message</h2>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Message:</strong></p>
        <p style="background: #f9f9f9; padding: 15px; border-radius: 5px;">{{ $userMessage }}</p>
        <hr>
        <p style="color: #888; font-size: 12px;">This email was sent from MAT ROCK Restaurant contact form.</p>
    </div>
</body>
</html>
