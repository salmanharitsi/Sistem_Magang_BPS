@extends('layouts.pembimbing')

@section('title', 'Pembimbing dashboard')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">

        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Bimbingan</h1>
                <p class="text-2xl font-bold">10</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Bimbingan Selesai</h1>
                <p class="text-2xl font-bold">8</p>
                <p class="text-sm font-normal text-blue-600">+5 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Bimbingan Aktif</h1>
                <p class="text-2xl font-bold">2</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>

    </div>

@endsection