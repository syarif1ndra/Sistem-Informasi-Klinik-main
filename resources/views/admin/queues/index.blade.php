@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Antrian</h1>

        <div class="flex items-center gap-4">
            <a href="{{ route('public.queue_display') }}" target="_blank"
                class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded shadow flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Buka Layar Antrian
            </a>
            <form action="{{ route('admin.queues.index') }}" method="GET" class="flex items-center">
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
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="queue-table-body" class="bg-white divide-y divide-gray-200">
                @include('admin.queues.partials.table')
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        // Define the table data route specifically for AJAX
        const tableDataUrl = '{{ route("admin.queues.tableData") }}';

        // Polling functionality for realtime updates
        function fetchQueueTableData() {
            // Include that date filter correctly
            const dateParam = new URLSearchParams(window.location.search).get('date') || '{{ $date }}';
            fetch(`${tableDataUrl}?date=${dateParam}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('queue-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching realtime queue data:', error));
        }

        // Poll every 5 seconds
        setInterval(fetchQueueTableData, 5000);

        function callPatient(queueId, queueNumber, patientName) {
            console.log(`Calling patient: ${queueNumber} - ${patientName}`);
            // Text to Speech
            const text = `Nomor antrian ${queueNumber}, ${patientName}`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID'; // Indonesian
            window.speechSynthesis.speak(utterance);

            // Update Status via AJAX
            fetch(`/admin/queues/${queueId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: 'calling' })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI Status Badge
                        const statusSpan = document.getElementById(`status-${queueId}`);
                        if (statusSpan) {
                            statusSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800';
                            statusSpan.innerText = 'Calling';
                        }
                        // Optional: Update row background
                        const row = document.getElementById(`row-${queueId}`);
                        if (row) {
                            row.classList.add('bg-yellow-50');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection