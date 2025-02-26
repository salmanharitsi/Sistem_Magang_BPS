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
                        placeholder="cari magang..." required="">
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
                        <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->bidang_tujuan }}</td>
                        </td>
                        <td class="py-4 px-6 text-left flex flex-col items-center gap-3">
                            <div class="px-3 py-1 bg-green-50 border-2 border-green-600 rounded-full text-green-700 text-xs whitespace-nowrap">{{ Carbon::parse($data->tanggal_mulai)->format('j-F-Y') }}</div>
                            <div class="px-3 py-1 bg-red-50 border-2 border-red-600 rounded-full text-red-700 text-xs whitespace-nowrap">{{ Carbon::parse($data->tanggal_selesai)->format('j-F-Y') }}</div>
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
                                @elseif($data->status_magang == 'active' && Carbon::parse($data->tanggal_mulai)->isPast())
                                    <p class="text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Berlangsung</p>
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
                            <p class="font-semibold text-md">Data magang tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $magang->links('vendor.pagination.custom-pagination') }}
    </div>
</div>