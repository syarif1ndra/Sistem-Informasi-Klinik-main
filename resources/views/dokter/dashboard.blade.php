@extends('layouts.dokter')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Dokter</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Total Pasien Ditangani -->
        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-pink-500 transform hover:scale-105 transition duration-300">
            <div class="p-4 rounded-full bg-pink-100 text-pink-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Pasien Ditangani</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalHandledPatients }}</p>
            </div>
        </div>

        <!-- Pendapatan Pribadi -->
        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-rose-500 transform hover:scale-105 transition duration-300">
            <div class="p-4 rounded-full bg-rose-100 text-rose-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Pendapatan Pribadi</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($personalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Today's Patient Queue Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">Daftar Antrian Hari Ini</h3>
            <span
                class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody id="dokter-queue-table-body" class="bg-white divide-y divide-gray-200">
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