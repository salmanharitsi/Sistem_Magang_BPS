@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Bagian Kiri: Carousel Tanggal -->
        <div class="flex flex-col gap-6 w-full md:w-1/2">
            <div
                class="w-full h-fit py-4 px-[53px] card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
                <div id="presensi-carousel" class="overflow-hidden" wire:ignore>
                    <div class="carousel-inner flex transition-transform duration-300 ease-in-out">
                        @php
                            $groupedPresensi = $presensiData->groupBy(function ($item) {
                                return Carbon::parse($item->tanggal)->format('F Y'); // Kelompokkan berdasarkan bulan dan tahun
                            });
                        @endphp

                        @foreach ($groupedPresensi as $month => $presensiGroup)
                            <div class="carousel-item w-full flex-shrink-0" data-index="{{ $loop->index }}">
                                <div class="grid grid-cols-4 lg:grid-cols-7 gap-3 md:gap-4 place-items-center">
                                    @php $lastMonth = null; @endphp

                                    @foreach ($presensiGroup as $index => $presensi)
                                        @php
                                            $tanggal = Carbon::parse($presensi->tanggal);
                                            $isSelected = $selectedDate === $presensi->tanggal;
                                            $isFutureDate = $tanggal->greaterThan(Carbon::today()); // Cek apakah tanggal belum berlalu
                                        @endphp

                                        @if ($lastMonth !== $tanggal->month)
                                            <div
                                                class="w-full col-span-4 lg:col-span-7 text-start font-semibold mt-2 text-xl mb-3">
                                                {{ $tanggal->translatedFormat('F Y') }} <!-- Contoh: Januari 2024 -->
                                            </div>
                                            @php $lastMonth = $tanggal->month; @endphp
                                        @endif

                                        <!-- Div Bulat Tanggal -->
                                        <div @unless ($isFutureDate) wire:click="selectPresensi('{{ $presensi->tanggal }}')" @endunless
                                            class="flex items-center justify-center w-12 h-12 rounded-full 
                                                @if ($presensi->status === 'hadir' && $presensi->jam_keluar && !$isSelected) bg-green-500 text-white
                                                @elseif ($isSelected) 
                                                    bg-blue-500 text-white
                                                @elseif ($presensi->status === 'izin') 
                                                    bg-amber-500 text-white
                                                @elseif ($presensi->status === 'tidak-hadir') 
                                                    bg-red-500 text-white
                                                @else
                                                    bg-gray-200 @endif
                                                {{ $isFutureDate ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}">
                                            {{ $tanggal->format('d') }} <!-- Tampilkan tanggal (contoh: 17) -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Carousel navigation buttons -->
                <button id="prev-btn"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-blue-500 text-white rounded-full w-10 h-10 shadow-lg hover:bg-blue-600 focus:outline-none">
                    <i class="ti ti-chevron-left text-xl"></i>
                </button>
                <button id="next-btn"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 text-white rounded-full w-10 h-10 shadow-lg hover:bg-blue-600 focus:outline-none">
                    <i class="ti ti-chevron-right text-xl"></i>
                </button>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-md grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <p class="text-sm">Hari Ini</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <p class="text-sm">Hadir</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <p class="text-sm">Izin</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <p class="text-sm">Tidak Hadir</p>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Detail Presensi -->
        <div class="w-full md:w-1/2 h-fit card dark:bg-gray-800 sm:rounded-lg overflow-hidden relative">
            @if ($selectedPresensi)
                @if (
                    $selectedPresensi->tanggal == Carbon::today()->toDateString() &&
                        $selectedPresensi->status !== 'izin' &&
                        $selectedPresensi->status !== 'tidak-hadir' &&
                        (!$selectedPresensi->jam_masuk || !$selectedPresensi->jam_keluar))
                    <div class="bg-white p-5 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">Pengecekan Lokasi</h2>
                        <div id="map" class="w-full h-56 rounded-lg relative">
                            <!-- Elemen loading -->
                            <div id="map-loading"
                                class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-75">
                                <span class="text-gray-700 animate-pulse">Memuat map...</span>
                            </div>
                        </div>
                        <div id="location-status" class="mt-4">
                            <!-- Pesan dan tombol akan ditampilkan di sini berdasarkan kondisi -->
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header Section with Status Badge -->
                        <div class="bg-gray-50 p-5 border-b">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                <h2 class="text-xl font-semibold text-gray-800">Detail Presensi</h2>
                                @if ($selectedPresensi->pembimbing_id)
                                    <div
                                        class="px-3 py-1 border border-green-800 bg-green-100 text-green-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-check"></i>
                                        <p class="text-xs">Disetujui</p>
                                    </div>
                                @else
                                    <div
                                        class="px-3 py-1 border border-amber-800 bg-amber-100 text-amber-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-clock"></i>
                                        <p class="text-xs">Menunggu Persetujuan</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="p-5">
                            <!-- Date Row -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Tanggal</div>
                                <div class="w-3/5 text-gray-900 font-semibold">
                                    {{ Carbon::parse($selectedPresensi->tanggal)->translatedFormat('d F Y') }}</div>
                            </div>

                            <!-- Status Row -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Status</div>
                                <div class="w-3/5">
                                    @if ($selectedPresensi->status === 'hadir')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                            Hadir
                                        </span>
                                    @elseif ($selectedPresensi->status === 'izin')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                            Izin
                                        </span>
                                    @elseif ($selectedPresensi->status === 'tidak-hadir')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                            Tidak Hadir
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ $selectedPresensi->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Time In and Out (if available) -->
                            @if ($selectedPresensi->jam_masuk && $selectedPresensi->jam_keluar)
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <div class="w-2/5 text-gray-600 font-medium">Jam Masuk</div>
                                    <div class="w-3/5 text-gray-900">
                                        <div class="flex gap-1 items-center">
                                            <i class="ti ti-login text-2xl text-blue-500"></i>
                                            {{ $selectedPresensi->jam_masuk }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <div class="w-2/5 text-gray-600 font-medium">Jam Keluar</div>
                                    <div class="w-3/5 text-gray-900">
                                        <div class="flex gap-1 items-center">
                                            <i class="ti ti-logout text-2xl text-blue-500"></i>
                                            {{ $selectedPresensi->jam_keluar }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Keterangan Izin (if applicable) -->
                            @if ($selectedPresensi->status === 'izin')
                                <div class="flex items-start py-3">
                                    <div class="w-2/5 text-gray-600 font-medium">Keterangan Izin</div>
                                    <div
                                        class="w-3/5 text-gray-900 bg-gray-100 p-3 rounded-md border border-gray-500 text-sm">
                                        {{ $selectedPresensi->keterangan_izin ?? 'Tidak ada keterangan' }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Footer with timestamp if needed -->
                        @if ($selectedPresensi->created_at)
                            <div class="bg-gray-50 px-5 py-3 text-xs text-gray-500 text-right">
                                Terakhir diperbarui:
                                {{ Carbon::parse($selectedPresensi->updated_at)->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <div class="p-5">
                    <div
                        class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                        <div class="flex gap-3 items-start lg:items-center">
                            <i class="ti ti-sparkles text-lg"></i>
                            <p class="text-sm">Presensi tidak tersedia pada akhir pekan, selamat menikmati akhir pekan!
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Load Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('presensi-carousel');
        const carouselInner = carousel.querySelector('.carousel-inner');
        const items = carousel.querySelectorAll('.carousel-item');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        // Ambil nilai currentSlide dari Livewire
        let currentIndex = @json($currentSlide);
        const totalItems = items.length;

        // Initialize carousel
        updateCarousel();

        // Event listeners for buttons
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
            // Update state carousel di Livewire
            Livewire.emit('updateCurrentSlide', currentIndex);
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
            // Update state carousel di Livewire
            Livewire.emit('updateCurrentSlide', currentIndex);
        });

        function updateCarousel() {
            // Update transform to show current item
            carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Set current slide berdasarkan state Livewire
        Livewire.on('setCurrentSlide', (index) => {
            currentIndex = index;
            updateCarousel();
        });
    });

    document.addEventListener('livewire:load', function() {
        // Set current slide berdasarkan state Livewire
        Livewire.emit('setCurrentSlide', @json($currentSlide));
    });

    document.addEventListener('DOMContentLoaded', function() {
        var locationInput = document.getElementById('location');
        var map, userMarker, officeMarker, officeCircle;
        // var officeLatitude = 0.51001435; // Koordinat BPS
        // var officeLongitude = 101.45457153; 
        var officeLatitude = 0.444011; // Koordinat Rumah
        var officeLongitude = 101.459271;
        // var officeLatitude = 0.445742; // Koordinat nyasar
        // var officeLongitude = 101.466078;
        var officeRadius = 50; // Radius dalam meter
        var locationStatus = document.getElementById('location-status'); // Elemen untuk menampilkan status
        var mapLoading = document.getElementById('map-loading'); // Elemen loading
        var userLatitude, userLongitude;

        if (document.getElementById('map')) {
            if (navigator.geolocation) {
                var options = {
                    enableHighAccuracy: true,
                    timeout: 30000,
                    maximumAge: 0
                };
                navigator.geolocation.watchPosition(updateUserLocation, errorHandler, options);
            } else {
                alert("Geolocation tidak didukung di browser ini.");
            }

            function updateUserLocation(position) {
                userLatitude = position.coords.latitude;
                userLongitude = position.coords.longitude;
                var accuracy = position.coords.accuracy;

                console.log(
                    `Latitude: ${userLatitude}, Longitude: ${userLongitude}, Accuracy: ${accuracy} meters`);

                // Simpan lokasi di input hidden dan juga di session storage
                if (locationInput) {
                    locationInput.value = userLatitude + ',' + userLongitude;
                }

                // Simpan lokasi di sessionStorage untuk digunakan di halaman lain
                sessionStorage.setItem('userLocation', userLatitude + ',' + userLongitude);

                // Kode map initialization dan lainnya sama seperti sebelumnya
                if (!map) {
                    // Sembunyikan elemen loading setelah map selesai dimuat
                    if (mapLoading) {
                        mapLoading.style.display = 'none';
                    }

                    // Inisialisasi peta
                    map = L.map('map').setView([userLatitude, userLongitude], 18);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    // Buat ikon kustom untuk marker pengguna
                    var greenIcon = L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34]
                    });

                    // Tambahkan marker pengguna dengan ikon hijau
                    userMarker = L.marker([userLatitude, userLongitude], {
                            icon: greenIcon
                        })
                        .addTo(map)
                        .bindPopup('Lokasi Anda')
                        .openPopup();

                    // Tambahkan marker kantor
                    officeMarker = L.marker([officeLatitude, officeLongitude]).addTo(map)
                        .bindPopup('Lokasi Kantor').openPopup();

                    // Tambahkan radius kantor
                    officeCircle = L.circle([officeLatitude, officeLongitude], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.3,
                        radius: officeRadius
                    }).addTo(map);
                } else {
                    // Update posisi pengguna
                    userMarker.setLatLng([userLatitude, userLongitude]);
                    map.setView([userLatitude, userLongitude], 18);
                }

                // Hitung jarak antara lokasi pengguna dan kantor
                var userCoords = [userLatitude, userLongitude];
                var officeCoords = [officeLatitude, officeLongitude];
                var distance = map.distance(userCoords, officeCoords);

                // Perbarui status lokasi berdasarkan jarak
                if (distance <= officeRadius) {
                    // Jika dalam radius, tampilkan tombol "Lapor Kehadiran"
                    locationStatus.innerHTML = `
                    @if ($selectedPresensi)
                        @if ($selectedPresensi->jam_masuk)
                            <div class="mt-5 flex flex-col gap-5">
                                <form action="{{ route('usernormal.lapor-harian', $selectedPresensi->id) }}" method="get" class="w-full">
                                    <input type="hidden" name="location" value="${userLatitude},${userLongitude}">
                                    <button type="submit" class="w-full bg-green-600 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap hover:bg-white hover:text-green-600 hover:border-green-600 transition-all duration-200 text-center cursor-pointer">
                                        Laporkan Pulang
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-5 flex">
                                <form action="{{ route('usernormal.lapor-harian', $selectedPresensi->id) }}" method="get" class="w-full">
                                    <input type="hidden" name="location" value="${userLatitude},${userLongitude}">
                                    <button type="submit" class="w-full bg-blue-600 px-4 border-2 border-transparent text-white py-1.5 rounded-lg whitespace-nowrap hover:bg-white hover:text-blue-600 hover:border-blue-600 transition-all duration-200 text-center cursor-pointer">
                                        Laporkan Kehadiran
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                    `;
                } else {
                    // Jika di luar radius, tampilkan pesan dan tombol "Lapor Izin"
                    locationStatus.innerHTML = `
                    @if ($selectedPresensi)
                        @if ($selectedPresensi->jam_masuk)
                            <div class="mt-5 flex flex-col gap-5">
                                <div class="w-full h-fit flex gap-3 items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                                    <i class="ti ti-alert-triangle text-lg"></i>
                                    <p class="text-sm">Kamu tidak berada dalam radius kantor!</p>
                                </div>
                            </div>
                        @else
                            <div class="mt-5 flex flex-col gap-5">
                                <div class="w-full h-fit flex gap-3 items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                                    <i class="ti ti-alert-triangle text-lg"></i>
                                    <p class="text-sm">Kamu tidak berada dalam radius kantor!</p>
                                </div>
                                <form action="{{ route('usernormal.lapor-izin', $selectedPresensi->id) }}" method="get">
                                    <input type="hidden" name="location" value="${userLatitude},${userLongitude}">
                                    <button type="submit" class="w-full bg-red-600 px-4 py-1.5 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-200 text-center cursor-pointer">
                                        Laporkan Izin
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                    `;
                }
            }

            function errorHandler(error) {
                console.warn(`ERROR(${error.code}): ${error.message}`);
                if (locationInput) {
                    locationInput.value = 'Location not available';
                }
                // Tampilkan pesan error jika geolocation gagal
                locationStatus.innerHTML = `
                    <div class="mt-4 text-red-500 text-sm text-center">
                        Gagal mendapatkan lokasi. Pastikan izin lokasi pada browser diaktifkan.
                    </div>
                    <div class="mt-5 flex flex-col gap-5">
                        <form action="{{ route('usernormal.lapor-izin', $selectedPresensi->id) }}" method="get">
                            <input type="hidden" name="location" value="${userLatitude},${userLongitude}">
                            <button type="submit" class="w-full bg-red-600 px-4 py-1.5 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-200 text-center cursor-pointer">
                                Laporkan Izin
                            </button>
                        </form>
                    </div>
                `;
                if (mapLoading) {
                    mapLoading.style.display = 'none';
                }
            }
        }
    });
</script>
