<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Internship</title>
    <!-- Using inline styles for PDF compatibility -->
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: 'DroidSerif';
            font-style: bold;
            font-weight: 600;
            src: url('{{ public_path('fonts/droid-serif.bold.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'AlexBrush';
            src: url('{{ public_path('fonts/alex-brush.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('{{ public_path('fonts/Montserrat-ExtraLight.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'MontserratLight';
            src: url('{{ public_path('fonts/montserrat-light.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'MontserratMedium';
            src: url('{{ public_path('fonts/montserrat-medium.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('fonts/poppins.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsBold';
            src: url('{{ public_path('fonts/poppins-bold.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsSemibold';
            src: url('{{ public_path('fonts/poppins-semibold.ttf') }}') format('truetype');
        }
        
        .page {
            position: relative;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .watermark img {
            width: 100%; 
            height: auto;
            min-width: 750px;
        }

        .certificate-logo .tut-wuri {
            position: absolute;
            margin-top: 25px;
            margin-left: 50px;
            z-index: 1;
            left: 0;
            top: 0;
        }

        .certificate-logo .bps {
            position: absolute;
            margin-top: 30px;
            margin-right: 50px;
            z-index: 1;
            right: 0;
            top: 0;
        }

        .certificate-logo-eval .tut-wuri {
            position: absolute;
            margin-top: 25px;
            margin-right: 50px;
            z-index: 1;
            right: 70;
            top: 0;
        }

        .certificate-logo-eval .bps {
            position: absolute;
            margin-top: 33px;
            margin-right: 50px;
            z-index: 1;
            right: 0;
            top: 0;
        }
        
        .certificate-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* padding: 60mm 50mm; */
        }
        
        .cert-title {
            color: #2b2d42;
            font-size: 70px;
            font-weight: bold;
            font-family: 'DroidSerif';
            margin-top: 100px;
        }
        
        .cert-subtitle {
            color: #2b2d42;
            font-size: 27px;
            letter-spacing: 5px;
            font-weight: bold;
            font-family: 'DroidSerif';
            margin-top: -50px;
        }
        
        .cert-intro {
            font-size: 20px;
            font-family: 'MontserratLight';
            color: #2b2d42;
        }
        
        .cert-name {
            font-size: 71px;
            font-weight: normal;
            color: #2b2d42;
            width: 100%;
            font-family:'AlexBrush';
            margin-top: -35px;
        }
        
        .cert-description {
            font-size: 16px;
            line-height: 1;
            font-family: 'Poppins';
            color: #2b2d42;
            margin-top: 30px;
        }

        .cert-description span {
            font-family: 'PoppinsBold';
        }
        
        /* Modified signature section to use table */
        .signature-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            border: none;
            font-size: 16px;
        }

        .header-signature {
            font-size: 16px;
            font-family: 'PoppinsSemibold';
        }
        
        .signature-line {
            margin-top: 90px;
            padding-top: 5mm;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            font-family: 'MontserratMedium';
        }

        .signature-center {
            position: absolute;
            bottom: 10px;
            right: 0;
            left: 0;
            text-align: center;
            margin-top: 50px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        /* Evaluation Page */
        .eval-page {
            padding: 50px;
        }
        
        .student-info {
            text-align: left;
            margin-bottom: 25px;
        }
        
        .student-info p {
            margin: 3mm 0;
        }
        
        .eval-table {
            width: 100%;
            border-collapse: collapse;
            z-index: 50;
        }
        
        .eval-table th,
        .eval-table td {
            border: 1px solid #333;
            padding: 2mm;
            text-align: left;
        }
        
        .eval-table th {
            background-color: #b8b8b4;
        }
        
        .center-text {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- First Page - Certificate -->
    <div class="page">
        {{-- line design --}}
        <div style="width: 8px; height: 200px; background-color: #68b92e; position: absolute; bottom: -1px; left: 0; z-index: 2;"></div>
        <div style="width: 150px; height: 8px; background-color: #68b92e; position: absolute; bottom: -1px; left: 0; z-index: 2;"></div>
        <div style="width: 100%; height: 8px; background-color: #ea891b; position: absolute; bottom: -1px; left: 0; right: 0; z-index: 1;"></div>
        <div style="width: 8px; height: 200px; background-color: #0092dd; position: absolute; bottom: -1px; right: 0; z-index: 2;"></div>
        <div style="width: 150px; height: 8px; background-color: #0092dd; position: absolute; bottom: -1px; right: 0; z-index: 2;"></div>

        {{-- triangle design --}}
        <div style="width: 0; height: 0; border-left: 45px solid transparent; border-right: 45px solid transparent; border-bottom: 86.6px solid #fff; position: absolute; bottom: -1px; left: 100px; z-index: 2;"></div>
        <div style="width: 0; height: 0; border-left: 45px solid transparent; border-right: 45px solid transparent; border-bottom: 86.6px solid #fff; position: absolute; bottom: -1px; right: 100px; z-index: 2;"></div>

        <div style="width: 0; height: 0; border-top: 85px solid transparent; border-bottom: 85px solid transparent; border-right: 86.6px solid #fff; position: absolute; bottom: 155px; left: -45px; z-index: 2;"></div>
        <div style="width: 0; height: 0; border-top: 85px solid transparent; border-bottom: 85px solid transparent; border-left: 86.6px solid #fff; position: absolute; bottom: 155px; right: -45px; z-index: 2;"></div>
        
        {{-- watermark page --}}
        <div class="watermark">
            <img class="bps" src="{{ public_path('assets/images/sertifikat/logo-bps.png') }}" alt="Logo">
        </div>

        {{-- Logo --}}
        <div class="certificate-logo">
            <img class="tut-wuri" src="{{ public_path('assets/images/sertifikat/logo-tut-wuri.png') }}" alt="Logo" style="height: 70px;">
            <img class="bps" src="{{ public_path('assets/images/sertifikat/logo-bps.png') }}" alt="Logo" style="height: 55px;">
        </div>

        <div class="certificate-content">

            <!-- Header -->
            <div class="cert-header">
                <h1 class="cert-title">CERTIFICATE</h1>
                <p class="cert-subtitle">Of Internship</p>
            </div>

            <!-- Main Content -->
            <p class="cert-intro">This Certificate is Proudly Presented To</p>

            <h2 class="cert-name">{{ $nama_peserta }}</h2>
            <div style="width: 350px; height: 1px; background-color: #2b2d42; margin: -45px auto 0 auto;"></div>
            
            <p class="cert-description">
                has successfully completed the <span>{{ $program_magang }}</span> at<br>
                <span>BPS Provinsi Riau</span>, during the period of <span>{{ $tanggal_mulai }}</span><br>
                to <span>{{ $tanggal_selesai }}</span>
            </p>

            <!-- Signatures - Using Table instead of grid/flex -->
            <table class="signature-table">
                <tr>
                    <td>
                        <p class="header-signature">Head of BPS Riau Province</p>
                        <div class="signature-line">Asep Riyadi S.Si, M.M</div>
                    </td>
                    <td>
                        <p class="header-signature">Internship Coordinator</p>
                        <div class="signature-line">Amrizal S.ST., M.M</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Second Page - Evaluation -->
    <div class="eval-page">
        {{-- watermark page --}}
        <div class="watermark">
            <img class="bps" src="{{ public_path('assets/images/sertifikat/logo-bps.png') }}" alt="Logo">
        </div>

        {{-- Logo --}}
        <div class="certificate-logo-eval">
            <img class="tut-wuri" src="{{ public_path('assets/images/sertifikat/logo-tut-wuri.png') }}" alt="Logo" style="height: 70px;">
            <img class="bps" src="{{ public_path('assets/images/sertifikat/logo-bps.png') }}" alt="Logo" style="height: 55px;">
        </div>

        {{-- line design --}}
        <div style="width: 8px; height: 200px; background-color: #68b92e; position: absolute; bottom: -1px; left: 0; z-index: 2;"></div>
        <div style="width: 150px; height: 8px; background-color: #68b92e; position: absolute; bottom: -1px; left: 0; z-index: 2;"></div>
        <div style="width: 100%; height: 8px; background-color: #ea891b; position: absolute; bottom: -1px; left: 0; right: 0; z-index: 1;"></div>
        <div style="width: 8px; height: 200px; background-color: #0092dd; position: absolute; bottom: -1px; right: 0; z-index: 2;"></div>
        <div style="width: 150px; height: 8px; background-color: #0092dd; position: absolute; bottom: -1px; right: 0; z-index: 2;"></div>

        {{-- triangle design --}}
        <div style="width: 0; height: 0; border-left: 45px solid transparent; border-right: 45px solid transparent; border-bottom: 86.6px solid #fff; position: absolute; bottom: -1px; left: 100px; z-index: 2;"></div>
        <div style="width: 0; height: 0; border-left: 45px solid transparent; border-right: 45px solid transparent; border-bottom: 86.6px solid #fff; position: absolute; bottom: -1px; right: 100px; z-index: 2;"></div>

        <div style="width: 0; height: 0; border-top: 85px solid transparent; border-bottom: 85px solid transparent; border-right: 86.6px solid #fff; position: absolute; bottom: 155px; left: -45px; z-index: 2;"></div>
        <div style="width: 0; height: 0; border-top: 85px solid transparent; border-bottom: 85px solid transparent; border-left: 86.6px solid #fff; position: absolute; bottom: 155px; right: -45px; z-index: 2;"></div>

        <!-- Student Info -->
        <table class="student-info" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 10%; padding: 1px 0; vertical-align: top; font-family: 'PoppinsSemiBold';">Name</td>
                <td style="padding: 1px 0; font-family: 'MontserratMedium';">: {{ $nama_peserta }}</td>
            </tr>
            <tr>
                <td style="padding: 1px 0; vertical-align: top; font-family: 'PoppinsSemiBold';">Institution</td>
                <td style="padding: 1px 0; font-family: 'MontserratMedium';">: {{ $asal_institusi }}</td>
            </tr>
        </table>

        <!-- Evaluation Table -->
        <table class="eval-table">
            <thead>
                <tr>
                    <th class="center-text" style="width: 5%; text-align: center;">NO</th>
                    <th style="width: 20%;">INDICATOR</th>
                    <th style="width: 70%;">DESCRIPTION</th>
                    <th class="center-text" style="width: 5%;">SCORE</th>
                </tr>
            </thead>
            <tbody>
                <!-- Fixed rows -->
                <tr>
                    <td colspan="4" style="padding: 3px; background-color: #e7e7e7; font-family: 'MontserratMedium'; font-size: 14px;">Weight Score: 70%</td>
                </tr>
                <tr>
                    <td class="center-text" style="text-align: center">1</td>
                    <td>Presensi</td>
                    <td>Kehadiran selama magang</td>
                    <td class="center-text" style="text-align: center">{{ $nilai_presensi }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="padding: 3px; background-color: #e7e7e7; font-family: 'MontserratMedium'; font-size: 14px;">Weight Score: 20%</td>
                </tr>
                <tr>
                    <td class="center-text" style="text-align: center">2</td>
                    <td>Logbook</td>
                    <td>Pencatatan kegiatan harian</td>
                    <td class="center-text" style="text-align: center">{{ $nilai_logbook }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="padding: 3px; background-color: #e7e7e7; font-family: 'MontserratMedium'; font-size: 14px;">Weight Score: 10%</td>
                </tr>
                <!-- Dynamic rows based on nilai_lainnya -->
                @if (isset($nilai_lainnya) && is_array($nilai_lainnya))
                    @foreach ($nilai_lainnya as $index => $nilai)
                        <tr>
                            <td class="center-text" style="text-align: center">{{ $index + 3 }}</td>
                            <td>{{ $nilai['indikator'] ?? 'Nilai lainnya' }}</td>
                            <td>{{ $nilai['deskripsi'] ?? '-' }}</td>
                            <td class="center-text" style="text-align: center">{{ $nilai['nilai'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center-text" style="text-align: center">3</td>
                        <td>Nilai lainnya</td>
                        <td>-</td>
                        <td class="center-text" style="text-align: center">-</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" style="padding: 3px; background-color: #e7e7e7; font-family: 'MontserratMedium'; font-size: 14px;">Total Score</td>
                    <td style="text-align: center; padding: 3px; background-color: #e7e7e7; font-family: 'PoppinsBold';">{{ $total_nilai }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-center">
            <p class="header-signature">Pekanbaru, {{ $tanggal }}</p>
            <p class="header-signature" style="margin-top: -20px">Internship Mentor</p>
        
            <p class="signature-line">{{ $pembimbing }}</p>
        </div>
    </div>
</body>

</html>