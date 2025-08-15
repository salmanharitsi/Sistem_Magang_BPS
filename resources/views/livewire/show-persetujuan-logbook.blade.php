@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
<div>
    <div class="p-4 border-b border-gray-300">
        <h1 class="font-semibold text-lg text-gray-800">Persetujuan Logbook</h1>
    </div>
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
                        placeholder="cari logbook..." required="">
                </div>
            </form>
        </div>
        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <div class="flex items-center gap-2">
                <p class="font-semibold">Filter:</p>
                <div class="relative">
                    <select wire:model.live="statusFilter" id="status-filter"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                        <option value="">Semua Status</option>
                        <option value="mengisi">Mengisi</option>
                        <option value="tidak-mengisi">Tidak Mengisi</option>
                    </select>
                </div>
            </div>
            @if (count($selectedItems) > 0)
                <button type="button" wire:click="bulkAction"
                    class="flex items-center justify-center text-white bg-green-500 border border-transparent hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 font-medium rounded-lg text-sm px-4 py-2 transition-all duration-200">
                    <i class="ti ti-check mr-2"></i>
                    Setujui {{ count($selectedItems) }} dokumen
                </button>
            @endif
        </div>
    </div>
    <div class="overflow-x-auto">
        <table id="dataIkuTable" class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="p-4 w-4 text-center">
                        <div class="flex items-center justify-center">
                            <input id="checkbox-all" type="checkbox" wire:model.live="selectAll"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="checkbox-all" class="sr-only">Pilih Semua</label>
                        </div>
                    </th>
                    <th scope="col" class="p-4 w-4 text-left">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Hari, Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Jenis Magang
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logbook as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="p-4 w-4 text-center">
                            <div class="flex items-center justify-center">
                                <input id="checkbox-{{ $data->id }}" type="checkbox" wire:model.live="selectedItems"
                                    value="{{ $data->id }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="checkbox-{{ $data->id }}" class="sr-only">Pilih item</label>
                            </div>
                        </td>
                        <td class="py-4 px-6 w-[30px]">{{ $logbook->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{ $data->magang->user->name }}
                        </td>
                        <td class="py-4 px-6 text-left whitespace-nowrap">
                            {{ Carbon::parse($data->tanggal)->translatedFormat('l, j F Y') }}</td>
                        <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->magang->jenis_magang }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="text-[13px] mx-auto items-center w-fit">
                                @if ($data->status == 'mengisi')
                                    <p
                                        class="text-xs text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">
                                        Mengisi</p>
                                @elseif($data->status == 'tidak-mengisi')
                                    <p
                                        class="text-xs text-red-700 border-red-600 bg-red-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">
                                        Tidak Mengisi</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" wire:click.prevent="showDetail('{{ $data->id }}')"
                                class="pjax-link w-fit mx-auto flex items-center gap-1 bg-green-500 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 transition-all duration-200">
                                <i class="ti ti-check"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="8" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Data logbook tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $logbook->links('vendor.pagination.custom-pagination') }}
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4">
                    <h2 class="text-xl font-semibold">Detail Logbook</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="mt-4">
                    <table class="w-full">
                        <tr>
                            <td class="py-1 pr-4 font-semibold">Nama</td>
                            <td class="py-1">: {{ $selectedData['nama'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4 font-semibold">Tanggal</td>
                            <td class="py-1">:
                                {{ Carbon::parse($selectedData['tanggal'])->translatedFormat('l, j F Y') ?? ($selectedData['tanggal'] ?? '') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4 font-semibold">Status</td>
                            <td class="py-1 flex gap-[5px] items-center">
                                <p>: </p>
                                <select wire:model.live="selectedData.status"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1">
                                    <option value="mengisi"
                                        {{ $selectedData['status'] === 'mengisi' ? 'selected' : '' }}>Mengisi</option>
                                    <option value="tidak-mengisi"
                                        {{ $selectedData['status'] === 'tidak-mengisi' ? 'selected' : '' }}>Tidak
                                        Mengisi</option>
                                </select>
                                <div
                                    class="flex items-center py-[6px] px-1.5 rounded-md border border-yellow-800 bg-yellow-100 text-yellow-800 text-xs text-center font-medium dark:bg-yellow-900 dark:text-yellow-300">
                                    <i class="ti ti-alert-circle mr-1"></i>
                                    <p class="whitespace-nowrap">status dapat diubah</p>
                                </div>
                            </td>
                        </tr>
                        @if (isset($selectedData['status']) && $selectedData['status'] === 'mengisi')
                            <tr>
                                <td class="py-1 pr-4 font-semibold align-top">Kegiatan</td>
                                <td class="py-1 flex gap-1">
                                    <p>: </p>
                                    @if ($selectedData['status'] === 'mengisi' && $originalStatus === 'tidak-mengisi')
                                        {{-- Tampilkan textarea jika mengubah dari tidak-mengisi ke mengisi --}}
                                        <textarea wire:model="selectedData.deskripsi"
                                            class="w-full text-gray-900 bg-gray-100 p-2.5 rounded-md border border-gray-500 text-sm" rows="4">{{ $selectedData['deskripsi'] }}</textarea>
                                    @else
                                        {{-- Tampilkan sebagai teks biasa jika status awal sudah mengisi --}}
                                        <p class="text-gray-900">{{ $selectedData['deskripsi'] }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-4 font-semibold align-top">Lampiran</td>
                                <td class="py-1 flex gap-1">
                                    <p>: </p>
                                    @if ($selectedData['status'] === 'mengisi' && $originalStatus === 'tidak-mengisi')
                                        {{-- Tampilkan input jika mengubah dari tidak-mengisi ke mengisi --}}
                                        <input type="text" wire:model="selectedData.lampiran"
                                            class="w-full text-gray-900 bg-gray-100 p-2.5 rounded-md border border-gray-500 text-sm"
                                            placeholder="Masukkan link Google Drive...">
                                    @else
                                        {{-- Tampilkan sebagai link jika status awal sudah mengisi --}}
                                        <a href="{{ $selectedData['lampiran'] }}" target="_blank"
                                            class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                            <i class="ti ti-brand-google-drive mr-2"></i>Lihat Lampiran
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>
                    @if ($selectedData['status'] === 'mengisi')
                    <div class="mt-6">
                        <div class="w-2/5 text-black font-semibold mb-2">
                            Komentar Pembimbing <span class="text-red-500">*</span>
                        </div>
                        <textarea wire:model="selectedData.komentar"
                            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px] {{ session()->has('error') ? 'border-red-500' : '' }}"
                            rows="4" placeholder="Tambahkan komentar atau catatan untuk peserta magang..."></textarea>
                        @if (session()->has('error'))
                            <p class="text-red-500 text-[11px]">
                                {{ session('error')['title'] }}
                            </p>
                        @endif
                    </div>            
                    @endif
                    

                    <div class="mt-4 flex gap-5">
                        <button wire:click="tolakLogbook"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all duration-200">
                            Tolak Dokumen
                        </button>
                        <button wire:click="approveLogbook"
                            class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-200">
                            Setujui Dokumen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>