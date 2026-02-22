@extends('layouts.user')

@section('title', 'Pendaftaran Klinik')

@section('content')
    <div class="min-h-screen bg-slate-50/50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-br from-pink-500 via-rose-500 to-rose-600 px-8 py-10 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>

                    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-3xl font-extrabold text-white tracking-tight">Pendaftaran Klinik</h2>
                            <p class="text-pink-100 mt-1 font-medium italic opacity-90">Satu langkah lebih dekat menuju
                                sehat.</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md border border-white/30">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.registration.store') }}" method="POST" class="p-8 md:p-10 space-y-8">
                    @csrf

                    @if ($errors->any())
                        <div
                            class="bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center space-x-3 animate-pulse">
                            <svg class="h-6 w-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-rose-700 font-semibold">Mohon periksa kembali inputan Anda.</p>
                        </div>
                    @endif

                    <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100 relative group transition-all">
                        <div
                            class="absolute -top-3 left-6 bg-white px-4 py-1 rounded-full border border-gray-100 shadow-sm">
                            <span class="text-[10px] font-black uppercase tracking-widest text-pink-500">Informasi
                                Pasien</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                            <div class="space-y-1">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama
                                    Lengkap</label>
                                <p class="text-gray-800 font-bold flex items-center">
                                    <span class="w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                                    {{ Auth::user()->userPatient->name }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIK
                                </label>
                                <p class="text-gray-800 font-mono font-bold tracking-wider">
                                    {{ Auth::user()->userPatient->nik ?? '---' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-bold text-gray-700 ml-1">Tanggal Kunjungan</label>
                            <div class="relative group">
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full pl-4 pr-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                                    required>
                            </div>
                            @error('date') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="service_name" class="block text-sm font-bold text-gray-700 ml-1">Pilih
                                Layanan</label>
                            <div class="relative group">
                                <select name="service_name" id="service_name"
                                    class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold appearance-none focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                                    required>
                                    <option value="" disabled selected>-- Pilih Layanan Klinik --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service }}" {{ old('service_name') == $service ? 'selected' : '' }}>
                                            {{ $service }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            @error('service_name') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="complaint" class="block text-sm font-bold text-gray-700 ml-1">Keluhan (Opsional)</label>
                        <div class="relative group">
                            <textarea name="complaint" id="complaint" rows="3"
                                class="w-full pl-4 pr-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                                placeholder="Jelaskan keluhan yang Anda rasakan...">{{ old('complaint') }}</textarea>
                        </div>
                        @error('complaint') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        class="flex flex-col-reverse md:flex-row md:items-center justify-between gap-4 pt-6 border-t border-gray-50">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center justify-center px-6 py-3.5 rounded-xl text-gray-500 font-bold hover:bg-gray-100 hover:text-gray-700 transition-all active:scale-95 group">
                            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batalkan Pendaftaran
                        </a>

                        <button type="submit"
                            class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-2xl font-black shadow-xl shadow-rose-200 hover:shadow-2xl hover:shadow-rose-300 transform hover:-translate-y-1 transition-all active:scale-95">
                            Konfirmasi & Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center mt-8 text-gray-400 text-sm font-medium">
                Butuh bantuan? <a href="#" class="text-pink-500 hover:underline">Hubungi Admin Klinik</a>
            </p>
        </div>
    </div>
@endsection