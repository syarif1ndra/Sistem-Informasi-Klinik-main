@extends('layouts.bidan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Bidan</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-pink-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-pink-100 text-pink-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Pasien Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPatientsToday }}</p>
            </div>
        </div>

        <div class="bg-indigo-50 rounded-lg p-6 border border-indigo-100 flex items-center justify-center">
            <div class="text-center">
                <p class="text-indigo-600 font-semibold mb-1">Tanggal</p>
                <p class="text-2xl font-bold text-indigo-900">
                    {{ \Carbon\Carbon::parse($today)->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Kehamilan -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-rose-400">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pemeriksaan Kehamilan (12 Bln)</h3>
            <canvas id="pregnancyChart"></canvas>
        </div>

        <!-- Imunisasi -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-blue-400">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Imunisasi Bayi (12 Bln)</h3>
            <canvas id="immunizationChart"></canvas>
        </div>

        <!-- Persalinan -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-emerald-400">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Persalinan (12 Bln)</h3>
            <canvas id="birthChart"></canvas>
        </div>
    </div>

    <!-- Today's Patient Queue Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">Daftar Antrian Hari Ini</h3>
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
            <tbody id="bidan-queue-table-body" class="bg-white divide-y divide-gray-200">
                @include('bidan.partials.queue_table')
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Common Chart Options
        const commonOptions = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Hide legend to save space
                }
            }
        };

        // 1. Pregnancy Chart
        new Chart(document.getElementById('pregnancyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($pregnancyChart['labels']) !!},
                datasets: [{
                    label: 'Pemeriksaan Kehamilan',
                    data: {!! json_encode($pregnancyChart['data']) !!},
                    backgroundColor: 'rgba(251, 113, 133, 0.6)', // rose-400
                    borderColor: 'rgba(225, 29, 72, 1)',
                    borderWidth: 1
                }]
            },
            options: commonOptions
        });

        // 2. Immunization Chart
        new Chart(document.getElementById('immunizationChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($immunizationChart['labels']) !!},
                datasets: [{
                    label: 'Imunisasi Bayi',
                    data: {!! json_encode($immunizationChart['data']) !!},
                    backgroundColor: 'rgba(96, 165, 250, 0.2)', // blue-400
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: commonOptions
        });

        // 3. Birth Chart
        new Chart(document.getElementById('birthChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($birthChart['labels']) !!},
                datasets: [{
                    label: 'Persalinan',
                    data: {!! json_encode($birthChart['data']) !!},
                    backgroundColor: 'rgba(52, 211, 153, 0.6)', // emerald-400
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: commonOptions
        });

        // Polling functionality for realtime updates (similar to admin.queues)
        function fetchQueueTableData() {
            fetch('{{ route("bidan.queues.tableData") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('bidan-queue-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching realtime queue data:', error));
        }

        // Poll every 5 seconds
        setInterval(fetchQueueTableData, 5000);
    </script>
@endsection