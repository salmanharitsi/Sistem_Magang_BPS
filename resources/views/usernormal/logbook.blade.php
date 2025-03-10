@extends('layouts.app')

@section('title', 'User Presensi')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                    Logbook
                </h4>
            </div>
        </div>
        <!-- Start coding here -->
        <div class="col-span-4">
            @livewire('show-all-logbook')
        </div>

    </div>
@endsection
