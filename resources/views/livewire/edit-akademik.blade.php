<form class="flex flex-col gap-5" wire:submit="update_akademik">
    <div class="grid md:grid-cols-1 gap-4">
        
        <!-- Enhanced Dropdown Institusi -->
        <div>
            <label for="institusi_id" class="block mb-1 text-md font-medium text-gray-700">
                Asal Institusi<span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative" x-data="editInstitusiDropdown()">
                <!-- Input Field yang bisa diklik -->
                <div class="bg-gray-50 border border-gray-500 rounded-lg w-full p-2.5 text-sm cursor-pointer flex justify-between items-center"
                     @click="toggleDropdown()"
                     :class="{ 'border-blue-500': isOpen }">
                    <span x-text="selectedText" class="truncate" :class="{ 'text-gray-400': !selected }"></span>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': isOpen }"></i>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="isOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     @click.away="closeDropdown()"
                     class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-80 overflow-hidden">
                    
                    <!-- Search Input - Fixed di atas -->
                    <div class="sticky top-0 bg-white border-b border-gray-200 p-3">
                        <div class="relative">
                            <input type="text" 
                                   x-model="searchTerm"
                                   @input="filterInstitusi()"
                                   placeholder="Cari institusi..."
                                   class="w-full pl-8 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    <!-- Scrollable Options -->
                    <div class="max-h-48 overflow-y-auto">
                        <!-- Default Option -->
                        <div @click="selectInstitusi('', 'Pilih Institusi')"
                             class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer border-b border-gray-100"
                             :class="{ 'bg-blue-50 text-blue-700': selected === '' }">
                            Pilih Institusi
                        </div>

                        <!-- Institusi Options -->
                        <template x-for="institusi in filteredInstitusi" :key="institusi.id">
                            <div @click="selectInstitusi(institusi.id, institusi.nama)"
                                 class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer border-b border-gray-100"
                                 :class="{ 'bg-blue-50 text-blue-700': selected == institusi.id }">
                                <span x-text="institusi.nama"></span>
                            </div>
                        </template>

                        <!-- No Results -->
                        <div x-show="filteredInstitusi.length === 0 && searchTerm !== ''" 
                             class="px-4 py-3 text-sm text-gray-500 text-center border-b border-gray-100">
                            Institusi tidak ditemukan
                        </div>
                    </div>

                    <!-- Add New Institution - Fixed di bawah -->
                    <div class="sticky bottom-0 bg-white border-t border-gray-200">
                        <a href="{{ url('/institusi') }}"
                           class="block px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 transition duration-200 flex items-center gap-2 font-medium">
                            <i class="fas fa-plus text-xs"></i>
                            <span>Daftarkan Institusi Baru</span>
                        </a>
                    </div>
                </div>

                <!-- Hidden input untuk Livewire -->
                <input type="hidden" name="institusi_id" wire:model.live="institusi_id" x-model="selected">
            </div>
            
            @error('institusi_id')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <!-- Field Jurusan -->
        <div>
            <label for="jurusan" class="block mb-1 text-md font-medium text-gray-700">
                Jurusan<span class="text-red-500 ml-1">*</span>
            </label>
            <input type="text" name="jurusan" id="jurusan" wire:model.live="jurusan"
                placeholder="Masukkan jurusan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('jurusan')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <!-- Field Nomor Induk -->
        <div>
            <label for="nomor_induk" class="block mb-1 text-md font-medium text-gray-700">
                Nomor Induk Siswa/Mahasiswa<span class="text-red-500 ml-1">*</span>
            </label>
            <input type="number" name="nomor_induk" id="nomor_induk" min="0" wire:model.live="nomor_induk"
                placeholder="Masukkan nomor induk"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('nomor_induk')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <!-- Submit Button -->
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">
        Perbarui Data Akademik
    </button>
</form>

<script>
function editInstitusiDropdown() {
    return {
        isOpen: false,
        selected: @entangle('institusi_id').live,
        selectedText: 'Pilih Institusi',
        searchTerm: '',
        institusiList: @json($institusiList),
        filteredInstitusi: @json($institusiList),

        init() {
            // Set initial selected text berdasarkan nilai yang sudah ada
            this.updateSelectedText();
            
            this.$watch('selected', value => {
                this.updateSelectedText();
            });
        },

        updateSelectedText() {
            if (this.selected) {
                const institusi = this.institusiList.find(item => item.id == this.selected);
                this.selectedText = institusi ? institusi.nama : 'Pilih Institusi';
            } else {
                this.selectedText = 'Pilih Institusi';
            }
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.searchTerm = '';
                this.filteredInstitusi = this.institusiList;
                // Focus search input setelah dropdown terbuka
                this.$nextTick(() => {
                    const searchInput = this.$el.querySelector('input[type="text"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                });
            }
        },

        closeDropdown() {
            this.isOpen = false;
        },

        selectInstitusi(id, nama) {
            this.selected = id;
            this.selectedText = nama;
            this.closeDropdown();
        },

        filterInstitusi() {
            if (this.searchTerm === '') {
                this.filteredInstitusi = this.institusiList;
            } else {
                this.filteredInstitusi = this.institusiList.filter(institusi =>
                    institusi.nama.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                    institusi.jenis?.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            }
        }
    }
}
</script>