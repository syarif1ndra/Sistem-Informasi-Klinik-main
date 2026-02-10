<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Klinik Bidan') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-pink-500 via-pink-600 to-rose-600 flex-col justify-between p-12">
            <div>
                <div class="text-4xl font-bold text-white mb-2">🏥 Klinik Bidan</div>
                <p class="text-pink-100 text-lg">Pelayanan Kesehatan Ibu dan Anak Terpercaya</p>
            </div>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-20">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Profesional Berpengalaman</p>
                        <p class="text-pink-100 text-sm">Tim bidan terlatih dan bersertifikat</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-20">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Harga Terjangkau</p>
                        <p class="text-pink-100 text-sm">Layanan berkualitas dengan harga kompetitif</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-20">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Fasilitas Lengkap</p>
                        <p class="text-pink-100 text-sm">Peralatan medis modern dan standar internasional</p>
                    </div>
                </div>
            </div>
            <div class="text-pink-100 text-sm">
                <p>&copy; {{ date('Y') }} Klinik Bidan. Semua hak dilindungi.</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Header -->
                <div class="lg:hidden text-center mb-8">
                    <div class="text-3xl font-bold text-pink-600 mb-2">🏥 Klinik Bidan</div>
                    <p class="text-gray-600">Pelayanan Kesehatan Ibu dan Anak</p>
                </div>

                {{ $slot }}

                <!-- Back to Home Link -->
                <div class="text-center mt-6">
                    <a href="/" class="text-gray-600 hover:text-pink-600 text-sm font-medium transition">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
