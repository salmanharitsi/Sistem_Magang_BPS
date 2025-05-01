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
                        placeholder="cari presensi..." required="">
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <div class="flex items-center gap-2">
                <p class="font-semibold">Filter:</p>
                <div class="relative">
                    <select wire:model.live="statusFilter" id="status-filter" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="tidak-hadir">Tidak Hadir</option>
                        <option value="izin">Izin</option>
                    </select>
                </div>
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
                        Hari, Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Keterangan
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($presensi as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $presensi->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{Carbon::parse($data->tanggal)->translatedFormat('l, d F Y')}}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($data->status === 'hadir')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                    Hadir
                                </span>
                            @elseif ($data->status === 'izin')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                    Izin
                                </span>
                            @elseif ($data->status === 'tidak-hadir')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                    Tidak Hadir
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="mx-auto w-fit flex items-center">
                                @if ($data->pembimbing_id && $data->status_review === 'diterima')
                                    <div
                                        class="w-fit px-3 py-1 border border-green-800 bg-green-100 text-green-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-check"></i>
                                        <p class="text-xs">Disetujui</p>
                                    </div>
                                @elseif ($data->pembimbing_id && $data->status_review === 'ditolak')
                                    <div
                                        class="w-fit px-3 py-1 border border-red-800 bg-red-100 text-red-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-x"></i>
                                        <p class="text-xs">Ditolak</p>
                                    </div>
                                @else
                                    <div
                                        class="w-fit px-3 py-1 border border-red-800 bg-red-100 text-red-800 rounded-full font-medium text-sm flex items-center gap-1">
                                        <i class="ti ti-x"></i>
                                        <p class="text-xs">Belum Disetujui</p>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div wire:click.prevent="showDetail('{{ $data->id }}')"
                                class="pjax-link mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200 cursor-pointer">
                                <i class="ti ti-eye"></i>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="8" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Data presensi tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $presensi->links('vendor.pagination.custom-pagination') }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4">
                    <h2 class="text-xl font-semibold">Detail Presensi</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="mt-4">
                    <table class="w-full">
                        <tr>
                            <td class="py-1 pr-4 font-semibold">Tanggal</td>
                            <td class="py-1">: {{ Carbon::parse($selectedData['tanggal'])->translatedFormat('l, j F Y') ?? $selectedData['tanggal'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4 font-semibold">Status</td>
                            <td class="py-1 flex gap-[5px] items-center">:
                                @if ($selectedData['status'] === 'hadir')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                        Hadir
                                    </span>
                                @elseif ($selectedData['status'] === 'izin')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                        Izin
                                    </span>
                                @elseif ($selectedData['status'] === 'tidak-hadir')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                        Tidak Hadir
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @if ($selectedData['pembimbing_id'])
                            <tr>
                                <td class="py-1 pr-4 font-semibold">Diperiksa Oleh</td>
                                <td class="py-1 flex gap-[5px] items-center">:
                                    <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                        <i class="ti ti-user-circle text-lg"></i>
                                        {{ $selectedData['pembimbing_id'] }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @if(isset($selectedData['status']) && $selectedData['status'] === 'izin')
                            <tr>
                                <td class="py-1 pr-4 font-semibold align-top">Lampiran</td>
                                <td class="py-1 flex gap-1 text-sm">
                                    <p>: </p>
                                    @if ($selectedData['lampiran'])
                                        <a href="{{ $selectedData['lampiran'] }}" target="_blank" class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                            <i class="ti ti-brand-google-drive mr-2"></i>Lihat Lampiran
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-500 rounded-md">
                                            Tidak ada lampiran
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-4 font-semibold align-top">Keterangan</td>
                                <td class="py-1 flex gap-1">
                                    <p>: </p>
                                    <div class="w-full text-gray-900 bg-gray-100 p-2.5 rounded-md border border-gray-500 text-sm">
                                        {{ $selectedData['keterangan_izin'] ?? 'Tidak ada keterangan' }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>

                    <!-- Tampilkan foto_masuk dan foto_keluar jika status adalah hadir -->
                    @if(isset($selectedData['status']) && $selectedData['status'] === 'hadir')
                        <div class="flex w-full gap-5 mt-4">
                            <div class="flex justify-center py-1.5 w-1/2 rounded-lg bg-green-100 text-green-800">
                                <p class="font-medium">masuk : {{ $selectedData['jam_masuk'] ?? '' }}</p>
                            </div>
                            <div class="flex justify-center py-1.5 w-1/2 rounded-lg bg-red-100 text-red-800">
                                <p class="font-medium">keluar : {{ $selectedData['jam_keluar'] ?? '--:--:--' }}</p>
                            </div>
                        </div>
                        <div class="flex justify-center gap-5 w-full">
                            <div class="mt-5 w-1/2">                            
                                @if($selectedData['foto_masuk'])
                                    <img src="{{ asset($selectedData['foto_masuk']) }}" alt="Foto Masuk" class="w-full h-auto rounded-lg">
                                @else
                                    <p class="text-gray-500">Foto masuk tidak tersedia.</p>
                                @endif
                            </div>
                            <div class="mt-5 w-1/2">
                                @if($selectedData['foto_keluar'])
                                    <img src="{{ asset($selectedData['foto_keluar']) }}" alt="Foto Keluar" class="w-full h-auto rounded-lg">
                                @else
                                    <p class="text-gray-500">Foto keluar tidak tersedia.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>