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
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                {{ $queue->assignedPractitioner->role === 'dokter' ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200' : 'bg-gradient-to-r from-pink-50 to-rose-50 text-pink-700 border border-pink-200' }}">
                        {{-- Role icon --}}
                        @if($queue->assignedPractitioner->role === 'dokter')
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        @endif
                        <span>{{ $queue->assignedPractitioner->name }}</span>
                        <span class="inline-block px-1.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide
                                     {{ $queue->assignedPractitioner->role === 'dokter' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                            {{ ucfirst($queue->assignedPractitioner->role) }}
                        </span>
                    </div>
                @else
                    <span class="text-gray-400 text-xs italic">—</span>
                @endif
            @else
                {{-- Editable dropdown --}}
                <form action="{{ route('admin.queues.update', $queue) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="relative inline-block">
                        <select name="assigned_practitioner_id" onchange="this.form.submit()"
                            class="text-xs font-semibold border border-gray-200 rounded-xl pl-7 pr-7 py-2 bg-white hover:border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-300/50 focus:border-pink-400 cursor-pointer transition-all duration-200 shadow-sm hover:shadow appearance-none min-w-[180px]"
                            style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22 stroke-width=%222%22><path stroke-linecap=%22round%22 stroke-linejoin=%22round%22 d=%22M19 9l-7 7-7-7%22/></svg>'); background-repeat: no-repeat; background-position: right 8px center; background-size: 14px;">
                            <option value="" disabled {{ !$queue->assigned_practitioner_id ? 'selected' : '' }}>— Pilih Praktisi —</option>
                            @php
                                $dokters = $practitioners->where('role', 'dokter');
                                $bidans = $practitioners->where('role', 'bidan');
                            @endphp
                            @if($dokters->count())
                                <optgroup label="👨‍⚕️ Dokter">
                                    @foreach($dokters as $user)
                                        <option value="{{ $user->id }}" {{ $queue->assigned_practitioner_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if($bidans->count())
                                <optgroup label="👩‍⚕️ Bidan">
                                    @foreach($bidans as $user)
                                        <option value="{{ $user->id }}" {{ $queue->assigned_practitioner_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                        {{-- Icon indicator --}}
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                            @if($queue->assignedPractitioner && $queue->assignedPractitioner->role === 'dokter')
                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @elseif($queue->assignedPractitioner && $queue->assignedPractitioner->role === 'bidan')
                                <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @endif
                        </div>
                    </div>
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