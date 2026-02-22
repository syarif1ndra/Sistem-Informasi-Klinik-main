@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
    <div class="min-h-screen bg-slate-50/50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                class="relative bg-gradient-to-br from-pink-500 via-rose-500 to-rose-600 rounded-3xl shadow-2xl overflow-hidden mb-10">
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-pink-400/20 rounded-full blur-2xl"></div>

                <div class="relative px-8 py-12 md:px-12 flex flex-col md:flex-row items-center justify-between">
                    <div class="text-center md:text-left mb-6 md:mb-0">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3 tracking-tight">
                            Selamat Datang, <span class="text-pink-100">{{ $user->name }}</span>!
                        </h1>
                        <p class="text-pink-50/90 text-lg font-medium max-w-md leading-relaxed">
                            Kelola kesehatan Anda dan keluarga dalam satu genggaman dengan layanan terbaik kami.
                        </p>
                    </div>
                    <div class="hidden lg:block">
                        <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm border border-white/30">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profil Pasien --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-pink-100 transition-all duration-300">
                    <div class="flex items-start justify-between mb-8">
                        <div class="p-3 bg-blue-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide {{ $patient ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            <span
                                class="w-2 h-2 mr-1.5 rounded-full {{ $patient ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                            {{ $patient ? 'TERVERIFIKASI' : 'BELUM LENGKAP' }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 mb-2">Profil Pasien</h2>

                    @if ($patient)
                        <div class="space-y-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Nama Lengkap
                                </p>
                                <p class="font-semibold text-gray-800">{{ $patient->name }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Nomor Induk
                                    Kependudukan</p>
                                <p class="font-semibold text-gray-800">{{ $patient->nik }}</p>
                            </div>
                        </div>
                        <a href="{{ route('user.patient.edit') }}"
                            class="flex items-center justify-center w-full bg-white border-2 border-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-50 hover:border-gray-200 transition-all active:scale-95">
                            Perbarui Data
                        </a>
                    @else
                        <p class="text-gray-500 leading-relaxed mb-8">Akses layanan penuh dengan melengkapi informasi profil
                            kesehatan Anda terlebih dahulu.</p>
                        <a href="{{ route('user.patient.create') }}"
                            class="block w-full text-center bg-pink-600 text-white py-4 rounded-xl font-bold hover:bg-pink-700 transition-all shadow-lg shadow-pink-200 active:scale-95">
                            Lengkapi Profil
                        </a>
                    @endif
                </div>

                {{-- Pendaftaran klinnik --}}
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-pink-100 transition-all duration-300">
                    <div class="flex items-start justify-between mb-8">
                        <div class="p-3 bg-pink-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Klinik</h2>
                    <p class="text-gray-500 leading-relaxed mb-8">Pilih jadwal dan dokter spesialis dengan mudah tanpa perlu
                        mengantre lama di lokasi.</p>

                    @if ($patient)
                        <a href="{{ route('user.registration.create') }}"
                            class="block w-full text-center bg-gradient-to-r from-pink-500 to-rose-600 text-white py-4 rounded-xl font-bold hover:from-pink-600 hover:to-rose-700 transition-all shadow-lg shadow-rose-200 active:scale-95">
                            Daftar Sekarang
                        </a>
                    @else
                        <button disabled
                            class="block w-full text-center bg-gray-100 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed border border-gray-200">
                            Fitur Belum Tersedia
                        </button>
                        <p class="text-center text-[10px] text-gray-400 mt-3 italic">Silakan lengkapi profil terlebih dahulu
                        </p>
                    @endif
                </div>

                {{-- Riwayat Terakhir Card --}}
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-xl hover:border-pink-100 transition-all duration-300">
                    {{-- Header dengan Ikon --}}
                    <div class="flex items-start justify-between mb-8">
                        <div class="p-3 bg-emerald-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 mb-2">Riwayat Terakhir</h2>
                    <p class="text-gray-500 leading-relaxed mb-6">Pantau status pemeriksaan dan riwayat kunjungan medis Anda
                        sebelumnya.</p>

                    {{-- Daftar Riwayat Singkat --}}
                    <div class="space-y-3 mb-8 flex-grow">
                        @forelse($recentRegistrations as $registration)
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-transparent hover:border-gray-200 transition-all">
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-gray-800 truncate">
                                        {{ $registration->service_name ?? $registration->service->name ?? 'Layanan Umum' }}</p>
                                    <p class="text-[10px] text-gray-500 tracking-wide">
                                        {{ \Carbon\Carbon::parse($registration->date)->isoFormat('D MMM Y') }}
                                    </p>
                                    @if($registration->complaint)
                                        <p class="text-[10px] text-gray-500 truncate mt-1 max-w-[180px] sm:max-w-xs" title="{{ $registration->complaint }}">
                                            <span class="font-semibold text-gray-400">Keluhan:</span> {{ $registration->complaint }}
                                        </p>
                                    @endif
                                </div>

                                @php
                                    $statusClasses = [
                                        'waiting' => 'bg-amber-100 text-amber-700',
                                        'called' => 'bg-blue-100 text-blue-700',
                                        'finished' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                    ];
                                    $currentStatus = $registration->status ?? 'waiting';
                                @endphp

                                <div class="flex flex-col items-end gap-2">
                                    <span
                                        class="text-[9px] font-black uppercase px-2 py-0.5 rounded-md {{ $statusClasses[$currentStatus] ?? 'bg-gray-100' }}">
                                        {{ $currentStatus }}
                                    </span>
                                    
                                    @if($registration->transaction_data)
                                        <button type="button" 
                                            onclick="openTransactionModal({{ $registration->transaction_data->id }})"
                                            class="inline-flex items-center text-[10px] font-bold text-pink-600 hover:text-pink-700 hover:underline transition-colors mt-1">
                                            Lihat Struk 
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>

                                        <!-- Hidden data for this transaction -->
                                        <div id="tx-data-{{ $registration->transaction_data->id }}" class="hidden">
                                            <div class="tx-total">{{ number_format($registration->transaction_data->total_amount, 0, ',', '.') }}</div>
                                            <div class="tx-status">{{ ucfirst($registration->transaction_data->status) }}</div>
                                            <div class="tx-payment">{{ strtoupper($registration->transaction_data->payment_method) }}</div>
                                            <div class="tx-items">
                                                @foreach($registration->transaction_data->items as $item)
                                                    <div class="flex justify-between text-sm py-2 border-b border-gray-100 last:border-0">
                                                        <div class="flex flex-col text-left">
                                                            <span class="font-bold text-gray-800">{{ $item->name }}</span>
                                                            <span class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                        </div>
                                                        <span class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <p class="text-sm text-gray-400 italic">Belum ada riwayat.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tombol Aksi Bawah (Sama dengan Card Profil/Pendaftaran) --}}
                    <a href="{{ route('user.registration.index') }}"
                        class="flex items-center justify-center w-full bg-white border-2 border-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-50 hover:border-gray-200 transition-all active:scale-95">
                        Lihat Semua Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <!-- Transaction Modal Structure -->
    <div id="transactionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeTransactionModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto transform scale-95 transition-transform duration-300 overflow-hidden flex flex-col max-h-[90vh]">
            
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-800">Detail Layanan</h3>
                        <p class="text-xs font-semibold text-gray-400">Rincian Obat & Tindakan</p>
                    </div>
                </div>
                <button onclick="closeTransactionModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-rose-100 hover:text-rose-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 overflow-y-auto flex-grow">
                
                <!-- Status & Payment Method Badges -->
                <div class="flex gap-2 mb-6">
                    <span id="modal-status" class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600">
                        STATUS
                    </span>
                    <span id="modal-payment" class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-600">
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('transactionModal');
    if (!modal) return;
    
    const modalContent = modal.querySelector('.transform');
    
    window.openTransactionModal = function(txId) {
        // Fetch data from hidden divs
        const container = document.getElementById(`tx-data-${txId}`);
        if(!container) {
            console.error('Data container not found for txId:', txId);
            return;
        }

        const total = container.querySelector('.tx-total').innerHTML;
        const status = container.querySelector('.tx-status').innerHTML;
        const payment = container.querySelector('.tx-payment').innerHTML;
        const itemsHtml = container.querySelector('.tx-items').innerHTML;

        // Populate modal
        document.getElementById('modal-total').innerText = total;
        document.getElementById('modal-status').innerText = status;
        document.getElementById('modal-payment').innerText = payment;
        document.getElementById('modal-items-container').innerHTML = itemsHtml;

        // Color status badge based on value
        const statusBadge = document.getElementById('modal-status');
        if(status.toLowerCase() === 'paid') {
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

    window.closeTransactionModal = function() {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'auto'; // Restore scroll
        }, 150);
    };
    
    // Listen for Escape key to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !modal.classList.contains('opacity-0')) {
            window.closeTransactionModal();
        }
    });

    // Make sure clicking backdrop closes modal
    modal.addEventListener('click', function(event) {
        if (event.target === modal || event.target.closest('.backdrop-blur-sm')) {
            window.closeTransactionModal();
        }
    });
});
</script>
@endsection
