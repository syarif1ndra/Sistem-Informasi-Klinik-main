@extends('layouts.apoteker')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('apoteker.prescriptions.index') }}"
                class="p-2 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Resep</h1>
                    @if($prescription->status == 'menunggu')
                        <span
                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Menunggu</span>
                    @elseif($prescription->status == 'diproses')
                        <span
                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                    @elseif($prescription->status == 'siap_diambil')
                        <span
                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Siap
                            Diambil</span>
                    @else
                        <span
                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-1">Ref Tgl: {{ $prescription->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content: Prescription Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Medicine List -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                            Daftar Obat
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($prescription->items as $item)
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">{{ $item->medicine->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $item->medicine->category }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-2xl font-bold text-gray-900">{{ $item->quantity }}</span>
                                                <span class="text-sm text-gray-500 ml-1">pcs</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex flex-wrap gap-4">
                                            <div
                                                class="bg-blue-50 text-blue-800 rounded-lg px-3 py-2 text-sm flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-medium">Dosis:</span> {{ $item->dosage ?: '-' }}
                                            </div>
                                            @if($item->instructions)
                                                <div
                                                    class="bg-indigo-50 text-indigo-800 rounded-lg px-3 py-2 text-sm flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="font-medium">Aturan:</span> {{ $item->instructions }}
                                                </div>
                                            @endif

                                            <!-- Stock Warning Indicator -->
                                            @if($prescription->status == 'menunggu' && $item->medicine->stock < $item->quantity)
                                                <div
                                                    class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-3 py-2 text-sm flex items-center gap-2 w-full mt-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                        </path>
                                                    </svg>
                                                    <span class="font-bold">Stok Tidak Cukup!</span> (Sisa:
                                                    {{ $item->medicine->stock }})
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                Tidak ada detail obat pada resep ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Notes Section -->
                @if($prescription->notes)
                    <div class="bg-yellow-50 rounded-2xl p-6 border border-yellow-100">
                        <h3 class="text-sm font-bold text-yellow-800 mb-2 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Catatan Resep
                        </h3>
                        <p class="text-yellow-700 text-sm leading-relaxed">{{ $prescription->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar: Info & Actions -->
            <div class="space-y-6">


                <!-- Action Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-900">Aksi Status</h2>
                    </div>
                    <div class="p-6">
                        @if($prescription->status == 'menunggu')
                            <p class="mb-4 text-sm text-gray-600">Resep saat ini sedang <strong
                                    class="text-orange-600">menunggu</strong> untuk diproses. Klik tombol di bawah untuk mulai
                                memproses dan memotong stok obat.</p>
                            <form action="{{ route('apoteker.prescriptions.update_status', $prescription) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="diproses">
                                <button type="submit"
                                    class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                                    onclick="return confirm('Proses resep ini dan potong stok obat?')">
                                    Proses Resep Sekarang
                                </button>
                            </form>
                        @elseif($prescription->status == 'diproses')
                            <p class="mb-4 text-sm text-gray-600">Resep sedang <strong class="text-blue-600">diproses</strong>.
                                Stok obat telah diambil dari master data. Klik tombol di bawah apabila obat sudah dikemas dan
                                siap diambil oleh pasien.</p>
                            <form action="{{ route('apoteker.prescriptions.update_status', $prescription) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="siap_diambil">
                                <button type="submit"
                                    class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition"
                                    onclick="return confirm('Tandai obat siap diambil?')">
                                    Obat Siap Diambil
                                </button>
                            </form>
                        @elseif($prescription->status == 'siap_diambil')
                            <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100">
                                <p class="text-sm text-emerald-800 m-0">
                                    <strong>Menunggu Pembayaran!</strong><br>Obat sudah siap diambil. Status ini akan otomatis
                                    berubah menjadi <strong>Selesai</strong> jika pasien telah membayar lunas di Kasir.
                                </p>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-800 m-0">
                                    <strong>Resep Selesai!</strong><br>Obat telah diserahkan dan transaksi pembayaran telah
                                    selesai.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection