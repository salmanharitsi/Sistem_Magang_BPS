@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
<div>
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/5">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="ti ti-search text-lg text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="cari magang..." required="">
                </div>
            </form>
        </div>
        
        
        <div class="relative inline-block text-left" id="filterContainer">

            @if($isFiltered)
            <div class="inline-flex items-center px-4 py-2 text-sm font-medium bg-green-50 border-2 border-green-600 rounded-full text-green-700 text-xs whitespace-nowrap rounded-lg mr-4">
                <span class=" text-center font-medium text-white-600">{{ $totalMagangAktif }} Peserta Magang</span>
            </div>
            @endif
            
            <button id="filterButton" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="ti ti-filter mr-2"></i>
                Filter
            </button>
        </div>
    </div>
    
    <!-- Filter dropdown -->
    <div id="filterDropdown"
         class="hidden fixed rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
         style="z-index: 9999;">
        <div class="p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="status-filter"
                        class="block text-[15px] font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="statusFilter" id="status-filter" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                        <option value="">Semua Status</option>
                        <option value="segera-dimulai">Segera Dimulai</option>
                        <option value="berlangsung">Berlangsung</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
    
                <div class="mb-4">
                    <label for="fungsi-bagian-filter"
                        class="block text-[15px] font-medium text-gray-700 mb-1">Bidang Tujuan</label>
                    <select wire:model.defer="filterFungsiBagian" id="fungsi-bagian-filter"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                        <option value="">Semua</option>
                        @foreach ($listFungsiBagian as $fungsi)
                                @if ($fungsi->title != 'Pimpinan')
                                    <option value="{{ $fungsi->title }}">{{ $fungsi->title }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="asal-instansi-filter"
                        class="block text-[15px] font-medium text-gray-700 mb-1">Asal Instansi</label>
                    <select wire:model.defer="filterAsalInstansi" id="asal-instansi-filter"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                        <option value="">Semua</option>
                        @foreach ($listAsalInstansi as $instansi)
                            <option value="{{ $instansi }}">{{ $instansi }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="pembimbing-filter" class="block text-[15px] font-medium text-gray-700 mb-1">Pembimbing</label>
                    <select wire:model.defer="filterPembimbing" id="pembimbing-filter"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                        <option value="">Semua</option>
                        @foreach ($listPembimbing as $pembimbing)
                            <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3.5">
                <label class="block text-[15px] font-medium text-gray-700 mb-1">Periode Magang</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="filter-bulan-mulai" class="block text-xs text-gray-500 mb-1">Bulan Mulai</label>
                        <select wire:model.defer="filterBulanMulai" id="filter-bulan-mulai"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Pilih Bulan</option>
                            @foreach ($listBulan as $key => $bulan)
                                <option value="{{ $key }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filter-bulan-selesai" class="block text-xs text-gray-500 mb-1">Bulan Selesai</label>
                        <select wire:model.defer="filterBulanSelesai" id="filter-bulan-selesai"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Pilih Bulan</option>
                            @foreach ($listBulan as $key => $bulan)
                                <option value="{{ $key }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                        @error('filterBulanSelesai')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex">
                <button wire:click="applyFilters" type="button"
                    class="px-3 py-2 w-full text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table id="dataIkuTable" class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="p-4 w-4 text-left">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Jenis Magang
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Bidang Tujuan
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Periode Magang
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Pembimbing
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($magang as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $magang->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{$data->user->name}}
                        </td>
                        <td class="py-4 px-6 text-left">
                            {{$data->jenis_magang}}
                        </td>
                        <td class="py-4 px-6 text-left">{{ $data->bidang_tujuan }}</td>
                        </td>
                        <td class="py-4 px-6 text-left flex flex-col items-center gap-3">
                            <div class="px-3 py-1 bg-green-50 border-2 border-green-600 rounded-full text-green-700 text-xs whitespace-nowrap">{{ Carbon::parse($data->tanggal_mulai)->translatedFormat('j F Y') }}</div>
                            <div class="px-3 py-1 bg-red-50 border-2 border-red-600 rounded-full text-red-700 text-xs whitespace-nowrap">{{ Carbon::parse($data->tanggal_selesai)->translatedFormat('j F Y') }}</div>
                        </td>
                        <td class="py-4 px-6 text-left">
                            <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                <i class="ti ti-user-circle text-lg"></i>
                                {{ $data->pembimbingPertama->name }}
                            </div>
                            @if($data->pembimbingKedua)
                            <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                <i class="ti ti-user-circle text-lg"></i>
                                {{ $data->pembimbingKedua->name }}
                            </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div
                                class="text-[13px] mx-auto items-center w-fit">
                                @if ($data->status_magang == 'active' && Carbon::parse($data->tanggal_mulai)->isFuture())
                                    <p class="text-amber-700 border-amber-600 bg-amber-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Segera dimulai</p>
                                @elseif($data->status_magang == 'active' && Carbon::parse($data->tanggal_mulai)->isPast() && Carbon::parse($data->tanggal_selesai)->addDays(1)->isFuture())
                                    <p class="text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Berlangsung</p>
                                @elseif($data->status_magang == 'active' && Carbon::parse($data->tanggal_selesai)->addDays(1)->isPast())
                                    <p class="text-gray-700 border-gray-600 bg-gray-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Selesai</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <a href="/daftar-bimbingan/{{ $data->id }}"
                                class="pjax-link mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="8" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Data magang tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $magang->links('vendor.pagination.custom-pagination') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.getElementById('filterButton');
        const filterDropdown = document.getElementById('filterDropdown');
        const filterContainer = document.getElementById('filterContainer');

        filterButton.addEventListener('click', function(event) {
            event.stopPropagation();
            filterDropdown.classList.toggle('hidden');
            
            // Position the dropdown based on the button's position
            const buttonRect = filterButton.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Responsive positioning based on screen size
            if (window.innerWidth < 768) { // Mobile view
                // Center the dropdown in mobile view
                filterDropdown.style.left = '50%';
                filterDropdown.style.right = 'auto';
                filterDropdown.style.transform = 'translateX(-50%)';
                filterDropdown.style.width = '90%';
                filterDropdown.style.maxWidth = '400px';
            } else { // Desktop view
                filterDropdown.style.transform = 'none';
                filterDropdown.style.left = 'auto';
                filterDropdown.style.right = (window.innerWidth - buttonRect.right) + 'px';
                filterDropdown.style.width = '400px';
            }
            
            // Set the vertical position
            filterDropdown.style.top = (buttonRect.bottom + scrollTop) + 'px';
        });

        document.addEventListener('click', function(event) {
            if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                filterDropdown.classList.add('hidden');
            }
        });
        
        // Add resize event listener to reposition dropdown when window is resized
        window.addEventListener('resize', function() {
            if (!filterDropdown.classList.contains('hidden')) {
                const buttonRect = filterButton.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (window.innerWidth < 768) { // Mobile view
                    // Center the dropdown in mobile view
                    filterDropdown.style.left = '50%';
                    filterDropdown.style.right = 'auto';
                    filterDropdown.style.transform = 'translateX(-50%)';
                    filterDropdown.style.width = '90%';
                    filterDropdown.style.maxWidth = '400px';
                } else { // Desktop view
                    filterDropdown.style.transform = 'none';
                    filterDropdown.style.left = 'auto';
                    filterDropdown.style.right = (window.innerWidth - buttonRect.right) + 'px';
                    filterDropdown.style.width = '400px';
                }
                
                filterDropdown.style.top = (buttonRect.bottom + scrollTop) + 'px';
            }
        });
    });
    </script>
</div>