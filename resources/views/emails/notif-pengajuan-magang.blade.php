<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Magang Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Pengajuan Magang Baru</h2>
        <p>Kepada Tim Admin,</p>
        <p>Ada pengajuan magang baru yang memerlukan tindakan Anda.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #1c64f2;">
            <h3 style="margin-top: 0;">Detail Pengajuan</h3>
            <p><strong>Nama Pendaftar:</strong> {{ $userName }}</p>
            <p><strong>Email Pendaftar:</strong> {{ $userEmail }}</p>
            <p><strong>Jenis Magang:</strong> {{ $jensMagang }}</p>
            <p><strong>Bidang Tujuan:</strong> {{ $bidangTujuan }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->format('d F Y') }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d F Y') }}</p>
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/admin/pengajuan/'.$pengajuanId) }}"
                style="background: #1c64f2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Lihat Detail Pengajuan
            </a>
        </div>
        
        <p>Segera tindak lanjuti pengajuan ini.</p>
        
        <p>Salam,<br>Sistem SIMAGANG</p>
        
        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 12px; color: #666; text-align: center;">
            © {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>