<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f4f4; padding:20px;">

    <div style="max-width:600px; margin:auto; background:white; padding:20px; border-radius:8px;">
        
        <h2 style="color:#333;">Reset Password</h2>

        <p>Halo <strong>{{ $username }}</strong>,</p>

        <p>Kami menerima permintaan untuk mereset password akun kamu.</p>

        <p>Gunakan kode di bawah ini:</p>

        <div style="text-align:center; margin:30px 0;">
            <span style="font-size:32px; letter-spacing:5px; font-weight:bold; color:#2d89ef;">
                {{ $code }}
            </span>
        </div>

        <p>Kode ini berlaku selama <strong>5 menit</strong>.</p>

        <p>Jika kamu tidak meminta reset password, abaikan email ini.</p>

        <hr>

        <p style="font-size:12px; color:#888;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

</body>
</html>