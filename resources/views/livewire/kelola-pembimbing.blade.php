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
                        placeholder="cari peserta magang..." required="">
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <div class="flex items-center gap-2">
                <p class="font-semibold">Filter:</p>
                <div class="relative">
                    <select wire:model.live="statusFilter" id="status-filter" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5">
                        <option value="">Semua Fungsi Bagian</option>
                        @foreach ($listFungsiBagian as $fungsi)
                        @if ($fungsi->title != 'Pimpinan')
                        <option value="{{ $fungsi->title }}">{{ $fungsi->title }}</option>
                    @endif
                        @endforeach
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
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Institusi
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Bidang Tujuan
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Pembimbing 1
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Pembimbing 2
                    </th>
                    @if ($isAdmin)
                        <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                            Aksi
                        </th>
                    @endif
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
                            {{$data->pengajuan->institusi}}
                        </td>
                        <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->bidang_tujuan }}</td>
                        <td class="py-4 px-6 text-left">
                            <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                <i class="ti ti-user-circle text-lg"></i>
                                {{ $data->pembimbingPertama->name }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-left">
                            @if($data->pembimbingKedua)
                                <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                    <i class="ti ti-user-circle text-lg"></i>
                                    {{ $data->pembimbingKedua->name }}
                                </div>
                            @else
                                <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                    -
                                </div>
                            @endif
                        </td>
                        @if ($isAdmin)
                            <td class="py-4 px-6">
                                <button wire:click.prevent="confirmEdit('{{$data->id}}')"
                                    class="mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </td>
                        @endif
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

    @if ($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Edit Pembimbing Magang</h2>
                    <button wire:click="resetModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form wire:submit.prevent="updatePembimbing">
                    <div class="mb-4">
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Bidang Tujuan<span class="text-red-500 ml-1">*</span></label>
                        <select wire:model.live="selectedBidangTujuan" id="bidang_tujuan" 
                            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Pilih Bidang Tujuan</option>
                            @foreach ($listFungsiBagian as $fungsi)
                                @if ($fungsi->title != 'Pimpinan')
                                    <option value="{{ $fungsi->id }}">{{ $fungsi->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('selectedBidangTujuan') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Pembimbing Pertama<span class="text-red-500 ml-1">*</span></label>
                        <select wire:model.live="selectedPembimbing1" id="pembimbing1" 
                            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Pilih Pembimbing Pertama</option>
                            @foreach ($pembimbingList as $pembimbing)
                                <option value="{{ $pembimbing->id }}" {{ $selectedPembimbing1 == $pembimbing->id ? 'selected' : '' }}>
                                    {{ $pembimbing->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('selectedPembimbing1'))
                            <span class="text-red-500 text-[11px]">{{ $errors->first('selectedPembimbing1') }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Pembimbing Kedua</label>
                        <select wire:model.defer="selectedPembimbing2" id="pembimbing2" 
                            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Pilih Pembimbing Kedua (Opsional)</option>
                            @foreach ($pembimbingList2 as $pembimbing)
                                <option value="{{ $pembimbing->id }}" {{ $selectedPembimbing2 == $pembimbing->id ? 'selected' : '' }}>
                                    {{ $pembimbing->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-5 flex">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>