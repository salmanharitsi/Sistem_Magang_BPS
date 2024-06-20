<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Registrasi - Simagang</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="h-fit">
        <div class="m-0 p-0 w-full h-[50vh] absolute gradient-overlay-registrasi z-[0] basis-[65%]">
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class= "object-cover w-full h-full">
        </div>
        <div class="relative h-fit md:h-[115vh] 3xl:h-[100vh] flex items-center justify-center">
            <div class="w-full sm:w-[90%] lg:w-[50%]">
                @livewire('registrasi')
            </div>
        </div>
    </div>
    
    @livewireScripts
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
            newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
            newWindow.document.title = "Image Preview";
        }
    </script>
    
</body>

</html>
