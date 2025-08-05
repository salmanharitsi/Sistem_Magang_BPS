<form class="flex flex-col gap-5 p-5" wire:submit="updateJamKerja">
    <div class="grid md:grid-cols-1 gap-4">
        <div>
            <label for="tanggal_mulai" class="block mb-1 text-md font-medium text-gray-700">Tanggal Mulai<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" wire:model.live="tanggal_mulai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5" />
            @error('tanggal_mulai')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="tanggal_selesai" class="block mb-1 text-md font-medium text-gray-700">Tanggal Selesai<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" wire:model.live="tanggal_selesai"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5" />
            @error('tanggal_selesai')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jenis_bulan" class="block mb-1 text-md font-medium text-gray-700">Jenis Bulan<span
                    class="text-red-500 ml-1">*</span></label>
            <select name="jenis_bulan" id="jenis_bulan" wire:model.live="jenis_bulan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="">Pilih Jenis Bulan</option>
                <option value="biasa">Bulan Biasa (07:00 - 16:00)</option>
                <option value="ramadhan">Bulan Ramadhan (08:00 - 15:00)</option>
            </select>
            @error('jenis_bulan')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>
    </div>

    @if($presensi_count !== null)
        <div class="p-4 bg-gray-100 rounded-lg">
            @if($presensi_count > 0)
                <p class="text-green-600">Terdapat {{ $presensi_count }} data presensi pada rentang tanggal tersebut.</p>
            @else
                <p class="text-red-600">Tidak ada data presensi pada rentang tanggal tersebut.</p>
            @endif
        </div>
    @endif

    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">
        Perbarui Jam Kerja
    </button>
</form>