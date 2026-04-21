@extends($activeLayout ?? 'layouts.admin')

@section('content')
    <div class="flex flex-col mb-8 gap-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 border-l-4 border-pink-500 pl-4">
                Data Imunisasi
            </h1>

            <form action="{{ route('admin.immunizations.index') }}" method="GET" class="flex flex-col w-full lg:w-auto gap-3"
                id="filter-form">

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative flex-1 md:w-72">
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Cari nama anak atau orang tua..."
                            class="w-full shadow-sm border border-gray-300 rounded-lg py-2 px-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">
                    </div>

                    <div class="flex items-center gap-2 flex-1">
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                            class="flex-1 shadow-sm border border-gray-300 rounded-lg py-2 px-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">

                        <span class="text-gray-400 text-xs font-bold uppercase">s/d</span>

                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                            class="flex-1 shadow-sm border border-gray-300 rounded-lg py-2 px-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    </div>

                    <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm w-full sm:w-auto">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div
            class="flex flex-col sm:flex-row items-start sm:items-center gap-3 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter Cepat:
            </span>

            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="setQuickFilter('today')"
                    class="px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-600 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                    Hari Ini
                </button>
                <button type="button" onclick="setQuickFilter('7days')"
                    class="px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-600 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                    7 Hari Terakhir
                </button>
                <button type="button" onclick="setQuickFilter('thisMonth')"
                    class="px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-600 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                    Bulan Ini
                </button>
                <button type="button" onclick="setQuickFilter('thisYear')"
                    class="px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-600 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                    Tahun Ini
                </button>
            </div>
        </div>
    </div>

    <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('admin.immunizations.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Data Imunisasi
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
                    <a href="{{ route('admin.immunizations.exportExcel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                        target="_blank"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('admin.immunizations.exportPdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                        target="_blank"
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
        <div class="overflow-x-auto w-full custom-scrollbar" style="-webkit-overflow-scrolling: touch;">
            <table class="min-w-[900px] w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Nama
                            Anak</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Orang
                            Tua</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Tanggal
                            Imunisasi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Catatan
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider whitespace-nowrap">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($immunizations as $record)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($immunizations->currentPage() - 1) * $immunizations->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $record->child_name }}</div>
                                <div class="text-[10px] text-gray-500 font-semibold">NIK: {{ $record->child_nik ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->parent_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($record->immunization_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-[200px] truncate">
                                {{ $record->notes ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.immunizations.edit', $record) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</a>

                                    <form action="{{ route('admin.immunizations.destroy', $record) }}" method="POST"
                                        class="inline-block" id="delete-form-{{ $record->id }}"
                                        onsubmit="event.preventDefault();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal(document.getElementById('delete-form-{{ $record->id }}'), '{{ $record->child_name }}')"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data imunisasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $immunizations->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function setQuickFilter(type) {
            const today = new Date();
            let startDate = new Date();
            let endDate = new Date();

            switch (type) {
                case 'today':
                    break;
                case '7days':
                    startDate.setDate(today.getDate() - 7);
                    break;
                case 'thisMonth':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    break;
                case 'thisYear':
                    startDate = new Date(today.getFullYear(), 0, 1);
                    endDate = new Date(today.getFullYear(), 11, 31);
                    break;
            }

            const format = (date) => {
                const d = new Date(date);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                const year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            };

            document.getElementById('start_date').value = format(startDate);
            document.getElementById('end_date').value = format(endDate);
            document.getElementById('filter-form').submit();
        }
    </script>
@endsection
