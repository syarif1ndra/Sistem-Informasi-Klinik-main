@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <span class="p-3 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                Detail Transaksi
            </h1>
            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center gap-2 text-gray-500 hover:text-pink-600 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div
                class="bg-gradient-to-r from-pink-500 to-rose-600 px-8 py-6 flex flex-col md:flex-row justify-between items-center text-white">
                <div>
                    <span class="text-pink-100 uppercase tracking-wider text-xs font-bold">ID Transaksi</span>
                    <h2 class="text-3xl font-bold mt-1">{{ $transaction->id }}</h2>
                </div>
                <div class="mt-4 md:mt-0 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/20">
                    <span
                        class="flex items-center gap-2 font-bold {{ $transaction->status == 'paid' ? 'text-green-200' : 'text-yellow-200' }}">
                        @if($transaction->status == 'paid')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" border="0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                            LUNAS
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" border="0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                            </svg>
                            BELUM LUNAS
                        @endif
                    </span>
                </div>
            </div>

            <div class="p-8">
                <!-- Patient Info -->
                <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Pasien
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Nama
                                Pasien</label>
                            <div class="text-lg font-semibold text-gray-900">{{ $transaction->patient->name }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Tanggal &
                                Waktu</label>
                            <div class="text-lg font-semibold text-gray-900">
                                {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Metode
                                Pembayaran</label>
                            <div class="text-lg font-semibold text-gray-900">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_method == 'bpjs' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $transaction->payment_method == 'bpjs' ? 'BPJS Kesehatan' : 'Umum' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="overflow-hidden rounded-lg border border-gray-200 mb-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Item</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transaction->items as $item)
                                <tr class="hover:bg-pink-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div
                                            class="text-xs text-gray-500 inline-block px-2 py-0.5 rounded-full bg-gray-100 mt-1">
                                            {{ $item->item_type == 'App\Models\Service' ? 'Layanan' : 'Obat' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-800">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-500">Total Tagihan</td>
                                <td
                                    class="px-6 py-4 text-right font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-600">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($transaction->notes)
                    <div class="mb-8 p-6 bg-amber-50 rounded-xl border border-amber-200">
                        <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wide mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Catatan
                        </h3>
                        <p class="text-gray-700 text-sm whitespace-pre-wrap">{{ $transaction->notes }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 print:hidden">
                    <button
                        onclick="window.open('{{ route('admin.transactions.print_struk', $transaction->id) }}', '_blank', 'width=400,height=600')"
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Struk
                    </button>

                    @if($transaction->status == 'unpaid')
                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none transition transform hover:-translate-y-0.5 shadow-lg hover:shadow-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tandai Lunas
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection