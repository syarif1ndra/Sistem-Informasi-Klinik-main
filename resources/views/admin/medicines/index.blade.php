@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Vaksin & Obat</h1>
        <a href="{{ route('admin.medicines.create') }}"
            class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700 transition">
            + Tambah Obat
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="overflow-x-auto w-full custom-scrollbar" style="-webkit-overflow-scrolling: touch;">
            <table class="min-w-[800px] w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Nama
                            Obat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Stok
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Harga
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider whitespace-nowrap">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($medicines as $medicine)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration + ($medicines->currentPage() - 1) * $medicines->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $medicine->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $medicine->category }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $medicine->stock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $medicine->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp {{ number_format($medicine->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.medicines.edit', $medicine) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                    <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST"
                                        class="inline-block" id="delete-form-{{ $medicine->id }}"
                                        onsubmit="event.preventDefault();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal(document.getElementById('delete-form-{{ $medicine->id }}'), '{{ $medicine->name }}')"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $medicines->links() }}
        </div>
    </div>
@endsection
