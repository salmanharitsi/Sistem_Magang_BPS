<form class="grid gap-5" wire:submit.prevent="submit_izin">
    <div>
        <h4 class="font-semibold mb-2">Keterangan Perizinan<span class="text-red-500 ml-1">*</span></h4>
        <textarea maxlength="250" name="keterangan_izin" id="keterangan_izin" wire:model.live="keterangan_izin"
            class="min-h-36 bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
            placeholder="Masukkan keterangan izin..."></textarea>
        @error('keterangan_izin')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <h4 class="font-semibold mb-2">Lampiran <span class="text-xs font-normal">(opsional)</span></h4>
        <div
            class="flex flex-col md:flex-row items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
            <div class="flex items-center gap-2">
                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                @if ($lampiran)
                    <p class="text-gray-600 text-sm">{{ $lampiran->getClientOriginalName() }}</p>
                @else
                    <p class="text-sm">dokumen belum di upload</p>
                @endif
            </div>
            @if ($lampiran)
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ $lampiran ? $lampiran->temporaryUrl() : Storage::url($lampiran) }}')">
                        Lihat file
                    </button>
                    <div>
                        <input type="file" accept=".png, .jpg, .jpeg" name="lampiran" id="lampiran"
                            wire:model.live="lampiran" class="hidden" />
                        <label for="lampiran"
                            class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                            Ganti file
                        </label>
                    </div>
                    <button type="button" wire:click="hapus_lampiran"
                        class="px-3 py-2 text-sm text-white bg-gray-600 rounded-md font-medium transition-all duration-200 hover:bg-gray-400 hover:text-black whitespace-nowrap cursor-pointer">
                        <i class="ti ti-trash text-white"></i>
                    </button>
                </div>
            @else
                <div>
                    <input type="file" accept=".png, .jpg, .jpeg" name="lampiran" id="lampiran"
                        wire:model.live="lampiran" class="hidden" />
                    <label for="lampiran"
                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                        Upload file
                    </label>
                </div>
            @endif
        </div>
    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">
        Submit Perizinan
    </button>
</form>

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
            alert('Preview dokumen tidak tersedia di tampilan mobile');
        }
    }
</script>
