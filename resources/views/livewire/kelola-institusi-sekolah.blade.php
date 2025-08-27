@php
    use Carbon\Carbon;
@endphp

<div>
    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button 
                    wire:click="setActiveTab('approved')"
                    class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'approved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 m-2' }}">
                    Seluruh Institusi
                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $approvedInstitusi->total() }}
                    </span>
                </button>
                <button 
                    wire:click="setActiveTab('pending')"
                    class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Institusi Perlu Review
                    <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $pendingInstitusi->total() }}
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800">{{ session('success')['title'] }}</p>
        </div>
    @endif

    <!-- Tab Content -->
    <div class="tab-content">
        @if($activeTab === 'approved')
            <!-- Tabel Institusi Diverifikasi -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/5">
                        <form class="flex items-center">
                            <label for="approved-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="ti ti-search text-lg text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <input wire:model.live="search" type="text" id="approved-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="cari institusi..." required="">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto min-h-screen-half">
                    <table class="w-full text-sm text-left rtl:text-left">
                        <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                            <tr class="h-full">
                                <th scope="col" class="p-4 w-4 text-left">No</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-left">Nama Institusi</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-left">Alamat</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Total Mahasiswa</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($approvedInstitusi as $index => $data)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 w-[30px]">{{ $approvedInstitusi->firstItem() + $index }}</td>
                                    <td class="py-4 px-6 text-left font-medium">{{ $data->nama }}</td>
                                    <td class="py-4 px-6 text-left">{{ $data->alamat }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            0 Mahasiswa
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <button wire:click="openModal({{ $data->id }})"
                                            class="w-fit mx-auto flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                            <i class="ti ti-eye"></i>
                                            <p class="text-sm whitespace-nowrap">Review</p>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b hover:bg-gray-50 text-center">
                                    <td colspan="5" class="py-10 text-gray-300">
                                        <i class="ti ti-building text-4xl"></i>
                                        <p class="font-semibold text-md">Belum ada institusi yang diverifikasi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination untuk approved -->
                    {{ $approvedInstitusi->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>

        @else
            <!-- Tabel Institusi Perlu Review -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/5">
                        <form class="flex items-center">
                            <label for="pending-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="ti ti-search text-lg text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <input wire:model.live="searchApproved" type="text" id="pending-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="cari institusi..." required="">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto min-h-screen-half">
                    <table class="w-full text-sm text-left rtl:text-left">
                        <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                            <tr class="h-full">
                                <th scope="col" class="p-4 w-4 text-left">No</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-left">Nama Institusi</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-left">Alamat</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-left">Tanggal Daftar</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Status</th>
                                <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingInstitusi as $index => $data)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 w-[30px]">{{ $pendingInstitusi->firstItem() + $index }}</td>
                                    <td class="py-4 px-6 text-left font-medium">{{ $data->nama }}</td>
                                    <td class="py-4 px-6 text-left">{{ $data->alamat }}</td>
                                    <td class="py-4 px-6 text-left">{{ Carbon::parse($data->created_at)->format('d/m/Y') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="text-[13px] w-fit items-center mx-auto">
                                            <p class="text-amber-700 border-amber-600 bg-amber-50 border-2 rounded-full whitespace-nowrap px-3 py-1">
                                                Menunggu Review
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <button wire:click="openModal({{ $data->id }})"
                                            class="w-fit mx-auto flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                            <i class="ti ti-eye"></i>
                                            <p class="text-sm whitespace-nowrap">Review</p>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b hover:bg-gray-50 text-center">
                                    <td colspan="6" class="py-10 text-gray-300">
                                        <i class="ti ti-building text-4xl"></i>
                                        <p class="font-semibold text-md">Tidak ada institusi yang perlu direview</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination untuk pending -->
                    {{ $pendingInstitusi->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Review Institusi (Style seperti EditGaleri) -->
    @if($showModal && $selectedInstitusi)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Review Institusi</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <!-- Content Modal -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ $selectedInstitusi->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Saat Ini</label>
                            <div class="text-[13px] w-fit">
                                @if ($selectedInstitusi->status == 'pending')
                                    <p class="text-amber-700 border-amber-600 bg-amber-50 border-2 rounded-full whitespace-nowrap px-3 py-1">Menunggu Review</p>
                                @elseif($selectedInstitusi->status == 'approved')
                                    <p class="text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1">Disetujui</p>
                                @else
                                    <p class="text-red-700 border-red-600 bg-red-50 border-2 rounded-full whitespace-nowrap px-3 py-1">Ditolak</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ $selectedInstitusi->alamat }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pendaftaran</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ Carbon::parse($selectedInstitusi->created_at)->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Update</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ Carbon::parse($selectedInstitusi->updated_at)->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($selectedInstitusi->status == 'pending')
                    <div class="flex justify-end space-x-3 pt-6 mt-6 border-t">
                        <button wire:click="closeModal" type="button" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </button>
                        <button wire:click="rejectInstitusi({{ $selectedInstitusi->id }})" type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="ti ti-x mr-1"></i>
                            Tolak
                        </button>
                        <button wire:click="approveInstitusi({{ $selectedInstitusi->id }})" type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="ti ti-check mr-1"></i>
                            Setujui
                        </button>
                    </div>
                @else
                    <div class="flex justify-end pt-6 mt-6 border-t">
                        <button wire:click="closeModal" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Tutup
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>