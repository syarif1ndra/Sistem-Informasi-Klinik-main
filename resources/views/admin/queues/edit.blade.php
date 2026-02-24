@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Edit Antrian</h1>
        <a href="{{ route('admin.queues.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-pink-500 max-w-xl">
        {{-- Queue & Patient Info --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Informasi Antrian</h2>
            <dl class="grid grid-cols-2 gap-2 text-sm">
                <dt class="text-gray-500">No. Antrian</dt>
                <dd class="font-semibold">{{ sprintf('%03d', $queue->queue_number) }}</dd>
                <dt class="text-gray-500">Nama Pasien</dt>
                <dd class="font-semibold">{{ $queue->patient_name }}</dd>
                <dt class="text-gray-500">Layanan</dt>
                <dd>{{ $queue->service_name ?? '-' }}</dd>
                <dt class="text-gray-500">Tanggal</dt>
                <dd>{{ \Carbon\Carbon::parse($queue->date)->translatedFormat('d M Y') }}</dd>
                <dt class="text-gray-500">Status</dt>
                <dd>
                    <span class="px-2 inline-flex text-xs font-semibold rounded-full
                            {{ $queue->status === 'waiting' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $queue->status === 'calling' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $queue->status === 'finished' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $queue->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($queue->status) }}
                    </span>
                </dd>
            </dl>
        </div>

        {{-- Edit Assigned Practitioner Form --}}
        <form action="{{ route('admin.queues.update', $queue) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="assigned_practitioner_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Praktisi yang Ditugaskan
                </label>
                <select name="assigned_practitioner_id" id="assigned_practitioner_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Tidak Ada Penugasan --</option>
                    @php $grouped = $practitioners->groupBy('role'); @endphp
                    @foreach($grouped as $role => $users)
                        <optgroup label="{{ ucfirst($role) }}">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $queue->assigned_practitioner_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('assigned_practitioner_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection