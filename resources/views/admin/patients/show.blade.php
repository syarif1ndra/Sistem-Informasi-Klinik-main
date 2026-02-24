@extends('layouts.admin')
@section('title', 'Detail Pasien - ' . $patient->name)

@section('content')

    {{-- =================== HALAMAN UTAMA =================== --}}

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <a href="{{ route('admin.patients.index') }}"
                class="text-sm text-pink-500 hover:underline flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Pasien
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pasien</h1>
        </div>
        @if($activeQueue)
            <div class="flex items-center gap-3 bg-white rounded-xl border border-pink-200 px-5 py-3 shadow-sm">
                <div class="text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">No. Antrian</p>
                    <p class="text-2xl font-black text-pink-600">{{ sprintf('%03d', $activeQueue->queue_number) }}</p>
                </div>
                <div class="w-px h-10 bg-gray-200"></div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Kunjungan</p>
                    <p class="text-sm font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($activeQueue->date)->translatedFormat('d M Y') }}
                    </p>
                </div>
            </div>
        @endif
    </div>

    {{-- Info Pasien --}}
    <div class="bg-white rounded-xl shadow border-t-4 border-pink-500 p-6 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama</p>
                <p class="text-gray-800 font-semibold">{{ $patient->name }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">NIK</p>
                <p class="text-800 font-mono">{{ $patient->nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Lahir</p>
                <p class="text-gray-800">
                    {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->translatedFormat('d M Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis Kelamin</p>
                <p class="text-gray-800">
                    {{ $patient->gender === 'L' ? 'Laki-laki' : ($patient->gender === 'P' ? 'Perempuan' : '-') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">No. HP</p>
                <p class="text-gray-800">{{ $patient->phone ?? '-' }}</p>
            </div>
            <div class="col-span-2 md:col-span-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat</p>
                <p class="text-gray-800">{{ $patient->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Riwayat Skrining & Diagnosis --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
        <h2 class="text-xl font-black text-gray-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Riwayat Skrining &amp; Diagnosis
        </h2>
        <div class="flex items-center gap-3">
            @if($screenings->isNotEmpty())
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pasien ini memiliki skrining
                </span>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        @forelse($screenings as $screening)
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                {{-- Header Card --}}
                <div
                    class="bg-gradient-to-r from-pink-50/50 to-rose-50/50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-pink-100 text-pink-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">
                                {{ \Carbon\Carbon::parse($screening->examined_at)->translatedFormat('l, d F Y') }}</h3>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mt-1">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($screening->examined_at)->format('H:i') }} WIB
                                </span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="flex items-center gap-1 font-medium text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $screening->examiner->name ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Body Card --}}
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">

                    {{-- Kiri: TTV --}}
                    <div class="space-y-5">
                        <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2 uppercase tracking-wide">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Tanda-Tanda Vital (TTV)
                        </h4>

                        @if(!$screening->blood_pressure && !$screening->temperature && !$screening->pulse && !$screening->respiratory_rate && !$screening->weight && !$screening->height)
                            <div class="bg-gray-50 rounded-xl p-6 text-center text-sm text-gray-400 italic border border-gray-100">
                                Data TTV tidak dicatat
                            </div>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @if($screening->blood_pressure)
                                    <div class="bg-blue-50/50 rounded-xl p-3 border border-blue-100/50">
                                        <p class="text-xs text-blue-500 font-semibold mb-1">Tekanan Darah</p>
                                        <p class="font-bold text-gray-800">{{ $screening->blood_pressure }} <span
                                                class="text-xs font-normal text-gray-500">mmHg</span></p>
                                    </div>
                                @endif

                                @if($screening->temperature)
                                    <div class="bg-orange-50/50 rounded-xl p-3 border border-orange-100/50">
                                        <p class="text-xs text-orange-500 font-semibold mb-1">Suhu Tubuh</p>
                                        <p class="font-bold text-gray-800">{{ $screening->temperature }} <span
                                                class="text-xs font-normal text-gray-500">°C</span></p>
                                    </div>
                                @endif

                                @if($screening->pulse)
                                    <div class="bg-rose-50/50 rounded-xl p-3 border border-rose-100/50">
                                        <p class="text-xs text-rose-500 font-semibold mb-1">Denyut Nadi</p>
                                        <p class="font-bold text-gray-800">{{ $screening->pulse }} <span
                                                class="text-xs font-normal text-gray-500">bpm</span></p>
                                    </div>
                                @endif

                                @if($screening->respiratory_rate)
                                    <div class="bg-cyan-50/50 rounded-xl p-3 border border-cyan-100/50">
                                        <p class="text-xs text-cyan-500 font-semibold mb-1">Pernapasan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->respiratory_rate }} <span
                                                class="text-xs font-normal text-gray-500">/mnt</span></p>
                                    </div>
                                @endif

                                @if($screening->weight)
                                    <div class="bg-emerald-50/50 rounded-xl p-3 border border-emerald-100/50">
                                        <p class="text-xs text-emerald-500 font-semibold mb-1">Berat Badan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->weight }} <span
                                                class="text-xs font-normal text-gray-500">kg</span></p>
                                    </div>
                                @endif

                                @if($screening->height)
                                    <div class="bg-purple-50/50 rounded-xl p-3 border border-purple-100/50">
                                        <p class="text-xs text-purple-500 font-semibold mb-1">Tinggi Badan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->height }} <span
                                                class="text-xs font-normal text-gray-500">cm</span></p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Kanan: Anamnesis & Diagnosis --}}
                    <div class="space-y-5 lg:pl-6 pt-6 lg:pt-0">
                        <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2 uppercase tracking-wide">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Anamnesis &amp; Diagnosis
                        </h4>

                        <div class="space-y-4">
                            {{-- Keluhan & Riwayat --}}
                            @if($screening->main_complaint || $screening->medical_history)
                                <div class="bg-indigo-50/30 rounded-xl p-4 border border-indigo-100/50">
                                    @if($screening->main_complaint)
                                        <div class="mb-3">
                                            <p class="text-xs font-bold text-indigo-800 mb-1 uppercase tracking-wider">Keluhan Utama</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $screening->main_complaint }}</p>
                                        </div>
                                    @endif
                                    @if($screening->medical_history)
                                        <div class="{{ $screening->main_complaint ? 'pt-3 border-t border-indigo-100' : '' }}">
                                            <p class="text-xs font-bold text-indigo-800 mb-1 uppercase tracking-wider">Riwayat Penyakit
                                            </p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $screening->medical_history }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Diagnosis --}}
                            <div class="bg-rose-50/30 rounded-xl p-4 border border-rose-100/50">
                                <p class="text-xs font-bold text-rose-800 mb-1 uppercase tracking-wider">Diagnosis Medis</p>
                                @if($screening->diagnosis_text)
                                    <p class="text-sm text-gray-800 font-medium leading-relaxed mb-3">
                                        {{ $screening->diagnosis_text }}</p>
                                @else
                                    <p class="text-sm text-gray-400 italic mb-3">Belum ada catatan diagnosis.</p>
                                @endif

                                {{-- ICD-10 Badges --}}
                                @if($screening->icd10Codes && $screening->icd10Codes->isNotEmpty())
                                    <div class="flex flex-wrap gap-2 pt-3 border-t border-rose-100">
                                        @foreach($screening->icd10Codes as $code)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-white text-rose-700 border border-rose-200 shadow-sm" title="{{ $code->name ?? 'ICD-10 Code' }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></span>
                                                <span>{{ $code->code }}</span>
                                                <span class="font-normal opacity-80 pl-1.5 border-l border-rose-200 ml-0.5 truncate max-w-xs">{{ $code->name }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                <div
                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Skrining</h3>
                <p class="text-gray-500 text-sm max-w-sm">Pasien ini belum memiliki catatan skrining dan diagnosis dalam riwayat
                    kunjungannya.</p>
            </div>
        @endforelse
    </div>
@endsection