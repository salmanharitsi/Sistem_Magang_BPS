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
                        placeholder="Cari FAQ..." required="">
                </div>
            </form>
        </div>
        <div class="flex space-x-2">
            <button wire:click="create" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="ti ti-plus mr-2"></i>
                Tambah FAQ
            </button>            
        </div>
    </div>

    <div class="overflow-x-auto min-h-screen-half">
    <table class="w-full text-sm text-left rtl:text-left">
        <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
            <tr class="h-full">
                <th scope="col" class="px-6 py-3 border-l border-white text-left">Pertanyaan</th>
                <th scope="col" class="px-6 py-3 border-l border-white text-left">Jawaban</th>
                <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faqs as $faq)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 text-left">{{ $faq->question }}</td>
                    <td class="py-4 px-6 text-left">{{ $faq->answer }}</td>
                    <td class="py-4 px-6">
                        <button wire:click="edit({{ $faq->id }})" class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">
                            <i class="ti ti-edit"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-10 text-gray-400">
                        <i class="ti ti-file-x text-4xl"></i>
                        <p class="font-semibold">Data FAQ tidak ditemukan</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <!-- Modal Edit -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-lg font-semibold mb-4">{{ $isEdit ? 'Edit FAQ' : 'Tambah FAQ' }}</h2>
                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div class="mb-3">
                        <label class="block text-sm font-medium">Pertanyaan</label>
                        <input wire:model.defer="question" type="text" class="w-full border rounded-lg p-2">
                        @error('question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium">Jawaban</label>
                        <textarea wire:model.defer="answer" class="w-full border rounded-lg p-2"></textarea>
                        @error('answer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="resetModal" class="bg-gray-400 px-4 py-2 text-white rounded-lg">Batal</button>
                        <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
