<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('bps.png') }}" type="image/png"/>
    <script>
        document.documentElement.classList.add('js')
    </script>
    <title>Daftarkan Institusi - Simagang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@if (Auth::check())
    @php
        $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
    @endphp
@endif
@if (Auth::guard('pegawai')->check())
    @php
        $firstLetter = strtoupper(substr(Auth::guard('pegawai')->user()->name, 0, 1));
    @endphp
@endif

<body class="bg-gray-50">
    @include('_message')

    {{-- Navbar section --}}
    <nav
        class="fixed top-0 px-[20px] md:px-[10%] py-3 w-full flex justify-between items-center bg-gradient-to-r from-blue-900 to-blue-500 z-[100]">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r md:border-white border-transparent">
                <img class="w-[80%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white hidden md:block">
                <h1 class="font-normal">Badan Pusat Statistik</h1>
                <p class="font-light">Provinsi Riau</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center justify-center gap-7 text-white text-sm">
            <a href="{{ url('/') }}#beranda" class="nav-link py-1">Beranda</a>
            <a href="{{ url('/') }}#fungsi-bagian" class="nav-link py-1">Informasi bagian</a>
            <a href="{{ url('/') }}#faqs" class="nav-link py-1">FAQs</a>
            @if (Auth::check())
                @if (!empty(Auth::user()->foto_profil))
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                            class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer">
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                        <div
                            class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                            <h1>{{ $firstLetter }}</h1>
                        </div>
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @endif
            @elseif(Auth::guard('pegawai')->check())
                @php
                    $pegawai = Auth::guard('pegawai')->user();
                    $dashboardUrl = $pegawai->role_temp == 'admin' ? '/dashboard-admin' : '/dashboard-pembimbing';
                @endphp
                <a href="{{ url($dashboardUrl) }}"
                    class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                    <div
                        class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                        <h1>{{ $firstLetter }}</h1>
                    </div>
                    <p class="font-medium">{{ Str::limit($pegawai->name, 9, '...') }}</p>
                </a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                    <i class="fas fa-user"></i>
                    <p class="font-medium">Masuk ke akun</p>
                </a>
            @endif
        </div>
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fa-solid fa-bars fa-2x"></i>
            </button>
        </div>
    </nav>

    <!-- Add spacing to prevent content from hiding behind fixed navbar -->
    <div class="h-[62px]"></div>

    <div id="mobile-menu"
        class="hidden fixed lg:hidden top-[62px] rounded-b-lg py-3 w-full bg-gradient-to-r from-blue-900 to-blue-500 text-white text-sm flex items-center gap-5 justify-center flex-col z-30 overflow-hidden">
        <div class="border-b border-white text-white w-full py-3 text-center flex flex-col gap-3">
            <h1 class="font-regular text-[21px]">Badan Pusat Statistik</h1>
            <p class="font-light text-[16px]">Provinsi Riau</p>
        </div>
        <a href="{{ url('/') }}#beranda" class="nav-link py-3">Beranda</a>
        <a href="{{ url('/') }}#fungsi-bagian" class="nav-link py-3">Informasi bidang</a>
        <a href="{{ url('/') }}#faqs" class="nav-link py-3">FAQs</a>
        @if (Auth::check())
            <a href="{{ url('/dashboard') }}"
                class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                @if (!empty(Auth::user()->foto_profil))
                    <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                        class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer">
                @else
                    <div class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                        <h1>{{ $firstLetter }}</h1>
                    </div>
                @endif
                <p class="font-medium">{{ Str::limit(Auth::user()->name, 15, '...') }}</p>
            </a>
        @else
            <a href="{{ url('/login') }}"
                class="px-5 py-3 mb-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <i class="fas fa-user"></i>
                <p class="font-medium">Masuk ke akun</p>
            </a>
        @endif
    </div>

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-500 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Daftarkan Institusi</h1>
                <p class="text-xl text-blue-100">Daftarkan institusi Anda untuk program magang BPS Provinsi Riau</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Info Banner -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Informasi Penting</h3>
                    <ul class="text-blue-800 space-y-1 text-sm">
                        <li>• Hanya institusi yang sudah diverifikasi yang dapat dipilih saat pendaftaran magang</li>
                        <li>• Proses verifikasi institusi membutuhkan waktu 1-3 hari kerja</li>
                        <li>• Pastikan data yang dimasukkan benar dan lengkap</li>
                        <li>• Jika institusi belum disetujui, silakan menunggu atau hubungi BPS Provinsi Riau</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Form Pendaftaran -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-university text-blue-600 mr-2"></i>
                    Daftarkan Institusi Baru
                </h2>

                <form action="{{ route('institusi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Nama Institusi -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="nama" 
                               id="nama" 
                               value="{{ old('nama') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                               placeholder="Contoh: Universitas Negeri Jakarta"
                               required>
                        @error('nama')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Institusi -->
                    {{-- <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Institusi <span class="text-red-500">*</span></label>
                        <select name="jenis" 
                                id="jenis" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                required>
                            <option value="">Pilih Jenis Institusi</option>
                            <option value="universitas" {{ old('jenis') === 'universitas' ? 'selected' : '' }}>Universitas</option>
                            <option value="sekolah" {{ old('jenis') === 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                            <option value="akademi" {{ old('jenis') === 'akademi' ? 'selected' : '' }}>Akademi</option>
                            <option value="politeknik" {{ old('jenis') === 'politeknik' ? 'selected' : '' }}>Politeknik</option>
                            <option value="lainnya" {{ old('jenis') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" 
                                  id="alamat" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                  placeholder="Alamat lengkap institusi"
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kontak Person -->
                    {{-- <div>
                        <label for="kontak_person" class="block text-sm font-medium text-gray-700 mb-1">Nama Kontak Person <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="kontak_person" 
                               id="kontak_person" 
                               value="{{ old('kontak_person') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                               placeholder="Nama orang yang dapat dihubungi"
                               required>
                        @error('kontak_person')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Email -->
                    {{-- <div>
                        <label for="email_pengaju" class="block text-sm font-medium text-gray-700 mb-1">Email Institusi <span class="text-red-500">*</span></label>
                        <input type="email" 
                               name="email_pengaju" 
                               id="email_pengaju" 
                               value="{{ old('email_pengaju') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                               placeholder="email@institusi.ac.id"
                               required>
                        @error('email_pengaju')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Nomor Telepon -->
                    {{-- <div>
                        <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" 
                               name="nomor_telepon" 
                               id="nomor_telepon" 
                               value="{{ old('nomor_telepon') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                               placeholder="08xxxxxxxxxx atau 021xxxxxxx"
                               required>
                        @error('nomor_telepon')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Keterangan -->
                    {{-- <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                        <textarea name="keterangan" 
                                  id="keterangan" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                  placeholder="Informasi tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Daftarkan Institusi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Status Institusi -->
            <div class="space-y-6">
                <!-- Institusi Pending -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                        Menunggu Verifikasi ({{ $institusiPending->count() }})
                    </h3>
                    
                    @if($institusiPending->count() > 0)
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @foreach($institusiPending as $institusi)
                                <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                    <h4 class="font-medium text-gray-800">{{ $institusi->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ Str::limit($institusi->alamat, 60) }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded">
                                            Menunggu Verifikasi
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada institusi yang menunggu verifikasi</p>
                    @endif
                </div>

                <!-- Institusi Approved -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Institusi Disetujui ({{ $institusiApproved->count() }})
                    </h3>
                    
                    @if($institusiApproved->count() > 0)
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @foreach($institusiApproved as $institusi)
                                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <h4 class="font-medium text-gray-800">{{ $institusi->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ Str::limit($institusi->alamat, 60) }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded">
                                            Disetujui
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Disetujui {{ $institusi->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada institusi yang disetujui</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

    {{-- Footer section --}}
    <footer
        class="flex flex-col w-full h-fit gap-7 px-5 py-5 md:px-[10%] md:py-7 bg-gradient-to-r from-blue-900 to-blue-500">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r border-white border-transparent">
                <img class="w-[100%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white md:block">
                <h1 class="font-normal text-[18px] md:text-[25px]">Badan Pusat Statistik</h1>
                <p class="font-light text-[15px] md:text-[20px]">Provinsi Riau</p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between gap-5">
            <div class="flex items-end text-white">
                <p class="lg:w-[50%] font-light">
                    Badan Pusat Statistik Provinsi Riau (Statistics of Riau Province)
                    Jl. Pattimura No. 12 Pekanbaru - Riau, Indonesia,
                    <br>
                    Telp (62-761) 23042
                    <br>
                    Faks (62-761) 21336
                    <br>
                    Mailbox: riau@bps.go.id
                </p>
            </div>
            <div class="w-[50%] h-fit bg-white rounded-lg">
                <img src="{{ asset('assets/cover.webp') }}" alt="Berakhlak logo image">
            </div>
        </div>
        <span class="w-full border-b border-white"></span>
        <div class="flex flex-col-reverse md:flex-row gap-3 items-center justify-between">
            <div class="text-white font-light">
                <h1>Hak Cipta © 2024 Badan Pusat Statistik</h1>
            </div>
            <div class="flex gap-5 text-white">
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
                <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>