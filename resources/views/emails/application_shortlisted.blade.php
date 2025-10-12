<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Shortlisted</title>
</head>
<body>
    <h2>Dear {{ $application->name }},</h2>

    <p>Congratulations! You have been <strong>shortlisted</strong> for the position of
        <strong>{{ $application->vacancy->title ?? 'the advertised role' }}</strong>.</p>

    <p>Our HR team will contact you soon with details about the next stage of the recruitment process.</p>

    <p>Best regards,<br>
    <strong>The HR Team</strong><br>
    {{ config('app.name') }}</p>
</body>
</html>
