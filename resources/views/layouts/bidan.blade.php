<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bidan - Sistem Informasi Klinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                            900: '#831843',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden"></div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 text-white overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 lg:block flex flex-col shadow-xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <span class="text-2xl font-bold tracking-wider text-pink-500">Bidan Siti Hajar</span>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 mt-6 px-4 space-y-2 overflow-y-auto">
                {{-- DASHBOARD BIDAN --}}
                <a href="{{ route('bidan.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('bidan.dashboard') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Dashboard Bidan</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Akses Bidan</p>
                </div>

                {{-- ANTRIAN --}}
                <a href="{{ route('bidan.queues.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('bidan.queues*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span class="font-medium">Antrian</span>
                </a>

                {{-- IMUNISASI --}}
                <a href="{{ route('admin.immunizations.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.immunizations*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    <span class="font-medium">Imunisasi</span>
                </a>

                {{-- KELAHIRAN --}}
                <a href="{{ route('admin.birth_records.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.birth_records*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    <span class="font-medium">Kelahiran</span>
                </a>

                {{-- TRANSAKSI --}}
                <a href="{{ route('bidan.transactions.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('bidan.transactions*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Transaksi</span>
                </a>

                {{-- PASIEN SAYA --}}
                <a href="{{ route('bidan.patients.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('bidan.patients*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Pasien </span>
                </a>

                {{-- LAPORAN KEUANGAN --}}
                <a href="{{ route('bidan.reports.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('bidan.reports*') ? 'bg-pink-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Laporan Keuangan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Bidan' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-xs text-gray-400 hover:text-white transition duration-150">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b lg:hidden">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none focus:text-gray-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <span class="ml-4 text-lg font-semibold text-gray-900">Dashboard Bidan</span>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Toast Notifications -->
                <div x-data="{
                    show: false,
                    message: '',
                    type: 'success',
                    init() {
                        @if(session('success'))
                            this.showToast('{{ session('success') }}', 'success');
                        @endif
                        @if(session('error'))
                            this.showToast('{{ session('error') }}', 'error');
                        @endif
                    },
                    showToast(msg, toastType) {
                        this.message = msg;
                        this.type = toastType;
                        this.show = true;
                        setTimeout(() => { this.show = false }, 5000);
                    }
                }" @show-toast.window="showToast($event.detail.message, $event.detail.type)" x-show="show"
                    x-transition:enter="transform ease-out duration-300 transition"
                    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed top-4 right-4 z-50 max-w-md w-full"
                    style="display: none;">
                    <div :class="{
                        'bg-gradient-to-r from-green-500 to-emerald-600': type === 'success',
                        'bg-gradient-to-r from-red-500 to-pink-600': type === 'error',
                        'bg-gradient-to-r from-blue-500 to-indigo-600': type === 'info',
                        'bg-gradient-to-r from-yellow-500 to-orange-600': type === 'warning'
                    }" class="rounded-xl shadow-2xl p-4 flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg x-show="type === 'success'" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <svg x-show="type === 'error'" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <svg x-show="type === 'info'" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg x-show="type === 'warning'" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 pt-0.5">
                            <p class="text-sm font-bold text-white"
                                x-text="type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : type === 'warning' ? 'Peringatan!' : 'Informasi'">
                            </p>
                            <p class="mt-1 text-sm text-white/90" x-text="message"></p>
                        </div>

                        <button @click="show = false" class="flex-shrink-0 text-white/80 hover:text-white transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Optional but good to keep if they delete records) -->
    <!-- (Omitted for brevity, assume similar layout structure) -->

    @yield('scripts')
    @stack('scripts')
</body>

</html>