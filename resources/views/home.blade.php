<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="icon" href="{{ asset('bps.png') }}" type="image/png"/>

    <script>
        document.documentElement.classList.add('js')
    </script>
    <title>Simagang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
</head>

@if (Auth::check())
    @php
        $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
    @endphp
@endif
@if (Auth::guard('pegawai')->check())
    @php
        $firstLetter = strtoupper(substr(Auth::guard('pegawai')->user()->name, 0, 1));
    @endphp
@endif

<body>

    @include('_message')

    {{-- Navbar section --}}
    <nav
        class="fixed top-0 px-[20px] md:px-[10%] py-3 w-full flex justify-between items-center bg-gradient-to-r from-blue-900 to-blue-500 z-[100]">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r md:border-white border-transparent">
                <img class="w-[80%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white hidden md:block">
                <h1 class="font-normal">Badan Pusat Statistik</h1>
                <p class="font-light">Provinsi Riau</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center justify-center gap-7 text-white text-sm">
            <a href="#beranda" class="nav-link py-1">Beranda</a>
            <a href="#fungsi-bagian" class="nav-link py-1">Informasi bagian</a>
            <a href="#faqs" class="nav-link py-1">FAQs</a>
            @if (Auth::check())
                @if (!empty(Auth::user()->foto_profil))
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                            class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer">
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                        <div
                            class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                            <h1>{{ $firstLetter }}</h1>
                        </div>
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @endif
            @elseif(Auth::guard('pegawai')->check())
                @php
                    $pegawai = Auth::guard('pegawai')->user();
                    $dashboardUrl = $pegawai->role_temp == 'admin' ? '/dashboard-admin' : '/dashboard-pembimbing';
                @endphp
                <a href="{{ url($dashboardUrl) }}"
                    class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                    <div
                        class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                        <h1>{{ $firstLetter }}</h1>
                    </div>
                    <p class="font-medium">{{ Str::limit($pegawai->name, 9, '...') }}</p>
                </a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                    <i class="fas fa-user"></i>
                    <p class="font-medium">Masuk ke akun</p>
                </a>
            @endif
        </div>
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fa-solid fa-bars fa-2x"></i>
            </button>
        </div>
    </nav>

    <!-- Add spacing to prevent content from hiding behind fixed navbar -->
    <div class="h-[62px]"></div>

    <div id="mobile-menu"
        class="hidden fixed lg:hidden top-[62px] rounded-b-lg py-3 w-full bg-gradient-to-r from-blue-900 to-blue-500 text-white text-sm flex items-center gap-5 justify-center flex-col z-30 overflow-hidden">
        <div class="border-b border-white text-white w-full py-3 text-center flex flex-col gap-3">
            <h1 class="font-regular text-[21px]">Badan Pusat Statistik</h1>
            <p class="font-light text-[16px]">Provinsi Riau</p>
        </div>
        <a href="#beranda" class="nav-link py-3">Beranda</a>
        <a href="#fungsi-bagian" class="nav-link py-3">Informasi bidang</a>
        <a href="#faqs" class="nav-link py-3">FAQs</a>
        @if (Auth::check())
            <a href="{{ url('/login') }}"
                class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                    class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer"
                    onclick="openPreview('{{ Storage::url(Auth::user()->foto_profil) }}')">
                <p class="font-medium">{{ Str::limit(Auth::user()->name, 15, '...') }}</p>
            </a>
        @else
            <a href="{{ url('/login') }}"
                class="px-5 py-3 mb-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <i class="fas fa-user"></i>
                <p class="font-medium">Masuk ke akun</p>
            </a>
        @endif
    </div>

    {{-- Beranda section --}}
    <section id="beranda">
        <div class="m-0 p-0 w-full h-[100vh] absolute gradient-overlay z-[0] parallax-beranda">
            {{-- <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full"> --}}
        </div>
        <div class="relative px-[20px] md:px-[10%] h-[75vh] flex flex-col items-end text-end justify-center gap-8">
            <h1 class="font-bold text-white text-[33px] md:text-[41px] lg:text-[54px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Program Magang <br> Bersama Badan Pusat Statistik <br> Provinsi Riau</h1>
            <p class="font-light text-white text-[14px] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Daftarkan diri untuk mengikuti program magang yang ditawarkan oleh <br> Badan
                Pusat Statistik Provinsi Riau. Kembangkan potensi diri <br> bersama statistisi berpengalaman.</p>
            <div
                class="flex flex-col md:flex-row gap-5 items-center text-center w-full md:w-fit delay-[1000ms] duration-[600ms] taos:scale-[1.1] taos:opacity-0">
                <a href="#alur-pendaftaran"
                    class="rounded-[10px] w-full md:px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500">Alur
                    Pendaftaran</a>
                <a href="{{ Auth::check() ? '/dashboard' : '/registrasi' }}"
                    class="rounded-[10px] w-full md:px-9 py-3 bg-white text-[#514E4E] text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-[#e2e2e2]">
                    Ikuti Program
                </a>
            </div>
        </div>
    </section>

    {{-- Fungsi bagian section --}}
    <section id="fungsi-bagian" class="relative w-full h-fit px-2 py-5 md:px-[5.5%] md:py-10 bg-gray-100">
        <div class="md:px-[6%]">
            <h1 class="text-[#373737] text-[23px] md:text-[30px] font-bold">Kenali fungsi bagian di BPS </h1>
        </div>
        <div class="flex">
            <div class="flex items-center">
                <div class="w-full flex justify-end">
                    <button class="next-slider p-3 rounded-lg bg-white border border-[#767676] shadow-lg mr-3 flex">
                        <i class="fa-solid fa-arrow-left" style="color: #767676"></i>
                    </button>
                </div>
            </div>
            <div id="sliderContainer"
                class="w-full overflow-hidden delay-[400ms] duration-[600ms] taos:scale-[0.6] taos:opacity-0"
                data-taos-offset="100">
                <ul id="slider" class="flex w-full mt-5 md:mt-0">
                    @foreach ($fungsi_bagian as $item)
                        <li class="px-2 py-2 md:py-5 md:px-5">
                            <div
                                class="fungsi-card-parent rounded-lg border p-5 bg-white flex flex-col justify-between h-full relative overflow-hidden">
                                <div>
                                    <div class="w-[20%]">
                                        <img class="w-full" src="{{ asset('assets/home/fungsi_bagian/koma.svg') }}"
                                            alt="">
                                    </div>
                                    <div>
                                        <h2
                                            class="text-[20px] md:text-[25px] text-[#5d5d5d] font-bold text-end">
                                            {{ $item['title'] }}</h2>
                                        <div class="w-full flex justify-end mt-[-5px]">
                                            <img class="w-[50%]"
                                                src="{{ asset('assets/home/fungsi_bagian/underline.svg') }}"
                                                alt="">
                                        </div>
                                        <p class="mt-5 text-[15px] text-gray-500 line-clamp-5 text-justify">{{ $item['description'] }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button onclick="openDetailModal(
                                        '{{ $item['title'] }}',
                                        '{{ $item['description'] }}',
                                        @json($item['jurusan']->pluck('jurusan'))
                                    )" 
                                class="mt-3 w-fit text-end text-white relative z-10 icon-container">
                                    <i class="icon-info fa-solid fa-arrow-left p-3 bg-gradient-to-r from-blue-400 to-blue-700 rounded-full cursor-pointer rotate-45"></i>
                                </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Modal -->
            <div id="detailFungsiBagianModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[1000] hidden">
                <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                    <div class="flex justify-between items-center border-b pb-4">
                        <h3 class="text-2xl font-semibold text-blue-600" id="fungsiTitle"></h3>
                        <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-x"></i>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="">
                            <h4 class="text-lg font-bold text-gray-900">Deskripsi</h4>
                            <p id="fungsiDescription" class="text-gray-600 text-justify max-h-[290px] overflow-y-auto"></p>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-lg font-bold text-gray-900">Jurusan yang Direkomendasikan</h4>
                            <div 
                              id="jurusanList"
                              class="grid grid-cols-2 md:grid-cols-3 gap-1 text-gray-600 max-h-[80px] overflow-y-auto pr-2">
                            </div>  
                        </div>                          
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-full flex justify-start">
                    <button class="prev-slider p-3 rounded-lg bg-white border border-[#767676] shadow-lg ml-3 flex">
                        <i class="fa-solid fa-arrow-right" style="color: #767676"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- About section --}}
    <section class="w-full">
        <div class="m-0 p-0 w-full h-[75vh] absolute gradient-overlay-about z-0 parallax-about">
            {{-- <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full"> --}}
        </div>
        <div class="relative px-[20px] md:px-[10%] h-[75vh] flex flex-col items-start text-start justify-center gap-8">
            <h1 class="font-bold text-white text-[33px] md:text-[36px] lg:text-[49px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Belum kenal dengan BPS?</h1>
            <p class="font-light text-white text-[14px] w-[90%] lg:w-[60%] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">BPS atau Badan Pusat Statistik adalah Lembaga Pemerintah Non Kementerian yang
                bertanggung
                jawab langsung kepada Presiden. Sebelumnya, BPS merupakan Biro Pusat Statistik, yang dibentuk
                berdasarkan UU Nomor 6 Tahun 1960 tentang Sensus dan UU Nomer 7 Tahun 1960 tentang Statistik.</p>
            <div
                class="flex flex-col md:flex-row gap-5 items-center text-center w-full md:w-fit delay-[1000ms] duration-[600ms] taos:scale-[1.1] taos:opacity-0">
                <a href="https://ppid.bps.go.id/app/konten/0000/Profil-BPS.html" target="_blank"
                    class="rounded-[10px] w-full md:px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500 flex items-center justify-center gap-3">
                    Lebih Lengkap
                    <i class="transition-transform duration-300 fa-solid fa-arrow-right text-white"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Alur Pendaftaran Section --}}
    <section id="alur-pendaftaran" class="relative w-full h-fit px-2 py-5 md:px-[10%] md:py-10  flex items-center flex-col gap-[24px] bg-gray-100 overflow-hidden">     
        <div class="w-full flex flex-col items-start justify-start gap-1">
            <h1 class="text-[#373737] text-[23px] md:text-[30px] font-bold">Alur Pendaftaran Magang BPS</h1>
            <p class="text-gray-600 text-[16px]">Ikuti langkah-langkah berikut untuk mengikuti program magang di Badan Pusat Statistik Provinsi Riau</p>
        </div>
        
        <div class="w-full flex flex-col items-center justify-center delay-[700ms] duration-[600ms] taos:scale-[0.8] taos:opacity-0" data-taos-offset="100">
            <!-- Timeline untuk Desktop (md and up) -->
            <div class="hidden lg:flex w-full relative">
                <!-- Timeline line -->
                <div class="absolute top-1/2 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-700 transform -translate-y-1/2 rounded-full"></div>
                
                <!-- Step 1 -->
                <div class="w-1/5 px-2 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold mb-4 z-10">1</div>
                        <div class="bg-white shadow-lg rounded-lg p-4 text-center h-fit flex flex-col gap-4">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <h3 class="font-bold text-[#5d5d5d] text-lg">Registrasi Akun</h3>
                                <div class="w-full flex justify-center">
                                    <i class="fa-solid fa-user-plus text-4xl text-blue-600"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Buat akun baru dengan mengisi formulir pendaftaran</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="w-1/5 px-2 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold mb-4 z-10">2</div>
                        <div class="bg-white shadow-lg rounded-lg p-4 text-center h-fit flex flex-col gap-4">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <h3 class="font-bold text-[#5d5d5d] text-lg">Lengkapi Profil</h3>
                                <div class="w-full flex justify-center">
                                    <i class="fa-solid fa-id-card text-4xl text-blue-600"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Isi data diri, pendidikan, dan unggah berkas yang diperlukan</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="w-1/5 px-2 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold mb-4 z-10">3</div>
                        <div class="bg-white shadow-lg rounded-lg p-4 text-center h-fit flex flex-col gap-4">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <h3 class="font-bold text-[#5d5d5d] text-lg">Ajukan Lamaran</h3>
                                <div class="w-full flex justify-center">
                                    <i class="fa-solid fa-file-signature text-4xl text-blue-600"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Pilih bagian yang sesuai dengan jurusan dan minat Anda</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="w-1/5 px-2 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold mb-4 z-10">4</div>
                        <div class="bg-white shadow-lg rounded-lg p-4 text-center h-fit flex flex-col gap-4">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <h3 class="font-bold text-[#5d5d5d] text-lg">Proses Seleksi</h3>
                                <div class="w-full flex justify-center">
                                    <i class="fa-solid fa-list-check text-4xl text-blue-600"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Tim BPS akan menyeleksi lamaran kamu secara bertahap</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 5 -->
                <div class="w-1/5 px-2 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold mb-4 z-10">5</div>
                        <div class="bg-white shadow-lg rounded-lg p-4 text-center h-fit flex flex-col gap-4">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <h3 class="font-bold text-[#5d5d5d] text-lg">Mulai Magang</h3>
                                <div class="w-full flex justify-center">
                                    <i class="fa-solid fa-briefcase text-4xl text-blue-600"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Jika diterima, Anda akan mengikuti program magang sesuai jadwal</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Timeline untuk Mobile (sm and below) -->
            <div class="lg:hidden w-full relative pb-8">
                <!-- Timeline vertical line -->
                <div class="absolute top-0 left-[25px] w-1 h-full bg-gradient-to-b from-blue-400 to-blue-700 rounded-full"></div>
                
                <!-- Step 1 -->
                <div class="flex mb-10 relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold z-10 flex-shrink-0">1</div>
                    <div class="ml-4 bg-white shadow-lg rounded-lg p-4 flex-grow">
                        <h3 class="font-bold text-[#5d5d5d] text-lg">Registrasi Akun</h3>
                        <div class="w-full flex items-center mt-2">
                            <i class="fa-solid fa-user-plus text-2xl text-blue-600 mr-3"></i>
                            <p class="text-sm text-gray-500">Buat akun baru dengan mengisi formulir pendaftaran</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex mb-10 relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold z-10 flex-shrink-0">2</div>
                    <div class="ml-4 bg-white shadow-lg rounded-lg p-4 flex-grow">
                        <h3 class="font-bold text-[#5d5d5d] text-lg">Lengkapi Profil</h3>
                        <div class="w-full flex items-center mt-2">
                            <i class="fa-solid fa-id-card text-2xl text-blue-600 mr-3"></i>
                            <p class="text-sm text-gray-500">Isi data diri, pendidikan, dan unggah berkas yang diperlukan</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex mb-10 relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold z-10 flex-shrink-0">3</div>
                    <div class="ml-4 bg-white shadow-lg rounded-lg p-4 flex-grow">
                        <h3 class="font-bold text-[#5d5d5d] text-lg">Ajukan Lamaran</h3>
                        <div class="w-full flex items-center mt-2">
                            <i class="fa-solid fa-file-signature text-2xl text-blue-600 mr-3"></i>
                            <p class="text-sm text-gray-500">Pilih bagian yang sesuai dengan jurusan dan minat Anda</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="flex mb-10 relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold z-10 flex-shrink-0">4</div>
                    <div class="ml-4 bg-white shadow-lg rounded-lg p-4 flex-grow">
                        <h3 class="font-bold text-[#5d5d5d] text-lg">Proses Seleksi</h3>
                        <div class="w-full flex items-center mt-2">
                            <i class="fa-solid fa-list-check text-2xl text-blue-600 mr-3"></i>
                            <p class="text-sm text-gray-500">Tim BPS akan menyeleksi lamaran yang masuk</p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 5 -->
                <div class="flex relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-400 to-blue-700 flex items-center justify-center text-white text-xl font-bold z-10 flex-shrink-0">5</div>
                    <div class="ml-4 bg-white shadow-lg rounded-lg p-4 flex-grow">
                        <h3 class="font-bold text-[#5d5d5d] text-lg">Mulai Magang</h3>
                        <div class="w-full flex items-center mt-2">
                            <i class="fa-solid fa-briefcase text-2xl text-blue-600 mr-3"></i>
                            <p class="text-sm text-gray-500">Jika diterima, Anda akan mengikuti program magang sesuai jadwal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-center mt-8">
            <a href="{{ Auth::check() ? '/dashboard' : '/registrasi' }}" class="rounded-[10px] px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500 delay-[900ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                Mulai Pendaftaran
            </a>
        </div>
    </section>

     {{-- Galeri & Fasilitas Section --}}
    @if($galeris->count() > 0 || $fasilitas->count() > 0)
        <section class="w-full h-fit px-2 py-5 md:px-[10%] md:py-10 flex items-center flex-col gap-[24px bg-gray-100 overflow-hidden">
            <div class="w-full flex flex-col items-start justify-start gap-1">
                <h2 class="text-3xl font-bold text-blue-900">Galeri & Fasilitas</h2>
                <p class="text-gray-600">Dokumentasi kegiatan dan fasilitas magang BPS</p>
            </div>

            <!-- Tab Navigation -->
            <div class="w-full flex justify-center mb-6">
                <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                    @if($galeris->count() > 0)
                        <button id="tab-galeri" class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm text-blue-900 hover:text-blue-700 bg-white shadow active" onclick="switchTab('galeri')">
                            <i class="ti ti-photo text-lg"></i>
                            Galeri
                        </button>
                    @endif
                    @if($fasilitas->count() > 0)
                        <button id="tab-fasilitas" class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm {{ !$galeris->count() ? 'text-blue-900 bg-white shadow active' : 'text-gray-500' }} hover:text-gray-700" onclick="switchTab('fasilitas')">
                            <i class="ti ti-tools text-lg"></i>
                            Fasilitas
                        </button>
                    @endif
                </div>
            </div>

            <!-- Galeri Slider -->
            @if($galeris->count() > 0)
                <div id="galeri-content" class="w-full swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach($galeris as $galeri)
                            <div class="swiper-slide">
                                <div class="relative group cursor-pointer" onclick="openImagePreview('{{ asset('storage/' . $galeri->image_path) }}', '{{ $galeri->judul }}')">
                                    <img src="{{ asset('storage/' . $galeri->image_path) }}" class="w-full h-64 object-cover rounded-lg" alt="{{ $galeri->judul }}">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold">{{ $galeri->judul }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif

            <!-- Fasilitas Slider -->
            @if($fasilitas->count() > 0)
                <div id="fasilitas-content" class="w-full swiper mySwiper {{ $galeris->count() > 0 ? 'hidden' : '' }}">
                    <div class="swiper-wrapper">
                        @foreach($fasilitas as $item)
                            <div class="swiper-slide">
                                <div class="relative group cursor-pointer" onclick="openImagePreview('{{ asset('storage/' . $item->image_path) }}', '{{ $item->judul }}')">
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-64 object-cover rounded-lg" alt="{{ $item->judul }}">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold">{{ $item->judul }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif

            <!-- Image Preview Modal -->
            <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[1000] hidden">
                <div class="max-w-4xl w-full mx-4 bg-white rounded-lg overflow-hidden">
                    <div class="p-4 bg-white flex justify-between items-center border-b">
                        <h3 id="previewTitle" class="text-xl font-semibold text-gray-800"></h3>
                        <button onclick="closeImagePreview()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="relative">
                        <img id="previewImage" src="" alt="Preview" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </section>
    @endif

     <!-- Testimoni Section -->
    <!-- Testimoni Section - Menggunakan tema yang sudah ada -->
@if($testimonis->where('is_displayed', true)->count() > 0)
    <section class="w-full h-fit px-2 py-5 md:px-[10%] md:py-10 flex items-center flex-col gap-[24px] bg-gray-100">
        <div class="w-full flex flex-col items-start justify-start gap-1">
            <h1 class="text-[#373737] text-[23px] md:text-[30px] font-bold">Apa Kata Mereka?</h1>
            <p class="text-gray-600 text-[16px]">Testimoni dari peserta program magang BPS Provinsi Riau yang telah merasakan pengalaman berharga</p>
        </div>
        
        <div class="flex w-full">
            <!-- Left Arrow -->
            <div class="flex items-center">
                <div class="w-full flex justify-end">
                    <button id="prevTestimoni" class="p-3 rounded-lg bg-white border border-[#767676] shadow-lg mr-3 flex">
                        <i class="fa-solid fa-arrow-left" style="color: #767676"></i>
                    </button>
                </div>
            </div>
            
            <!-- Testimonial Container -->
            <div id="testimoniContainer" class="w-full overflow-hidden delay-[400ms] duration-[600ms] taos:scale-[0.6] taos:opacity-0" data-taos-offset="100">
                <ul id="testimoniSlider" class="flex w-full mt-5 md:mt-0 transition-transform duration-500 ease-in-out">
                    @foreach ($testimonis->where('is_displayed', true) as $index => $testimoni)
                        @php
                            $firstLetter = strtoupper(substr($testimoni->magang->user->name ?? 'A', 0, 1));
                        @endphp
                        <li class="px-2 py-2 md:py-5 md:px-5 flex-shrink-0 w-full md:w-1/3">
                            <div class="bg-white rounded-lg border p-5 flex flex-col justify-between h-full relative overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                <!-- Quote Icon -->
                                <div class="w-[20%] mb-4">
                                    <i class="fa-solid fa-quote-left text-2xl text-blue-600"></i>
                                </div>
                                
                                <!-- User Profile Section -->
                                <div class="flex items-center gap-4 mb-4">
                                    @if(!empty($testimoni->magang->user->foto_profil))
                                        <img src="{{ Storage::url($testimoni->magang->user->foto_profil) }}" 
                                             alt="Foto Profil" 
                                             class="w-12 h-12 object-cover rounded-full border-2 border-blue-600">
                                    @else
                                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-lg">
                                            {{ $firstLetter }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-[18px] md:text-[20px] text-[#5d5d5d] font-bold">
                                            {{ $testimoni->magang->user->name }}
                                        </h3>
                                        <p class="text-[13px] text-gray-500">
                                            {{ $testimoni->magang->jurusan }}
                                        </p>
                                        <p class="text-[12px] text-gray-400">
                                            {{ $testimoni->magang->user->institusi->nama }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Testimonial Content -->
                                <div class="flex-grow">
                                    <p class="text-[14px] text-gray-600 line-clamp-4 text-justify leading-relaxed">
                                        "{{ $testimoni->testimoni }}"
                                    </p>
                                </div>
                                
                                <!-- Badge -->
                                <div class="flex justify-between items-center">
                                    <div class="bg-gradient-to-r from-blue-400 to-blue-700 text-white px-3 py-1 rounded-full text-[12px] font-medium">
                                        {{ $testimoni->magang->lamaran->fungsiBagian->title ?? 'Magang BPS Provinsi Riau' }}
                                    </div>
                                    <div class="text-[12px] text-gray-400">
                                        {{ \Carbon\Carbon::parse($testimoni->created_at)->format('M Y') }}
                                    </div>
                                </div>
                                
                                <!-- Decorative underline -->
                                <div class="w-full flex justify-end mt-2">
                                    <img class="w-[30%]" src="{{ asset('assets/home/fungsi_bagian/underline.svg') }}" alt="">
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Right Arrow -->
            <div class="flex items-center">
                <div class="w-full flex justify-start">
                    <button id="nextTestimoni" class="p-3 rounded-lg bg-white border border-[#767676] shadow-lg ml-3 flex">
                        <i class="fa-solid fa-arrow-right" style="color: #767676"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Dots Indicator -->
        @php
            $totalTestimoni = $testimonis->where('is_displayed', true)->count();
            $totalSlides = ceil($totalTestimoni / 3);
        @endphp
        
        @if($totalSlides > 1)
            <div class="flex justify-center gap-2 mt-5">
                @for($i = 0; $i < $totalSlides; $i++)
                    <div class="testimoni-dot w-3 h-3 rounded-full {{ $i === 0 ? 'bg-blue-600' : 'bg-gray-300' }} cursor-pointer transition-colors duration-300" data-slide="{{ $i }}"></div>
                @endfor
            </div>
        @endif
    </section>
@endif

    {{-- FaQs Section --}}
    <section id="faqs"
        class="w-full h-fit px-2 py-5 md:px-[10%] md:py-10  flex items-center flex-col gap-[24px] bg-gray-100">
        <div class="w-full flex flex-col items-start justify-start gap-1">
            <h1 class="text-[#373737] text-[23px] md:text-[30px] font-bold">Frequently asked questions</h1>
            <p class="text-gray-600 text-[16px]">Butuh bantuan? Coba cek terlebih dahulu pertanyaan yang sering
                ditanyakan berikut</p>
        </div>
        <div class="w-full flex flex-col justify-center items-center mt-[20px]">
            <div class="w-[87%]">
                @foreach ($faqs as $index => $faq)
                    <div
                        class="accordion-item delay-[{{ ($index + 1) * 100 }}ms] duration-[600ms] taos:translate-y-[100px] taos:opacity-0">
                        <div
                            class="accordion-title flex justify-between items-center py-[20px] border-b border-[#E1E3E3] gap-5 cursor-pointer">
                            <p class="text-[#6C6F70] text-[16px]">{{ $faq['question'] }}</p>
                            <i class="transition-transform duration-300 fa-solid fa-arrow-down text-[#6C6F70]"></i>
                        </div>
                        <div class="accordion-content overflow-hidden transition-all duration-300 max-h-0">
                            <div
                                class="p-[20px] bg-gradient-to-r from-blue-100 to-blue-300 border border-blue-700 rounded-lg">
                                <p class="text-gray-800 text-[15px]">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- Footer setion --}}
    <footer
        class="flex flex-col w-full h-fit gap-7 px-5 py-5 md:px-[10%] md:py-7 bg-gradient-to-r from-blue-900 to-blue-500">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r border-white border-transparent">
                <img class="w-[100%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white md:block">
                <h1 class="font-normal text-[18px] md:text-[25px]">Badan Pusat Statistik</h1>
                <p class="font-light text-[15px] md:text-[20px]">Provinsi Riau</p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between gap-5">
            <div class="flex items-end text-white">
                <p class="lg:w-[50%] font-light">
                    Badan Pusat Statistik Provinsi Riau (Statistics of Riau Province)
                    Jl. Pattimura No. 12 Pekanbaru - Riau, Indonesia,
                    <br>
                    Telp (62-761) 23042
                    <br>
                    Faks (62-761) 21336
                    <br>
                    Mailbox: riau@bps.go.id
                </p>
            </div>
            <div class="w-[50%] h-fit bg-white rounded-lg">
                <img src="{{ asset('assets/cover.webp') }}" alt="Berakhlak logo image">
            </div>
        </div>
        <span class="w-full border-b border-white"></span>
        <div class="flex flex-col-reverse md:flex-row gap-3 items-center justify-between">
            <div class="text-white font-light">
                <h1>Hak Cipta © 2024 Badan Pusat Statistik</h1>
                <span>Website hasil kolaborasi BPS dan </span>
                <a href="/tim-pengembang" 
                   class="text-blue-200 hover:text-white transition-colors duration-300 text-sm font-normal">
                    Mahasiswa Teknik Informatika Universitas Riau
                </a>
            </div>            
            <div class="flex gap-5 text-white">
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
                <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('testimoniSlider');
    const prevBtn = document.getElementById('prevTestimoni');
    const nextBtn = document.getElementById('nextTestimoni');
    const dots = document.querySelectorAll('.testimoni-dot');
    
    if (!slider) return;
    
    const totalItems = slider.children.length;
    const itemsPerView = window.innerWidth >= 768 ? 3 : 1; // 3 untuk desktop, 1 untuk mobile
    const totalSlides = Math.ceil(totalItems / itemsPerView);
    let currentSlide = 0;
    
    // Auto slide interval
    let autoSlideInterval;
    
    function updateSlider() {
        const translateX = -(currentSlide * (100 / (itemsPerView === 1 ? 1 : totalSlides)));
        slider.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-blue-600');
            } else {
                dot.classList.remove('bg-blue-600');
                dot.classList.add('bg-gray-300');
            }
        });
        
        // Update button states
        if (prevBtn && nextBtn) {
            prevBtn.disabled = currentSlide === 0;
            nextBtn.disabled = currentSlide === totalSlides - 1;
            
            if (currentSlide === 0) {
                prevBtn.style.opacity = '0.5';
            } else {
                prevBtn.style.opacity = '1';
            }
            
            if (currentSlide === totalSlides - 1) {
                nextBtn.style.opacity = '0.5';
            } else {
                nextBtn.style.opacity = '1';
            }
        }
    }
    
    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
        } else {
            currentSlide = 0; // Loop back to first slide
        }
        updateSlider();
    }
    
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
        } else {
            currentSlide = totalSlides - 1; // Loop to last slide
        }
        updateSlider();
    }
    
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 5000); // Auto slide every 5 seconds
    }
    
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }
    
    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            setTimeout(startAutoSlide, 3000); // Restart auto slide after 3 seconds
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            setTimeout(startAutoSlide, 3000); // Restart auto slide after 3 seconds
        });
    }
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopAutoSlide();
            currentSlide = index;
            updateSlider();
            setTimeout(startAutoSlide, 3000); // Restart auto slide after 3 seconds
        });
    });
    
    // Pause auto slide on hover
    const testimoniContainer = document.getElementById('testimoniContainer');
    if (testimoniContainer) {
        testimoniContainer.addEventListener('mouseenter', stopAutoSlide);
        testimoniContainer.addEventListener('mouseleave', startAutoSlide);
    }
    
    // Initialize
    updateSlider();
    
    // Start auto slide if there are multiple slides
    if (totalSlides > 1) {
        startAutoSlide();
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
        const newItemsPerView = window.innerWidth >= 768 ? 3 : 1;
        if (newItemsPerView !== itemsPerView) {
            location.reload(); // Simple solution: reload page on significant resize
        }
    });
});
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listeners to all icon containers
            const iconContainers = document.querySelectorAll('.icon-container');
            const fungsiItem = @json($fungsi_bagian); // Pindahkan ke atas, biar nggak diulang-ulang dalam foreach
    
            iconContainers.forEach(function(container, index) {
                container.addEventListener('click', function() {
                    if (fungsiItem && fungsiItem[index]) {
                        openDetailModal(fungsiItem[index]);
                    }
                });
            });
        });
    
        // Function to open modal with fungsi bagian details
        function openDetailModal(fungsiData) {
        document.getElementById('fungsiTitle').textContent = fungsiData.title;
        document.getElementById('fungsiDescription').textContent = fungsiData.description;

        const jurusanList = document.getElementById('jurusanList');
        jurusanList.innerHTML = ''; // bersihin dulu

        if (fungsiData.jurusan?.length) {
            fungsiData.jurusan.forEach(j => {
            const d = document.createElement('div');
            d.className = 'flex items-start';
            d.innerHTML = `
                <span class="mr-2 text-blue-600">•</span>
                <span>${j.jurusan}</span>
            `;
            jurusanList.appendChild(d);
            });
        } else {
            jurusanList.innerHTML =
            '<div class="text-gray-400 col-span-3">Tidak ada jurusan tersedia.</div>';
        }

        document
            .getElementById('detailFungsiBagianModal')
            .classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        }
    
        // Function to close the modal
        function closeDetailModal() {
            document.getElementById('detailFungsiBagianModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling
        }
    
        // Close modal when clicking outside
        document.getElementById('detailFungsiBagianModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDetailModal();
            }
        });

        // Inisialisasi Swiper
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        // Function untuk switch tab
        function switchTab(tab) {
            // Reset semua tab dan content
            document.getElementById('tab-galeri').classList.remove('bg-white', 'shadow', 'text-blue-900');
            document.getElementById('tab-fasilitas').classList.remove('bg-white', 'shadow', 'text-blue-900');
            document.getElementById('galeri-content').classList.add('hidden');
            document.getElementById('fasilitas-content').classList.add('hidden');
            
            // Aktifkan tab yang dipilih
            document.getElementById('tab-' + tab).classList.add('bg-white', 'shadow', 'text-blue-900');
            document.getElementById(tab + '-content').classList.remove('hidden');
            
            // Reinisialisasi Swiper untuk content yang baru ditampilkan
            swiper.update();
        }

        // Function untuk membuka preview gambar
        function openImagePreview(imageUrl, title) {
            const modal = document.getElementById('imagePreviewModal');
            const previewImage = document.getElementById('previewImage');
            const previewTitle = document.getElementById('previewTitle');
            
            previewImage.src = imageUrl;
            previewTitle.textContent = title;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Function untuk menutup preview gambar
        function closeImagePreview() {
            const modal = document.getElementById('imagePreviewModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Menutup modal ketika mengklik area di luar gambar
        document.getElementById('imagePreviewModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeImagePreview();
            }
        });

        // Menambahkan event listener untuk tombol ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImagePreview();
            }
        });
    </script>
    
</body>

</html>
