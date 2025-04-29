@php
    use Carbon\Carbon;
@endphp
<div class="pegawai-container">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/5">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="ti ti-search text-lg text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="cari pegawai..." required="">
                </div>
            </form>
        </div>
        <!-- Filter Button and Dropdown -->
        <div class="relative inline-block text-left">
            <button wire:click="create"
                class="text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 px-4 py-2 mr-2 inline-flex items-center">
                <i class="ti ti-plus mr-2"></i>
                Tambah Pegawai
            </button>
            <button id="filterButton" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="ti ti-filter mr-2"></i>
                Filter
            </button>
            <div id="filterDropdown"
                class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50">
                <div class="p-4">

                    <!-- Fungsi Bagian Filter -->
                    <div class="mb-4">
                        <label for="fungsi-bagian-filter"
                            class="block text-[15px] font-medium text-gray-700 mb-1">Fungsi Bagian</label>
                        <select wire:model.defer="filterFungsiBagian" id="fungsi-bagian-filter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Semua</option>
                            @foreach ($listFungsiBagian as $fungsi)
                                <option value="{{ $fungsi->title }}">{{ $fungsi->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div class="mb-4">
                        <label for="role-filter" class="block text-[15px] font-medium text-gray-700 mb-1">Role</label>
                        <select wire:model.defer="filterRole" id="role-filter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                            <option value="">Semua</option>
                            <option value="regular">Pembimbing</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <!-- Apply and Reset Buttons -->
                    <div class="flex">
                        <button wire:click="applyFilters" type="button"
                            class="px-3 py-2 w-full text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Minimum height container untuk tabel -->
    <div class="overflow-x-auto min-h-screen-half">
        <table id="dataIkuTable" class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="p-4 w-4 text-left">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Fungsi Bagian
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $pegawai->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{ $data->name }}
                        </td>
                        <td class="py-4 px-6 text-left">
                            {{ $data->fungsi_bagian }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="text-[13px] mx-auto items-center w-fit">
                                @if ($data->role_temp == 'regular')
                                    <p
                                        class="text-green-700 border-green-600 bg bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">
                                        Pembimbing</p>
                                @elseif($data->role_temp == 'admin')
                                    <p
                                        class="text-blue-700 border-blue-600 bg-blue-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">
                                        Admin</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <button wire:click="edit('{{ $data->id }}')" wire:key="edit-{{ $data->id }}"
                                class="mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <i class="ti ti-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="8" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Data Pegawai tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pegawai->links('vendor.pagination.custom-pagination') }}

        @if ($showModal)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[1000]">
                <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                    <div class="flex justify-between items-center border-b pb-4 mb-5">
                        <h2 class="text-lg font-semibold">Tambah Pegawai</h2>
                        <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Nama<span
                                        class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="name" name="name" id="name" type="text"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan nama pegawai">
                                @if ($errors->has('name'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Email<span
                                        class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="email" name="email" id="email" type="email"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan email pegawai">
                                @if ($errors->has('email'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Password<span
                                        class="text-red-500 ml-1">*</span></label>
                                <div class="relative group">
                                    <input wire:model.live="password" name="password" id="password" type="password"
                                        class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                        placeholder="Masukkan password">
                                    <button type="button" onclick="togglePasswordVisibility('password')"
                                        class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                                        <i id="togglePasswordIcon_password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Konfirmasi
                                    Password<span class="text-red-500 ml-1">*</span></label>
                                <div class="relative group">
                                    <input wire:model.live="confirm_password" name="confirm_password"
                                        id="confirm_password" type="password"
                                        class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                        placeholder="Masukkan konfirmasi password">
                                    <button type="button" onclick="togglePasswordVisibility('confirm_password')"
                                        class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                                        <i id="togglePasswordIcon_confirm_password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if ($errors->has('confirm_password'))
                                    <span
                                        class="text-red-500 text-[11px]">{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Nomor Induk
                                    Pegawai<span class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="nomor_induk" name="nomor_induk" id="nomor_induk"
                                    type="number"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan nomor induk pegawai">
                                @if ($errors->has('nomor_induk'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('nomor_induk') }}</span>
                                @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Fungsi Bagian<span
                                        class="text-red-500 ml-1">*</span></label>
                                <select wire:model.live="fungsi_bagian" name="fungsi_bagian" id="fungsi_bagian"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]">
                                    <option value="">-- Pilih Fungsi Bagian --</option>
                                    @foreach ($listFungsiBagian as $fungsi)
                                        <option value="{{ $fungsi->title }}">{{ $fungsi->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('fungsi_bagian'))
                                    <span
                                        class="text-red-500 text-[11px]">{{ $errors->first('fungsi_bagian') }}</span>
                                @endif
                            </div>

                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Role<span
                                        class="text-red-500 ml-1">*</span></label>
                                <select wire:model.live="role_temp" name="role_temp" id="role_temp"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="regular">Pembimbing</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @if ($errors->has('role_temp'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('role_temp') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 flex">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">Buat
                                Akun Pegawai</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if ($showEditModal)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[1000]">
                <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-5">
                    <div class="flex justify-between items-center border-b pb-4 mb-5">
                        <h2 class="text-lg font-semibold">Edit Pegawai</h2>
                        <button wire:click="closeEditModal" class="text-gray-500 hover:text-gray-700">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Nama<span
                                        class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="name" name="name" type="text"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan nama pegawai">
                                @if ($errors->has('name'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Email<span
                                        class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="email" name="email" type="email"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan email pegawai">
                                @if ($errors->has('email'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Password</label>
                                <div class="relative group">
                                    <input wire:model.live="password" name="password" id="edit_password"
                                        type="password"
                                        class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <button type="button" onclick="togglePasswordVisibility('edit_password')"
                                        class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                                        <i id="togglePasswordIcon_edit_password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div>
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Konfirmasi Password</label>
                                <div class="relative group">
                                    <input wire:model.live="confirm_password" name="confirm_password"
                                        id="edit_confirm_password" type="password"
                                        class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <button type="button" onclick="togglePasswordVisibility('edit_confirm_password')"
                                        class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                                        <i id="togglePasswordIcon_edit_confirm_password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if ($errors->has('confirm_password'))
                                    <span
                                        class="text-red-500 text-[11px]">{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Nomor Induk
                                    Pegawai<span class="text-red-500 ml-1">*</span></label>
                                <input wire:model.live="nomor_induk" name="nomor_induk" type="number"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]"
                                    placeholder="Masukkan nomor induk pegawai">
                                @if ($errors->has('nomor_induk'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('nomor_induk') }}</span>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-[15px] font-medium text-gray-700">Role<span
                                        class="text-red-500 ml-1">*</span></label>
                                <select wire:model.live="role_temp" name="role_temp"
                                    class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder:text-[12px]">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="regular">Pembimbing</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @if ($errors->has('role_temp'))
                                    <span class="text-red-500 text-[11px]">{{ $errors->first('role_temp') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 flex">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <style>
        .min-h-screen-half {
            min-height: 50vh;
        }
    </style>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('togglePasswordIcon_' + fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filterButton');
            const filterDropdown = document.getElementById('filterDropdown');

            filterButton.addEventListener('click', function(event) {
                event.stopPropagation();
                filterDropdown.classList.toggle('hidden');

                const buttonRect = filterButton.getBoundingClientRect();
                filterDropdown.style.top = (buttonRect.height + 5) + 'px';
            });

            document.addEventListener('click', function(event) {
                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</div>
