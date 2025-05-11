<!DOCTYPE html>
<html>
<head>
    <title>Status Pengajuan Magang</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Status Pengajuan Magang</h2>
        <p>Hai, <strong>{{ $name }}</strong></p>
        
        @if ($status == 'accepted')
            <div style="background: #e6f7e6; padding: 15px; margin: 20px 0; border-left: 4px solid #48bb78;">
                <p>Selamat! Pengajuan magang Anda telah <strong>DITERIMA</strong>.</p>
                <p>Kami senang mengundang Anda untuk bergabung dalam program magang kami.</p>
                <p>Silahkan upload surat pengantar Anda!</p>
            </div>
        @else
            <div style="background: #feebc8; padding: 15px; margin: 20px 0; border-left: 4px solid #ed8936;">
                <p>Kami ingin memberitahu bahwa pengajuan magang Anda telah <strong>DITOLAK</strong>.</p>
                
                @if ($komentar)
                    <h3>Catatan dari Tim:</h3>
                    <p>{{ $komentar }}</p>
                @endif
                
                <p>Terima kasih atas minat Anda. Kami mendorong Anda untuk tetap mencoba kesempatan lain.</p>
            </div>
        @endif
        
        <p>Salam hangat,<br>Tim Rekrutmen</p>
    </div>
</body>
</html>