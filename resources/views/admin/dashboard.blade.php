@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
 

  
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
                <p class="text-gray-500 text-sm font-semibold">Total Pasien</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_patients'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-rose-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-rose-100 text-rose-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Antrian Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['today_queues'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-purple-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Transaksi Belum Bayar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_transactions'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-fuchsia-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-fuchsia-100 text-fuchsia-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Obat Stok Menipis</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['low_stock_medicines'] }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Monthly Income Chart -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-blue-500">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pendapatan Klinik per Bulan</h3>
            <canvas id="monthlyIncomeChart"></canvas>
        </div>

        <!-- Patient Trend Chart -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-purple-500">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Jumlah Pasien 7 Hari Terakhir</h3>
            <canvas id="patientTrendChart"></canvas>
        </div>
    </div>

    <!-- Recent Queues Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Antrian Terbaru Hari Ini</h3>
            <a href="{{ route('admin.queues.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentQueues as $queue)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="text-lg font-bold text-gray-900">{{ sprintf('%03d', $queue->queue_number) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $queue->patient->name ?? ($queue->userPatient->name ?? '-') }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $queue->patient->nik ?? ($queue->userPatient->nik ?? '-') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->service_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $queue->status == 'waiting' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $queue->status == 'calling' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $queue->status == 'finished' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $queue->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($queue->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada antrian hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Monthly Income Chart
        const incomeCtx = document.getElementById('monthlyIncomeChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyIncome['labels']) !!},
                datasets: [
                    {
                        label: 'Total Pendapatan',
                        data: {!! json_encode($monthlyIncome['data']) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // 2. Patient Trend Chart (Line)
        const trendCtx = document.getElementById('patientTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($patientTrend['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: {!! json_encode($patientTrend['data']) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    tension: 0.4, // Smooth curve
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection