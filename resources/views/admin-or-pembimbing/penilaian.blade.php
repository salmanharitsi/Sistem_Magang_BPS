@extends($layout)

@section('title', 'Daftar Persetujuan')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
            <div class="col-span-1 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="flex h-full items-center">
                    <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                        Penilaian Magang
                    </h4>
                    <i class="ti ti-star text-2xl ml-2"></i>
                </div>
            </div>
    
            <div class="col-span-1 card h-fit rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-3">
                        @if (!empty($magang->user->foto_profil))
                            <img id="profile-image" src="{{ Storage::url($magang->user->foto_profil) }}" alt="Preview Foto Profil"
                                class="w-[50px] h-[50px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                                onclick="openPreview('{{ Storage::url($magang->user->foto_profil) }}')">
                        @else
                            <h1
                                class="flex w-[71px] h-[71px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                                {{ strtoupper(substr($magang->user->name, 0, 1)) }}
                            </h1>
                        @endif
                        <div>
                            <div>
                                <h5 class="font-semibold text-xl">{{ $magang->user->name }}</h5>
                            </div>
                            <p class="text-xs text-gray-500">{{ $magang->jenis_magang }}</p>
                        </div>
                    </div>
                    <a href="/daftar-bimbingan/{{ $magang->id }}"
                        class="pjax-link text-sm flex items-center justify-center bg-blue-600 w-full md:w-fit border border-transparent px-3 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                        <i class="ti ti-eye mr-2"></i>
                        Lihat Data Magang
                    </a>
                </div>
            </div>
        </div>

        @if (!$magang->laporan_magang)
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <p class="text-sm">Peserta magang belum upload laporan akhir magang</p>
                </div>
            </div>
        @endif

        @if ($checkAccPresensi || $checkAccLogbook)
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">Data presensi dan logbook ada yang belum diperiksa</p>
                    </div>
                    <a href="/daftar-persetujuan"
                        class="pjax-link bg-red-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                        <p class="text-sm whitespace-nowrap">Setujui Dokumen</p>
                    </a>
                </div>
            </div>
        @endif

        @if ($magang->laporan_magang && !$checkAccPresensi && !$checkAccLogbook)
            <div class="col-span-4">
                @livewire('input-nilai', ['magang' => $magang])
            </div>
        @endif

    </div>

    <script>
        function openPreview(url) {
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;
            const width = screenWidth / 2;
            const height = screenHeight / 2;
            const left = (screenWidth - width) / 2;
            const top = (screenHeight - height) / 2;

            const newWindow = window.open(
                '',
                '',
                `width=${width},height=${height},top=${top},left=${left}`
            );

            if (newWindow) {
                newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
                newWindow.document.title = "Image Preview";
            } else {
                alert('Preview dokumen tidak tersedia di tampilan mobile');
            }
        }
    </script>

@endsection
