<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Accepted</title>
</head>
<body>
    <h2>Dear {{ $application->name }},</h2>

    <p>We are pleased to inform you that your application for the position of
        <strong>{{ $application->vacancy->title ?? 'the advertised role' }}</strong> has been <strong>accepted</strong>.</p>

    <p>Our team will contact you soon with further details. Congratulations once again!</p>

    <p>Best regards,<br>
    <strong>The HR Team</strong><br>
    {{ config('app.name') }}</p>
</body>
</html>
