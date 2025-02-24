<form class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200 border">
    <div
        class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
        <div class="flex gap-3 items-start lg:items-center">
            <i class="ti ti-alert-circle text-lg"></i>
            <p class="text-sm">Lakukan pengecekan surat pengantar sebelum menerima peserta magang</p>
        </div>
    </div>

    <div class="mt-4">
        <h6 class="text-[17px] font-semibold text-gray-800">Bidang tujuan: {{ $pengajuan->bidang_tujuan }}</h6>
        <p class="text-sm text-gray-500">Pembimbing yang ada merupakan pembimbing dengan bidang sesuai dengan bidang tujuan peserta magang</p>
    </div>

    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Pembimbing 1 Dropdown -->
        <div>
            <label for="pembimbing1" class="block text-[17px] mb-1 font-semibold text-gray-800">Pembimbing 1</label>
            <select wire:model.live="pembimbing1" id="pembimbing1" name="pembimbing1" 
                class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Pembimbing 1</option>
                @foreach($pembimbingList as $pembimbing)
                    <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                @endforeach
            </select>
            @error('pembimbing1')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <!-- Pembimbing 2 Dropdown (Opsional) -->
        <div>
            <label for="pembimbing2" class="block text-[17px] mb-1 font-semibold text-gray-800">Pembimbing 2 <span class="text-[10px] text-gray-500">(Opsional)</span></label>
            <select wire:model="pembimbing2" id="pembimbing2" name="pembimbing2" 
                class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Pembimbing 2</option>
                @foreach($pembimbing2Options as $pembimbing)
                    <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-5 justify-between md:col-span-2">
            <button type="button" wire:click="setShowTerimaModal(true)"
                class="w-full text-sm md:w-1/2 p-2 font-medium bg-blue-600 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-blue-600 hover:border-blue-600 transition-all duration-200">
                Terima final
            </button>
            <button type="button" wire:click="setShowTolakModal(true)"
                class="w-full text-sm md:w-1/2 p-2 font-medium bg-red-600 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-200">
                Tolak dan ajukan kembali
            </button>
        </div>
        
        <div class="@if(!$showTerimaModal) hidden @endif col-span-2">
            <div class="justify-center items-center w-full max-h-full">
                <div class="relative p-4 w-full max-h-full">
                    <div class="relative">
                        <button type="button" wire:click="setShowTerimaModal(false)"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-[15px] font-normal text-gray-500 dark:text-gray-400">Apakah yakin
                                menerima pengajuan milik <span class="font-bold">{{ $pengajuan->name }}</span>
                                ini?</h3>
                            <button type="button" wire:click="terimaPengajuan"
                                class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center cursor-pointer">
                                Ya, Terima
                            </button>
                            <button type="button" wire:click="setShowTerimaModal(false)"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                                Tidak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="@if(!$showTolakModal) hidden @endif col-span-2">
            <div class="justify-center items-center w-full max-h-full">
                <div class="relative p-4 w-full max-h-full">
                    <div class="relative">
                        <button type="button" wire:click="setShowTolakModal(false)"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-[15px] font-normal text-gray-500">Apakah yakin menolak pengajuan milik 
                                <span class="font-bold">{{ $pengajuan->name }}</span> ini?</h3>
                            <div class="mt-5 flex items-center justify-center">
                                <button type="button" wire:click="tolakPengajuan"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center cursor-pointer">
                                    Ya, Tolak
                                </button>
                                <button type="button" wire:click="setShowTolakModal(false)"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                                    Tidak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>