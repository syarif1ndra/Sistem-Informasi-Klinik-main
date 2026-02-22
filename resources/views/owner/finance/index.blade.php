@extends('layouts.owner')

@section('content')
    <div class="space-y-6">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Rekap Keuangan</h1>
                <p class="text-gray-500 mt-1">Laporan Arus Kas dan Estimasi Laba</p>
            </div>
            <form method="GET" action="{{ route('owner.finance') }}"
                class="flex flex-wrap items-end gap-3 w-full md:w-auto">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <button type="submit"
                    class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm h-[38px]">
                    Filter Data
                </button>
            </form>
        </div>

        <!-- Cards Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Kas Masuk (Lunas)</p>
                <h3 class="text-2xl font-black text-emerald-600">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Kas Keluar (Pengeluaran)</p>
                <h3 class="text-2xl font-black text-rose-600">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Laba Kotor</p>
                <h3 class="text-2xl font-black text-blue-600">Rp {{ number_format($labaKotor, 0, ',', '.') }}</h3>
            </div>
            <div
                class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-sm p-6 text-white transform hover:-translate-y-1 transition duration-300">
                <p class="text-sm font-bold text-pink-100 uppercase mb-1">Estimasi Laba Bersih</p>
                <h3 class="text-2xl font-black">Rp {{ number_format($labaBersih, 0, ',', '.') }}</h3>
                <p class="text-xs text-pink-100 mt-1">Dipotong modal obat (Rp {{ number_format($modalObat, 0, ',', '.') }})
                </p>
            </div>
        </div>

        <!-- Transaksi Pending Alert -->
        @if($pendingTrans > 0)
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700">
                            Ada potensi pendapatan dari transaksi yang belum lunas sebesar <b>Rp
                                {{ number_format($pendingTrans, 0, ',', '.') }}</b>.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Tambah Pengeluaran -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Catat Pengeluaran Baru</h3>
                    <form action="{{ route('owner.finance.expense.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Deskripsi</label>
                                <input type="text" name="description" placeholder="Contoh: Beli token listrik" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                                <input type="number" name="amount" min="1" placeholder="Contoh: 150000" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            <button type="submit"
                                class="w-full bg-pink-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-700 transition">
                                Simpan Pengeluaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Pengeluaran -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Pengeluaran (Kas Keluar) Terfilter</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Tgl</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Keterangan</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Nominal</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($expenses as $exp)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($exp->date)->translatedFormat('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $exp->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-rose-600">Rp
                                            {{ number_format($exp->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <form action="{{ route('owner.finance.expense.destroy', $exp->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="openDeleteModal(this.closest('form'), 'Pengeluaran {{ $exp->description }}')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada catatan
                                            pengeluaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection