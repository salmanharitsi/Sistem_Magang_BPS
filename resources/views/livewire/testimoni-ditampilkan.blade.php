@php
    use Carbon\Carbon;
@endphp

<div class="pegawai-container bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="p-4 border-b border-gray-300">
        <h1 class="font-semibold text-lg text-gray-800">Testimoni yang Ditampilkan di Landing Page</h1>
    </div>
    
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/5">
            <form class="flex items-center">
                <label for="simple-search-displayed" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="ti ti-search text-lg text-gray-500"></i>
                    </div>
                    <input wire:model.live="searchDisplayed" type="text" id="simple-search-displayed"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                        placeholder="Cari Testimoni..." required="">
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto min-h-screen-half">
        <table class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">Nama Peserta</th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">Testimoni</th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">Tanggal</th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($displayedTestimonis as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 text-left">{{ $item->magang->user->name ?? '-' }}</td>
                        <td class="py-4 px-6 text-left">{{ $item->testimoni }}</td>
                        <td class="py-4 px-6 text-left">{{ $item->created_at->format('d-m-Y') }}</td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 w-fit mx-auto items-center">
                                <button wire:click="confirmHide('{{ $item->id }}')"
                                    class="mx-auto w-fit flex items-center gap-1 bg-red-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                    <i class="ti ti-eye-off"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-400">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold">Belum ada testimoni yang ditampilkan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $displayedTestimonis->links('vendor.pagination.custom-pagination') }}
    </div>

    <!-- Modal Konfirmasi Sembunyikan -->
    @if($showHideModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Konfirmasi Sembunyikan Testimoni</h2>
                    <button wire:click="$set('showHideModal', false)" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <p>Apakah Anda yakin ingin menyembunyikan testimoni ini dari landing page?</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showHideModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button wire:click="toggleDisplay" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Ya, Sembunyikan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>