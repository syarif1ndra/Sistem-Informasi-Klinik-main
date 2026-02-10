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
        <a href="{{ route('admin.transactions.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            Tambah Transaksi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $transaction->patient->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                            {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $transaction->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.transactions.show', $transaction) }}"
                                class="text-blue-600 hover:text-blue-900 mr-2">Detail</a>
                            @if($transaction->status == 'unpaid')
                                <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Bayar</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST"
                                class="inline-block" 
                                id="delete-form-{{ $transaction->id }}"
                                onsubmit="event.preventDefault();">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                    onclick="openDeleteModal(document.getElementById('delete-form-{{ $transaction->id }}'), 'Transaksi #{{ $transaction->id }}')"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection