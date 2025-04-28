@extends($layout)

@section('title', 'Detail Bimbingan')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1 card rounded-lg bg-white p-5 ">
            <div class="flex gap-4">
                @if (!empty($magang->pengajuan->foto_profil))
                    <img id="profile-image"
                        src="{{ Storage::url($magang->pengajuan->foto_profil) }}"
                        alt="Preview Foto Profil"
                        class="w-[71px] h-[71px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                        onclick="openPreview('{{ Storage::url($magang->pengajuan->foto_profil) }}')">
                @else
                    <h1
                        class="flex w-[71px] h-[71px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                        {{ strtoupper(substr($magang->pengajuan->name, 0, 1)) }}
                    </h1>
                @endif
                <div class="flex flex-col justify-center">
                    <p class="text-lg font-semibold text-gray-800">{{ $magang->pengajuan->name }}</p>
                    <div class="text-xs w-fit mt-1 px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 border border-blue-700">{{ $magang->pengajuan->institusi }}</div>
                </div>
            </div>
            <div class="flex gap-10 border-b border-gray-300 pb-4">
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jurusan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $magang->pengajuan->jurusan }}
                    </p>
                </div>
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor Induk</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $magang->pengajuan->nomor_induk }}
                    </p>
                </div>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Alamat</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->pengajuan->alamat }}
                </p>
            </div>
            <div class="flex gap-10">
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor HP</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $magang->pengajuan->nomor_hp }}
                    </p>
                </div>
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tempat/Tanggal Lahir</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $magang->pengajuan->tempat_lahir }} / {{ Carbon::parse($magang->pengajuan->tanggal_lahir)->translatedFormat('j F Y') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-span-1 card rounded-lg bg-white p-5">
            <div class="text-gray-800 pb-3 border-b border-gray-300">
                <h4 class="text-xl font-semibold">Penanggung Jawab</h4>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->pengajuan->penanggung_jawab_name }}
                </p>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jabatan</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->pengajuan->penanggung_jawab_jabatan }}
                </p>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->pengajuan->penanggung_jawab_email }}
                </p>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor HP</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->pengajuan->penanggung_jawab_nomor_hp }}
                </p>
            </div>
        </div>
        <div class="col-span-1 card rounded-lg bg-white p-5">
            <div class="text-gray-800 pb-3 border-b border-gray-300 flex items-center justify-between">
                <h4 class="text-xl font-semibold">Data Magang</h4>
                <div
                    class="text-[13px] w-fit">
                    @if ($magang->status_magang == 'active' && Carbon::parse($magang->tanggal_mulai)->isFuture())
                        <p class="text-amber-700 border-amber-600 bg-amber-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Segera dimulai</p>
                    @elseif($magang->status_magang == 'active' && Carbon::parse($magang->tanggal_mulai)->isPast() && Carbon::parse($magang->tanggal_selesai)->addDays(1)->isFuture())
                        <p class="text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Berlangsung</p>
                    @elseif($magang->status_magang == 'active' && Carbon::parse($magang->tanggal_selesai)->addDays(1)->isPast())
                        <p class="text-gray-700 border-gray-600 bg-gray-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Selesai</p>
                    @endif
                </div>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Magang</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->jenis_magang }}
                </p>
            </div>
            <div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Fungsi Bagian</h6>
                <p class="text-gray-600 text-sm">
                    {{ $magang->bidang_tujuan }}
                </p>
            </div>
            <div class="flex gap-10">
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Mulai</h6>
                    <div class="px-3 py-1 mt-2 w-fit bg-green-50 border border-green-700 rounded-full text-green-700 text-xs">{{ Carbon::parse($magang->tanggal_mulai)->translatedFormat('j F Y') }}</div>
                </div>
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Selesai</h6>
                    <div class="px-3 py-1 mt-2 w-fit bg-red-50 border border-red-700 rounded-full text-red-700 text-xs">{{ Carbon::parse($magang->tanggal_selesai)->translatedFormat('j F Y') }}</div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-0 md:gap-10">
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Pembimbing 1</h6>
                    <div class="mt-1 flex items-center gap-1 text-gray-600 text-sm">
                        <i class="ti ti-user-circle"></i>
                        {{ $magang->pembimbingPertama->name }}
                    </div>
                </div>
                <div>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Pembimbing 2</h6>
                    @if ($magang->pembimbingKedua)
                        <div class="mt-1 flex items-center gap-1 text-gray-600 text-sm">
                            <i class="ti ti-user-circle"></i>
                            {{ $magang->pembimbingKedua->name }}
                        </div>
                    @else
                        <div class="mt-1 text-gray-600">-</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (Carbon::parse($magang->tanggal_mulai)->isFuture())
        <div class="mt-6 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                <i class="ti ti-calendar-time text-lg"></i>
                <p class="text-sm">Peserta magang ini akan memulai magangnya pada <span class="font-bold">{{ Carbon::parse($magang->tanggal_mulai)->translatedFormat('j F Y') }}</span></p>
            </div>
        </div>
    @endif

    @if (Carbon::parse($magang->tanggal_mulai)->isPast())
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card col-span-1 rounded-lg p-5 flex items-center justify-center">
                @livewire('grafik-presensi-bimbingan', ['magang' => $magang->id])
            </div>
            <div class="card col-span-2 rounded-lg h-fit overflow-hidden">
                @livewire('daftar-presensi-bimbingan', ['magang' => $magang->id])
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card col-span-1 rounded-lg p-5 flex items-center justify-center">
                @livewire('grafik-logbook-bimbingan', ['magang' => $magang->id])
            </div>
            <div class="card col-span-2 rounded-lg h-fit overflow-hidden">
                @livewire('daftar-logbook-bimbingan', ['magang' => $magang->id])
            </div>
        </div>
    @endif

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