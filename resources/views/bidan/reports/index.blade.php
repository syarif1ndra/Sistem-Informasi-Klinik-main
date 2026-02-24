@extends('layouts.bidan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Laporan Keuangan Saya</h1>
    </div>

    {{-- Date Filter --}}
    <form method="GET" action="{{ route('bidan.reports.index') }}"
        class="bg-white rounded-lg shadow p-4 mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>
        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg text-sm">
            Filter
        </button>
    </form>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-500">
            <p class="text-gray-500 text-sm uppercase font-semibold">Total Transaksi</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTransactions }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm uppercase font-semibold">Total Pendapatan (Lunas)</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Transaction Table --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Metode Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Tagihan Pasein</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-green-200">Pendapatan Anda</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $transaction->patient->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ strtoupper($transaction->payment_method) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">
                            Rp {{ number_format($transaction->practitioner_income, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400 italic">Tidak ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $transactions->links() }}</div>
@endsection