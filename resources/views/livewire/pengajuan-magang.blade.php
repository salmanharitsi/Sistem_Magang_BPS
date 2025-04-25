<form class="flex flex-col gap-3" wire:submit="create_pengajuan">

    <div class="grid md:grid-cols-2 gap-5">

        <div>
            <label for="jenis_magang" class="block mb-1 text-md font-medium text-gray-700">Jenis Magang<span
                    class="text-red-500 ml-1">*</span></label>
            <select name="jenis_magang" id="jenis_magang" wire:model.live="jenis_magang"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="" disabled selected hidden>Pilih jenis magang</option>
                <option value="Kerja Praktik (KP)">Kerja Praktik (KP)</option>
                <option value="Praktik Kerja Lapangan (PKL)">Praktik Kerja Lapangan (PKL)</option>
                <option value="Merdeka Belajar Kampus Merdeka (MBKM)">Merdeka Belajar Kampus Merdeka (MBKM)</option>
            </select>
            @error('jenis_magang')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="bidang_tujuan" class="block mb-1 text-md font-medium text-gray-700">
                Bidang Tujuan<span class="text-red-500 ml-1">*</span>
            </label>
            <select name="bidang_tujuan" id="bidang_tujuan" wire:model.live="bidang_tujuan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="" disabled selected hidden>Pilih bidang yang dituju</option>
                @foreach ($listFungsiBagian as $fungsi)
                    <option value="{{ $fungsi->title }}">{{ $fungsi->title }}</option>
                @endforeach
            </select>
            @error('bidang_tujuan')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>
        

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <div>
            <label for="tanggal_mulai" class="block text-md font-medium text-gray-700">Tanggal Mulai<span
                    class="text-red-500 ml-1">*</span></label>
            <p class="text-sm mb-1 text-gray-500">Tentukan rencana mulai magang</p>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" wire:model.live="tanggal_mulai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                min="{{ date('Y-m-d', strtotime('+2 day')) }}" />
            @error('tanggal_mulai')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="tanggal_selesai" class="block text-md font-medium text-gray-700">Tanggal Selesai<span
                    class="text-red-500 ml-1">*</span></label>
            <p class="text-sm mb-1 text-gray-500">Tentukan rencana selesai magang</p>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" wire:model.live="tanggal_selesai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('tanggal_selesai')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <span class ="border-b border-gray-300 col-span-2"></span>

        <div class="col-span-2 text-lg font-medium text-gray-900">Data Penanggung Jawab</div>

        <div>
            <label for="penanggung_jawab_name" class="block text-md font-medium text-gray-700">Nama<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="penanggung_jawab_name" id="penanggung_jawab_name" wire:model.live="penanggung_jawab_name" placeholder="Masukkan nama penanggung jawab beserta gelar"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('penanggung_jawab_name')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="penanggung_jawab_jabatan" class="block text-md font-medium text-gray-700">Jabatan<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="penanggung_jawab_jabatan" id="penanggung_jawab_jabatan" wire:model.live="penanggung_jawab_jabatan" placeholder="Masukkan jabatan penanggung jawab"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('penanggung_jawab_jabatan')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="penanggung_jawab_email" class="block text-md font-medium text-gray-700">Email<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="penanggung_jawab_email" id="penanggung_jawab_email" wire:model.live="penanggung_jawab_email" placeholder="Masukkan email penanggung jawab"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('penanggung_jawab_email')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="penanggung_jawab_nomor_hp" class="block text-md font-medium text-gray-700">Nomor HP<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="number" name="penanggung_jawab_nomor_hp" id="penanggung_jawab_nomor_hp" wire:model.live="penanggung_jawab_nomor_hp" placeholder="Masukkan nomor hp penanggung jawab"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"/>
            @error('penanggung_jawab_nomor_hp')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="mt-4 flex flex-col justify-start w-full gap-2">
        <div class="flex gap-2 items-center">
            <input id="checkbox1" type="checkbox" onchange="toggleSubmitButton()"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
            <p class="text-[12px]">Apakah kamu sudah yakin semua data diisi dengan benar?</p>
        </div>
        <div class="flex gap-2 items-center">
            <input id="checkbox2" type="checkbox" onchange="toggleSubmitButton()"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
            <p class="text-[12px]">Menyetujui keputusan hasil seleksi dari Badan Pusat Statistik Provinsi Riau</p>
        </div>
    </div>

    <button id="submitBtn" type="submit" disabled
        class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Kirim
        Pengajuan</button>
</form>

<script>
    function toggleSubmitButton() {
        var checkbox1 = document.getElementById('checkbox1');
        var checkbox2 = document.getElementById('checkbox2');
        var submitBtn = document.getElementById('submitBtn');

        if (checkbox1.checked && checkbox2.checked) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
</script>
