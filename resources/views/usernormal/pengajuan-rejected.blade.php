@component('mail::message')
# Pengajuan Magang Perlu Perbaikan

Halo **{{ $pengajuan->name }}**,

Mohon maaf, pengajuan magang Anda belum dapat disetujui dan memerlukan beberapa perbaikan.

@component('mail::panel')
**Bidang Tujuan:** {{ $pengajuan->bidang_tujuan }}  
**Jenis Magang:** {{ $pengajuan->jenis_magang }}  
**Alasan Penolakan:** {{ $pengajuan->komentar }}
@endcomponent

Silakan melakukan perbaikan pada dokumen pengajuan Anda dan submit kembali melalui sistem.

@component('mail::button', ['url' => config('app.url')])
Login ke Sistem
@endcomponent

Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi departemen kami melalui informasi kontak yang tersedia di sistem.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent