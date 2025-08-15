@extends('layouts.app')

@section('title', 'Nilai & Sertifikat')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="flex h-full items-center">
                    <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                        Nilai & Sertifikat Magang
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-span-4">
            @livewire('nilai-sertifikat', ['magang' => $magang])
        </div>

    </div>

@endsection
