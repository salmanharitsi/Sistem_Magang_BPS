<!-- resources/views/emails/internship-status.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Status Pengajuan Magang</title>
</head>
<body>
    <h2>Hai, {{ $name }}</h2>
    
    @if ($status == 'accepted')
        <p>Selamat! Pengajuan magang Anda telah <strong>DITERIMA</strong>.</p>
        <p>Kami senang mengundang Anda untuk bergabung dalam program magang kami.</p>
        <p>Silahkan upload surat pengantar Anda!</p>
    @else
        <p>Kami ingin memberitahu bahwa pengajuan magang Anda telah <strong>DITOLAK</strong>.</p>
        
        @if ($komentar)
            <h3>Catatan dari Tim:</h3>
            <p>{{ $komentar }}</p>
        @endif
        
        <p>Terima kasih atas minat Anda. Kami mendorong Anda untuk tetap mencoba kesempatan lain.</p>
    @endif
    
    <p>Salam hangat,<br>Tim Rekrutmen</p>
</body>
</html>