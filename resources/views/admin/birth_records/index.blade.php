@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Data Kelahiran</h1>

        <form action="{{ route('admin.birth_records.index') }}" method="GET" class="flex items-center">
            <input type="date" name="date" value="{{ $date }}"
                class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
        </form>
    </div>

    <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('admin.birth_records.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Data Kelahiran
        </a>
        <div x-data="{ open: false }" class="relative z-10">
            <button @click="open = !open" @click.away="open = false" type="button"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <span>Export Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open"
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;">
                <div class="py-1">
                    <a href="{{ route('admin.birth_records.exportExcel', ['date' => $date]) }}" target="_blank"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('admin.birth_records.exportPdf', ['date' => $date]) }}" target="_blank"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Bayi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tgl Lahir
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Ibu</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Ayah</th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($birthRecords as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loop->iteration + ($birthRecords->currentPage() - 1) * $birthRecords->perPage() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $record->baby_name }}</div>
                            <div class="text-xs text-gray-500">{{ $record->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($record->birth_date)->translatedFormat('d F Y') }}
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($record->birth_time)->format('H:i') }}
                                WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->mother_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->father_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.birth_records.generatePdf', $record) }}"
                                class="text-green-600 hover:text-green-900 mr-2" target="_blank">Cetak</a>
                            <a href="{{ route('admin.birth_records.edit', $record) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <form action="{{ route('admin.birth_records.destroy', $record) }}" method="POST"
                                class="inline-block" id="delete-form-{{ $record->id }}" onsubmit="event.preventDefault();">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="openDeleteModal(document.getElementById('delete-form-{{ $record->id }}'), '{{ $record->baby_name }}')"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kelahiran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $birthRecords->links() }}
        </div>
    </div>
@endsection