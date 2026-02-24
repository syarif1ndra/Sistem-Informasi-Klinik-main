@extends('layouts.bidan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Pasien</h1>
    </div>

    {{-- Date Filter --}}
    <form method="GET" action="{{ route('bidan.patients.index') }}"
        class="bg-white rounded-lg shadow p-4 mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>
        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg text-sm">
            Filter
        </button>
    </form>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. HP</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal Antrian</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                    <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    @foreach($patient->queues as $queue)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700 font-bold">
                                {{ sprintf('%03d', $queue->queue_number) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $patient->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($queue->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $queue->complaint ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('bidan.patients.show', $patient) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-pink-50 text-pink-700 rounded-lg border border-pink-200 hover:bg-pink-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-400 italic">
                            Tidak ada pasien yang ditugaskan untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $patients->links() }}</div>
@endsection