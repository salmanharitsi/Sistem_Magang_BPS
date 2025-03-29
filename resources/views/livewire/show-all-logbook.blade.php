@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-500 flex items-center">
            <i class="ti ti-check-circle mr-2"></i>
            <p>{{ session('success')['title'] }}</p>
        </div>
    @endif
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Bagian Kiri: Carousel Tanggal -->
        <div class="flex flex-col gap-6 w-full md:w-1/2">
            <div
                class="w-full h-fit py-4 px-[53px] card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
                <div id="logbook-carousel" class="overflow-hidden" wire:ignore>
                    <div class="carousel-inner flex transition-transform duration-300 ease-in-out">
                        @php
                            $groupedLogbook = $logbookData->groupBy(function ($item) {
                                return Carbon::parse($item->tanggal)->format('F Y'); // Kelompokkan berdasarkan bulan dan tahun
                            });
                            // Urutkan logbook berdasarkan tanggal untuk menentukan hari ke-berapa
                            $sortedLogbook = $logbookData->sortBy('tanggal');
                            $logbookDayMap = [];
                            foreach ($sortedLogbook as $index => $log) {
                                $logbookDayMap[$log->tanggal] = $index + 1; // Hari ke-1, ke-2, dst
                            }

                        @endphp

                        @foreach ($groupedLogbook as $month => $logbookGroup)
                            <div class="carousel-item w-full flex-shrink-0" data-index="{{ $loop->index }}">
                                <div class="grid grid-cols-4 lg:grid-cols-7 gap-3 md:gap-4 place-items-center">
                                    @php $lastMonth = null; @endphp

                                    @foreach ($logbookGroup as $index => $logbook)
                                        @php
                                            $tanggal = Carbon::parse($logbook->tanggal);
                                            $isSelected = $selectedDate === $logbook->tanggal;
                                            $isFutureDate = $tanggal->greaterThan(Carbon::today()); // Cek apakah tanggal belum berlalu
                                        @endphp

                                        @if ($lastMonth !== $tanggal->month)
                                            <div
                                                class="w-full col-span-4 lg:col-span-7 text-start font-semibold mt-2 mb-2">
                                                {{ $tanggal->translatedFormat('F Y') }} <!-- Contoh: Januari 2024 -->
                                            </div>
                                            @php $lastMonth = $tanggal->month; @endphp
                                        @endif

                                        <!-- Div Bulat Tanggal -->
                                        <div @unless ($isFutureDate) wire:click="selectLogbook('{{ $logbook->tanggal }}')" @endunless
                                            class="flex items-center justify-center w-12 h-12 rounded-full
                                                @if ($isFutureDate) bg-gray-200 text-gray-600 cursor-not-allowed
                                                @elseif ($isSelected) bg-blue-500 text-white
                                                @elseif ($logbook->status === 'mengisi') bg-green-500 text-white
                                                @elseif ($logbook->status === 'tidak-mengisi') bg-red-500 text-white
                                                @else bg-gray-200 @endif
                                                {{ $isFutureDate ? '' : 'cursor-pointer' }}">
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
                    <p class="text-sm">Sudah Mengisi</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <p class="text-sm">Tidak Mengisi</p>
                </div>
            </div>
        </div>


        <!-- Bagian Kanan: Detail Logbook -->
        <div class="w-full md:w-1/2 h-fit card dark:bg-gray-800 sm:rounded-lg overflow-hidden relative">
            @if ($selectedLogbook)
                @php
                    $today = Carbon::today()->toDateString();
                    $selectedDate = Carbon::parse($selectedLogbook->tanggal)->toDateString();
                    $hasContent = $selectedLogbook->status === 'mengisi' && !empty($selectedLogbook->deskripsi);
                    $hariKe = $logbookDayMap[$selectedLogbook->tanggal] ?? 0; // Mendapatkan hari ke-berapa
                @endphp

                @if (
                    $selectedDate == $today &&
                        !$hasContent &&
                        Carbon::now()->lt(Carbon::today()->setHour(17)->setMinute(0)->setSecond(0)))
                    <!-- Form Input Logbook untuk hari ini -->
                    <div class="bg-white p-5 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-2">Tambah Logbook</h2>
                        <p class="text-sm text-gray-600 mb-4">Magang Hari keeee - {{ $hariKe }}</p>

                        <form wire:submit.prevent="store">
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">
                                    Kegiatan<span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea wire:model="deskripsi"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    rows="6" placeholder="Masukkan kegiatAAan" required></textarea>
                                @error('deskripsi')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-5">
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">
                                    Lampiran (Link Google Drive)<span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" wire:model="lampiran"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Masukkan link Google Drive" required />
                                @error('lampiran')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full text-white mt-5 bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
                                Kirim Logbook
                            </button>
                        </form>
                    </div>
                @elseif ($selectedDate == $today && !$hasContent)
                    <!-- Show message that it's past cutoff time -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header Section -->
                        <div class="bg-gray-50 p-5 border-b">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Detail Logbook</h2>
                                    <p class="text-sm text-gray-600">Magang Hari ke - {{ $hariKe }}</p>
                                </div>
                                <div class="px-3 py-1 border border-amber-800 bg-amber-100 text-amber-800 rounded-full font-medium text-sm flex items-center gap-1">
                                    <i class="ti ti-clock"></i>
                                    <p class="text-xs">Menunggu Persetujuan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="p-5">
                            <!-- Date Row -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Tanggal</div>
                                <div class="w-3/5 text-gray-900 font-semibold">
                                    {{ Carbon::parse($selectedLogbook->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <!-- Status Row -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Status</div>
                                <div class="w-3/5">
                                    <div class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded border border-red-700">
                                        <i class="ti ti-x-circle mr-2"></i>
                                        Tidak Mengisi
                                    </div>
                                </div>
                            </div>

                            <!-- Message Row -->
                            <div class="flex items-start py-3">
                                <div class="w-2/5 text-gray-600 font-medium">Keterangan</div>
                                <div class="w-3/5 text-gray-900">
                                    <div class="bg-red-50 p-3 rounded border border-red-200">
                                        <p class="text-red-700">Batas waktu pengisian logbook untuk tanggal ini telah berakhir.</p>
                                        <p class="text-red-600 text-sm mt-1">Logbook harus diisi pada hari yang sama sebelum pukul 17:00.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer with timestamp -->
                        <div class="bg-gray-50 px-5 py-3 text-xs text-gray-500 text-right">
                            Status diperbarui: {{ Carbon::parse($selectedLogbook->updated_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                @elseif ($selectedDate < $today && !$hasContent)
                    <!-- Show message for past dates -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header Section -->
                        <div class="bg-gray-50 p-5 border-b">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Detail Logbook</h2>
                                    <p class="text-sm text-gray-600">Magang Hari ke - {{ $hariKe }}</p>
                                </div>
                                @if ($selectedLogbook->pembimbing_id)
                                    <div class="px-3 py-1 border border-green-800 bg-green-100 text-green-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-check"></i>
                                        <p class="text-xs">Disetujui</p>
                                    </div>
                                @else
                                    <div class="px-3 py-1 border border-amber-800 bg-amber-100 text-amber-800 rounded-full font-medium text-sm flex items-center gap-1">
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
                                    {{ Carbon::parse($selectedLogbook->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <!-- Status Row -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Status</div>
                                <div class="w-3/5">
                                    <div class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded border border-red-700">
                                        <i class="ti ti-x-circle mr-2"></i>
                                        Tidak Mengisi
                                    </div>
                                </div>
                            </div>

                            <!-- Message Row -->
                            <div class="flex items-start py-3">
                                <div class="w-2/5 text-gray-600 font-medium">Keterangan</div>
                                <div class="w-3/5 text-gray-900">
                                    <div class="bg-red-50 p-3 rounded border border-red-200">
                                        <p class="text-red-700">Batas waktu pengisian logbook untuk tanggal ini telah berakhir.</p>
                                        <p class="text-red-600 text-sm mt-1">Logbook harus diisi pada hari yang sama sebelum pukul 17:00.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer with timestamp -->
                        <div class="bg-gray-50 px-5 py-3 text-xs text-gray-500 text-right">
                            Status diperbarui: {{ Carbon::parse($selectedLogbook->updated_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                @else
                    <!-- Tampilan Detail Logbook (untuk yang sudah diisi atau hari lampau) -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header Section with Status Badge -->
                        <div class="bg-gray-50 p-5 border-b">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Detail Logbooaak</h2>
                                    <p class="text-sm text-gray-600">Magang Hari ke - {{ $hariKe }}</p>
                                </div>
                                @if ($selectedLogbook->pembimbing_id)
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
                                    {{ Carbon::parse($selectedLogbook->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            {{-- <!-- Status Row  ratsanya tak butuh e-->
                        <div class="flex items-center py-3 border-b border-gray-100">
                            <div class="w-2/5 text-gray-600 font-medium">Status</div>
                            <div class="w-3/5">
                                @if ($selectedLogbook->status === 'disetujui')
                                    <div
                                        class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded border border-green-700">
                                        <i class="ti ti-check mr-2"></i>
                                        Disetujui
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 rounded border border-amber-700">
                                        <i class="ti ti-clock mr-2"></i>
                                        Menunggu Persetujuan
                                    </div>
                                @endif
                            </div>
                        </div> --}}

                            <!-- Kegiatan Row -->
                            <div class="flex flex-col py-3 border-b border-gray-100">
                                <div class="text-gray-600 font-medium mb-2">Kegiatan</div>
                                <div class="text-gray-900 bg-gray-50 p-3 rounded">
                                    {{ $selectedLogbook->deskripsi ?? 'Tidak ada data' }}
                                </div>
                            </div>

                            <!-- Lampiran Row (Google Drive Link) -->
                            <div class="flex items-center py-3 border-b border-gray-100">
                                <div class="w-2/5 text-gray-600 font-medium">Lampiran</div>
                                <div class="w-3/5">
                                    <a href="{{ $selectedLogbook->lampiran }}" target="_blank"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                                        <i class="ti ti-brand-google-drive mr-2"></i>
                                        Lihat Lampiran
                                    </a>
                                </div>
                            </div>


                            <!-- Komentar Row (jika ada) -->
                            <div class="flex flex-col py-3">
                                <div class="text-gray-600 font-medium mb-2">Komentar Pembimbing</div>
                                @if ($selectedLogbook->status === 'approved')
                                    @if ($selectedLogbook->komentar)
                                        <div class="text-gray-900 bg-blue-50 p-3 rounded border border-blue-200">
                                            {{ $selectedLogbook->komentar }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-gray-500 bg-gray-50 p-3 rounded border border-gray-200">
                                        Belum ada komentar
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer with timestamp -->
                        @if ($selectedLogbook->created_at)
                            <div class="bg-gray-50 px-5 py-3 text-xs text-gray-500 text-right">
                                Terakhir diperbarui:
                                {{ Carbon::parse($selectedLogbook->updated_at)->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <div class="p-5">
                    <div
                        class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                        <div class="flex gap-3 items-start lg:items-center">
                            <i class="ti ti-info-circle text-lg"></i>
                            <p class="text-sm">Silahkan pilih tanggal untuk melihat detail logbook atau menambahkan
                                logbook
                                baru.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('logbook-carousel');
            const carouselInner = carousel.querySelector('.carousel-inner');
            const items = carousel.querySelectorAll('.carousel-item');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            let currentIndex = 0;
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
    </script>
