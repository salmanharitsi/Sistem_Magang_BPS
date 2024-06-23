@extends('layouts.app')

@section('title', 'User dashboard')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">

        <div class="flex flex-col gap-6">
            <div class="card rounded-xl bg-white p-5 h-full dark:bg-gray-700 transition-all duration-200">
                <h4 class="text-gray-700 text-lg font-semibold mb-4 dark:text-white">
                    Cari Pengajuan
                </h4>
                <div class="flex items-center justify-between relative group">
                    <input type="text" name="" id="" placeholder="" wire:model.live=""
                        class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
                    <button type="button"
                        class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                        <i id="" class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card rounded-xl bg-white p-5 h-full dark:bg-gray-700 transition-all duration-200">
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

        <div class="col-span-3 card rounded-xl bg-white p-5 h-full dark:bg-gray-700 transition-all duration-200">
            <div class="">
                <h4 class="text-gray-700 text-lg font-semibold mb-4 dark:text-white">
                    Riwayat Pengajuan
                </h4>
            </div>
        </div>

    </div>
@endsection
