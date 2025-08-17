<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Pengembang - BPS Provinsi Riau</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-overlay {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(59, 130, 246, 0.8) 50%, rgba(147, 197, 253, 0.7) 100%);
        }
        
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover-effect:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .profile-glow {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }
        
        .profile-glow-orange {
            box-shadow: 0 0 30px rgba(249, 115, 22, 0.3);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .skill-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .skill-badge-orange {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(251, 146, 60, 0.1));
            border: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .social-icon {
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-2px);
            color: #3b82f6 !important;
        }
        
        .social-icon-orange:hover {
            color: #f97316 !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <section class="relative min-h-screen flex items-center justify-center gradient-overlay">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-blue-500"></div>
        <div class="relative z-10 text-center text-white px-6 max-w-6xl">
            <div class="flex flex-col items-center mb-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-bar text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl md:text-3xl font-bold">Badan Pusat Statistik</h1>
                        <p class="text-xl opacity-90">Provinsi Riau</p>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-full px-8 py-3 border border-white/20">
                    <p class="text-lg font-light">Website hasil kolaborasi BPS dan Mahasiswa Teknik Informatika Universitas Riau</p>
                </div>
            </div>
            
            <h2 class="text-4xl md:text-6xl font-bold mb-6 floating-animation">Tim Pengembang</h2>
            <p class="text-xl md:text-2xl opacity-90 mb-12 max-w-3xl mx-auto">
                Mengenal sosok di balik pengembangan sistem informasi magang BPS Provinsi Riau
            </p>
            
            <div class="flex justify-center">
                <button onclick="scrollToTeam()" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
                    Lihat Tim Developer
                    <i class="fas fa-arrow-down ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team-section" class="py-20 px-4 md:px-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gradient mb-6">Tim Developer</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Mahasiswa Teknik Informatika Universitas Riau yang berkontribusi dalam pengembangan Sistem Informasi Magang BPS Provinsi Riau
                </p>
            </div>

            <!-- Developer Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                <!-- Developer 1 -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden card-hover-effect">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 opacity-10"></div>
                        <div class="relative p-8">
                            <!-- Profile Section -->
                            <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                                <div class="relative">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center profile-glow overflow-hidden">
                                        <img src="{{ asset('storage/tim-pengembang/Fajar.jpg') }}" 
                                             alt="Fajar Rahmar" 
                                             class="w-full h-full object-cover">
                                    </div>                                    
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                        <i class="fas fa-code text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="text-center md:text-left flex-1">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Fajar Rahmar</h3>
                                    <p class="text-blue-600 font-semibold mb-2">NIM: 2107112738                                    </p>
                                    <p class="text-gray-600">Teknik Informatika - Universitas Riau</p>
                                </div>
                            </div>

                            <!-- Role & Responsibility -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-briefcase text-blue-600 mr-2"></i>
                                    Peran & Tanggung Jawab
                                </h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Fullstack Developer untuk Aplikasi Sistem Pengelolaan Magang (SIMAGANG) di Badan Pusat Statistik Provinsi Riau
                                </p>
                            </div>

                            <!-- Skills -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-code text-blue-600 mr-2"></i>
                                    Keahlian Teknis
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-blue-700">Laravel</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-blue-700">HTML/CSS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-blue-700">ReactJS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-blue-700">Tailwind CSS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-blue-700">MySQL</span>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="flex gap-4 justify-center md:justify-start">
                                <a href="http://linkedin.com/in/fajar-rahmat" class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://github.com/fajarrahmaat27" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="mailto:fajarrahmat934@gmail.com" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="https://wa.me/6282385162404" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Developer 2 -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden card-hover-effect">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-600 opacity-10"></div>
                        <div class="relative p-8">
                            <!-- Profile Section -->
                            <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                                <div class="relative">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center profile-glow overflow-hidden">
                                        <img src="{{ asset('storage/tim-pengembang/salman.jpg') }}" 
                                             alt="Salman" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-500 rounded-full border-4 border-white flex items-center justify-center">
                                        <i class="fas fa-code text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="text-center md:text-left flex-1">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Salman Al Haritsi</h3>
                                    <p class="text-green-600 font-semibold mb-2">NIM: 2107135422</p>
                                    <p class="text-gray-600">Teknik Informatika - Universitas Riau</p>
                                </div>
                            </div>

                            <!-- Role & Responsibility -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-briefcase text-green-600 mr-2"></i>
                                    Peran & Tanggung Jawab
                                </h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Fullstack Developer untuk Aplikasi Sistem Pengelolaan Magang (SIMAGANG) di Badan Pusat Statistik Provinsi Riau
                                </p>
                            </div>

                            <!-- Skills -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-code text-green-600 mr-2"></i>
                                    Keahlian Teknis
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">NextJS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">Laravel</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">Livewire</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">ReactJS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">Tailwind CSS</span>
                                    <span class="skill-badge px-3 py-1 rounded-full text-sm font-medium text-green-700">MySQL</span>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="flex gap-4 justify-center md:justify-start">
                                <a href="http://linkedin.com/in/salmanalharitsi" class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://github.com/salmanharitsi" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="mailto:salmanalharitsi14@gmail.com" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="https://wa.me/6282214978008" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Developer 3 -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden card-hover-effect lg:col-span-2 lg:max-w-2xl lg:mx-auto">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-orange-600 opacity-10"></div>
                        <div class="relative p-8">
                            <!-- Profile Section -->
                            <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                                <div class="relative">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center profile-glow overflow-hidden">
                                        <img src="{{ asset('storage/tim-pengembang/ranto.png') }}" 
                                             alt="Ranto" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-purple-500 rounded-full border-4 border-white flex items-center justify-center">
                                        <i class="fas fa-code text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="text-center md:text-left flex-1">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Ranto Anjasmara Marpaung</h3>
                                    <p class="text-orange-600 font-semibold mb-2">NIM: 2107113602</p>
                                    <p class="text-gray-600">Teknik Informatika - Universitas Riau</p>
                                </div>
                            </div>

                            <!-- Role & Responsibility -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-briefcase text-orange-600 mr-2"></i>
                                    Peran & Tanggung Jawab
                                </h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Fullstack Developer untuk Aplikasi Sistem Pengelolaan Magang (SIMAGANG) di Badan Pusat Statistik Provinsi Riau
                                </p>
                            </div>

                            <!-- Skills -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-code text-orange-600 mr-2"></i>
                                    Keahlian Teknis
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">Laravel</span>
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">ReactJS</span>
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">HTML/CSS</span>
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">Tailwind CSS</span>
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">MySQL</span>
                                    <span class="skill-badge-orange px-3 py-1 rounded-full text-sm font-medium text-orange-700">Livewire</span>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="flex gap-4 justify-center md:justify-start">
                                <a href="http://linkedin.com/in/ranto-anjasmara-marpaung" class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://github.com/RantoAnjasmaraMarpaung10" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="mailto:rantoanjasmaramarpaung@gmail.com" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="https://wa.me/6285211203802" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white social-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Information -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-500 rounded-3xl p-8 md:p-12 text-white mb-16">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-3xl font-bold mb-4">Tentang Proyek</h3>
                        <p class="text-blue-100 mb-6 leading-relaxed">
                            Sistem Informasi Magang BPS Provinsi Riau (SIMAGANG) dikembangkan sebagai bagian dari program 
                            kolaborasi antara BPS dan mahasiswa Teknik Informatika Universitas Riau. Sistem ini bertujuan 
                            untuk mempermudah proses pendaftaran, seleksi, dan pengelolaan program magang.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                                <span class="text-sm font-medium">Laravel Framework</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                                <span class="text-sm font-medium">Responsive Design</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                                <span class="text-sm font-medium">Modern UI/UX</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="w-32 h-32 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 floating-animation">
                            <i class="fas fa-handshake text-5xl text-white"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Kolaborasi Sukses</h4>
                        <p class="text-blue-100 text-sm">BPS × Universitas Riau</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto">
                    <div class="flex items-center justify-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-gray-800">BPS Provinsi Riau</h4>
                            <p class="text-gray-600 text-sm">Statistics of Riau Province</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">
                        Jl. Pattimura No. 12 Pekanbaru - Riau, Indonesia<br>
                        Telp (62-761) 23042 | Faks (62-761) 21336<br>
                        Email: riau@bps.go.id
                    </p>
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500">
                            Hak Cipta © 2024 Badan Pusat Statistik - 
                            <span class="font-medium text-blue-600">Website hasil kolaborasi BPS dan Mahasiswa Teknik Informatika Universitas Riau</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function scrollToTeam() {
            document.getElementById('team-section').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.card-hover-effect').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>
