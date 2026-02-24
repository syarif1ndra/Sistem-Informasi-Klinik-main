@extends('layouts.owner')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Owner</h1>
            <p class="text-gray-500 mt-1">Ringkasan performa klinik hari ini</p>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- 1. Pasien Hari ini -->
            <div
                class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div
                    class="absolute -right-6 -top-6 w-32 h-32 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex justify-between items-start relative z-10">
                    <div class="flex flex-col">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Pasien Hari Ini</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-gray-900">{{ $totalPasienHariIni }}</h3>
                            <span class="text-sm text-gray-400 font-medium">pasien</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <span
                                class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-lg text-xs font-bold">{{ $totalKunjunganBulanIni }}</span>
                            <span class="text-xs text-gray-500 font-medium">Kunjungan Bulan Ini</span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-blue-500 to-indigo-600 p-4 rounded-2xl shadow-lg shadow-blue-200 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. Pendapatan Hari ini -->
            <div
                class="bg-gradient-to-br from-pink-500 via-rose-500 to-orange-400 rounded-3xl shadow-[0_8px_30px_rgb(236,72,153,0.3)] p-6 text-white transform hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                <div
                    class="absolute -right-10 -bottom-10 w-40 h-40 bg-white opacity-10 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div
                    class="absolute -left-10 -top-10 w-32 h-32 bg-white opacity-10 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex justify-between items-start relative z-10 h-full">
                    <div class="flex flex-col h-full justify-between">
                        <p class="text-sm font-semibold text-pink-50 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p>
                        <h3 class="text-4xl font-black mb-4">Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                        </h3>
                        <div
                            class="mt-auto flex items-center gap-2 bg-white/20 backdrop-blur-sm w-max px-3 py-1.5 rounded-xl border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span class="text-xs text-pink-50 font-semibold tracking-wide">Rp
                                {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }} Bulan Ini</span>
                        </div>
                    </div>
                    <div
                        class="bg-white/20 backdrop-blur-md border border-white/30 p-4 rounded-2xl shadow-lg shadow-black/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 3. Total Transaksi Terfilter -->
            <div
                class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div
                    class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex justify-between items-start relative z-10">
                    <div class="flex flex-col">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Transaksi</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-gray-900">{{ $totalTransaksi }}</h3>
                            <span class="text-sm text-gray-400 font-medium">trx</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <span
                                class="bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                
                            </span>
                            <span class="text-xs text-gray-500 font-medium"></span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-emerald-400 to-teal-500 p-4 rounded-2xl shadow-lg shadow-emerald-200 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tren Pendapatan (12 Bulan)</h3>
                <div class="h-72">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <!-- Patient Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Kunjungan Pasien (7 Hari)</h3>
                <div class="h-72">
                    <canvas id="patientChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Top Dokter -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="flex flex-col mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-pink-50 rounded-xl text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-md font-bold text-gray-900 tracking-tight">Staf Medis Teratas</h3>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 pl-12">Berdasarkan kontribusi pasien terbanyak</p>
                </div>
                
                <div class="space-y-4">
                    @forelse($topStaff as $staff)
                        <div class="flex justify-between items-center group p-3 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-pink-700 font-bold text-sm shadow-sm">
                                    {{ substr($staff->staff_name, 0, 2) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 group-hover:text-pink-600 transition truncate max-w-[120px]">
                                        {{ $staff->staff_name }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-400">{{ $staff->total }} pasien ditangani</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 text-xs font-bold rounded-xl whitespace-nowrap shadow-sm border border-emerald-100">
                                Rp {{ number_format($staff->revenue, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="p-3 bg-gray-50 rounded-full mb-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada data staf</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Services -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="flex flex-col mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-md font-bold text-gray-900 tracking-tight">Layanan Teratas</h3>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 pl-12">Berdasarkan frekuensi penggunaan</p>
                </div>
                
                <div class="space-y-4">
                    @forelse($topServices as $service)
                        <div class="flex justify-between items-center group p-3 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-700 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition truncate max-w-[140px]">
                                    {{ $service->name }}
                                </span>
                            </div>
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 text-xs font-bold rounded-xl whitespace-nowrap shadow-sm border border-blue-100">
                                {{ $service->total }}&times;
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="p-3 bg-gray-50 rounded-full mb-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada data layanan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Medicines -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="flex flex-col mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-md font-bold text-gray-900 tracking-tight">Obat Terlaris</h3>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 pl-12">Berdasarkan total quantity terjual</p>
                </div>
                
                <div class="space-y-4">
                    @forelse($topMedicines as $medicine)
                        <div class="flex justify-between items-center group p-3 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-700 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-gray-800 group-hover:text-emerald-600 transition truncate max-w-[140px]">
                                    {{ $medicine->name }}
                                </span>
                            </div>
                            <span class="px-3 py-1 bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 text-xs font-bold rounded-xl whitespace-nowrap shadow-sm border border-emerald-100">
                                {{ $medicine->total }} pcs
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="p-3 bg-gray-50 rounded-full mb-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada data obat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Alert Sections -->
        <div class="mb-8">
            <!-- Low Stock -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-orange-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1 h-full bg-orange-400"></div>
                <div class="bg-gradient-to-r from-orange-50 to-white px-6 py-4 border-b border-orange-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-md font-bold text-orange-900 tracking-tight">Peringatan: Stok Obat Menipis (&le; 10)</h3>
                    </div>
                </div>
                <div class="p-0 max-h-60 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($lowStockMedicines as $med)
                                <tr class="hover:bg-orange-50/30 transition-colors">
                                    <td class="px-6 py-3 text-sm text-gray-900 font-medium">{{ $med->name }}</td>
                                    <td class="px-6 py-3 text-sm text-right font-black {{ $med->stock == 0 ? 'text-red-500' : 'text-orange-500' }}">
                                        {{ $med->stock }} <span class="text-xs font-normal text-gray-400">pcs</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-sm text-center text-gray-400 font-medium">Stok obat aman terkendali.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Transactions List -->
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">10 Transaksi Terbaru</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Trx ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($latestTransactions as $trx)
                            <tr class="hover:bg-blue-50/30 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">#{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $trx->patient->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($trx->payment_method == 'bpjs')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl bg-blue-50 text-blue-700 border border-blue-100">BPJS</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl bg-gray-50 text-gray-700 border border-gray-200">TUNAI</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-right text-gray-900">
                                    Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($trx->status == 'paid')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm">Lunas</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl bg-orange-50 text-orange-700 border border-orange-100 shadow-sm">Belum Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 font-medium">
                                    Belum ada transaksi di klinik ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const gradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(236, 72, 153, 0.5)'); // pink-500
            gradient.addColorStop(1, 'rgba(236, 72, 153, 0.0)');

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsPendapatan) !!},
                    datasets: [{
                        label: 'Pendapatan',
                        data: {!! json_encode($dataPendapatan) !!},
                        borderColor: '#db2777', // pink-600
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#db2777',
                        pointHoverBackgroundColor: '#db2777',
                        pointHoverBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let value = context.parsed.y;
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f3f4f6' },
                            ticks: {
                                callback: function (value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'M';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + 'K';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            const patientCtx = document.getElementById('patientChart').getContext('2d');
            new Chart(patientCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelsPasien) !!},
                    datasets: [{
                        label: 'Kunjungan',
                        data: {!! json_encode($dataPasien) !!},
                        backgroundColor: '#3b82f6', // blue-500
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f3f4f6' },
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endsection