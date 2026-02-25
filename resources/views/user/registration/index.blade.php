@extends('layouts.user')

@section('title', 'Riwayat Pendaftaran')

@section('content')
    <div class="min-h-screen bg-slate-50/50 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Riwayat </h2>
                    <p class="text-gray-500 mt-1 font-medium">Pantau status antrean dan jadwal kunjungan Anda.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center px-5 py-2.5 text-gray-500 font-bold hover:text-pink-600 transition-all">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.registration.create') }}"
                        class="flex items-center bg-gradient-to-r from-pink-500 to-rose-600 text-white px-6 py-3 rounded-2xl font-black shadow-xl shadow-rose-200 hover:shadow-2xl hover:shadow-rose-300 transition-all active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Daftar Baru
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm animate-fade-in">
                    <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="overflow-x-auto overflow-y-hidden">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th
                                    class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    Tanggal & Waktu</th>
                                <th
                                    class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    No. Antrian</th>
                                <th
                                    class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    Layanan</th>
                                <th
                                    class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    Keluhan</th>
                                <th
                                    class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($registrations as $registration)
                                <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-800 tracking-tight">
                                                {{ \Carbon\Carbon::parse($registration->date)->isoFormat('dddd, D MMM Y') }}
                                            </span>
                                            <span class="text-[11px] text-gray-400 font-medium">Terdaftar pada
                                                {{ $registration->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 font-black text-lg border border-pink-100 shadow-sm shadow-pink-100/50 group-hover:scale-110 transition-transform">
                                            {{ str_pad($registration->queue_number, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full bg-rose-400 mr-3"></div>
                                            <span class="text-sm font-extrabold text-gray-700 tracking-tight">
                                                {{ $registration->service_name ?? $registration->service->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 max-w-[200px]">
                                        <p class="text-sm font-medium text-gray-600 truncate"
                                            title="{{ $registration->complaint }}">
                                            {{ $registration->complaint ?? '-' }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-center">
                                        @php
                                            $statusConfig = [
                                                'waiting' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'dot' => 'bg-amber-400', 'label' => 'Menunggu'],
                                                'called' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'dot' => 'bg-blue-400', 'label' => 'Dipanggil'],
                                                'finished' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-400', 'label' => 'Selesai'],
                                                'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'dot' => 'bg-rose-400', 'label' => 'Dibatalkan'],
                                            ];
                                            $conf = $statusConfig[$registration->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'dot' => 'bg-gray-400', 'label' => $registration->status];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 rounded-xl {{ $conf['bg'] }} {{ $conf['text'] }} text-[10px] font-black uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $conf['dot'] }} mr-2 animate-pulse"></span>
                                            {{ $conf['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        @if($registration->status === 'waiting')
                                            <form action="{{ route('user.registration.cancel', $registration) }}" method="POST"
                                                onsubmit="event.preventDefault(); openCancelModal(this.action);" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-white text-rose-500 text-[10px] font-black tracking-widest uppercase rounded-xl border border-rose-200 hover:bg-rose-50 hover:border-rose-300 hover:text-rose-600 transition-all active:scale-95 shadow-sm">
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Batalkan
                                                </button>
                                            </form>
                                        @elseif($registration->transaction_data)
                                            <button type="button"
                                                onclick="openTransactionModal({{ $registration->transaction_data->id }})"
                                                class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-500 hover:text-white transition-all active:scale-90 group/btn shadow-sm">
                                                <svg class="w-4 h-4 mr-1.5 text-emerald-500 group-hover/btn:text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                Lihat Struk
                                            </button>

                                            @if($registration->transaction_data->status === 'paid')
                                                <a href="{{ route('user.registration.transactions.print_struk', $registration->transaction_data->id) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center px-4 py-2 bg-pink-50 text-pink-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-pink-500 hover:text-white transition-all active:scale-90 shadow-sm ml-2 group/print">
                                                    <svg class="w-4 h-4 mr-1.5 text-pink-500 group-hover/print:text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17 17v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-9a2 2 0 012-2h2m3-4h6a2 2 0 012 2v6m-6 0H9m12 0a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2">
                                                        </path>
                                                    </svg>
                                                    Cetak Struk
                                                </a>
                                            @endif

                                            <!-- Hidden data for this transaction -->
                                            <div id="tx-data-{{ $registration->transaction_data->id }}" class="hidden">
                                                <div class="tx-total">
                                                    {{ number_format($registration->transaction_data->total_amount, 0, ',', '.') }}
                                                </div>
                                                <div class="tx-status">{{ ucfirst($registration->transaction_data->status) }}</div>
                                                <div class="tx-payment">
                                                    {{ strtoupper($registration->transaction_data->payment_method) }}</div>
                                                <div class="tx-items">
                                                    @php
                                                        $konsultasi = $registration->transaction_data->items->where('name', 'Biaya Konsultasi')->first();
                                                        $layanan = $registration->transaction_data->items->where('item_type', 'App\Models\Service')->where('name', '!=', 'Biaya Konsultasi');
                                                        $obat = $registration->transaction_data->items->where('item_type', 'App\Models\Medicine');
                                                    @endphp

                                                    @if($konsultasi)
                                                        <div class="text-[10px] font-bold text-gray-400 uppercase mt-2 mb-1">Konsultasi</div>
                                                        <div class="flex justify-between text-sm py-1 border-b border-gray-100 last:border-0">
                                                            <div class="flex flex-col">
                                                                <span class="font-bold text-gray-800">{{ $konsultasi->name }}</span>
                                                                <span class="text-xs text-gray-500">{{ $konsultasi->quantity }}x Rp {{ number_format($konsultasi->price, 0, ',', '.') }}</span>
                                                            </div>
                                                            <span class="font-bold text-gray-800">Rp {{ number_format($konsultasi->subtotal, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif

                                                    @if($layanan->count() > 0)
                                                        <div class="text-[10px] font-bold text-gray-400 uppercase mt-2 mb-1">Layanan</div>
                                                        @foreach($layanan as $item)
                                                            <div class="flex justify-between text-sm py-1 border-b border-gray-100 last:border-0 pl-2">
                                                                <div class="flex flex-col">
                                                                    <span class="font-bold text-gray-800">{{ $item->name }}</span>
                                                                    <span class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                                </div>
                                                                <span class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if($obat->count() > 0)
                                                        <div class="text-[10px] font-bold text-gray-400 uppercase mt-2 mb-1">Obat & Vaksin</div>
                                                        @foreach($obat as $item)
                                                            <div class="flex justify-between text-sm py-1 border-b border-gray-100 last:border-0 pl-2">
                                                                <div class="flex flex-col">
                                                                    <span class="font-bold text-gray-800">{{ $item->name }}</span>
                                                                    <span class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                                </div>
                                                                <span class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="tx-notes">{{ $registration->transaction_data->notes }}</div>
                                            </div>
                                        @else
                                            <span
                                                class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-6 bg-slate-50 rounded-full mb-4">
                                                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 font-bold tracking-tight">Belum ada riwayat.</p>
                                            <p class="text-xs text-gray-300 mt-1">Layanan kesehatan yang Anda ambil akan muncul
                                                di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($registrations->hasPages())
                    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>

            <p class="text-center mt-10 text-gray-400 text-[11px] font-bold uppercase tracking-[0.2em]">
                &copy; 2026 Klinik Bidan Siti Hajar &bull; Layanan Terpercaya
            </p>
        </div>
    </div>

    <!-- Transaction Modal Structure -->
    <div id="transactionModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeTransactionModal()">
        </div>

        <!-- Modal Content -->
        <div
            class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto transform scale-95 transition-transform duration-300 overflow-hidden flex flex-col max-h-[90vh]">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-800">Detail Layanan</h3>
                        <p class="text-xs font-semibold text-gray-400">Rincian Obat & Tindakan</p>
                    </div>
                </div>
                <button onclick="closeTransactionModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-rose-100 hover:text-rose-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 overflow-y-auto flex-grow">

                <!-- Status & Payment Method Badges -->
                <div class="flex gap-2 mb-6">
                    <span id="modal-status"
                        class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600">
                        STATUS
                    </span>
                    <span id="modal-payment"
                        class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-600">
                        PAYMENT
                    </span>
                </div>

                <!-- Items Container -->
                <div class="space-y-1 mb-6">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Rincian Item</h4>
                    <div id="modal-items-container" class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100">
                        <!-- Items injected here by JS -->
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t-2 border-dashed border-gray-200 pt-4 mt-2">
                    <div class="flex justify-between items-end">
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Biaya</span>
                        <div class="text-right">
                            <span class="text-xs font-bold text-gray-400 align-top">Rp</span>
                            <span id="modal-total" class="text-3xl font-black text-emerald-600 tracking-tight">0</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div id="modal-notes-wrapper" class="mt-4 hidden">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                        <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-1">Catatan</p>
                        <p id="modal-notes" class="text-sm text-gray-700 whitespace-pre-wrap"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal Structure -->
    <div id="cancelModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeCancelModal()"></div>

        <!-- Modal Content -->
        <div
            class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm mx-auto transform scale-95 transition-transform duration-300 overflow-hidden flex flex-col">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-800 mb-2">Batalkan Pendaftaran?</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin membatalkan pendaftaran dengan layanan ini?
                    Tindakan ini tidak dapat diurungkan.</p>
                <form id="globalCancelForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeCancelModal()"
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors">
                            Kembali
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-rose-500 text-white font-bold rounded-xl hover:bg-rose-600 shadow-md shadow-rose-200 transition-colors">
                            Ya, Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cancelModal = document.getElementById('cancelModal');
            const cancelModalContent = cancelModal ? cancelModal.querySelector('.transform') : null;

            window.openCancelModal = function (actionUrl) {
                document.getElementById('globalCancelForm').action = actionUrl;
                cancelModal.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    cancelModalContent.classList.remove('scale-95');
                    cancelModalContent.classList.add('scale-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            };

            window.closeCancelModal = function () {
                cancelModalContent.classList.remove('scale-100');
                cancelModalContent.classList.add('scale-95');
                setTimeout(() => {
                    cancelModal.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = 'auto';
                }, 150);
            };

            const modal = document.getElementById('transactionModal');
            if (!modal) return;

            const modalContent = modal.querySelector('.transform');

            window.openTransactionModal = function (txId) {
                // Fetch data from hidden divs
                const container = document.getElementById(`tx-data-${txId}`);
                if (!container) {
                    console.error('Data container not found for txId:', txId);
                    return;
                }

                const total = container.querySelector('.tx-total').innerHTML;
                const status = container.querySelector('.tx-status').innerHTML;
                const payment = container.querySelector('.tx-payment').innerHTML;
                const itemsHtml = container.querySelector('.tx-items').innerHTML;
                const notesEl = container.querySelector('.tx-notes');
                const notes = notesEl ? notesEl.innerText.trim() : '';

                // Populate modal
                document.getElementById('modal-total').innerText = total;
                document.getElementById('modal-status').innerText = status;
                document.getElementById('modal-payment').innerText = payment;
                document.getElementById('modal-items-container').innerHTML = itemsHtml;

                // Show/hide notes
                const notesWrapper = document.getElementById('modal-notes-wrapper');
                const notesText = document.getElementById('modal-notes');
                if (notes) {
                    notesText.innerText = notes;
                    notesWrapper.classList.remove('hidden');
                } else {
                    notesWrapper.classList.add('hidden');
                }

                // Color status badge based on value
                const statusBadge = document.getElementById('modal-status');
                if (status.toLowerCase() === 'paid') {
                    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700';
                    statusBadge.innerText = 'LUNAS';
                } else {
                    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-700';
                    statusBadge.innerText = 'BELUM LUNAS';
                }

                // Show Modal
                modal.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);

                // Prevent body scroll
                document.body.style.overflow = 'hidden';
            };

            window.closeTransactionModal = function () {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = 'auto'; // Restore scroll
                }, 150);
            };

            // Listen for Escape key to close modal
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.classList.contains('opacity-0')) {
                    window.closeTransactionModal();
                }
            });

            // Make sure clicking backdrop closes modal
            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('.backdrop-blur-sm')) {
                    window.closeTransactionModal();
                }
            });
        });
    </script>
@endsection