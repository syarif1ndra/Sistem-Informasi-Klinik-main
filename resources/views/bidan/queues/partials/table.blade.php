@forelse($queues as $queue)
    <tr id="row-{{ $queue->id }}" class="{{ $queue->status == 'calling' ? 'bg-yellow-50' : '' }}">
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-lg font-bold text-gray-900">{{ sprintf('%03d', $queue->queue_number) }}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $queue->patient_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->service_name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->complaint ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span id="status-{{ $queue->id }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $queue->status === 'waiting' ? 'bg-gray-100 text-gray-800' : '' }}
                    {{ $queue->status === 'calling' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $queue->status === 'called' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $queue->status === 'finished' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $queue->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                {{ ucfirst($queue->status) }}
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada antrian yang ditugaskan ke Anda untuk tanggal
            ini.</td>
    </tr>
@endforelse