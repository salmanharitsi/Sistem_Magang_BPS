<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Magang Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Pengajuan Magang Disetujui</h2>
        <p>Halo <strong>{{ $pengajuan->name }}</strong>,</p>
        <p>Selamat! Pengajuan magang Anda telah disetujui. Berikut detail magang Anda:</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #48bb78;">
            <p><strong>Bidang Tujuan:</strong> {{ $magang->bidang_tujuan }}</p>
            <p><strong>Jenis Magang:</strong> {{ $magang->jenis_magang }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ date('d F Y', strtotime($magang->tanggal_mulai)) }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ date('d F Y', strtotime($magang->tanggal_selesai)) }}</p>
            <p><strong>Pembimbing Pertama:</strong> {{ $pembimbing1->name ?? 'Belum ditentukan' }}</p>
            @if($pembimbing2)
            <p><strong>Pembimbing Kedua:</strong> {{ $pembimbing2->name ?? 'Belum ditentukan' }}</p>
            @endif
        </div>
        
        <p>Silakan datang pada tanggal mulai magang yang telah ditentukan dan laporkan kehadiran Anda kepada pembimbing.</p>
        
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