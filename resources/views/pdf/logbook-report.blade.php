<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Laporan Logbook</title>
    <style>
        @page {
            margin: 3cm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 5px 0;
        }
        .header p {
            font-size: 12px;
            margin: 2px 0;
        }
        .divider {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }
        .personal-info table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .personal-info td {
            padding: 4px 0;
        }
        .label {
            width: 25%;
            font-weight: bold;
        }
        .colon {
            width: 5%;
            text-align: center;
        }
        .value {
            width: 70%;
        }
        .report-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #999;
            padding: 6px;
            font-size: 11px;
        }
        table.data-table th {
            background-color: #f2f2f2;
        }
        .status-mengisi {
            color: green;
            font-weight: bold;
        }
        .status-tidak-mengisi {
            color: red;
            font-weight: bold;
        }
        .footer {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN LOGBOOK MAGANG</h1>
            <p>Periode Magang: {{ $userData['tanggal_mulai'] }} - {{ $userData['tanggal_selesai'] }}</p>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Personal Info -->
        <div class="personal-info">
            <table>
                <tr>
                    <td class="label">Nama Peserta</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $userData['nama'] }}</td>
                </tr>
                <tr>
                    <td class="label">Asal Institusi</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $userData['institusi'] }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor Induk</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $userData['nomor_induk'] }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Magang</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $userData['jenis_magang'] }}</td>
                </tr>
            </table>
        </div>

        <!-- Presensi Table -->
        <div class="report-title">RIWAYAT LOGBOOK</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Hari/Tanggal</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 15%;">Deskripsi</th>
                    <th style="width: 15%;">Lampiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logbook as $index => $item)
                    @php
                        $status = strtolower($item->status);
                        $isMengisi = $status === 'mengisi';
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, DD/MM/YYYY') }}</td>
                        <td class="{{ $isMengisi ? 'status-mengisi' : 'status-tidak-mengisi' }}">
                            {{ ucfirst($status) }}
                        </td>
                        <td>{{ $isMengisi ? ($item->deskripsi ?? '-') : '-' }}</td>
                        <td>{{ $isMengisi ? ($item->lampiran ?? '-') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data logbook.</td>
                    </tr>
                @endforelse
            </tbody>            
        </table>

        <!-- Footer -->
        <div class="footer">
            Pekanbaru / {{ $tanggal_cetak }}
        </div>

        <table style="width: 100%; margin-top: 5px; margin-left: -2px;">
            <tr>
                <td style="width: 76%;"></td> <!-- Kosongkan sisi kiri -->
                <td style="width: 24%; text-align: left;">
                    <p>Pembimbing Magang</p>
                    <br><br><br> <!-- Ruang untuk tanda tangan -->
                    <p style="text-decoration: underline; font-weight: bold;">
                        {{ $userData['pembimbing'] }}
                    </p>
                </td>
            </tr>
        </table>        

    </div>
</body>
</html>
