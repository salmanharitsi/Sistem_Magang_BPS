@extends('layouts.admin')

@section('title', 'Edit Fungsi Bagian')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

    <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
        <div class="">
            <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                Edit Home
            </h4>
        </div>
    </div>
    <div class="lg:grid grid-cols-1 lg:grid-cols-6 gap-x-6 gap-y-6 col-span-4">
        <div class="col-span-1">
            <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 mb-4 md:mb-0" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-white bg-blue-600" data-tabs-inactive-classes="bg-white card hover:text-blue-600" role="tablist">
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" aria-current="page" id="biodata-styled-tab" data-selected="biodata" data-tabs-target="#styled-biodata" type="button" role="tab" aria-controls="biodata" aria-selected="false">
                        <i class="ti ti-hierarchy-3 text-lg"></i>
                        <p>Fungsi Bagian</p>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="akademik-styled-tab" data-selected="akademik" data-tabs-target="#styled-akademik" type="button" role="tab" aria-controls="akademik" aria-selected="false">
                        <i class="ti ti-message-question text-lg"></i>
                        <p>FAQ</p>
                    </button>
                </li>
            </ul>
        </div>
        <div class="card rounded-lg p-5 col-span-5 bg-white h-fit" id="default-styled-tab-content">
            <div class="bg-white text-medium text-gray-500 rounded-lg w-full" id="styled-biodata" role="tabpanel" aria-labelledby="profile-tab">
                <h4 class="text-gray-800 text-2xl pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    Fungsi Bagian
                </h4>
                <div class="md:px-[0%] md:pt-[2%]">
                    @livewire('edit-fungsi-bagian')
                </div>
            </div>
            <div class="bg-white text-medium text-gray-500 rounded-lg w-full" id="styled-akademik" role="tabpanel" aria-labelledby="dashboard-tab">
                <h4 class="text-gray-800 text-2xl pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    FAQ
                </h4>
                <div class="md:px-[0%] md:pt-[2%]">
                    @livewire('edit-faq')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection