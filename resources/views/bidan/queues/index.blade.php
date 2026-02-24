@extends('layouts.bidan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Antrian </h1>

        <div class="flex items-center gap-4">
            <form action="{{ route('bidan.queues.index') }}" method="GET" class="flex items-center">
                <input type="date" name="date" value="{{ $date }}"
                    class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
        </div>
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
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody id="queue-table-body" class="bg-white divide-y divide-gray-200">
                @include('bidan.queues.partials.table')
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        const tableDataUrl = '{{ route("bidan.queues.tableDataList") }}';

        function fetchQueueTableData() {
            const dateParam = new URLSearchParams(window.location.search).get('date') || '{{ $date }}';
            fetch(`${tableDataUrl}?date=${dateParam}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('queue-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching realtime queue data:', error));
        }

        setInterval(fetchQueueTableData, 5000);
    </script>
@endsection