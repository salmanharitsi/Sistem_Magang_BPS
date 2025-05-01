<div class="">
    <div class="card p-5 rounded-lg">

        @php
            if ($totalNilai > 85) {
                $color = 'blue';
            } elseif ($totalNilai > 75) {
                $color = 'amber';
            } else {
                $color = 'red';
            }
        @endphp

        <div class="w-full p-5 border border-{{ $color }}-500 bg-{{ $color }}-50 rounded-lg hover:shadow-md transition-all duration-300 mb-6">
            <h4 class="text-lg font-semibold text-center text-{{ $color }}-800 mb-2">Total Nilai</h4>
            <div class="w-full h-16 flex items-center justify-center text-4xl font-bold text-{{ $color }}-700">
                {{ $totalNilai }}
            </div>
        </div>

        <div class="mt-4 pb-5 border-b border-gray-300">
            <h4 class="text-lg font-bold text-blue-700 flex items-center gap-2 mb-2">
                <span class="bg-blue-600 rounded-full w-6 h-6 flex items-center justify-center text-white text-sm">1</span>
                Nilai Presensi (70%)
            </h4>
            <div class="flex gap-5">
                <div class="grid grid-cols-10 gap-5 w-full">
                    <div class="col-span-10 md:col-span-2 ">
                        <div>Indikator</div>
                        <input
                            class="mt-1 text-sm p-4 flex items-center justify-start w-full border border-gray-300 bg-gray-100 rounded-md" value="Presensi" disabled>
                        </input>
                    </div>
                    <div class="col-span-10 md:col-span-8">
                        <div>Deskripsi</div>
                        <input class="p-4 mt-1 text-sm border border-gray-300 bg-gray-100 rounded-md w-full" value="Kehadiran peserta magang selama menjalankan program" disabled></input>
                    </div>
                </div>
                <div>
                    <div>Nilai</div>
                    <input
                        class="p-4 text-sm col-span-1 mt-1 flex items-center justify-center border border-gray-300 bg-gray-100 rounded-md max-w-[55px]" value="{{ round($nilaiPresensi, 2) }}" disabled>    
                    </input>
                </div>
            </div>
        </div>

        <div class="mt-4 pb-5 border-b border-gray-300">
            <h4 class="text-lg font-bold text-blue-700 flex items-center gap-2 mb-2">
                <span class="bg-blue-600 rounded-full w-6 h-6 flex items-center justify-center text-white text-sm">2</span>
                Nilai Logbook (20%)
            </h4>
            <div class="flex gap-5">
                <div class="grid grid-cols-10 gap-5 w-full">
                    <div class="col-span-10 md:col-span-2 ">
                        <div>Indikator</div>
                        <input
                            class="mt-1 text-sm p-4 flex items-center justify-start w-full border border-gray-300 bg-gray-100 rounded-md" value="Logbook" disabled>
                        </input>
                    </div>
                    <div class="col-span-10 md:col-span-8">
                        <div>Deskripsi</div>
                        <input class="p-4 mt-1 text-sm border border-gray-300 bg-gray-100 rounded-md w-full" value="Kelengkapan logbook peserta magang selama menjalankan program" disabled></input>
                    </div>
                </div>
                <div>
                    <div>Nilai</div>
                    <input
                        class="p-4 text-sm col-span-1 mt-1 flex items-center justify-center border border-gray-300 bg-gray-100 rounded-md max-w-[55px]" value="{{ round($nilaiLogbook, 2) }}" disabled>
                    </input>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="text-lg font-bold text-blue-700 flex items-center gap-2 mb-2">
                <span class="bg-blue-600 rounded-full w-6 h-6 flex items-center justify-center text-white text-sm">3</span>
                Nilai Lainnya (10%)
            </h4>
            
            <!-- Container untuk indikator custom -->
            <div id="custom-indicators-container">
                @foreach($nilaiCustoms as $index => $indikator)
                    <div class="flex gap-5 mb-3 indicator-item">
                        <div class="grid grid-cols-10 gap-5 w-full">
                            <div class="col-span-10 md:col-span-2">
                                @if($index === 0)
                                    <div>Indikator</div>
                                @endif
                                <input type="text"
                                    wire:model.live="nilaiCustoms.{{ $index }}.indikator"
                                    class="mt-1 min-h-[53px] text-sm p-3 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nilaiCustoms.' . $index . '.indikator') border-red-500 @enderror"
                                    placeholder="Nama indikator">
                                @error('nilaiCustoms.' . $index . '.indikator')
                                    <p class="text-red-500 text-xs mt-2.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-10 md:col-span-8">
                                @if($index === 0)
                                    <div>Deskripsi</div>
                                @endif
                                <textarea
                                    wire:model.live="nilaiCustoms.{{ $index }}.deskripsi"
                                    class="px-3 pt-4 max-h-[53px] mt-1 text-sm border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nilaiCustoms.' . $index . '.deskripsi') border-red-500 @enderror"
                                    placeholder="Deskripsi indikator"></textarea>
                                @error('nilaiCustoms.' . $index . '.deskripsi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            @if($index === 0)
                                <div>Nilai</div>
                            @endif
                            <input type="number"
                                wire:model.live="nilaiCustoms.{{ $index }}.nilai"
                                class="p-3 min-h-[53px] text-sm col-span-1 mt-1 w-20 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nilaiCustoms.' . $index . '.nilai') border-red-500 @enderror"
                                min="0" max="100" required
                                placeholder="0-100">
                            @error('nilaiCustoms.' . $index . '.nilai')
                                <p class="text-red-500 text-xs mt-2.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-start md:items-center {{ count($nilaiCustoms) > 1 ? 'hidden' : '' }}">
                            <button data-tooltip-target="tooltip-default" type="button" class="text-amber-500 hover:text-amber-700 mt-10 md:mt-5">
                                <i class="ti ti-alert-circle text-lg"></i>
                            </button>
                        </div>
    
                        <!-- Tooltip -->
                        <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                            Nilai lainnya harus ada minimal 1 indikator nilai
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <div class="flex items-start md:items-center {{ count($nilaiCustoms) > 1 ? '' : 'hidden' }}">
                            @if(count($nilaiCustoms) > 1)
                                <button type="button" wire:click="removeIndicator({{ $index }})" 
                                        class="text-red-500 hover:text-red-700 {{ $index === 0 ? 'mt-10 md:mt-5'  : 'mt-4 md:mt-0'}}">
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        
            <!-- Tombol Tambah Indikator -->
            <div class="mt-2">
                @if(count($nilaiCustoms) < 10)
                    <button type="button" wire:click="addIndicator"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-all duration-200">
                        <i class="ti ti-plus text-sm"></i>
                        <span class="text-sm">Tambah Indikator</span>
                    </button>
                @endif
            </div>

            <div class="mt-4">
                <button wire:click="confirmSubmit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">
                    Simpan Penilaian
                </button>
            </div>
        </div>
    </div>

    @if ($showSubmitModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Konfirmasi Submit</h2>
                    <button wire:click="$set('showSubmitModal', false)" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                
                <div class="mb-3">
                    <p>Apakah Kamu yakin ingin submit nilai <span class="font-semibold">{{ $magang->pengajuan->name}}</span>?</p>
                </div>

                <div class="w-full mb-6 h-fit flex gap-3 items-start lg:items-center justify-center px-3 py-2 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <i class="ti ti-alert-triangle text-lg"></i>
                    <p class="text-sm">karna setelah ini nilai tidak dapat diubah</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showSubmitModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button wire:click="submitNilai" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Nilai
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>