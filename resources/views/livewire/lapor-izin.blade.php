<form class="grid gap-5" wire:submit.prevent="submit_izin">
    <div>
        <h4 class="font-semibold mb-2">Keterangan Perizinan<span class="text-red-500 ml-1">*</span></h4>
        <textarea maxlength="250" name="keterangan_izin" id="keterangan_izin" wire:model.live="keterangan_izin"
            class="min-h-36 bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
            placeholder="Masukkan keterangan izin..."></textarea>
        @error('keterangan_izin')
            <span class="text-red-500 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <h4 class="font-semibold mb-2">Lampiran <span class="text-[10px] font-normal">(Link dokumen)</span></h4>
        <input type="text" name="lampiran" wire:model.live="lampiran" class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]" placeholder="Masukkan link dokumen" />
        @error('lampiran')
            <span class="text-red-500 text-[11px]">{{$message}}</span>
        @enderror
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
