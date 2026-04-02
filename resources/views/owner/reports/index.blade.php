@extends('layouts.owner')

@section('content')
    <div class="space-y-6">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Lengkap</h1>
                <p class="text-gray-500 mt-1">Detail transaksi klinik berdasarkan periode</p>

                <div class="mt-4 flex space-x-4 border-b border-gray-200">
                    <a href="{{ route('owner.reports', ['type' => 'daily']) }}"
                        class="border-b-2 border-pink-500 py-2 px-1 text-sm font-medium text-pink-600">Harian (Detail)</a>
                    <a href="{{ route('owner.reports', ['type' => 'monthly']) }}"
                        class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Bulanan</a>
                    <a href="{{ route('owner.reports', ['type' => 'yearly']) }}"
                        class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Tahunan</a>
                </div>
            </div>
            <form method="GET" action="{{ route('owner.reports') }}"
                class="flex flex-wrap items-end gap-3 w-full md:w-auto">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dari</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sampai</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
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
                    <label class="block text-xs font-medium text-gray-700 mb-1">Metode Bayar</label>
                    <select name="payment_method"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                        <option value="all" {{ ($paymentMethod ?? 'all') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="cash" {{ ($paymentMethod ?? '') == 'cash' ? 'selected' : '' }}>Umum</option>
                        <option value="bpjs" {{ ($paymentMethod ?? '') == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Status Pembayaran Pegawai</label>
                    <select name="staff_payment_status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                        <option value="all" {{ ($staffPaymentStatus ?? 'all') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="paid" {{ ($staffPaymentStatus ?? '') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="unpaid" {{ ($staffPaymentStatus ?? '') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm h-[38px]">
                    Filter
                </button>
                <div x-data="{ open: false }" class="relative z-10 ml-auto md:ml-2">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="bg-indigo-600 font-medium hover:bg-indigo-700 text-white py-2 px-4 text-sm rounded-lg flex items-center gap-2 h-[38px] shadow-sm">
                        <span>Export Data</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('owner.reports.exportExcel', request()->all()) }}" target="_blank"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Excel
                            </a>
                            <a href="{{ route('owner.reports.exportPdf', request()->all()) }}" target="_blank"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Total Transaksi </p>
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
            </div>
            
            <div
                class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-indigo-100 uppercase tracking-widest mb-1">Klinik Bersih</p>
                    <h3 class="text-2xl font-black">Rp {{ number_format($totalClinicRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-full text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-emerald-100 uppercase tracking-widest mb-1">Medis Bersih</p>
                    <h3 class="text-2xl font-black">Rp {{ number_format($totalMedicalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-full text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-pink-100 uppercase tracking-widest mb-1">Total Pendapatan 
                        </p>
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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Praktisi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Metode
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Transaksi
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">P. Klinik
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">P. Medis
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Pembayaran Pegawai</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Lunas?</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $trx->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $trx->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $trx->patient->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $trx->handledBy->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $trx->payment_method == 'cash' ? 'UMUM' : strtoupper($trx->payment_method) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">Rp
                                    {{ number_format($trx->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-indigo-600">Rp
                                    {{ number_format($trx->medical_staff_revenue > 0 || $trx->clinic_revenue > 0 ? $trx->clinic_revenue : $trx->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-emerald-600">Rp
                                    {{ number_format($trx->medical_staff_revenue, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(in_array($trx->handledBy->role ?? '', ['dokter', 'bidan']) && $trx->medical_staff_revenue > 0)
                                        <form action="{{ route('owner.reports.togglePayment', $trx->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-1 rounded transition-colors {{ $trx->staff_payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}" title="{{ $trx->staff_payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}">
                                                @if($trx->staff_payment_status === 'paid')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
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
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection