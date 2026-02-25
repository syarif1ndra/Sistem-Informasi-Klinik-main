@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Lengkap</h1>
                <p class="text-gray-500 mt-1">Detail transaksi klinik berdasarkan periode</p>

                <div class="mt-4 flex space-x-4 border-b border-gray-200">
                    <a href="{{ route('admin.reports', ['type' => 'daily']) }}"
                        class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Harian
                        (Detail)</a>
                    <a href="{{ route('admin.reports', ['type' => 'monthly']) }}"
                        class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Bulanan</a>
                    <a href="{{ route('admin.reports', ['type' => 'yearly']) }}"
                        class="border-b-2 border-pink-500 py-2 px-1 text-sm font-medium text-pink-600">Tahunan</a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.reports') }}"
                class="flex flex-wrap items-end gap-3 w-full md:w-auto">
                <input type="hidden" name="type" value="yearly">

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Tahun</label>
                    <input type="number" name="year" value="{{ $year }}" min="2020" max="{{ date('Y') + 1 }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Praktisi</label>
                    <select name="practitioner_id"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                        <option value="all" {{ $practitionerId == 'all' ? 'selected' : '' }}>Semua Praktisi</option>
                        @foreach ($practitioners as $p)
                            <option value="{{ $p->id }}" {{ $practitionerId == $p->id ? 'selected' : '' }}>{{ $p->name }}
                                ({{ ucfirst($p->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm h-[38px]">
                        Filter
                    </button>
                    <button type="submit" name="export" value="pdf"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition shadow-sm h-[38px] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Cetak PDF
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Total Transaksi Filtered</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $totalTransactions }}</h3>
                </div>
                <div class="p-4 bg-gray-50 rounded-full text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div
                class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-pink-100 uppercase tracking-widest mb-1">Total Pendapatan Filtered</p>
                    <h3 class="text-3xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-4 bg-white/20 rounded-full text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800 text-lg">Agregasi Tahunan: {{ $year }}</h3>
                <p class="text-sm text-gray-500">Menampilkan rekapitulasi data setiap bulannya.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bulan
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Jumlah Transaksi</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total
                                Pendapatan (Lunas)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::create()->month($trx->label_month)->translatedFormat('F') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full font-bold">{{ $trx->total_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                    Rp {{ number_format($trx->total_revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">Tidak ada data transaksi pada tahun
                                    ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection