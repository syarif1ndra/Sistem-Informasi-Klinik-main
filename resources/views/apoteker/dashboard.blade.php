@extends('layouts.apoteker')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Apoteker</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas dan stok apotek hari ini</p>
            </div>
        </div>

        <!-- Stats Matrix -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Resep Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['prescriptions_today'] }}</p>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300 relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 w-16 h-16 bg-gradient-to-br from-orange-400/20 to-pink-500/20 rounded-bl-full pointer-events-none">
                </div>
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl relative z-10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-sm font-medium text-gray-500">Menunggu Proses</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['prescriptions_waiting'] }}</p>
                        @if($stats['prescriptions_waiting'] > 0)
                            <span class="flex h-3 w-3 relative">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Siap Diambil</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['prescriptions_ready'] }}</p>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Obat Keluar (Hari Ini)</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($stats['medicines_dispensed_today'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Alert: Low Stock -->
        @if(count($lowStockMedicines) > 0)
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 flex items-center gap-3 border-b border-red-100">
                        <div class="p-2 bg-white rounded-lg shadow-sm text-red-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-red-900 tracking-tight">Peringatan: Stok Tipis</h2>
                            <p class="text-sm text-red-700">Terdapat {{ count($lowStockMedicines) }} obat yang harus segera
                                direkomendasikan stok.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Nama Obat</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Kategori</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Stok Saat Ini</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Minimal Stok</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($lowStockMedicines as $medicine)
                                    <tr class="hover:bg-red-50/50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $medicine->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $medicine->category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1 px-3 rounded-md text-sm font-bold {{ $medicine->stock === 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                                {{ $medicine->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 font-medium">
                                            {{ $medicine->min_stock }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('apoteker.medicines.index') }}"
                                                class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded transition">
                                                Tambah Stok
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('apoteker.prescriptions.index', ['status' => 'menunggu']) }}"
                class="group block bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-md p-6 overflow-hidden relative">
                <div
                    class="absolute right-0 top-0 -mr-8 -mt-8 opacity-20 transform group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Proses Resep Antrian</h3>
                        <p class="text-pink-100 text-sm">Lihat daftar resep yang siap diproses.</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full text-white backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('apoteker.reports.index') }}"
                class="group block bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-md p-6 overflow-hidden relative">
                <div
                    class="absolute right-0 top-0 -mr-8 -mt-8 opacity-20 transform group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Laporan & Evaluasi</h3>
                        <p class="text-indigo-100 text-sm">Lihat rekapitulasi pengeluaran dan pemasukan obat.</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full text-white backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection