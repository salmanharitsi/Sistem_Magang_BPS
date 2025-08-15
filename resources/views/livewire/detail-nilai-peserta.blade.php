<div class="overflow-x-auto !bg-transparent p-1">
    <!-- Nilai Magang Card -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
            <h2 class="text-white text-xl font-semibold flex items-center">
                <i class="ti ti-script mr-2"></i>
                Nilai Magang
            </h2>
        </div>

        <!-- Wrapper div with overflow-x-auto to enable horizontal scrolling -->
        <div class="overflow-x-auto" style="width: 100%;">
            <table class="min-w-full text-sm">
                <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium uppercase tracking-wider">Indikator</th>
                        <th class="py-3 px-4 text-left font-medium uppercase tracking-wider">Deskripsi</th>
                        <th class="text-center font-medium uppercase tracking-wider">Nilai</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-indigo-900">
                        <td class="py-3 px-4 text-sm font-bold text-indigo-800 dark:text-indigo-300" colspan="3">
                            <div class="flex items-center">
                                Bobot Nilai: 70%
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="py-4 px-4 font-medium">Presensi</td>
                        <td class="py-4 px-4">Kehadiran peserta magang selama menjalankan program</td>
                        <td class="text-center">
                            <span class="inline-block w-full font-semibold text-blue-600 dark:text-blue-400">
                                {{ $magang->nilai_presensi }}
                            </span>
                        </td>
                    </tr>

                    <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-indigo-900">
                        <td class="py-3 px-4 text-sm font-bold text-indigo-800 dark:text-indigo-300" colspan="3">
                            <div class="flex items-center">
                                Bobot Nilai: 20%
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="py-4 px-4 font-medium">Logbook</td>
                        <td class="py-4 px-4">Kelengkapan logbook peserta magang selama menjalankan program</td>
                        <td class="text-center">
                            <span class="inline-block w-full font-semibold text-blue-600 dark:text-blue-400">
                                {{ $magang->nilai_logbook }}
                            </span>
                        </td>
                    </tr>

                    @php
                        $nilaiLainnya = is_array($magang->nilai_lainnya)
                            ? $magang->nilai_lainnya
                            : json_decode($magang->nilai_lainnya, true);
                    @endphp

                    <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-indigo-900">
                        <td class="py-3 px-4 text-sm font-bold text-indigo-800 dark:text-indigo-300" colspan="3">
                            <div class="flex items-center">
                                Bobot Nilai: 10%
                            </div>
                        </td>
                    </tr>
                    @forelse($nilaiLainnya as $komponen => $detail)
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="py-4 px-4 font-medium">{{ $detail['indikator'] ?? '-' }}</td>
                            <td class="py-4 px-4">{{ $detail['deskripsi'] ?? '-' }}</td>
                            <td class="text-center">
                                <span class="inline-block w-full font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $detail['nilai'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 px-4 text-center text-gray-400 italic" colspan="4">Tidak ada nilai tambahan.</td>
                        </tr>
                    @endforelse

                    <tr class="border-t-2 border-gray-300 dark:border-gray-600 font-bold bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 text-blue-800 dark:text-blue-100">
                        <td class="py-5 px-4" colspan="2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Total Nilai Magang
                            </div>
                        </td>
                        <td class="py-5 px-4 flex justify-center">
                            <div class="text-lg bg-white dark:bg-gray-800 rounded-lg px-4 py-2 shadow-inner inline-block">
                                {{ $magang->nilai_magang }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if ($magang->sertifikat_magang)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-5 bg-gradient-to-r from-blue-600 to-indigo-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-white text-xl font-semibold flex items-center">
                    <i class="ti ti-certificate mr-2"></i>
                    Sertifikat Magang
                </h2>

                <button wire:click="downloadSertifikat"
                    class="pjax-link bg-white text-blue-700 border-2 border-white px-4 py-2 rounded-lg hover:bg-blue-50 hover:border-blue-100 transition-all duration-300 flex items-center shadow-lg transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <p class="text-sm font-medium whitespace-nowrap">Unduh Sertifikat</p>
                </button>
            </div>
            
            <div class="p-2 bg-gray-100 dark:bg-gray-900">
                <div class="pdf-viewer h-[80vh] w-full bg-white dark:bg-gray-800 shadow-inner rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 overflow-x-auto">
                    <iframe src="{{ Storage::url($magang->sertifikat_magang) }}" class="w-full h-full" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    @endif
</div>