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
                <div id="logbook-carousel" class="overflow-hidden" wire:ignore>
                    <div class="carousel-inner flex transition-transform duration-300 ease-in-out">
                        @php
                            $groupedLogbook = $logbookData->groupBy(function ($item) {
                                return Carbon::parse($item->tanggal)->format('F Y'); // Kelompokkan berdasarkan bulan dan tahun
                            });
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
                                                class="w-full col-span-4 lg:col-span-7 text-start font-semibold mt-2 text-xl mb-3">
                                                {{ $tanggal->translatedFormat('F Y') }} <!-- Contoh: Januari 2024 -->
                                            </div>
                                            @php $lastMonth = $tanggal->month; @endphp
                                        @endif

                                        <!-- Div Bulat Tanggal -->
                                        <div @unless ($isFutureDate) wire:click="selectLogbook('{{ $logbook->tanggal }}')" @endunless
                                            class="flex items-center justify-center w-12 h-12 rounded-full
                                                @if ($isSelected) 
                                                    bg-blue-500 text-white
                                                @elseif ($tanggal->isWeekend())
                                                    bg-red-500 text-white
                                                @elseif ($logbook->status === 'mengisi') 
                                                    bg-green-500 text-white
                                                @elseif ($logbook->status === 'tidak-mengisi') 
                                                    bg-red-500 text-white
                                                @else 
                                                    bg-gray-200 
                                                @endif
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
            <div class="bg-white p-5 rounded-lg card grid grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <p class="text-sm">Hari Ini</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <p class="text-sm">Mengisi</p>
                </div>
                <div class="flex items-center justify-start lg:justify-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <p class="text-sm">Tidak Mengisi</p>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Detail Logbook -->
        <div class="w-full md:w-1/2 h-fit card dark:bg-gray-800 sm:rounded-lg overflow-hidden relative">
            @if ($selectedDate)
                @if (Carbon::parse($selectedDate)->isWeekend())
                    <!-- Weekend Display -->
                    <div class="p-5">
                        <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                            <div class="flex gap-3 items-start lg:items-center">
                                <i class="ti ti-sparkles text-lg"></i>
                                <p class="text-sm">Logbook tidak tersedia pada akhir pekan!</p>
                            </div>
                        </div>
                    </div>
                @elseif($selectedLogbook)
                    @php
                        $today = Carbon::today()->toDateString();
                        $selectedDate = Carbon::parse($selectedLogbook->tanggal)->toDateString();
                        $isWeekend = Carbon::parse($selectedLogbook->tanggal)->isWeekend();
                        $hasContent = $selectedLogbook->status === 'mengisi' && !empty($selectedLogbook->deskripsi);
                        $isPastCutoff = Carbon::now()->gte(Carbon::today()->setHour(17));
                    @endphp
            
                    @if ($isWeekend)
                        
                    @elseif ($selectedDate == $today && !$hasContent && !$isPastCutoff)
                        <!-- Form Input Logbook -->
                        <div class="bg-white p-5 rounded-lg shadow-md">
                            <h2 class="text-xl font-semibold">Pengisian Logbook</h2>
                            <p class="text-sm text-gray-600 mb-4">Magang Hari ke - {{ $hariKe }}</p>
                            <form wire:submit.prevent="store">
                                <div>
                                    <label class="block mb-2 text-[15px] font-medium text-gray-700">
                                        Kegiatan<span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <textarea wire:model.live="deskripsi" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" rows="6" placeholder="Masukkan kegiatan"></textarea>
                                    @error('deskripsi')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
                                </div>
                                <div class="mt-5">
                                    <label class="block mb-2 text-[15px] font-medium text-gray-700">
                                        Lampiran <span class="text-[10px]">(Link Google Drive)</span><span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" wire:model.live="lampiran" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="Masukkan link Google Drive" />
                                    @error('lampiran')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
                                </div>
                                <button type="submit" class="w-full text-white mt-5 bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
                                    Kirim Logbook
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Logbook Detail Display -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="bg-gray-50 p-5 border-b">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-800">Detail Logbook</h2>
                                        <p class="text-sm text-gray-600">Magang Hari ke - {{ $hariKe }}</p>
                                    </div>
                                    @if($selectedLogbook->pembimbing_id)
                                        <div class="px-3 py-1 border border-green-800 bg-green-100 text-green-800 rounded-full font-medium text-sm flex items-center gap-1">
                                            <i class="ti ti-check"></i><p class="text-xs">Disetujui</p>
                                        </div>
                                    @else
                                        <div class="px-3 py-1 border border-amber-800 bg-amber-100 text-amber-800 rounded-full font-medium text-sm flex items-center gap-1">
                                            <i class="ti ti-clock"></i><p class="text-xs">Menunggu Persetujuan</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
            
                            <div class="p-5">
                                <div class="flex items-center py-3 border-b border-gray-100">
                                    <div class="w-2/5 text-gray-600 font-medium">Tanggal</div>
                                    <div class="w-3/5 text-gray-900 font-semibold">
                                        {{ Carbon::parse($selectedLogbook->tanggal)->translatedFormat('l, d F Y') }}
                                    </div>
                                </div>
            
                                @if(!$hasContent)
                                    <div class="flex items-center py-3 border-b border-gray-100">
                                        <div class="w-2/5 text-gray-600 font-medium">Status</div>
                                        <div class="w-3/5">
                                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                                Tidak Mengisi
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex flex-col gap-5">
                                        <div class="w-full h-fit flex gap-3 items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                                            <i class="ti ti-alert-triangle text-lg"></i>
                                            <p class="text-sm">Batas waktu pengisian logbook untuk tanggal ini telah berakhir!</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-start py-3 border-b border-gray-100">
                                        <div class="w-2/5 text-gray-600 font-medium">Kegiatan</div>
                                        <div class="w-3/5 text-gray-900 bg-gray-100 p-3 rounded-md border border-gray-500 text-sm">
                                            {{ $selectedLogbook->deskripsi }}
                                        </div>
                                    </div>
            
                                    <div class="flex items-center py-3 border-b border-gray-100">
                                        <div class="w-2/5 text-gray-600 font-medium">Lampiran</div>
                                        <div class="w-3/5 text-sm">
                                            <a href="{{ $selectedLogbook->lampiran }}" target="_blank" class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                                <i class="ti ti-brand-google-drive mr-2"></i>Lihat Lampiran
                                            </a>
                                        </div>
                                    </div>
            
                                    @if ($selectedLogbook->komentar)
                                        <div class="flex items-start py-3">
                                            <div class="w-2/5 text-gray-600 font-medium">Komentar Pembimbing</div>
                                            <div class="w-3/5 text-gray-900 bg-gray-100 p-3 rounded-md border border-gray-500 text-sm">
                                                {{ $selectedLogbook->komentar }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
            
                            <div class="bg-gray-50 px-5 py-3 text-xs text-gray-500 text-right">
                                Status diperbarui: {{ Carbon::parse($selectedLogbook->updated_at)->format('d M Y H:i') }}
                            </div>
                        </div>
                    @endif
                @endif
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
    </script>
