@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
    @php
        $firstLetter = strtoupper(substr($user->name, 0, 1));
        use Carbon\Carbon;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <a href="/daftar-pengajuan" class="pjax-link w-fit flex items-center gap-1">
                <i class="ti ti-chevron-left text-xl"></i>
                <h4 class="text-gray-900 font-semibold text-xl dark:text-white">
                    Detail Pengajuan
                </h4>
            </a>
        </div>

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Pengajuan Program
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Magang</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $user->pengajuan->jenis_magang }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Bidang Tujuan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $user->pengajuan->bidang_tujuan }}
                    </p>
                    <div class="flex gap-5">
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Mulai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($user->pengajuan->tanggal_mulai)->format('j-F-Y') }}
                            </p>
                        </div>
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal selesai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($user->pengajuan->tanggal_selesai)->format('j-F-Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Informasi Akademik
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Asal Instansi</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $user->institusi }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jurusan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $user->jurusan }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor Induk Siswa/Mahasiswa</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $user->nomor_induk }}
                    </p>
                </div>
            </div>

        </div>

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    Biodata
                </h4>
                <div class="mt-4">
                    @if (!empty($user->foto_profil))
                        <img id="profile-image" src="{{ Storage::url($user->foto_profil) }}" alt="Preview Foto Profil"
                            class="w-28 h-28 object-cover rounded-full outline outline-blue-600 cursor-pointer"
                            onclick="openPreview('{{ Storage::url($user->foto_profil) }}')">
                    @else
                        <h1 class="flex w-28 h-28 items-center justify-center text-3xl text-white bg-blue-600 rounded-full">
                            {{ $firstLetter }}
                        </h1>
                    @endif
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tentang Saya</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->tentang_saya }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->name }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Kelamin</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->jenis_kelamin }}
                </p>
                <div class="flex gap-5">
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tempat Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $user->tempat_lahir }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ Carbon::parse($user->tanggal_lahir)->format('j-F-Y') }}
                        </p>
                    </div>
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">No Handphone</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->nomor_hp }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->email }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Alamat Lengkap</h6>
                <p class="text-gray-600 text-sm">
                    {{ $user->alamat }}
                </p>
            </div>
        </div>

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                Dokumen
            </h4>
            <div class="mt-4">
                <h6 class="text-[17px] font-semibold text-gray-800">Kartu Tanda Penduduk</h6>
                <div
                    class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $user->original_filename_ktp }}</p>
                    </div>
                    <button
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ Storage::url($user->kartu_penduduk) }}')">
                        Lihat file
                    </button>
                </div>

                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Kartu Tanda Siswa/Mahasiswa</h6>
                <div
                    class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $user->original_filename_kartu }}</p>
                    </div>
                    <button
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ Storage::url($user->kartu_tanda) }}')">
                        Lihat file
                    </button>
                </div>
            </div>
        </div>
        <!-- Start coding here -->
        <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            {{-- @livewire('show-daftar-pengajuan') --}}
        </div>

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
