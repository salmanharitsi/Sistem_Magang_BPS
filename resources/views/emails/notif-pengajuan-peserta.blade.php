<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Magang Berhasil Dikirim</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Pengajuan Magang Berhasil Dikirim</h2>
        <p>Halo, <strong>{{ $userName }}</strong>,</p>
        <p>Terima kasih telah mengajukan program magang di BPS Provinsi Riau.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Detail Pengajuan Magang</h3>
            <p><strong>Jenis Magang:</strong> {{ $jensMagang }}</p>
            <p><strong>Bidang Tujuan:</strong> {{ $bidangTujuan }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->format('d F Y') }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d F Y') }}</p>
        </div>
        
        <p>Kami akan segera memproses pengajuan Anda. Silakan pantau status pengajuan melalui aplikasi SIMAGANG.</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/pengajuan') }}"
                style="background: #1c64f2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Cek Status Pengajuan
            </a>
        </div>
        
        <p>Salam hangat,<br>Tim BPS Provinsi Riau</p>
    </div>
</body>
</html>