@extends('layouts.app')

@section('title', 'User Presensi')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                    Logbook
                </h4>
            </div>
        </div>

        @if (Carbon::parse($magang->tanggal_mulai)->isFuture())
            <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <i class="ti ti-calendar-time text-lg"></i>
                    <p class="text-sm">Logbook akan tersedia pada <span class="font-bold">{{ Carbon::parse($magang->tanggal_mulai)->translatedFormat('j F Y') }}</span></p>
                </div>
            </div>
        @else
            <!-- Start coding here -->
            <div class="col-span-4">
                @livewire('show-all-logbook')
            </div>
        @endif
    </div>
@endsection
