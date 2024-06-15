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

    {{-- Navbar section --}}
    <nav
        class="sticky top-0 px-[20px] md:px-[10%] py-3 w-full flex justify-between items-center bg-gradient-to-r from-blue-900 to-blue-500 z-[2]">
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
            <a href="#fungsi-bagian" class="nav-link py-1">FAQs</a>
            <a href=""
                class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <i class="fas fa-user"></i>
                <p class="font-medium">Masuk ke akun</p>
            </a>
        </div>
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fa-solid fa-bars fa-2x"></i>
            </button>
        </div>
    </nav>
    <div id="mobile-menu"
        class="hidden fixed lg:hidden px-[10%] py-3 w-full bg-gradient-to-r from-blue-900 to-blue-500 text-white text-sm flex items-center gap-5 justify-center flex-col z-[1]">
        <div class="border-b border-white text-white w-full py-3 text-center flex flex-col gap-3">
            <h1 class="font-regular text-[21px]">Badan Pusat Statistik</h1>
            <p class="font-light text-[16px]">Provinsi Riau</p>
        </div>
        <a href="#beranda" class="nav-link py-1">Beranda</a>
        <a href="#fungsi-bagian" class="nav-link py-1">Informasi bidang</a>
        <a href="#fungsi-bagian" class="nav-link py-1">FAQs</a>
        <a href="" class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
            <i class="fas fa-user"></i>
            <p class="font-medium">Masuk ke akun</p>
        </a>
    </div>

    {{-- Beranda section --}}
    <section id="beranda">
        <div class="m-0 p-0 w-full h-[75vh] absolute gradient-overlay z-[0]">
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full">
        </div>
        <div class="relative px-[20px] md:px-[10%] h-[75vh] flex flex-col items-end text-end justify-center gap-8">
            <h1 class="font-bold text-white text-[33px] md:text-[41px] lg:text-[54px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0"
                data-taos-offset="100">Program Magang <br> Bersama Badan Pusat Statistik <br> Provinsi Riau</h1>
            <p class="font-light text-white text-[14px] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0"
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
    <section id="fungsi-bagian" class="w-full h-fit px-2 py-5 md:px-[10%] md:py-10 bg-gray-100">
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
                    @foreach($fungsi_bagian as $item)
                    <li class="px-2 py-2 md:py-5 md:px-5">
                        <div class="rounded-lg border p-5 bg-white flex flex-col h-full relative overflow-hidden">
                            <div class="w-[20%]">
                                <img class="w-full" src="{{ asset('assets/home/fungsi_bagian/koma.svg') }}" alt="">
                            </div>
                            <div>
                                <h2 class="text-[20px] md:text-[25px] text-[#5d5d5d] font-bold text-end whitespace-nowrap">{{ $item['title'] }}</h2>
                                <div class="w-full flex justify-end mt-[-5px]">
                                    <img class="w-[50%]" src="{{ asset('assets/home/fungsi_bagian/underline.svg') }}" alt="">
                                </div>
                                <p class="mt-5 text-[15px] text-gray-500">{{ $item['description'] }}</p>
                            </div>
                            <div class="flex justify-end">
                                <div class="mt-3 w-fit text-end text-white relative z-10 icon-container">
                                    <i class="icon-info fa-solid fa-arrow-left p-3 bg-gradient-to-r from-blue-400 to-blue-700 rounded-full cursor-pointer rotate-45"></i>
                                </div>
                                <div class="overlay absolute top-0 left-0 w-full h-full flex items-center justify-center text-white text-center p-5 opacity-0 pointer-events-none transition-opacity duration-500">
                                    <div class="p-5">
                                        <h2 class="text-[22px] font-semibold">Rekomendasi Jurusan</h2>
                                        <div class="w-full flex justify-end mt-[-5px]">
                                            <img class="w-[70%]" src="{{ asset('assets/home/fungsi_bagian/underline-white.svg') }}" alt="">
                                        </div>
                                        <div class="mt-3 text-[14px] font-light flex">
                                            <p>
                                                @foreach($item['jurusan'] as $jurusan)
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

    <section>
        
    </section>

    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>
</body>

</html>
