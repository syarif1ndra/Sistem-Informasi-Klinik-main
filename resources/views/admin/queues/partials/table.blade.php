@forelse($queues as $queue)
    <tr id="row-{{ $queue->id }}" class="{{ $queue->status == 'calling' ? 'bg-yellow-50' : '' }}">
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-lg font-bold text-gray-900">{{ sprintf('%03d', $queue->queue_number) }}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $queue->patient_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->service_name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $queue->complaint ?? '-' }}</td>

        {{-- Inline Practitioner Dropdown --}}
        <td class="px-4 py-3 whitespace-nowrap">
            @if(in_array($queue->status, ['finished', 'cancelled']))
                {{-- Read-only badge when queue is done --}}
                @if($queue->assignedPractitioner)
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $queue->assignedPractitioner->role === 'dokter' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                        {{ ucfirst($queue->assignedPractitioner->role) }}
                    </span>
                @else
                    <span class="text-gray-400 text-xs italic">—</span>
                @endif
            @else
                {{-- Editable dropdown --}}
                <form action="{{ route('admin.queues.update', $queue) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="assigned_practitioner_id" onchange="this.form.submit()"
                        class="text-xs font-medium border border-gray-200 rounded-lg px-2 py-1.5 bg-gray-50 hover:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 cursor-pointer transition-colors duration-150 shadow-sm">
                        @foreach($practitioners as $user)
                            <option value="{{ $user->id }}" {{ $queue->assigned_practitioner_id == $user->id ? 'selected' : '' }}>
                                {{ ucfirst($user->role) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </td>

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
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex justify-end space-x-2">
                @if($queue->status != 'finished' && $queue->status != 'cancelled')
                    <button type="button"
                        onclick="callPatient({{ $queue->id }}, '{{ sprintf('%03d', $queue->queue_number) }}', '{{ addslashes($queue->patient_name) }}')"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                        Panggil
                    </button>

                    <form action="{{ route('admin.queues.updateStatus', $queue) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="finished">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                            Selesai
                        </button>
                    </form>

                    <form action="{{ route('admin.queues.updateStatus', $queue) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                            Batal
                        </button>
                    </form>
                @endif
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="px-6 py-4 text-center text-gray-400 italic">Tidak ada data antrian untuk tanggal ini.</td>
    </tr>
@endforelse