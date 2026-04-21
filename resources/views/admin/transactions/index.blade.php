@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Transaksi</h1>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex items-center">
            <input type="date" name="date" value="{{ $date }}"
                class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.transactions.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            Tambah Transaksi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="overflow-x-auto w-full custom-scrollbar" style="-webkit-overflow-scrolling: touch;">
            <table class="min-w-[1100px] w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">No
                        </th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Tanggal</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Pasien</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Metode</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Praktisi</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Total</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Status</th>
                        <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $transaction->patient->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_method == 'bpjs' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $transaction->payment_method == 'bpjs' ? 'BPJS' : 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->handledBy ? $transaction->handledBy->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $transaction->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}"
                                        class="text-amber-600 hover:text-amber-900">Edit</a>

                                    @if ($transaction->status == 'unpaid')
                                        <form action="{{ route('admin.transactions.update', $transaction) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-900 font-bold">Bayar</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST"
                                        class="inline-block" id="delete-form-{{ $transaction->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal(document.getElementById('delete-form-{{ $transaction->id }}'), 'Transaksi #{{ $transaction->id }}')"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
