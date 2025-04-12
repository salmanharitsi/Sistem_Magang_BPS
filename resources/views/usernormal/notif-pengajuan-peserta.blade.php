@component('mail::message')
# Pengajuan Magang Berhasil Dikirim

Halo {{ $userName }},

Terima kasih telah mengajukan program magang di BPS Provinsi Riau.

## Detail Pengajuan Magang

- **Jenis Magang:** {{ $jensMagang }}
- **Bidang Tujuan:** {{ $bidangTujuan }}
- **Tanggal Mulai:** {{ \Carbon\Carbon::parse($tanggalMulai)->format('d F Y') }}
- **Tanggal Selesai:** {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d F Y') }}

Kami akan segera memproses pengajuan Anda. Silakan pantau status pengajuan melalui aplikasi SIMAGANG.

@component('mail::button', ['url' => url('/pengajuan')])
Cek Status Pengajuan
@endcomponent

Salam hangat,<br>
Tim BPS Provinsi Riau

@endcomponent