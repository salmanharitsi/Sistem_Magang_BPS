{{-- File: resources/views/your-page/edit-testimoni.blade.php --}}

<div class="space-y-8 p-0.5 bg-[#f8f9fa]">
    <!-- Testimoni Peserta -->
    @livewire('testimoni-peserta')

    <!-- Simple Divider Line -->
    {{-- <div class=" border-t border-gray-300"></div> --}}

    <!-- Testimoni yang Ditampilkan -->
    @livewire('testimoni-ditampilkan')
</div>
