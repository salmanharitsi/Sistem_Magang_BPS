<form class="flex flex-col gap-3" wire:submit="create_pengajuan">

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label for="jenis_magang" class="block mb-1 text-md font-medium text-gray-700">Jenis Magang<span
                    class="text-red-500 ml-1">*</span></label>
            <select name="jenis_magang" id="jenis_magang" wire:model.live="jenis_magang"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="" disabled selected hidden>Pilih jenis magang</option>
                <option value="kp">Kerja Praktik (KP)</option>
                <option value="pkl">Praktik Kerja Lapangan (PKL)</option>
                <option value="mbkm">Merdeka Belajar Kampus Merdeka (MBKM)</option>
            </select>
            @error('jenis_magang')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="bidang_tujuan" class="block mb-1 text-md font-medium text-gray-700">Bidang Tujuan<span
                    class="text-red-500 ml-1">*</span></label>
            <select name="bidang_tujuan" id="bidang_tujuan" wire:model.live="bidang_tujuan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="" disabled selected hidden>Pilih bidang yang dituju</option>
                <option value="sosial">Statistik Sosial</option>
                <option value="produksi">Statistik Produksi</option>
                <option value="distribusi">Statistik Distribusi</option>
                <option value="nerwilis">Fungsi Nerwilis</option>
                <option value="ipds">Fungsi IPDS</option>
                <option value="umum">Bagian Umum</option>
            </select>
            @error('bidang_tujuan')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <div>
            <label for="tanggal_mulai" class="block text-md font-medium text-gray-700">Tanggal Mulai<span
                    class="text-red-500 ml-1">*</span></label>
            <p class="text-sm mb-1">Tentukan rencana mulai magang</p>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" wire:model.live="tanggal_mulai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('tanggal_mulai')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="tanggal_selesai" class="block text-md font-medium text-gray-700">Tanggal Selesai<span
                    class="text-red-500 ml-1">*</span></label>
            <p class="text-sm mb-1">Tentukan rencana selesai magang</p>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" wire:model.live="tanggal_selesai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('tanggal_selesai')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Kirim
        Pengajuan</button>
</form>
