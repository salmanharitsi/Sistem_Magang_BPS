@php
    use Carbon\Carbon;
@endphp
<div class="pegawai-container"> 
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
                        placeholder="cari pegawai..." required="">
                </div>
            </form>
        </div>
        <!-- Filter Button and Dropdown -->
        <div class="relative inline-block text-left">
            <button id="filterButton" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="ti ti-filter mr-2"></i>
                Filter
            </button>
            <div id="filterDropdown" class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50">
                <div class="py-2 px-4">
                    <h3 class="text-gray-700 font-medium mb-2">Filter berdasarkan</h3>
                    
                    <!-- Fungsi Bagian Filter -->
                    <div class="mb-4">
                        <label for="fungsi-bagian-filter" class="block text-sm font-medium text-gray-700 mb-1">Fungsi Bagian</label>
                        <select wire:model.live="filterFungsiBagian" id="fungsi-bagian-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Semua</option>
                            <option value="Fungsi Statistik Sosial">Fungsi Statistik Sosial</option>
                            <option value="Fungsi Statistik Produksi">Fungsi Statistik Produksi</option>
                            <option value="Fungsi Nerwilis">Fungsi Nerwilis</option>
                            <option value="Fungsi Statistik Distribusi">Fungsi Statistik Distribusi</option>
                            <option value="Fungsi IPDS">Fungsi IPSD</option>
                            <option value="Bagian Umum">Bagian Umum</option>
                        </select>
                    </div>
                    
                    <!-- Role Filter -->
                    <div class="mb-4">
                        <label for="role-filter" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select wire:model.live="filterRole" id="role-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Semua</option>
                            <option value="regular">Pembimbing</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <!-- Apply and Reset Buttons -->
                    <div class="flex justify-end pt-2">
                        <button wire:click="resetFilters" type="button" class="mr-2 px-3 py-1 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Reset
                        </button>
                        <button wire:click="applyFilters" type="button" class="px-3 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Minimum height container untuk tabel -->
    <div class="overflow-x-auto min-h-screen-half">
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
                        Fungsi Bagian
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $pegawai->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{$data->name}}
                        </td>
                        <td class="py-4 px-6 text-left">
                            {{$data->fungsi_bagian}}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div
                                class="text-[13px] mx-auto items-center w-fit">
                                @if ($data->role_temp == 'regular')
                                    <p class="text-green-700 border-green-600 bg bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Pembimbing</p>
                                @elseif($data->role_temp == 'admin')
                                    <p class="text-blue-700 border-blue-600 bg-blue-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Admin</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <a href=""
                                class="pjax-link mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="8" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Data Pegawai tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pegawai->links('vendor.pagination.custom-pagination') }}
    </div>

    <style>
        .min-h-screen-half {
            min-height: 50vh;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filterButton');
            const filterDropdown = document.getElementById('filterDropdown');
            
            filterButton.addEventListener('click', function(event) {
                event.stopPropagation();
                filterDropdown.classList.toggle('hidden');
                
                const buttonRect = filterButton.getBoundingClientRect();
                filterDropdown.style.top = (buttonRect.height + 5) + 'px';
            });
            
            document.addEventListener('click', function(event) {
                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</div>