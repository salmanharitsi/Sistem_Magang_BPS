@extends('layouts.app')

@section('title', 'User Lapor Harian')

@section('content')

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <!-- Peringatan jika diakses dari desktop -->
    <div id="desktop-warning" class="hidden lg:block text-center p-5 border border-red-600 bg-red-100 text-red-600 rounded-md">
        <div class="flex justify-center items-center space-x-2">
            <i class="ti ti-device-imac-off text-2xl"></i>
            <p class="text-sm font-medium">
                Silakan lakukan presensi menggunakan HP atau tablet.
            </p>
        </div>
    </div>
    

    <!-- Konten hanya tampil di HP / Tablet -->
    <div id="mobile-content" class="block lg:hidden">
        <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                        Magang Hari ke - {{ $hariKe }}
                    </h4>
                    <p class="text-md">{{ Carbon::parse($presensi->tanggal)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="mt-4 w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <p class="text-sm">Pastikan kamu memberikan perizinan kamera pada browser</p>
                </div>
            </div>
            <!-- Start coding here -->
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
                <div class="p-5 bg-white card rounded-md">
                    <div class="webcam-capture"></div>
                    <div class="mt-5 flex flex-col gap-5">
                        @if ($presensi->jam_masuk && !$presensi->jam_keluar)
                            <div>
                                <h4 class="text-xl font-semibold">Jam Keluar</h4>
                                <p id="real-time-clock" class="text-lg"></p>
                            </div>
                        @elseif (!$presensi->jam_masuk)
                            <div>
                                <h4 class="text-xl font-semibold">Jam Masuk</h4>
                                <p id="real-time-clock" class="text-lg"></p>
                            </div>
                        @endif

                        @if ($presensi->jam_masuk && !$presensi->jam_keluar)
                            <button 
                                id="submit-pulang"
                                class="w-full bg-green-600 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap hover:bg-white hover:text-green-600 hover:border-green-600 transition-all duration-200">
                                Submit Pulang
                            </button>
                        @elseif (!$presensi->jam_masuk)
                            <button 
                                id="submit-kehadiran"
                                class="w-full bg-blue-600 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap hover:bg-white hover:text-blue-600 hover:border-blue-600 transition-all duration-200">
                                Submit Kehadiran
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: 0 auto;
            height: auto !important;
            border-radius: 10px;
        }

        @media (min-width: 505px) {
            .webcam-capture {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100% !important;
                height: auto !important;
            }

            .webcam-capture video {
                width: 100% !important;
                margin: 0 auto;
            }
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debugging: Cek apakah elemen real-time-clock ada
        const clockElement = document.getElementById('real-time-clock');
        console.log('Clock Element:', clockElement);

        if (clockElement) {
            // Fungsi untuk memperbarui jam secara real-time
            function updateClock() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }

            // Update clock setiap detik
            updateClock();
            setInterval(updateClock, 1000);
        } else {
            console.error('Elemen dengan ID "real-time-clock" tidak ditemukan!');
        }

        // Inisialisasi kamera
        Webcam.set({
            width: 350,
            height: 300,
            image_format: 'png',
            png_quality: 90,
        });

        Webcam.attach('.webcam-capture');

        const btnKehadiran = document.getElementById('submit-kehadiran');
        if (btnKehadiran) {
            btnKehadiran.addEventListener('click', function () {
                handleSubmit('kehadiran');
            });
        }

        const btnPulang = document.getElementById('submit-pulang');
        if (btnPulang) {
            btnPulang.addEventListener('click', function () {
                handleSubmit('pulang');
            });
        }

        function handleSubmit(type) {
            Webcam.snap(function(dataUri) {
                submitPresensi(type, dataUri);
            });
        }

        function submitPresensi(type, imageData) {
            const presensiId = "{{ $presensi->id }}"; // Ambil ID presensi dari Blade
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/presensi/lapor-harian/${presensiId}/submit`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    type: type, // Bisa 'kehadiran' atau 'pulang'
                    image: imageData, // Kirim gambar sebagai Base64
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data!');
            });
        }
    });
</script>
@endsection
