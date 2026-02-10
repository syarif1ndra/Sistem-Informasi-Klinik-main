@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Data Imunisasi</h1>

        <form action="{{ route('admin.immunizations.index') }}" method="GET" class="flex items-center">
            <input type="date" name="date" value="{{ $date }}"
                class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.immunizations.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            Tambah Data Imunisasi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Anak</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Orang Tua
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal
                        Imunisasi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($immunizations as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $record->child_name }}</div>
                            <div class="text-xs text-gray-500">NIK: {{ $record->child_nik ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->parent_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($record->immunization_date)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($record->notes, 30) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.immunizations.edit', $record) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <form action="{{ route('admin.immunizations.destroy', $record) }}" method="POST"
                                class="inline-block" id="delete-form-{{ $record->id }}" onsubmit="event.preventDefault();">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="openDeleteModal(document.getElementById('delete-form-{{ $record->id }}'), '{{ $record->child_name }}')"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data imunisasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $immunizations->links() }}
        </div>
    </div>
@endsection