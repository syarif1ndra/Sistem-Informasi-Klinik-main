@extends('layouts.dokter')
@section('title', 'Detail Pasien - ' . $patient->name)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            min-height: 44px;
            border: 2px solid #f3f4f6;
            border-radius: 0.75rem;
        }

        .select2-container--default .select2-selection--multiple:focus,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #ec4899;
            outline: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ec4899;
            color: #fff;
            border: none;
            border-radius: 9999px;
            padding: 2px 10px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <a href="{{ route('dokter.patients.index') }}"
                class="text-sm text-pink-500 hover:underline flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Pasien
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pasien</h1>
        </div>
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
                <p class="text-gray-800 font-mono">{{ $patient->nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Lahir</p>
                <p class="text-gray-800">
                    {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->translatedFormat('d M Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis Kelamin</p>
                <p class="text-gray-800">
                    {{ $patient->gender === 'L' ? 'Laki-laki' : ($patient->gender === 'P' ? 'Perempuan' : '-') }}</p>
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

    {{-- Skrining & Diagnosis --}}
    <div class="bg-white rounded-xl shadow overflow-hidden border-t-4 border-rose-500">
        <div class="flex flex-col md:flex-row justify-between items-center px-6 py-4 border-b border-gray-100 gap-3">
            <h2 class="text-lg font-bold text-gray-800">Skrining &amp; Diagnosis</h2>
            <a href="{{ route('dokter.patients.screenings.create', $patient) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-semibold shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Skrining &amp; Diagnosis
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-50 to-rose-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Tanggal
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">TTV</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Diagnosis
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kode ICD-10
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Pemeriksa
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($screenings as $screening)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($screening->examined_at)->translatedFormat('d M Y') }}
                                <div class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($screening->examined_at)->format('H:i') }}</div>
                            </td>
                            <td class="px-4 py-4 text-xs text-gray-600 space-y-0.5">
                                @if($screening->blood_pressure)
                                <div><span class="font-semibold">TD:</span> {{ $screening->blood_pressure }} mmHg</div> @endif
                                @if($screening->temperature)
                                <div><span class="font-semibold">Suhu:</span> {{ $screening->temperature }} °C</div> @endif
                                @if($screening->pulse)
                                <div><span class="font-semibold">Nadi:</span> {{ $screening->pulse }} bpm</div> @endif
                                @if($screening->respiratory_rate)
                                <div><span class="font-semibold">RR:</span> {{ $screening->respiratory_rate }} /mnt</div> @endif
                                @if($screening->weight)
                                <div><span class="font-semibold">BB:</span> {{ $screening->weight }} kg</div> @endif
                                @if($screening->height)
                                <div><span class="font-semibold">TB:</span> {{ $screening->height }} cm</div> @endif
                                @if(!$screening->blood_pressure && !$screening->temperature && !$screening->pulse && !$screening->respiratory_rate && !$screening->weight && !$screening->height)
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 max-w-xs">
                                <p class="line-clamp-2">{{ $screening->diagnosis_text ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-4">
                                @if($screening->icd10Codes->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($screening->icd10Codes as $code)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700 border border-pink-200">
                                                {{ $code->code }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tidak ada kode ICD-10</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">{{ $screening->examiner->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('dokter.patients.screenings.edit', [$patient, $screening]) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-amber-50 text-amber-700 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data skrining untuk
                                pasien ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection