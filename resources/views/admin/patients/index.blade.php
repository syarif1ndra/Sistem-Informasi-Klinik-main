@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pasien</h1>

        <form action="{{ route('admin.patients.index') }}" method="GET" class="flex items-center">
            <input type="date" name="date" value="{{ $date }}"
                class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
        </form>
    </div>

    <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('admin.patients.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Pasien
        </a>
        <div class="flex gap-2">
            <a href="{{ route('admin.patients.exportExcel', ['date' => $date]) }}" target="_blank"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                Export Excel
            </a>
            <a href="{{ route('admin.patients.exportPdf', ['date' => $date]) }}" target="_blank"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan Terakhir</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $todaysQueue = $patient->queues->where('date', $date)->sortByDesc('created_at')->first();
                            @endphp
                            <span class="text-lg font-bold text-gray-900">
                                {{ $todaysQueue ? sprintf('%03d', $todaysQueue->queue_number) : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $patient->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($patient->medical_history, 30) ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->service ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($patient->address, 30) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.patients.edit', $patient) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline-block"
                                id="delete-form-{{ $patient->id }}" onsubmit="event.preventDefault();">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="openDeleteModal(document.getElementById('delete-form-{{ $patient->id }}'), '{{ $patient->name }}')"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data pasien.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $patients->links() }}
        </div>
    </div>
@endsection