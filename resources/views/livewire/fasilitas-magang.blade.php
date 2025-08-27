<div class="pegawai-container">
    <div class="p-4 border-b border-gray-300">
        <h1 class="font-semibold text-lg text-gray-800">Fasilitas Foto</h1>
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
                        placeholder="Cari Fasilitas..." required="">
                </div>
            </form>
        </div>
        <div class="flex space-x-2">
            <button wire:click="create" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="ti ti-plus mr-2"></i>
                Tambah Fasilitas
            </button>
        </div>
    </div>

    <div class="overflow-x-auto min-h-screen-half">
        <table class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">Judul</th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">Foto</th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fasilitas as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 text-left">{{ $item->judul }}</td>
                        <td class="py-4 px-6 text-left">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="Foto" class="w-24 h-16 object-cover rounded">
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 w-fit mx-auto items-center">
                                <button wire:click="edit({{ $item->id }})" class="mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="mx-auto w-fit flex items-center gap-1 bg-red-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-10 text-gray-400">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold">Data fasilitas tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $fasilitas->links('vendor.pagination.custom-pagination') }}
    </div>

    <!-- Modal Edit -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">{{ $isEdit ? 'Edit Foto' : 'Tambah Foto' }}</h2>
                    <button wire:click="resetModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div>
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Judul<span class="text-red-500 ml-1">*</span></label>
                        <input wire:model.defer="judul" name="judul" id="judul" type="text" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]" placeholder="Masukkan judul foto">
                        @error('judul') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-5">
                        <label class="block mb-2 text-[15px] font-medium text-gray-700">Foto<span class="text-red-500 ml-1">*</span></label>
                        <div class="flex flex-col md:flex-row items-center px-2 py-3 mt-2 justify-between text-blue-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-file-image text-2xl text-gray-700"></i>
                                @if ($image)
                                    <p class="text-gray-600 text-sm">{{ $image->getClientOriginalName() }}</p>
                                @elseif ($isEdit && $image_path)
                                    <p class="text-gray-600 text-sm">Foto sudah diupload</p>
                                @else
                                    <p class="text-sm">Belum ada foto yang diupload</p>
                                @endif
                            </div>
                            @if ($image)
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                        onclick="openPreview('{{ $image->temporaryUrl() }}')">
                                        Lihat file
                                    </button>
                                    <div>
                                        <input type="file" accept=".png, .jpg, .jpeg" name="image"
                                            id="image" wire:model.live="image" class="hidden" />
                                        <label for="image"
                                            class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                            Ganti file
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <input type="file" accept=".png, .jpg, .jpeg" name="image" id="image"
                                        wire:model.live="image" class="hidden" />
                                    <label for="image"
                                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                                        Upload file
                                    </label>
                                </div>
                            @endif
                        </div>
                        @if($isEdit && $image_path && !$image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $image_path) }}" alt="Foto lama" class="w-24 h-16 object-cover rounded">
                                <span class="text-xs text-gray-400">Foto saat ini</span>
                            </div>
                        @endif
                        @if($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-24 h-16 object-cover rounded">
                                <span class="text-xs text-gray-400">Preview foto baru</span>
                            </div>
                        @endif
                        @error('image') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4 flex">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                            {{ $isEdit ? 'Update Foto' : 'Tambah Foto' }}
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
                    <p>Apakah Kamu yakin ingin menghapus foto: "<span class="font-semibold">{{ $deleteTitle }}</span>"</p>
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

<script>
function openPreview(url) {
    const screenWidth = window.screen.width;
    const screenHeight = window.screen.height;
    const width = screenWidth / 2;
    const height = screenHeight / 2;
    const left = (screenWidth - width) / 2;
    const top = (screenHeight - height) / 2;

    const newWindow = window.open(
        '',
        '',
        `width=${width},height=${height},top=${top},left=${left}`
    );

    if (newWindow) {
        newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
        newWindow.document.title = "Image Preview";
    } else {
        alert('Preview foto tidak tersedia di tampilan mobile');
    }
}
</script>
