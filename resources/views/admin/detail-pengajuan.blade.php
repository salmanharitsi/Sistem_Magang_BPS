@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
    @php
        $firstLetter = strtoupper(substr($pengajuan->name, 0, 1));
        use Carbon\Carbon;
        Carbon::setLocale('id');
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

        @if ($pengajuan->status_pengajuan == 'accept-first' && is_null($pengajuan->surat_pengantar))
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <p class="text-sm">Calon peserta magang belum mengirim surat pengantar</p>
                </div>
            </div>
        @endif

        @if (Carbon::parse($pengajuan->tenggat)->addDays()->isPast() && !$pengajuan->surat_pengantar)
            <form
                action="{{ route('admin.tolak-pengajuan-tenggat', $pengajuan->id) }}" method="POST" 
                class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                @csrf
                <div class="flex flex-col md:flex-row items-start md:items-center gap-3 justify-between p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center ">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">Peserta magang melewati tenggat upload surat pengantar!</p>
                    </div>
                    <button type="submit"
                        class="pjax-link bg-red-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                        <p class="text-sm whitespace-nowrap">Tolak Pengajuan</p>
                    </button>
                </div>
            </form>
        @endif

        @if (!is_null($pengajuan->surat_pengantar) && $pengajuan->status_pengajuan != 'accept-final')
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200 border">
                <h6 class="text-[17px] font-semibold text-gray-800">Surat Pengantar</h6>
                <div
                    class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $pengajuan->surat_pengantar }}</p>
                    </div>
                    <a href="{{ $pengajuan->surat_pengantar}}" target="_blank"
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                        Cek surat
                    </a>
                </div>
            </div>
            @livewire('approve-final', ['pengajuan' => $pengajuan])
        @endif

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

            <div class="col-span-2 lg:col-span-1 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Pengajuan Program
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Magang</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->jenis_magang }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Bidang Tujuan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->bidang_tujuan }}
                    </p>
                    <div class="flex gap-5">
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Mulai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('j F Y') }}
                            </p>
                        </div>
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal selesai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($pengajuan->tanggal_selesai)->translatedFormat('j F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Informasi Akademik
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Asal Instansi</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->institusi }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jurusan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->jurusan }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor Induk Siswa/Mahasiswa</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->nomor_induk }}
                    </p>
                </div>
            </div>

            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    Penanggung Jawab
                </h4>
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->penanggung_jawab_name }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jabatan</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->penanggung_jawab_jabatan }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->penanggung_jawab_email }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor HP</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->penanggung_jawab_nomor_hp }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    Biodata
                </h4>
                <div class="mt-4">
                    @if (!empty($pengajuan->foto_profil))
                        <img id="profile-image" src="{{ Storage::url($pengajuan->foto_profil) }}"
                            alt="Preview Foto Profil"
                            class="w-28 h-28 object-cover rounded-full outline outline-blue-600 cursor-pointer"
                            onclick="openPreview('{{ Storage::url($pengajuan->foto_profil) }}')">
                    @else
                        <h1 class="flex w-28 h-28 items-center justify-center text-3xl text-white bg-blue-600 rounded-full">
                            {{ $firstLetter }}
                        </h1>
                    @endif
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tentang Saya</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->tentang_saya }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->name }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Kelamin</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->jenis_kelamin }}
                </p>
                <div class="flex gap-5">
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tempat Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->tempat_lahir }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ Carbon::parse($pengajuan->tanggal_lahir)->translatedFormat('j F Y') }}
                        </p>
                    </div>
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">No Handphone</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->nomor_hp }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->email }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Alamat Lengkap</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->alamat }}
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
                        @if ($pengajuan->original_filename_ktp)
                            <p class="text-gray-600 text-sm">{{ $pengajuan->original_filename_ktp }}</p>
                        @else
                            <p class="text-red-600 text-sm">Kartu Tanda Penduduk tidak ada</p>
                        @endif
                    </div>
                    @if ($pengajuan->original_filename_ktp)
                        <button
                            class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                            onclick="openPreview('{{ Storage::url($pengajuan->kartu_penduduk) }}')">
                            Lihat file
                        </button>
                    @endif
                </div>

                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Kartu Tanda Siswa/Mahasiswa</h6>
                <div
                    class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $pengajuan->original_filename_kartu }}</p>
                    </div>
                    <button
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ Storage::url($pengajuan->kartu_tanda) }}')">
                        Lihat file
                    </button>
                </div>
            </div>
        </div>

        @if ($pengajuan->status_pengajuan == "waiting")    
        <div
            class="col-span-4 card flex flex-col gap-5 rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="flex flex-col md:flex-row items-center gap-5 justify-between">
                <button
                    class="btn-terima-pengajuan w-full text-sm md:w-1/2 p-2 font-medium bg-blue-600 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-blue-600 hover:border-blue-600 transition-all duration-200">
                    Terima pengajuan
                </button>
                <button
                    class="btn-tolak-pengajuan w-full text-sm md:w-1/2 p-2 font-medium bg-red-600 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-200">
                    Tolak pengajuan
                </button>
            </div>
            <div class="act-terima-pengajuan hidden ">
                <div class="justify-center items-center w-full max-h-full">
                    <div class="relative p-4 w-full max-h-full">
                        <div class="relative">
                            <button
                                class="close-modal-terima absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                <form action="{{ route('admin.terima-pengajuan', $pengajuan->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center cursor-pointer">
                                        Ya, Terima
                                    </button>
                                </form>
                                <button
                                    class="close-modal-terima py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Tidak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="act-tolak-pengajuan hidden ">
                <div class="justify-center items-center w-full max-h-full">
                    <div class="relative p-4 w-full max-h-full">
                        <div class="relative">
                            <button
                                class="close-modal-tolak absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
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
                                    menolak pengajuan milik <span class="font-bold">{{ $pengajuan->name }}</span>
                                    ini?</h3>
                                <form action="{{ route('admin.tolak-pengajuan', $pengajuan->id) }}" method="POST"
                                    class="flex flex-col items-center justify-center gap-5">
                                    @csrf
                                    <div class="w-full md:w-[60%] text-start">
                                        <h1 class="mb-1">Pesan</h1>
                                        <textarea id="message" name="komentar" rows="4"
                                            class="block p-2 w-full text-[13px] text-gray-900 bg-gray-50 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Masukkan pesan jika ada" maxlength="255"></textarea>
                                    </div>
                                    <div class=" w-full md:w-[60%] text-start">
                                        <h1>Saran Pesan</h1>
                                        <div class="flex flex-wrap gap-2 mt-1 text-sm">
                                            <button type="button" class="suggest-btn px-2 py-1 bg-gray-100 text-gray-600 border border-gray-600 rounded-full" onclick="setMessage('Kuota magang saat ini sedang penuh')">Kuota magang saat ini sedang penuh</button>
                                            <button type="button" class="suggest-btn px-2 py-1 bg-gray-100 text-gray-600 border border-gray-600 rounded-full" onclick="setMessage('Dokumen tidak sesuai, periksa kembali')">Dokumen tidak sesuai, periksa kembali</button>
                                            <button type="button" class="suggest-btn px-2 py-1 bg-gray-100 text-gray-600 border border-gray-600 rounded-full" onclick="setMessage('Coba daftar pada divisi lain')">Coba daftar pada divisi lain</button>
                                            <button type="button" class="suggest-btn px-2 py-1 bg-gray-100 text-gray-600 border border-gray-600 rounded-full" onclick="setMessage('Maaf, saat ini kami sedang tidak menerima magang')">Maaf, saat ini kami sedang tidak menerima magang</button>
                                            <button type="button" class="suggest-btn px-2 py-1 bg-gray-100 text-gray-600 border border-gray-600 rounded-full" onclick="setMessage('Coba daftar pada periode lain')">Coba daftar pada periode lain</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button type="submit"
                                            class="text-white w-fit bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center cursor-pointer">
                                            Ya, Tolak
                                        </button>
                                        <button type="button"
                                            class="close-modal-tolak w-fit py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                            Tidak
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const terimaBtn = document.querySelector('.btn-terima-pengajuan');
            const tolakBtn = document.querySelector('.btn-tolak-pengajuan');
            const terimaDiv = document.querySelector('.act-terima-pengajuan');
            const tolakDiv = document.querySelector('.act-tolak-pengajuan');
            const closeMdlsTerima = document.querySelectorAll('.close-modal-terima');
            const closeMdlsTolak = document.querySelectorAll('.close-modal-tolak');

            terimaBtn.addEventListener('click', function() {
                terimaDiv.classList.remove('hidden');
                terimaDiv.classList.add('fade-in-div', 'show-div');
                tolakDiv.classList.remove('show-div');
                tolakDiv.classList.add('hidden');
                terimaDiv.scrollIntoView({
                    behavior: 'smooth'
                });
            });

            tolakBtn.addEventListener('click', function() {
                tolakDiv.classList.remove('hidden');
                tolakDiv.classList.add('fade-in-div', 'show-div');
                terimaDiv.classList.remove('show-div');
                terimaDiv.classList.add('hidden');
                tolakDiv.scrollIntoView({
                    behavior: 'smooth'
                });
            });

            closeMdlsTerima.forEach(closeMdl => {
                closeMdl.addEventListener('click', function() {
                    terimaDiv.classList.remove('show-div');
                    terimaDiv.classList.add('hidden');
                    terimaDiv.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            closeMdlsTolak.forEach(closeMdl => {
                closeMdl.addEventListener('click', function() {
                    tolakDiv.classList.remove('show-div');
                    tolakDiv.classList.add('hidden');
                    tolakDiv.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });

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

        function setMessage(text) {
            const messageTextarea = document.getElementById('message');
            messageTextarea.value = text;
        }
    </script>
@endsection
