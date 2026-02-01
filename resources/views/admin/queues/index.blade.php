@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Antrian</h1>

        <form action="{{ route('admin.queues.index') }}" method="GET" class="flex items-center">
            <input type="date" name="date" value="{{ $date }}"
                class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="text-gray-500 text-sm uppercase">Total Antrian</div>
            <div class="text-3xl font-bold">{{ $queues->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="text-gray-500 text-sm uppercase">Selesai</div>
            <div class="text-3xl font-bold">{{ $queues->where('status', 'finished')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="text-gray-500 text-sm uppercase">Menunggu</div>
            <div class="text-3xl font-bold">{{ $queues->where('status', 'waiting')->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Pembayaran
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi
                        (Real-time)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($queues as $queue)
                    <tr class="{{ $queue->status == 'calling' ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-lg font-bold text-gray-900">{{ $queue->queue_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $queue->patient->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->service->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $queue->status === 'waiting' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $queue->status === 'calling' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $queue->status === 'called' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $queue->status === 'finished' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $queue->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($queue->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $queue->bpjs_usage ? 'BPJS' : 'Umum' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                @if($queue->status != 'finished' && $queue->status != 'cancelled')
                                    @if($queue->status != 'calling')
                                        <form action="{{ route('admin.queues.updateStatus', $queue) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="calling">
                                            <button type="submit"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                                Panggil
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.queues.updateStatus', $queue) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="finished">
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                            Selesai
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.queues.updateStatus', $queue) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                            Batal
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data antrian untuk tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection