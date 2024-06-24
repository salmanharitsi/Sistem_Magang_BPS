<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.documentElement.classList.add('js')
    </script>
    <title>Simagang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('_message')

    {{-- Navbar section --}}
    <nav
        class="sticky top-0 px-[20px] md:px-[10%] py-3 w-full flex justify-between items-center bg-gradient-to-r from-blue-900 to-blue-500 z-[100]">
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
                <a href="{{ url('/login') }}"
                    class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                    <i class="fas fa-user"></i>
                    <p class="font-medium">{{Auth::user()->name}}</p>
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
    <div id="mobile-menu"
        class="hidden fixed lg:hidden rounded-b-lg px-[10%] py-3 w-full bg-gradient-to-r from-blue-900 to-blue-500 text-white text-sm flex items-center gap-5 justify-center flex-col z-[1]">
        <div class="border-b border-white text-white w-full py-3 text-center flex flex-col gap-3">
            <h1 class="font-regular text-[21px]">Badan Pusat Statistik</h1>
            <p class="font-light text-[16px]">Provinsi Riau</p>
        </div>
        <a href="#beranda" class="nav-link py-1">Beranda</a>
        <a href="#fungsi-bagian" class="nav-link py-1">Informasi bidang</a>
        <a href="#faqs" class="nav-link py-1">FAQs</a>
        @if (Auth::check())
            <a href="{{ url('/login') }}"
                class="px-5 py-3 mb-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <i class="fas fa-user"></i>
                <p class="font-medium">{{Auth::user()->name}}</p>
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
        <div class="m-0 p-0 w-full h-[75vh] absolute gradient-overlay z-[0] parallax-beranda">
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
                <a href=""
                    class="rounded-[10px] w-full md:px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500">Alur
                    Pendaftaran</a>
                <a href=""
                    class="rounded-[10px] w-full md:px-9 py-3 bg-white text-[#514E4E] text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-[#e2e2e2]">Telusuri
                    Program</a>
            </div>
        </div>
    </section>

    {{-- Fungsi bagian section --}}
    <section id="fungsi-bagian" class="w-full h-fit px-2 py-5 md:px-[5.5%] md:py-10 bg-gray-100">
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
                                class="fungsi-card-parent rounded-lg border p-5 bg-white flex flex-col h-full relative overflow-hidden">
                                <div class="w-[20%]">
                                    <img class="w-full" src="{{ asset('assets/home/fungsi_bagian/koma.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h2
                                        class="text-[20px] md:text-[25px] text-[#5d5d5d] font-bold text-end whitespace-nowrap">
                                        {{ $item['title'] }}</h2>
                                    <div class="w-full flex justify-end mt-[-5px]">
                                        <img class="w-[50%]"
                                            src="{{ asset('assets/home/fungsi_bagian/underline.svg') }}" alt="">
                                    </div>
                                    <p class="mt-5 text-[15px] text-gray-500">{{ $item['description'] }}</p>
                                </div>
                                <div class="flex justify-end">
                                    <div class="mt-3 w-fit text-end text-white relative z-10 icon-container">
                                        <i
                                            class="icon-info fa-solid fa-arrow-left p-3 bg-gradient-to-r from-blue-400 to-blue-700 rounded-full cursor-pointer rotate-45"></i>
                                    </div>
                                    <div
                                        class="overlay absolute top-0 left-0 w-full h-full flex items-center justify-center text-white text-center p-5 opacity-0 pointer-events-none transition-opacity duration-500 bg-gradient-to-r from-blue-50 to-blue-200 border border-blue-700">
                                        <div class="p-5">
                                            <h2 class="text-[22px] font-semibold text-blue-700">Rekomendasi Jurusan</h2>
                                            <div class="w-full flex justify-end mt-[-5px]">
                                                <img class="w-[70%]"
                                                    src="{{ asset('assets/home/fungsi_bagian/underline.svg') }}"
                                                    alt="">
                                            </div>
                                            <div class="mt-3 text-[14px] text-gray-800 font-normal flex">
                                                <p>
                                                    @foreach ($item['jurusan'] as $jurusan)
                                                        {{ $jurusan }},
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
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
            <h1 class="font-bold text-white text-[33px] md:text-[36px] lg:text-[49px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0"
                data-taos-offset="100">Belum kenal dengan BPS?</h1>
            <p class="font-light text-white text-[14px] w-[90%] lg:w-[60%] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0"
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

    {{-- FaQs Section --}}
    <section id="faqs"
        class="w-full h-fit px-2 py-5 md:px-[10%] md:py-10  flex items-center flex-col gap-[24px] bg-gray-100 overflow-hidden">
        <div class="w-[87%] flex flex-col items-start justify-center gap-1">
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
        class="flex flex-col w-full h-fit gap-7 px-5 py-5 md:px-[10%] md:py-10 bg-gradient-to-r from-blue-900 to-blue-500">
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
</body>

</html>
