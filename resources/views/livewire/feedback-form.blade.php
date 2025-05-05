<div class="px-2 pb-4">
    <form wire:submit.prevent="submit" class="space-y-8">
        <!-- Kritik & Saran Section -->
        <div class="bg-white rounded-lg shadow-lg p-5 border-l-4 border-blue-500 transition-all hover:shadow-xl">
            <h2 class="text-2xl font-semibold mb-4 text-blue-700 flex items-start md:items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 mt-1 md:mt-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                Testimoni, Kritik & Saran
            </h2>

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Testimoni<span class="text-red-500 ml-1">*</span></label>
                <textarea wire:model.live="testimoni" id="testimoni" name="testimoni"
                          class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                          rows="3"
                          placeholder="Apa kesan terbaik Kamu selama mengikuti magang ini? Bagikan pengalaman Kamu..."></textarea>
                @error('testimoni')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Kritik<span class="text-red-500 ml-1">*</span></label>
                <textarea wire:model.live="kritik" id="kritik" name="kritik"
                          class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                          rows="3"
                          placeholder="Berikan kritik terhadap program magang..."></textarea>
                @error('kritik')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
            </div>
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Saran<span class="text-red-500 ml-1">*</span></label>
                <textarea wire:model.live="saran" id="saran" name="saran"
                          class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                          rows="3"
                          placeholder="Berikan saran terhadap program magang..."></textarea>
                @error('saran')<span class="text-red-500 text-[11px]">{{$message}}</span>@enderror
            </div>
        </div>
        
        <!-- Feedback Aplikasi Section -->
        <div class="bg-white rounded-lg shadow-lg p-5 border-l-4 border-green-500 transition-all hover:shadow-xl">
            <h2 class="text-2xl font-semibold mb-2 text-green-700 flex items-start md:items-center">
                <i class="ti ti-device-imac mr-2 mt-1 md:mt-0"></i>
                Pengalaman Menggunakan Aplikasi
            </h2>
            <p class="text-gray-600 mb-6 italic">Bantu kami mengevaluasi aplikasi yang Kamu gunakan selama program magang</p>
            
            <div class="space-y-8">
                @foreach([
                    'aplikasi_daya_tarik' => 'Seberapa menarik tampilan aplikasi ini bagi Kamu?',
                    'aplikasi_kemudahan' => 'Seberapa mudah aplikasi ini digunakan dalam kegiatan sehari-hari?',
                    'aplikasi_efisiensi' => 'Seberapa cepat dan efisien aplikasi ini dalam menyelesaikan tugas?',
                    'aplikasi_keandalan' => 'Seberapa andal aplikasi ini (bebas dari error/crash)?',
                    'aplikasi_stimulasi' => 'Seberapa baik aplikasi ini memotivasi Kamu dalam bekerja?',
                    'aplikasi_originalitas' => 'Seberapa unik dan inovatif fitur-fitur aplikasi ini?'
                ] as $field => $label)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-gray-800 font-medium mb-3">{{ $label }}<span class="text-red-500 ml-1">*</span></label>
                        <div class="flex items-center justify-between mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">{{ $this->getEmoticon($i) }}</span>
                                    <input type="radio" 
                                           wire:model="{{ $field }}" 
                                           value="{{ $i }}" 
                                           class="mt-1 h-5 w-5 text-green-600 focus:ring-green-500 cursor-pointer">
                                </div>
                            @endfor
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span>Sangat Kurang</span>
                            <span>Sangat Baik</span>
                        </div>
                        @error($field)<span class="text-red-500 text-[11px] block mt-2">{{$message}}</span>@enderror
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Feedback Tempat Magang Section -->
        <div class="bg-white rounded-lg shadow-lg p-5 border-l-4 border-amber-500 transition-all hover:shadow-xl">
            <h2 class="text-2xl font-semibold mb-2 text-amber-700 flex items-start md:items-center">
                <i class="ti ti-building mr-2 mt-1 md:mt-0"></i>
                Pengalaman Program Magang
            </h2>
            <p class="text-gray-600 mb-6 italic">Bantu kami meningkatkan kualitas program magang untuk peserta berikutnya</p>
            
            <div class="space-y-8">
                @foreach([
                    'magang_fasilitas' => 'Bagaimana penilaian Kamu terhadap fasilitas yang disediakan?',
                    'magang_metode' => 'Seberapa efektif metode pembelajaran yang diterapkan pembimbing?',
                    'magang_materi' => 'Seberapa bermanfaat materi yang diberikan untuk pengembangan skill Kamu?',
                    'magang_pembimbing' => 'Bagaimana kualitas bimbingan yang diberikan oleh pembimbing magang?',
                    'magang_relevansi' => 'Seberapa relevan program magang ini dengan jurusan/karir Kamu?',
                    'magang_kepuasan' => 'Secara keseluruhan, seberapa puas Kamu dengan program magang ini?'
                ] as $field => $label)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-gray-800 font-medium mb-3">{{ $label }}<span class="text-red-500 ml-1">*</span></label>
                        <div class="flex items-center justify-between mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">{{ $this->getEmoticon($i) }}</span>
                                    <input type="radio" 
                                           wire:model="{{ $field }}" 
                                           value="{{ $i }}" 
                                           class="mt-1 h-5 w-5 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                </div>
                            @endfor
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span>Sangat Kurang</span>
                            <span>Sangat Baik</span>
                        </div>
                        @error($field)<span class="text-red-500 text-[11px] block mt-2">{{$message}}</span>@enderror
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Error Message -->
        @if($errors->any())
            <div class="mt-5 flex flex-col gap-5">
                <div class="w-full h-fit flex gap-3 items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <i class="ti ti-xbox-x text-lg"></i>
                    <p class="text-sm">Masih ada bagian yang kosong! Silahkan lengkapi semua bagian.</p>
                </div>
            </div>
        @endif
        
        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit" 
                    class="px-8 py-3 hover-gradient-purple text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all transform shadow-lg">
                <div class="flex items-center">
                    <i class="ti ti-send mr-3 text-lg"></i>
                    Kirim Feedback
                </div>
            </button>
        </div>
    </form>
</div>      