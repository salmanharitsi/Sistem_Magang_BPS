<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Upload Surat Pengantar</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Notifikasi Upload Surat Pengantar</h2>
        <p>Kepada Tim Admin,</p>
        <p>Surat Pengantar baru telah diupload oleh seorang pengguna.</p>
        
        <div style="background: #f4f4f4; padding: 15px; margin: 20px 0; border-left: 4px solid #1c64f2;">
            <h3 style="margin-top: 0;">Detail Dokumen</h3>
            <p><strong>Nama Pengguna:</strong> {{ $userName }}</p>
            <p><strong>Link File:</strong> {{ $suratPengantar }}</p>
            <p><strong>Waktu Upload:</strong> {{ $uploadedAt }}</p>
        </div>
    </div>
</body>
</html>