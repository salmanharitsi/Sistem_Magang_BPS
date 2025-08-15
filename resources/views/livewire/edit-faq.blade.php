@php
    use Carbon\Carbon;
@endphp

<div class="pegawai-container">
    <div class="p-4 border-b border-gray-300">
        <h1 class="font-semibold text-lg text-gray-800">Frequently asked questions (FAQ)</h1>
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
                        placeholder="Cari FAQ..." required="">
                </div>
            </form>
        </div>
        <div class="flex space-x-2">
            <button wire:click="create" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                            <div class="flex gap-2 w-fit mx-auto items-center">
                                <button wire:click="edit({{ $faq->id }})" class="mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $faq->id }})" class="mx-auto w-fit flex items-center gap-1 bg-red-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
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
        <!-- Custom Pagination -->
        {{ $faqs->links('vendor.pagination.custom-pagination') }}
    </div>

    <!-- Modal Edit -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">{{ $isEdit ? 'Edit FAQ' : 'Tambah FAQ' }}</h2>
                    <button wire:click="resetModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div>
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Pertanyaan<span class="text-red-500 ml-1">*</span></label>
                        <input wire:model.defer="question" name="question" id="question" type="text" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]" placeholder="Masukkan pertanyaan FAQ">
                        @error('question') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-5">
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Jawaban<span class="text-red-500 ml-1">*</span></label>
                        <textarea wire:model.defer="answer" name="answer" id="answer" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]" placeholder="Masukkan jawaban pertanyaan FAQ"></textarea>
                        @if($errors->has('answer'))
                            <span class="text-red-500 text-[11px]">{{ $errors->first('answer') }}</span>
                        @endif
                    </div>

                    <div class="mt-4 flex">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                            {{ $isEdit ? 'Update FAQ' : 'Tambah FAQ' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Delete -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Konfirmasi Hapus</h2>
                    <button wire:click="$set('showDeleteModal', false)" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <p>Apakah Kamu yakin ingin menghapus FAQ: "<span class="font-semibold">{{ $deleteQuestion }}</span>"</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button wire:click="delete" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
