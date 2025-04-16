@component('mail::message')
# Pengajuan Magang Baru

Kepada Tim Admin,

Ada pengajuan magang baru yang memerlukan tindakan Anda.

## Detail Pengajuan

- **Nama Pendaftar:** {{ $userName }}
- **Email Pendaftar:** {{ $userEmail }}
- **Jenis Magang:** {{ $jensMagang }}
- **Bidang Tujuan:** {{ $bidangTujuan }}
- **Tanggal Mulai:** {{ \Carbon\Carbon::parse($tanggalMulai)->format('d F Y') }}
- **Tanggal Selesai:** {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d F Y') }}

@component('mail::button', ['url' => url('/admin/pengajuan')])
Lihat Detail Pengajuan
@endcomponent

Segera tindaklanjuti pengajuan ini.

Salam,<br>
Sistem SIMAGANG
@endcomponent