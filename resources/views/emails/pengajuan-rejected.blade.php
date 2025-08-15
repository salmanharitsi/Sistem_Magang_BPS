<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Magang Ditolak</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Pengajuan Magang Ditolak</h2>
        <p>Halo <strong>{{ $pengajuan->name }}</strong>,</p>
        <p>Mohon maaf, pengajuan magang Anda belum dapat disetujui.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #e53e3e;">
            <p><strong>Bidang Tujuan:</strong> {{ $pengajuan->bidang_tujuan }}</p>
            <p><strong>Jenis Magang:</strong> {{ $pengajuan->jenis_magang }}</p>
            <p><strong>Alasan Penolakan:</strong> {{ $pengajuan->komentar }}</p>
        </div>
        
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/login') }}"
                style="background: #1c64f2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Login ke Sistem
            </a>
        </div>
        
        <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi departemen kami melalui informasi kontak yang tersedia di sistem.</p>
        
        <p>Terima kasih,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>