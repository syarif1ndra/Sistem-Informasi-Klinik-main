<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Klinik Bidan Siti Hajar - Natar Lampung Selatan</title>

    <meta name="description"
        content="Klinik Bidan Siti Hajar menyediakan layanan persalinan 24 jam, cek kehamilan, imunisasi, dan KB di Natar, Lampung Selatan. Profesional dan penuh kasih sayang.">

    <meta name="keywords"
        content="bidan siti hajar, bidan natar, klinik bersalin lampung selatan, persalinan 24 jam, imunisasi anak natar">

    <meta name="author" content="Klinik Bidan Siti Hajar">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Klinik Bidan Siti Hajar - Pelayanan Ibu & Anak Terbaik">
    <meta property="og:description"
        content="Layanan kebidanan profesional 24 jam di Natar, Lampung Selatan. Ambil antrian online sekarang!">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- JSON-LD tunggal dan lengkap untuk SEO Lokal --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalClinic",
      "name": "Klinik Bidan Siti Hajar",
      "alternateName": "Bidan Siti Hajar Natar",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('logo.png') }}",
      "telephone": "+62-812-3456-7890",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jalan Raya, Merak Batin, Natar",
        "addressLocality": "South Lampung",
        "postalCode": "35362",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -5.312345,
        "longitude": 105.123456
      }
    }
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;

        }

        #layanan,
        #obat,
        #faq {
            scroll-margin-top: 5rem;
            .text-gray-400 { color: #a1a1aa !important; }
        }
    </style>
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "MedicalClinic",
        "name": "Klinik Bidan Siti Hajar",
        "telephone": "+6281234567890",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jalan Raya, Merak Batin, Natar",
            "addressLocality": "South Lampung",
            "postalCode": "35362",
            "addressCountry": "ID"
        }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    <!-- Global Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('public.home') }}" class="text-2xl font-bold text-primary-600">
                            Klinik Bidan Siti Hajar
                        </a>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('public.home') }}"
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">Beranda</a>

                    <a href="{{ route('public.home') }}#layanan"
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">Layanan</a>

                    <a href="{{ route('public.home') }}#obat"
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">Obat</a>

                    @auth
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" type="button"
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="h-8 w-8 rounded-full bg-pink-500 flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                                style="display: none;">
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Dashboard Admin</a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Dashboard</a>
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Profile</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-primary-600 text-white hover:bg-primary-700 px-4 py-2 rounded-md text-sm font-medium transition shadow-md">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-600 focus:outline-none"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed. -->
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open. -->
                        <svg x-show="mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                <a href="{{ route('public.home') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50">Beranda</a>

                <a href="{{ route('public.home') }}#layanan" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50">Layanan</a>

                <a href="{{ route('public.home') }}#obat" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50">Obat</a>
                @auth
                    <div class="mt-4 px-3 border-t border-gray-200 pt-4">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-10 w-10 rounded-full bg-pink-500 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Dashboard
                                    Admin</a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="mt-4 px-3">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-4 py-2 rounded-md font-bold text-white bg-primary-600 hover:bg-primary-700">
                            Masuk
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-primary-400">Klinik Bidan<br>Siti Hajar</h2>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Memberikan pelayanan kesehatan terbaik bagi ibu dan anak dengan kasih sayang dan profesionalisme
                        sejak tahun 2010.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" target="_blank" aria-label="Facebook Klinik Bidan Siti Hajar"
                            class="text-gray-400 hover:text-[#1877F2] transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>

                        <a href="#" target="_blank" aria-label="Instagram Klinik Bidan Siti Hajar"
                            class="text-gray-400 hover:text-[#E4405F] transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>

                        <a href="https://wa.me/6282289685085" target="_blank" aria-label="WhatsApp Klinik Bidan Siti Hajar"
                            class="text-gray-400 hover:text-[#25D366] transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 border-b-2 border-primary-500 w-fit">Tautan Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.home') }}"
                                class="text-gray-400 hover:text-white hover:translate-x-2 transform transition inline-block text-sm">Beranda</a>
                        </li>
                        <li><a href="{{ route('public.home') }}#layanan"
                                class="text-gray-400 hover:text-white hover:translate-x-2 transform transition inline-block text-sm">Layanan
                                Kami</a></li>
                        <li><a href="{{ route('public.home') }}#obat"
                                class="text-gray-400 hover:text-white hover:translate-x-2 transform transition inline-block text-sm">Vaksin
                                & Obat</a></li>
                        <li><a href="{{ route('login') }}"
                                class="text-gray-400 hover:text-white hover:translate-x-2 transform transition inline-block text-sm">Ambil
                                Antrian</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 border-b-2 border-primary-500 w-fit">Kontak</h3>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <address class="not-italic text-sm text-gray-400 leading-relaxed">
                                Jalan Raya, Merak Batin, Natar, South Lampung Regency, Lampung 35362
                            </address>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+62 822-8968-5085</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>info@bidansitihajar.com</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gray-800/50 p-6 rounded-xl border border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-white">Jam Operasional</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex justify-between text-gray-400 border-b border-gray-700 pb-2">
                            <span>Senin - Jumat</span>
                            <span class="text-primary-400">08:00 - 20:00</span>
                        </li>
                        <li class="flex justify-between text-gray-400 border-b border-gray-700 pb-2">
                            <span>Sabtu</span>
                            <span class="text-primary-400">08:00 - 15:00</span>
                        </li>
                        <li class="flex justify-between text-gray-300 font-medium">
                            <span>Minggu</span>
                            <span class="text-red-400">Libur / Janji Temu</span>
                        </li>
                    </ul>
                    <p class="mt-4 text-[10px] text-gray-500 italic">*Untuk persalinan darurat, kami siap melayani 24
                        jam.</p>
                </div>

            </div>

            <div
                class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-xs">
                <p>© {{ date('Y') }} Klinik Bidan Siti Hajar. All rights reserved.</p>
                <div class="mt-4 md:mt-0 space-x-6">
                    <a href="#" class="hover:text-primary-400 transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-primary-400 transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
