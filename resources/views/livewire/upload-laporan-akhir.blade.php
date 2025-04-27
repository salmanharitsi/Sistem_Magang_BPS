<form class="flex flex-col gap-5" wire:submit.prevent="upload_laporan_akhir">
    <div>
        <label class="block mb-2 text-[15px] font-medium text-gray-700">
            Laporan Magang <span class="text-[10px]">(Link Google Drive)</span><span class="text-red-500 ml-1">*</span>
        </label>
        <input type="text" wire:model.live="laporan_magang"
            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
            placeholder="Masukkan link Google Drive" />
        @error('laporan_magang')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
    </div>
    <div>
        <label class="block mb-2 text-[15px] font-medium text-gray-700">
            Projek Magang <span class="text-[10px]">(Link Google Drive)</span>
        </label>
        <input type="text" wire:model.live="projek_magang"
            class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
            placeholder="Masukkan link Google Drive" />
        @error('projek_magang')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
    </div>
    <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
        Submit Dokumen
    </button>
</form>