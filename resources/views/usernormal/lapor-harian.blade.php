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
                Silakan lakukan presensi menggunakan HP atau tablet untuk mendapatkan lokasi yang lebih akurat.
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
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden">
                <div class="p-5 bg-white card rounded-md">
                    <div class="webcam-capture"></div>
                    <!-- Camera status indicator -->
                    <div id="camera-status" class="mt-3 text-center text-sm font-medium text-amber-600">
                        <span>Menunggu kamera...</span>
                    </div>
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
                                disabled
                                class="w-full bg-gray-400 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap transition-all duration-200 disabled:cursor-not-allowed">
                                Submit Pulang
                            </button>
                        @elseif (!$presensi->jam_masuk)
                            <button 
                                id="submit-kehadiran"
                                disabled
                                class="w-full bg-gray-400 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap transition-all duration-200 disabled:cursor-not-allowed">
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

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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

            const cameraStatus = document.getElementById('camera-status');
            const btnKehadiran = document.getElementById('submit-kehadiran');
            const btnPulang = document.getElementById('submit-pulang');
            let cameraReady = false;

            // Fungsi untuk mengaktifkan button saat kamera siap
            function enableButtons() {
                if (btnKehadiran) {
                    btnKehadiran.disabled = false;
                    btnKehadiran.classList.remove('bg-gray-400');
                    btnKehadiran.classList.add('bg-blue-600', 'hover:bg-white', 'hover:text-blue-600', 'hover:border-blue-600');
                }
                
                if (btnPulang) {
                    btnPulang.disabled = false;
                    btnPulang.classList.remove('bg-gray-400');
                    btnPulang.classList.add('bg-green-600', 'hover:bg-white', 'hover:text-green-600', 'hover:border-green-600');
                }
                
                if (cameraStatus) {
                    cameraStatus.innerHTML = '<span class="text-green-600">Kamera siap digunakan</span>';
                }
            }

            // Fungsi untuk menonaktifkan button saat kamera tidak siap
            function disableButtons() {
                if (btnKehadiran) {
                    btnKehadiran.disabled = true;
                    btnKehadiran.classList.remove('bg-blue-600', 'hover:bg-white', 'hover:text-blue-600', 'hover:border-blue-600');
                    btnKehadiran.classList.add('bg-gray-400');
                }
                
                if (btnPulang) {
                    btnPulang.disabled = true;
                    btnPulang.classList.remove('bg-green-600', 'hover:bg-white', 'hover:text-green-600', 'hover:border-green-600');
                    btnPulang.classList.add('bg-gray-400');
                }
                
                if (cameraStatus) {
                    cameraStatus.innerHTML = '<span class="text-amber-600">Menunggu kamera...</span>';
                }
            }

            // Memeriksa ketersediaan kamera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    console.log('Kamera tersedia');
                    // Matikan stream kamera sementara karena Webcam.js akan membutuhkannya kembali
                    stream.getTracks().forEach(track => track.stop());
                    
                    // Inisialisasi Webcam.js dengan event handlers
                    Webcam.set({
                        width: 350,
                        height: 300,
                        image_format: 'png',
                        png_quality: 90,
                    });

                    Webcam.on('load', function() {
                        console.log('Webcam library loaded');
                    });

                    Webcam.on('live', function() {
                        console.log('Kamera aktif dan siap digunakan');
                        cameraReady = true;
                        enableButtons();
                    });

                    Webcam.on('error', function(err) {
                        console.error('Webcam error:', err);
                        cameraReady = false;
                        disableButtons();
                        if (cameraStatus) {
                            cameraStatus.innerHTML = '<span class="text-red-600">Error: ' + err + '</span>';
                        }
                    });

                    // Pasang kamera
                    try {
                        Webcam.attach('.webcam-capture');
                    } catch (error) {
                        console.error('Gagal menginisialisasi kamera:', error);
                        disableButtons();
                        if (cameraStatus) {
                            cameraStatus.innerHTML = '<span class="text-red-600">Gagal menginisialisasi kamera. Silakan refresh halaman.</span>';
                        }
                    }
                })
                .catch(function(error) {
                    console.error('Kamera tidak tersedia:', error);
                    disableButtons();
                    if (cameraStatus) {
                        cameraStatus.innerHTML = '<span class="text-red-600">Kamera tidak tersedia. Periksa izin kamera Anda.</span>';
                    }
                });

            // Tambahkan event listener untuk tombol submit
            if (btnKehadiran) {
                btnKehadiran.addEventListener('click', function() {
                    if (cameraReady) {
                        handleSubmit('kehadiran');
                    }
                });
            }

            if (btnPulang) {
                btnPulang.addEventListener('click', function() {
                    if (cameraReady) {
                        handleSubmit('pulang');
                    }
                });
            }

            function handleSubmit(type) {
                if (!cameraReady) {
                    alert('Kamera belum siap. Mohon tunggu sebentar.');
                    return;
                }
                
                Webcam.snap(function(dataUri) {
                    submitPresensi(type, dataUri);
                });
            }

            function submitPresensi(type, imageData) {
                const presensiId = "{{ $presensi->id }}"; // Ambil ID presensi dari Blade
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Disable buttons while submitting
                disableButtons();
                if (cameraStatus) {
                    cameraStatus.innerHTML = '<span class="text-blue-600">Mengirim data...</span>';
                }

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
                        // Re-enable buttons if submission fails
                        enableButtons();
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data!');
                    // Re-enable buttons if submission fails
                    enableButtons();
                });
            }
        });
    </script>
@endsection