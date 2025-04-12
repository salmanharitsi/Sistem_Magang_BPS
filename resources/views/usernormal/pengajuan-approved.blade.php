@component('mail::message')
# Pengajuan Magang Disetujui

Halo **{{ $pengajuan->name }}**,

Selamat! Pengajuan magang Anda telah disetujui. Berikut detail magang Anda:

@component('mail::panel')
**Bidang Tujuan:** {{ $magang->bidang_tujuan }}  
**Jenis Magang:** {{ $magang->jenis_magang }}  
**Tanggal Mulai:** {{ date('d F Y', strtotime($magang->tanggal_mulai)) }}  
**Tanggal Selesai:** {{ date('d F Y', strtotime($magang->tanggal_selesai)) }}  
**Pembimbing Pertama:** {{ $pembimbing1->name ?? 'Belum ditentukan' }}  
@if($pembimbing2)
**Pembimbing Kedua:** {{ $pembimbing2->name ?? 'Belum ditentukan' }}  
@endif
@endcomponent

Silakan datang pada tanggal mulai magang yang telah ditentukan dan laporkan kehadiran Anda kepada pembimbing.

@component('mail::button', ['url' => config('app.url')])
Login ke Sistem
@endcomponent

Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi departemen kami melalui informasi kontak di bawah ini.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent