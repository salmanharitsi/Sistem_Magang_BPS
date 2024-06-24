@extends('layouts.app')

@section('title', 'User dashboard')

@section('content')
    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div
                class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Kamu belum terdaftar program magang</p>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <h4 class="text-gray-500 text-lg font-semibold mb-4 dark:text-white">
                    Traffic Distribution
                </h4>
                <div class="flex items-center justify-between gap-12">

                </div>
            </div>
            <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="flex gap-6 items-center justify-between">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-gray-500 text-lg font-semibold dark:text-white">
                            Product Sales
                        </h4>
                        <div class="flex flex-col gap-4">
                            <h3 class="text-[22px] font-semibold text-gray-500">
                                $6,820
                            </h3>
                            <div class="flex items-center gap-1">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-red-400">
                                    <i class="ti ti-arrow-down-right text-red-500"></i>
                                </span>
                                <p class="text-gray-500 text-sm font-normal">
                                    +9%
                                </p>
                                <p class="text-gray-400 text-sm font-normal text-nowrap">
                                    last year
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
