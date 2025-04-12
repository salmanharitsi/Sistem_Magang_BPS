@component('mail::message')
# Notifikasi Upload Surat Pengantar

Kepada Tim Admin,

Surat Pengantar baru telah diupload oleh seorang pengguna.

@component('mail::panel')
## Detail Dokumen
- **Nama Pengguna:** {{ $userName }}
- **ID Pengajuan:** {{ $pengajuanId }}
- **Nama File:** {{ $originalFilename }}
- **Waktu Upload:** {{ $uploadedAt }}
@endcomponent

{{-- @component('mail::button', ['url' => route('detail-pengajuan/{id}', $pengajuanId), 'color' => 'primary'])
Review Surat Pengantar
@endcomponent --}}

{{-- @component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
@endcomponent --}}