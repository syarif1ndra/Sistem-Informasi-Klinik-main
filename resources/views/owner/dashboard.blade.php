@extends('layouts.owner')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Owner</h1>
            <p class="text-gray-500 mt-1">Ringkasan performa klinik hari ini</p>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- 1. Pasien Hari ini -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                <div class="flex flex-col">
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Pasien Hari Ini</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $totalPasienHariIni }} <span
                            class="text-sm text-gray-400 font-medium">pasien</span></h3>
                    <p class="text-xs text-gray-400 mt-2 font-medium bg-gray-50 px-2 py-1 rounded inline-block w-max">
                        {{ $totalKunjunganBulanIni }} kunjungan bulan ini</p>
                </div>
            </div>

            <!-- 2. Pendapatan Hari ini -->
            <div
                class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-lg shadow-pink-200 p-6 text-white transform hover:-translate-y-1 transition duration-300">
                <div class="flex flex-col h-full justify-between">
                    <p class="text-sm font-bold text-pink-100 uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
                    <h3 class="text-3xl font-black mb-2">Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</h3>
                    <p class="text-xs text-pink-100 font-medium">Rp
                        {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }} bulan ini</p>
                </div>
            </div>

            <!-- 3. Total Transaksi Terfilter -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                <div class="flex flex-col">
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Total Transaksi</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $totalTransaksi }} <span
                            class="text-sm text-gray-400 font-medium">trx</span></h3>
                    <p class="text-xs text-gray-400 mt-2 font-medium bg-gray-50 px-2 py-1 rounded inline-block w-max">Sesuai
                        filter tanggal</p>
                </div>
            </div>

            <!-- 4. Dokter & Obat -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                <div class="flex flex-col">
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Dokter & Obat</p>
                    <div class="flex justify-between items-end mt-1">
                        <div>
                            <span class="text-2xl font-black text-blue-600">{{ $totalDokterAktif }}</span> <span
                                class="text-xs text-gray-500 font-bold uppercase tracking-wider">Dokter</span>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-emerald-600">{{ $totalObatTerjual }}</span> <span
                                class="text-xs text-gray-500 font-bold uppercase tracking-wider">Obat Terjual</span>
                        </div>
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-md font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    Staf Medis Teratas
                </h3>
                <div class="space-y-3">
                    @forelse($topStaff as $staff)
                        <div class="flex justify-between items-center group">
                            <span
                                class="text-sm font-medium text-gray-700 group-hover:text-pink-600 transition truncate pr-2">{{ $staff->staff_name }}</span>
                            <span
                                class="px-2.5 py-1 bg-pink-50 text-pink-700 text-xs font-bold rounded-full whitespace-nowrap">{{ $staff->total }}
                                px</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-2">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Services -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-md font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                            clip-rule="evenodd" />
                    </svg>
                    Layanan Teratas
                </h3>
                <div class="space-y-3">
                    @forelse($topServices as $service)
                        <div class="flex justify-between items-center group">
                            <span
                                class="text-sm font-medium text-gray-700 truncate pr-2 group-hover:text-blue-600 transition">{{ $service->name }}</span>
                            <span
                                class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full whitespace-nowrap">{{ $service->total }}
                                kali</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-2">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Medicines -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-md font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                            clip-rule="evenodd" />
                    </svg>
                    Obat Terlaris
                </h3>
                <div class="space-y-3">
                    @forelse($topMedicines as $medicine)
                        <div class="flex justify-between items-center group">
                            <span
                                class="text-sm font-medium text-gray-700 truncate pr-2 group-hover:text-emerald-600 transition">{{ $medicine->name }}</span>
                            <span
                                class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full whitespace-nowrap">{{ $medicine->total }}
                                pcs</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-2">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Alert Sections -->
        <div class="mb-8">
            <!-- Low Stock -->
            <div class="bg-white rounded-2xl shadow-sm border border-orange-200 overflow-hidden">
                <div class="bg-orange-50 px-5 py-3 border-b border-orange-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-md font-bold text-orange-800">Peringatan: Stok Obat Menipis (&le; 10)</h3>
                </div>
                <div class="p-0 max-h-60 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white sticky top-0">
                            <tr>
                                <th
                                    class="px-5 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Nama Obat</th>
                                <th
                                    class="px-5 py-2 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($lowStockMedicines as $med)
                                <tr class="hover:bg-orange-50/50">
                                    <td class="px-5 py-2 text-sm text-gray-900 font-medium">{{ $med->name }}</td>
                                    <td
                                        class="px-5 py-2 text-sm text-right font-bold {{ $med->stock == 0 ? 'text-red-600' : 'text-orange-600' }}">
                                        {{ $med->stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-5 py-4 text-sm text-center text-gray-500">Stok obat aman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Transactions List -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">10 Transaksi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($latestTransactions as $trx)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $trx->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $trx->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $trx->patient->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($trx->payment_method == 'bpjs')
                                        <span
                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-md bg-blue-100 text-blue-800">BPJS</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-md bg-gray-100 text-gray-800">TUNAI</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">Rp
                                    {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($trx->status == 'paid')
                                        <span
                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">Lunas</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">Belum
                                            Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada transaksi</td>
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