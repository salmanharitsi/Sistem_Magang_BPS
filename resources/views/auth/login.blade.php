<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.documentElement.classList.add('js')
    </script>
    <title>Login - Simagang</title>
    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="flex flex-col lg:flex-row relative">
        <div class="m-0 p-0 w-full h-[100vh] relative gradient-overlay-login z-[0] basis-[65%]">
            <a href="{{ url('/') }}" class="w-fit text-gray-800 text-sm absolute flex items-center justify-center gap-4 top-5 md:top-10 left-4 md:left-10 px-5 py-2 bg-white hover:bg-gray-200 transition-all ease-in rounded-lg">
                <i class="fa-solid fa-arrow-left"></i>
                <p>kembali ke beranda</p>
            </a>
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full">
        </div>
        <div class="relative px-5 py-5 md:px-20 md:py-10 flex flex-col items-center justify-center gap-7 z-10 basis-[35%]">
            <div class="flex w-full items-center justify-start md:justify-center">
                <img class="w-[90px]" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="flex flex-col w-full items-start gap-4 text-gray-700">
                <h1 class="font-semibold text-lg md:text-2xl">Selamat Datang di <br> Website Pengelolaan Magang </h1>
                <p class="font-normal text-sm">Masuk untuk menggunakan layanan</p>
            </div>
            <div
                class="w-full rounded-lg ">
                <form class="space-y-4 " action="">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-normal">
                            Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:border-blue-500 w-full p-2.5"
                            placeholder="name@gmail.com" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-normal">
                            Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:border-blue-500 w-full p-2.5"
                            required />
                    </div>
                    <div class="flex items-start">
                        <a href="#" class="ms-auto text-sm text-blue-500 hover:underline">Lupa
                            Password?</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Masuk</button>
                    <div class="text-sm text-center text-gray-700">
                        Belum punya akun? <a href="{{url('/registrasi')}}"
                            class="text-blue-500 hover:underline">Registrasi akun</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
