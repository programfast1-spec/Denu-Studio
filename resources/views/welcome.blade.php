<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-title" content="DENU" />
    <title>DENU STUDIO</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('web-app-manifest-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web-app-manifest-192x192.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tilt.js -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            color: #193318ff;
        }

        .animated-bg {
            background: linear-gradient(135deg, #f8fafc, #eef2ff, #e0f2fe);
            background-size: 600% 600%;
            animation: gradientShift 25s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-deep {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .neon-glow {
            color: #1e412cff;
            text-shadow: 0 1px 1px rgba(11, 39, 17, 0.04);
        }

        .feature-tilt:hover {
            box-shadow: 0 10px 20px rgba(19, 48, 20, 0.15);
        }
    </style>
</head>
<body class="antialiased animated-bg">
    <div class="min-h-screen flex flex-col items-center justify-center relative">

        {{-- Tombol Login/Register --}}
        <div class="absolute top-0 right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition">Log in</a>
            @endauth
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-12 w-full">
            {{-- Header --}}
            <header class="text-center mb-20">
                <h1 class="text-5xl md:text-7xl font-extrabold neon-glow tracking-tight mb-4">SELAMAT DATANG</h1>
                <p class="text-xl font-medium text-green-600">DENU STUDIO</p>
            </header>

            {{-- Tentang --}}
            <section class="glass-deep rounded-3xl p-10 text-center max-w-5xl mx-auto mb-20">
                <h2 class="text-3xl font-bold text-black-700 mb-4">Hello!!</h2>
                <p class="text-gray-900 leading-relaxed text-base">
                    Aplikasi ini adalah <strong class="text-black-800">Project SIMPEG ( Sistem Informasi Kepegawaian )</strong>  dilengkapi fitur-fitur seperti Autentikasi, Absensi GPS + QR Code, Slip Gaji PDF.
                </p>
            </section>

            {{-- Fitur --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $features = [
                        ['icon' => 'heroicon-o-qr-code', 'title' => 'Absensi QR & GPS', 'desc' => 'Validasi lokasi realtime & QR unik harian.'],
                        ['icon' => 'heroicon-o-clock', 'title' => 'Manajemen Lembur', 'desc' => 'Flow approval lembur antar divisi.'],
                        ['icon' => 'heroicon-o-document-text', 'title' => 'Cuti & Izin Online', 'desc' => 'Pengajuan izin + upload bukti otomatis.'],
                        ['icon' => 'heroicon-o-currency-dollar', 'title' => 'Slip Gaji PDF', 'desc' => 'Auto generate slip gaji digital format PDF.'],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div data-tilt data-tilt-max="15" data-tilt-glare="true" data-tilt-max-glare="0.15"
                         class="glass-deep p-6 rounded-2xl text-center transform transition duration-300 hover:scale-[1.03] feature-tilt">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-indigo-100 flex items-center justify-center">
                            <x-dynamic-component :component="$feature['icon']" class="w-8 h-8 text-indigo-600"/>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-gray-900 mt-2">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Footer --}}
            <footer class="mt-24 text-center text-sm text-gray-900">
                <p>Dibuat oleh <span class="text-pink-500">❤️</span> oleh 
                    <a href="#" target="_blank" class="text-red-600 font-semibold hover:underline">Muhamad Insan</a>
                </p>
                <p class="mt-1"></p>
            </footer>
        </div>
    </div>

    <script>
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15,
            speed: 600,
            glare: true,
            "max-glare": 0.15
        });
    </script>
</body>
</html>
