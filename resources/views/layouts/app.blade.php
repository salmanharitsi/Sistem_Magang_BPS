<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Favicon icon-->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" />
    <!-- Core Css -->
    <link rel="stylesheet" href="./assets/css/theme.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>

    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/darkMode.js', 'resources/js/dashboard.js'])
</head>

@php
    $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
@endphp

<body class="bg-gray-100 dark:bg-gray-800 transition-all duration-200">

    @include('_message')

    <div class="flex p-5 xl:pr-0">
        <!-- -------------- -->
        <!-- Layout Sidebar -->
        <!-- -------------- -->
        <aside id="application-sidebar-brand"
            class="hs-overlay hs-overlay-open:translate-x-0 dark:bg-gray-700 -translate-x-full transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-5 xl:left-auto top-0 left-0 with-vertical h-screen z-[999] shrink-0 w-[270px] shadow-md lg:rounded-xl bg-white left-sidebar transition-all duration-200">
            <div class="p-4">
                <a href="../" class="text-nowrap flex">
                    <div class="flex items-center justify-start md:justify-center border-transparent">
                        <img class="mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
                    </div>
                </a>
            </div>
            <div class="scroll-sidebar" data-simplebar="">
                <nav class="w-full flex flex-col sidebar-nav px-4 mt-5">
                    <ul id="sidebarnav" class="text-gray-600 text-sm">
                        <li class="text-xs font-bold pb-[5px]">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-600 font-semibold">HOME</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center relative rounded-md w-full transition-all duration-200 border border-white dark:border-gray-600 hover:border-blue-600 hover:text-blue-600"
                                href="/dashboard">
                                <i class="ti ti-layout-dashboard ps-2 text-xl"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="text-xs font-bold pb-[5px] mt-6">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-600 font-semibold">MENU</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center relative rounded-md w-full transition-all duration-200 border border-white dark:border-gray-600 hover:text-blue-600"
                                href="/pengajuan">
                                <i class="ti ti-list-check ps-2 text-xl"></i>
                                <span>Status Pengajuan</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center relative rounded-md w-full transition-all duration-200 border border-white dark:border-gray-600 hover:border-blue-600 hover:text-blue-600"
                                href="#">
                                <i class="ti ti-user-square ps-2 text-xl"></i>
                                <span>Profil</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center relative rounded-md w-full transition-all duration-200 border border-white dark:border-gray-600 hover:border-blue-600 hover:text-blue-600"
                                href="#">
                                <i class="ti ti-logout ps-2 text-xl"></i>
                                <span>Keluar</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- -------------- -->
        <!-- Layout Main -->
        <!-- -------------- -->
        <div class="w-full page-wrapper xl:px-6 px-0">
            <!-- Main Content -->
            <main class="h-full max-w-full">
                <div class="container full-container p-0 flex flex-col gap-6">
                    <!-- -------------- -->
                    <!-- Layout Header -->
                    <!-- -------------- -->
                    <header
                        class="bg-white sticky top-5 z-10 shadow-md rounded-xl w-full text-sm py-4 px-6 transition-all duration-200 dark:bg-gray-700">
                        <!-- ========== HEADER ========== -->

                        <nav class="w-full h-full flex items-center justify-between" aria-label="Global">
                            <div class="text-xl dark:text-white max-xl:hidden">
                                <h1>Halo! <span class="font-medium">{{ Auth::user()->name }}</span></h1>
                            </div>
                            <ul class="icon-nav flex items-center gap-4">
                                <li class="relative xl:hidden dark:text-white">
                                    <a class="text-xl icon-hover cursor-pointer text-heading" id="headerCollapse"
                                        data-hs-overlay="#application-sidebar-brand"
                                        aria-controls="application-sidebar-brand" aria-label="Toggle navigation"
                                        href="javascript:void(0)">
                                        <i class="ti ti-menu-2 relative z-1"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="flex gap-4">
                                <button id="theme-toggle" type="button"
                                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                        </path>
                                    </svg>
                                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                            fill-rule="evenodd" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                                        @if (Auth::user()->foto_profil != null)
                                            <a
                                                class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                                <img class="object-cover w-9 h-9 rounded-full"
                                                    src="./assets/images/profile/user-1.jpg" alt=""
                                                    aria-hidden="true" />
                                            </a>
                                        @else
                                            <a
                                                class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full bg-gradient-to-r from-blue-300 to-blue-50 border border-blue-600">
                                                <h1
                                                    class="object-cover font-regular text-blue-600 text-lg w-9 h-9 flex items-center justify-center">
                                                    {{ $firstLetter }}</h1>
                                            </a>
                                        @endif
                                        <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max w-[200px] hidden z-[12] bg-gray-100 dark:bg-gray-800"
                                            aria-labelledby="hs-dropdown-custom-icon-trigger">
                                            <div class="p-3  rounded-md flex flex-col gap-2">

                                                <a href=""
                                                    class="flex gap-2 items-center font-normal px-2 py-1 bg-gradient-to-r from-blue-300 to-blue-400 text-blue-600 rounded-md
                                                            hover:from-white hover:border hover:border-blue-600 hover:text-blue-600 transition duration-300
                                                            dark:from-green-200 dark:to-green-300 dark:hover:from-gray-800 dark:hover:border-green-500 dark:hover:text-green-500 dark:text-gray-700">
                                                    <i class="ti ti-user text-xl"></i>
                                                    <p class="text-[13px]">Profil Saya</p>
                                                </a>

                                                <a href="/logout"
                                                    class="flex gap-2 items-center font-normal px-2 py-1 bg-gradient-to-r from-blue-300 to-blue-400 text-blue-600 rounded-md
                                                            hover:from-white hover:border hover:border-blue-600 hover:text-blue-600 transition duration-300
                                                            dark:from-green-200 dark:to-green-300 dark:hover:from-gray-800 dark:hover:border-green-500 dark:hover:text-green-500 dark:text-gray-700">
                                                    <i class="ti ti-logout text-xl"></i>
                                                    <p class="text-[13px]">Keluar</p>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <!-- ========== END HEADER ========== -->
                    </header>

                    <!-- -------------- -->
                    <!-- Content -->
                    <!-- -------------- -->
                    <div id="pjax-container">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add your scripts here -->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./assets/libs/iconify-icon/dist/iconify-icon.min.js"></script>
    <script src="./assets/libs/@preline/dropdown/index.js"></script>
    <script src="./assets/libs/@preline/overlay/index.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script>
        $(document).pjax('a.pjax-link', '#pjax-container');

        $(document).on('pjax:end', function() {
            // Add any reinitialization code here, for example:
            // window.livewire.rescan();
        });
    </script>

</body>
