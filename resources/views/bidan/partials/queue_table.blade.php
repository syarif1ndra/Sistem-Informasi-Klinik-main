@forelse($recentQueues as $queue)
    <tr class="{{ $queue->status == 'calling' ? 'bg-yellow-50/50' : 'hover:bg-pink-50/30 transition-colors group' }}">
        <td class="px-6 py-4 whitespace-nowrap">
            <span
                class="text-lg font-black text-gray-900 group-hover:text-pink-600 transition-colors">{{ sprintf('%03d', $queue->queue_number) }}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-bold text-gray-900">
                {{ $queue->patient->name ?? ($queue->userPatient->name ?? '-') }}
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">{{ $queue->service_name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->complaint ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span
                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl shadow-sm border
                                        {{ $queue->status === 'waiting' ? 'bg-gray-50 text-gray-700 border-gray-200' : '' }}
                                        {{ $queue->status === 'calling' ? 'bg-yellow-50 text-yellow-700 border-yellow-200 shadow-yellow-100' : '' }}
                                        {{ $queue->status === 'called' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $queue->status === 'finished' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $queue->status === 'cancelled' ? 'bg-red-50 text-red-700 border-red-200' : '' }}">
                {{ ucfirst($queue->status) }}
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-medium">Tidak ada data antrian untuk hari ini.</td>
    </tr>
@endforelse