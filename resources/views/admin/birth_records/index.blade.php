@extends($activeLayout ?? 'layouts.admin')

@section('content')
    <div class="flex flex-col mb-8 gap-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 border-l-4 border-pink-500 pl-4">
                Data Kelahiran
            </h1>

            <form action="{{ route('admin.birth_records.index') }}" method="GET" class="flex flex-col w-full lg:w-auto gap-3"
                id="filter-form">

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative flex-1 md:w-80">
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Cari nama bayi, ibu, atau ayah..."
                            class="w-full shadow-sm border border-gray-300 rounded-lg py-2 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">
                    </div>

                    <div class="flex items-center gap-2 flex-1">
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                            class="flex-1 shadow-sm border border-gray-300 rounded-lg py-2 px-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">

                        <span class="text-gray-400 text-xs font-bold">s/d</span>

                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                            class="flex-1 shadow-sm border border-gray-300 rounded-lg py-2 px-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">
                    </div>

                    <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm w-full sm:w-auto">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div
            class="flex flex-col sm:flex-row items-start sm:items-center gap-3 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Filter Cepat:
            </span>

            <div class="flex flex-wrap gap-2">
                @php
                    $quickFilters = [
                        'today' => 'Hari Ini',
                        '7days' => '7 Hari Terakhir',
                        'thisMonth' => 'Bulan Ini',
                        'thisYear' => 'Tahun Ini',
                    ];
                @endphp

                @foreach ($quickFilters as $key => $label)
                    <button type="button" onclick="setQuickFilter('{{ $key }}')"
                        class="px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-600 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
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
                    <a href="{{ route('admin.birth_records.exportExcel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
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
                    <a href="{{ route('admin.birth_records.exportPdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
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
                            Bayi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Tgl
                            Lahir</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Ibu
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">Ayah
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider whitespace-nowrap">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($birthRecords as $record)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($birthRecords->currentPage() - 1) * $birthRecords->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $record->baby_name }}</div>
                                <div class="text-[10px] uppercase font-semibold text-gray-500">
                                    {{ $record->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-medium">
                                    {{ \Carbon\Carbon::parse($record->birth_date)->translatedFormat('d F Y') }}</div>
                                <div class="text-xs text-pink-600 font-semibold">
                                    {{ \Carbon\Carbon::parse($record->birth_time)->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->mother_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->father_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.birth_records.generatePdf', $record) }}"
                                        class="text-green-600 hover:text-green-900 font-bold" target="_blank">Cetak</a>

                                    <a href="{{ route('admin.birth_records.edit', $record) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</a>

                                    <form action="{{ route('admin.birth_records.destroy', $record) }}" method="POST"
                                        class="inline-block" id="delete-form-{{ $record->id }}"
                                        onsubmit="event.preventDefault();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal(document.getElementById('delete-form-{{ $record->id }}'), '{{ $record->baby_name }}')"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data kelahiran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $birthRecords->links() }}
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
