@extends('layouts.dokter')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Dokter</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Total Pasien Ditangani -->
        <div
            class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
            <!-- Decorative Background -->
            <div
                class="absolute -right-10 -top-10 w-32 h-32 bg-pink-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
            </div>

            <div class="flex items-center gap-5 relative z-10">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-bold tracking-wide uppercase mb-1">Total Pasien Ditangani</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $totalHandledPatients }}</p>
                        <span class="text-sm font-medium text-gray-400">pasien</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Pribadi -->
        <div
            class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 border border-gray-50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
            <!-- Decorative Background -->
            <div
                class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
            </div>

            <div class="flex items-center gap-5 relative z-10">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-bold tracking-wide uppercase mb-1">Total Pendapatan Pribadi</p>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">Rp
                        {{ number_format($personalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Patient Queue Table -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-gray-50">
        <div
            class="bg-gradient-to-r from-pink-50 to-white px-6 py-5 border-b border-pink-100 flex justify-between items-center relative">
            <div class="absolute top-0 left-0 w-1 h-full bg-pink-500"></div>
            <div class="flex items-center gap-3">
                <div class="p-2 bg-pink-100 rounded-lg text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Antrian</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Antrian
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Pasien
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody id="dokter-queue-table-body" class="bg-white divide-y divide-gray-50">
                    @include('dokter.queues.partials.table', ['queues' => $recentQueues])
                </tbody>
            </table>
        </div>
@endsection

    @section('scripts')
        <script>
            // Polling functionality for realtime updates (similar to admin.queues)
            function fetchQueueTableData() {
                fetch('{{ route("dokter.queues.tableData") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('dokter-queue-table-body').innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching realtime queue data:', error));
            }

            // Poll every 5 seconds
            setInterval(fetchQueueTableData, 5000);
        </script>
    @endsection