<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Institusi Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Pendaftaran Institusi Baru</h2>
        <p>Kepada Tim Admin BPS Provinsi Riau,</p>
        <p>Ada pendaftaran institusi baru yang memerlukan tindakan Anda.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #1c64f2;">
            <h3 style="margin-top: 0;">Detail Institusi</h3>
            <p><strong>Nama Institusi:</strong> {{ $namaInstitusi }}</p>
            <p><strong>Alamat:</strong> {{ $alamatInstitusi }}</p>
            <p><strong>Status:</strong> Pending Verifikasi</p>
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/dashboard-admin/kelola-institusi') }}"
                style="background: #1c64f2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Verifikasi Institusi Sekarang
            </a>
        </div>
        
        <p>Segera tindak lanjuti pendaftaran institusi ini.</p>
        
        <p>Salam,<br>Sistem SIMAGANG BPS Provinsi Riau</p>
        
        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 12px; color: #666; text-align: center;">
            © {{ date('Y') }} Badan Pusat Statistik Provinsi Riau. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>