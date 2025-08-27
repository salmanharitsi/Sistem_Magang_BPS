@extends('layouts.admin')

@section('title', 'Edit Konten')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

    <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
        <div class="">
            <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                Edit Konten
            </h4>
        </div>
    </div>
    <div class="lg:grid grid-cols-1 lg:grid-cols-6 gap-x-6 gap-y-6 col-span-4">
        <div class="col-span-1">
            <ul class="flex-column sticky top-5 space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 mb-4 md:mb-0" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-white bg-blue-600" data-tabs-inactive-classes="bg-white card hover:text-blue-600" role="tablist">
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" aria-current="page" id="fungsi-bagian-styled-tab" data-selected="fungsi-bagian" data-tabs-target="#styled-fungsi-bagian" type="button" role="tab" aria-controls="fungsi-bagian" aria-selected="false">
                        <i class="ti ti-hierarchy-3 text-lg"></i>
                        <p>Fungsi Bagian</p>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="faq-styled-tab" data-selected="faq" data-tabs-target="#styled-faq" type="button" role="tab" aria-controls="faq" aria-selected="false">
                        <i class="ti ti-message-question text-lg"></i>
                        <p>FAQ</p>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="galeri-styled-tab" data-selected="galeri" data-tabs-target="#styled-galeri" type="button" role="tab" aria-controls="galeri" aria-selected="false">
                        <i class="ti ti-photo-plus text-lg"></i>
                        <p>Galeri</p>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="fasilitas-styled-tab" data-selected="fasilitas" data-tabs-target="#styled-fasilitas" type="button" role="tab" aria-controls="fasilitas" aria-selected="false">
                        <i class="ti ti-tools text-lg"></i>
                        <p>Fasilitas Magang</p>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="testimoni-styled-tab" data-selected="testimoni" data-tabs-target="#styled-testimoni" type="button" role="tab" aria-controls="testimoni" aria-selected="false">
                        <i class="ti ti-message-question text-lg"></i>
                        <p>Testimoni</p>
                    </button>
                </li>
            </ul>
        </div>
        <div class=" rounded-lg col-span-5 h-fit" id="default-styled-tab-content">
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden" id="styled-fungsi-bagian" role="tabpanel" aria-labelledby="profile-tab">
                @livewire('edit-fungsi-bagian')
            </div>
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden" id="styled-faq" role="tabpanel" aria-labelledby="dashboard-tab">
                @livewire('edit-faq')
            </div>
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden" id="styled-galeri" role="tabpanel" aria-labelledby="dashboard-tab">
                @livewire('edit-galeri') 
            </div>
            <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden" id="styled-fasilitas" role="tabpanel" aria-labelledby="dashboard-tab">
                @livewire('fasilitas-magang') 
            </div>
            <div class="col-span-4 !bg-transparent dark:bg-gray-800 relative rounded-lg overflow-hidden" id="styled-testimoni" role="tabpanel" aria-labelledby="dashboard-tab">
                @livewire('edit-testimoni') 
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil query string dari URL
        const params = new URLSearchParams(window.location.search);
        const selectedTab = params.get('selected');
    
        if (selectedTab) {
            let tabId;
    
            // Tentukan tab ID berdasarkan nilai data-selected
            switch (selectedTab) {
                case 'fungsi-bagian':
                    tabId = 'fungsi-bagian-styled-tab';
                    break;
                case 'faq':
                    tabId = 'faq-styled-tab';
                    break;
                case 'galeri':
                    tabId = 'galeri-styled-tab';
                    break;
                case 'fasilitas':
                    tabId = 'fasilitas-styled-tab';
                    break;
                case 'testimoni':
                    tabId = 'testimoni-styled-tab';
                    break;
                default:
                    tabId = null;
            }
    
            // Jika tabId valid, set aria-selected menjadi true
            if (tabId) {
                document.getElementById(tabId).setAttribute('aria-selected', 'true');
            }
        }
    
        // Tambahkan event listener untuk mengubah query string saat tombol ditekan
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const selected = this.getAttribute('data-selected');
                const url = new URL(window.location);
                url.searchParams.set('selected', selected);
                window.history.pushState({}, '', url);
            });
        });
    });
</script>
@endsection