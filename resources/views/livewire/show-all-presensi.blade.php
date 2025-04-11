@php
    use Carbon\Carbon;
@endphp

<div class="flex flex-col md:flex-row gap-6">
    <!-- Bagian Kiri: Carousel Tanggal -->
    <div class="w-full md:w-1/2 h-fit py-4 px-[53px] card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
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
                                    <div class="w-full col-span-4 lg:col-span-7 text-start font-semibold mt-2 mb-2">
                                        {{ $tanggal->translatedFormat('F Y') }} <!-- Contoh: Januari 2024 -->
                                    </div>
                                    @php $lastMonth = $tanggal->month; @endphp
                                @endif
        
                                <!-- Div Bulat Tanggal -->
                                <div @unless ($isFutureDate) wire:click="selectPresensi('{{ $presensi->tanggal }}')" @endunless
                                    class="flex items-center justify-center w-12 h-12 rounded-full 
                                        {{ $isSelected ? 'bg-blue-500 text-white' : 'bg-gray-200' }} 
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

    <!-- Bagian Kanan: Detail Presensi -->
    <div class="w-full md:w-1/2 h-fit card dark:bg-gray-800 sm:rounded-lg overflow-hidden relative md:sticky md:top-28">
        @if ($selectedPresensi)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Detail Presensi</h2>
                <p><strong>Tanggal:</strong> {{ Carbon::parse($selectedPresensi->tanggal)->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ $selectedPresensi->status }}</p>
                <p><strong>Jam Masuk:</strong> {{ $selectedPresensi->jam_masuk ?? 'Belum ada data' }}</p>
                <p><strong>Jam Keluar:</strong> {{ $selectedPresensi->jam_keluar ?? 'Belum ada data' }}</p>
                <p><strong>Keterangan Izin:</strong> {{ $selectedPresensi->keterangan_izin ?? 'Tidak ada keterangan' }}
                </p>
            </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('presensi-carousel');
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
