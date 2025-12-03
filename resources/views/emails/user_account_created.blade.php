<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>
<body>

    <h2>Hello {{ $user->name }},</h2>

    <p>Your user account has been created successfully. Below are your login details:</p>

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Temporary Password:</strong> {{ $plainPassword }}</p>

    <p>Please log in and change your password immediately.</p>

    <p>Regards,<br>{{ config('app.name') }}</p>

</body>
</html>
