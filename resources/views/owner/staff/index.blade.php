@extends('layouts.owner')

@section('content')
    <div class="space-y-6">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kinerja Pegawai</h1>
                <p class="text-gray-500 mt-1">Monitoring performa Tenaga Medis (Dokter, Bidan, Perawat)</p>
            </div>
            <form method="GET" action="{{ route('owner.staff.performance') }}"
                class="flex flex-wrap items-end gap-3 w-full md:w-auto">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                </div>
                <button type="submit"
                    class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm h-[38px]">
                    Filter Data
                </button>
            </form>
        </div>

        <!-- Tenaga Medis Section -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100 mb-8">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-pink-50 to-white">
                <div class="p-2 bg-pink-100 rounded-lg text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Kinerja Tenaga Medis (Dokter, Bidan, Perawat)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Shift
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Pasien Ditangani</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kontribusi Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($medis as $staff)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $staff->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ $staff->role }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $staff->shift ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-pink-600">
                                    {{ $staff->total_pasien }} px
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-emerald-600">Rp
                                    {{ number_format($staff->revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data tenaga medis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection