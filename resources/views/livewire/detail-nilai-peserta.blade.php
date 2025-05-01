<div class="overflow-x-auto rounded-lg shadow-md">

    <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-blue-700 text-white">
            <tr>
                <th class="py-3 px-4 text-left font-medium">Indikator</th>
                <th class="py-3 px-4 text-left font-medium">Deskripsi</th>
                <th class="py-3 px-4 text-left font-medium">Nilai</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-200">
            <tr class="bg-gray-100 dark:bg-gray-700">
                <td class="py-2 px-4 text-sm font-bold text-gray-700 dark:text-gray-300" colspan="3">Bobot Nilai: 70%</td>
            </tr>
            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                <td class="py-3 px-4 font-medium">Presensi</td>
                <td class="py-3 px-4">Kehadiran peserta magang selama menjalankan program</td>
                <td class="py-3 px-4 font-semibold text-blue-600 dark:text-blue-400">{{ $magang->nilai_presensi }}</td>
            </tr>

            <tr class="bg-gray-100 dark:bg-gray-700">
                <td class="py-2 px-4 text-sm font-bold text-gray-700 dark:text-gray-300" colspan="3">Bobot Nilai: 20%</td>
            </tr>
            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                <td class="py-3 px-4 font-medium">Logbook</td>
                <td class="py-3 px-4">Kelengkapan logbook peserta magang selama menjalankan program</td>
                <td class="py-3 px-4 font-semibold text-blue-600 dark:text-blue-400">{{ $magang->nilai_logbook }}</td>
            </tr>

            @php
                $nilaiLainnya = is_array($magang->nilai_lainnya)
                    ? $magang->nilai_lainnya
                    : json_decode($magang->nilai_lainnya, true);
            @endphp

            <tr class="bg-gray-100 dark:bg-gray-700">
                <td class="py-2 px-4 text-sm font-bold text-gray-700 dark:text-gray-300" colspan="3">Bobot Nilai: 10%</td>
            </tr>
            @forelse($nilaiLainnya as $komponen => $detail)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <td class="py-3 px-4 font-medium">{{ $detail['indikator'] ?? '-' }}</td>
                    <td class="py-3 px-4">{{ $detail['deskripsi'] ?? '-' }}</td>
                    <td class="py-3 px-4 font-semibold text-blue-600 dark:text-blue-400">{{ $detail['nilai'] ?? '-' }}</td>
                </tr>
            @empty
                <tr class="border-t border-gray-200 dark:border-gray-700">
                    <td class="py-3 px-4 text-center text-gray-400 italic" colspan="4">Tidak ada nilai tambahan.</td>
                </tr>
            @endforelse

            <tr class="border-t-2 border-gray-300 dark:border-gray-600 font-bold bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-100">
                <td class="py-4 px-4" colspan="2">Total Nilai Magang</td>
                <td class="py-4 px-4 text-lg">{{ $magang->nilai_magang }}</td>
            </tr>
        </tbody>
    </table>
</div>