@php
    use Carbon\Carbon;
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
                        placeholder="cari pengajuan..." required="">
                </div>
            </form>
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
                        Jenis Magang
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Bidang Tujuan
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Tanggal Mulai
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Tanggal Selesai
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Tanggal Diajukan
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $pengajuan->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{$data->jenis_magang}}
                        </td>
                        <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->bidang_tujuan }}</td>
                        </td>
                        <td class="py-4 px-6 text-left">{{ Carbon::parse($data->tanggal_mulai)->format('j-F-Y') }}
                        </td>
                        <td class="py-4 px-6 text-left">{{ Carbon::parse($data->tanggal_selesai)->format('j-F-Y') }}
                        </td>
                        <td class="py-4 px-6 text-left">{{ $data->created_at->format('j-F-Y') }}</td>
                        <td class="py-4 px-6">
                            <p
                                class="px-3 py-1 text-[13px] rounded-full text-amber-700 border-amber-600 border-2 flex justify-between w-fit items-center bg-amber-50">
                                @if ($data->status_pengajuan == 'waiting')
                                    menunggu
                                @elseif($data->status_pengajuan == 'reject')
                                    ditolak
                                @endif
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            <a href=""
                                class="pjax-link w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="7" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Belum ada data pengajuan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $pengajuan->links('vendor.pagination.custom-pagination') }}
    </div>
</div>
