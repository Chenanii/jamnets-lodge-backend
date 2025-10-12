<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Rejected</title>
</head>
<body>
    <h2>Dear {{ $application->name }},</h2>

    <p>Thank you for your interest in the position of
        <strong>{{ $application->vacancy->title ?? 'the advertised role' }}</strong>.</p>

    <p>We regret to inform you that your application was <strong>not successful</strong> at this time.</p>

    <p>We truly appreciate the time you took to apply and encourage you to apply for future opportunities with us.</p>

    <p>Wishing you all the best in your career endeavors.</p>

    <p>Kind regards,<br>
    <strong>The HR Team</strong><br>
    {{ config('app.name') }}</p>
</body>
</html>
