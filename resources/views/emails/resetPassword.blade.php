<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Reset Password</h2>
        <p>Halo {{ $user->name }},</p>
        <p>Kami menerima permintaan untuk reset password akun Anda.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #1c64f2;">
            <h3 style="margin-top: 0;">Reset Password</h3>
            <p>Klik tombol di bawah ini untuk melanjutkan proses reset password.</p>
            <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('reset/'.$user->remember_token) }}"
                style="background: #1c64f2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Reset Password
            </a>
        </div>
        
        <p>Salam,<br>{{ config('app.name') }}</p>
        
        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 12px; color: #666; text-align: center;">
            © {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>