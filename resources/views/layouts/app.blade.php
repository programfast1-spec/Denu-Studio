<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DENU STUDIO</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('web-app-manifest-512x512.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web-app-manifest-192x192.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: window.innerWidth > 768 }" @resize.window="sidebarOpen = window.innerWidth > 768" class="flex h-screen bg-green-900">
            
            {{-- ================= Sidebar ================= --}}
            <aside 
                class="fixed inset-y-0 left-0 z-40 w-64 bg-green-900 text-gray-300 transform transition-transform duration-300 ease-in-out"
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            >
                <div class="flex items-center justify-center h-20 border-b border-green-900">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-white px-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="h-10 w-10 rounded-full object-cover">
                        <span class="font-bold text-xl">DENU</span>
                    </a>
                </div>
                
                <nav class="flex-1 px-4 py-4 space-y-2">
                    {{-- Menu umum --}}
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('*.dashboard')">
                        <x-heroicon-s-home class="w-6 h-6 mr-3" />
                        <span>Dashboard</span>
                    </x-sidebar-link>

                    {{-- Menu Karyawan --}}
                    @if(auth()->user()->isKaryawan())
                        <x-sidebar-link :href="route('karyawan.overtime.index')" :active="request()->routeIs('karyawan.overtime.*')">
                             <x-heroicon-s-clock class="w-6 h-6 mr-3" />
                            <span>Lembur</span>
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('karyawan.leaves.index')" :active="request()->routeIs('karyawan.leaves.*')">
                             <x-heroicon-s-document-text class="w-6 h-6 mr-3" />
                            <span>Cuti & Izin</span>
                        </x-sidebar-link>
                    @endif
                    
                    {{-- Menu Atasan --}}
                    @if(auth()->user()->isAtasan())
                        <p class="px-4 pt-4 font-semibold text-gray-400 text-xs uppercase">Persetujuan</p>
                        <x-sidebar-link :href="route('atasan.overtime.index')" :active="request()->routeIs('atasan.overtime.*')">
                            <x-heroicon-s-clock class="w-6 h-6 mr-3" />
                            <span>Persetujuan Lembur</span>
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('atasan.leaves.index')" :active="request()->routeIs('atasan.leaves.*')">
                             <x-heroicon-s-document-text class="w-6 h-6 mr-3" />
                            <span>Persetujuan Cuti</span>
                        </x-sidebar-link>
                    @endif

                    {{-- Menu Laporan + Admin --}}
                    @if(auth()->user()->isAtasan() || auth()->user()->isAdmin())
                        <p class="px-4 pt-4 font-semibold text-green-50 text-xs uppercase">Manajemen</p>
                        <x-sidebar-link :href="route('laporan.absensi.index')" :active="request()->routeIs('laporan.absensi.*')">
                            <x-heroicon-s-chart-bar class="w-6 h-6 mr-3" />
                            <span>Laporan Absensi</span>
                        </x-sidebar-link>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <x-sidebar-link :href="route('admin.payroll.index')" :active="request()->routeIs('admin.payroll.*')">
                            <x-heroicon-s-currency-dollar class="w-6 h-6 mr-3" />
                            <span>Penggajian</span>
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <x-heroicon-s-users class="w-6 h-6 mr-3" />
                            <span>Manajemen Karyawan</span>
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                            <x-heroicon-s-shield-check class="w-6 h-6 mr-3" />
                            <span>Audit Log</span>
                        </x-sidebar-link>
                        <p class="px-4 pt-4 font-semibold text-green-50 text-xs uppercase">Sistem</p>
                        <x-sidebar-link :href="route('admin.qrcode.show')" :active="request()->routeIs('admin.qrcode.*')">
                            <x-heroicon-s-qr-code class="w-6 h-6 mr-3" />
                            <span>QR Code Absensi</span>
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                            <x-heroicon-s-cog-6-tooth class="w-6 h-6 mr-3" />
                            <span>Pengaturan</span>
                        </x-sidebar-link>
                    @endif
                </nav>
            </aside>

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-50 z-30 md:hidden"></div>

            {{-- ================= Content ================= --}}
            <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out" :class="{'md:ml-64': sidebarOpen}">
                <header class="flex justify-between items-center p-4 bg-white border-b z-20">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-green-900 focus:outline-none">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        
                        <div class="font-semibold text-xl text-green-400 leading-tight ml-4">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-900 bg-white hover:text-green-500 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Logout dengan konfirmasi -->
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="#" id="logout-btn">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')

        <script>
            document.getElementById("logout-btn").addEventListener("click", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin mau logout?',
                    text: "Anda akan keluar dari sistem.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("logout-form").submit();
                    }
                });
            });
        </script>
    </body>
</html>
