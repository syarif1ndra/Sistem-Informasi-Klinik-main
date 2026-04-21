@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Layanan</h1>
        <a href="{{ route('admin.services.create') }}"
            class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700 transition">
            + Tambah Layanan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
        <div class="overflow-x-auto w-full custom-scrollbar" style="-webkit-overflow-scrolling: touch;">
            <table class="min-w-[800px] w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Nama
                            Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                            Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Harga
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider whitespace-nowrap">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $service)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 min-w-[200px]">
                                {{ Str::limit($service->description, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                        class="inline-block" id="delete-form-{{ $service->id }}"
                                        onsubmit="event.preventDefault();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal(document.getElementById('delete-form-{{ $service->id }}'), '{{ $service->name }}')"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data layanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $services->links() }}
        </div>
    </div>
@endsection
