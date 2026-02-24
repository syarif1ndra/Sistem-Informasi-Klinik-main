@extends('layouts.dokter')
@section('title', 'Detail Pasien - ' . $patient->name)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            min-height: 44px;
            border: 2px solid #f3f4f6;
            border-radius: 0.75rem;
            padding: 4px 8px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #ec4899;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, .1);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ec4899;
            color: #fff;
            border: none;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 12px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255, 255, 255, .7);
            margin-right: 5px;
        }

        .select2-dropdown {
            border: 2px solid #ec4899;
            border-radius: 0.75rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .1);
        }

        .select2-search--dropdown .select2-search__field {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 6px 10px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')

    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div x-data="{ openModal: false, openEditModal: false, editScreeningId: null }"
        @keydown.escape.window="openModal = false; openEditModal = false">

        {{-- Overlay --}}
        <div x-show="openModal || openEditModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40"
            @click="openModal = false; openEditModal = false"></div>

        {{-- ===== MODAL TAMBAH ===== --}}
        <div x-show="openModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" @click.stop>
                {{-- Modal Header --}}
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 flex-shrink-0">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah Skrining &amp; Diagnosis</h2>
                        <p class="text-sm text-gray-400">Pasien: <span
                                class="font-semibold text-gray-600">{{ $patient->name }}</span></p>
                    </div>
                    <button @click="openModal = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="overflow-y-auto flex-1 px-6 py-4">
                    <form id="formTambahSkrining" action="{{ route('dokter.patients.screenings.store', $patient) }}"
                        method="POST">
                        @csrf
                        <div class="space-y-5">

                            {{-- Waktu --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal &amp; Waktu
                                    Pemeriksaan <span class="text-rose-500">*</span></label>
                                <input type="datetime-local" name="examined_at" value="{{ now()->format('Y-m-d\TH:i') }}"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"
                                    required>
                            </div>

                            {{-- TTV --}}
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-pink-500 mb-3">Tanda-Tanda Vital
                                    (TTV)</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tinggi Badan
                                            (cm)</label>
                                        <input type="text" name="height" placeholder="cth: 160"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Berat Badan
                                            (kg)</label>
                                        <input type="text" name="weight" placeholder="cth: 55"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tekanan Darah
                                            (mmHg)</label>
                                        <input type="text" name="blood_pressure" placeholder="cth: 120/80"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Suhu Tubuh
                                            (°C)</label>
                                        <input type="text" name="temperature" placeholder="cth: 36.5"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Denyut Nadi
                                            (bpm)</label>
                                        <input type="text" name="pulse" placeholder="cth: 80"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Frek. Pernapasan
                                            (/mnt)</label>
                                        <input type="text" name="respiratory_rate" placeholder="cth: 20"
                                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                    </div>
                                </div>
                            </div>

                            {{-- Anamnesis & Diagnosis --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Utama</label>
                                <textarea name="main_complaint" rows="2" placeholder="Keluhan yang disampaikan pasien..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Riwayat Penyakit</label>
                                <textarea name="medical_history" rows="2" placeholder="Riwayat penyakit terdahulu..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Diagnosis Utama</label>
                                <textarea name="diagnosis_text" rows="2" placeholder="Diagnosis klinis..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                     ICD-10 <span class="text-gray-400 font-normal text-xs">(Opsional — bisa pilih lebih
                                        dari satu)</span>
                                </label>
                                <select name="icd10_codes[]" id="icd10SelectAdd" multiple style="width:100%">
                                    @foreach($icd10Codes as $code)
                                        <option value="{{ $code->id }}">{{ $code->code }} — {{ $code->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Modal Footer --}}
                <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 flex-shrink-0">
                    <button @click="openModal = false"
                        class="px-5 py-2.5 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition text-sm">Batal</button>
                    <button form="formTambahSkrining" type="submit"
                        class="px-7 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-bold shadow hover:shadow-lg transform hover:-translate-y-0.5 transition text-sm">
                        Simpan Skrining
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== MODAL EDIT ===== --}}
        @foreach($screenings as $screening)
            <div x-show="openEditModal && editScreeningId === {{ $screening->id }}" x-cloak
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" @click.stop>
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 flex-shrink-0">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Edit Skrining &amp; Diagnosis</h2>
                            <p class="text-sm text-gray-400">
                                {{ \Carbon\Carbon::parse($screening->examined_at)->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                        <button @click="openEditModal = false"
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="overflow-y-auto flex-1 px-6 py-4">
                        <form id="formEditSkrining{{ $screening->id }}"
                            action="{{ route('dokter.patients.screenings.update', [$patient, $screening]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal &amp; Waktu <span
                                            class="text-rose-500">*</span></label>
                                    <input type="datetime-local" name="examined_at"
                                        value="{{ \Carbon\Carbon::parse($screening->examined_at)->format('Y-m-d\TH:i') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"
                                        required>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs font-black uppercase tracking-widest text-pink-500 mb-3">Tanda-Tanda Vital
                                        (TTV)</p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tinggi Badan
                                                (cm)</label>
                                            <input type="text" name="height" value="{{ $screening->height }}"
                                                placeholder="cth: 160"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Berat Badan
                                                (kg)</label>
                                            <input type="text" name="weight" value="{{ $screening->weight }}"
                                                placeholder="cth: 55"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tekanan Darah
                                                (mmHg)</label>
                                            <input type="text" name="blood_pressure" value="{{ $screening->blood_pressure }}"
                                                placeholder="cth: 120/80"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Suhu Tubuh
                                                (°C)</label>
                                            <input type="text" name="temperature" value="{{ $screening->temperature }}"
                                                placeholder="cth: 36.5"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Denyut Nadi
                                                (bpm)</label>
                                            <input type="text" name="pulse" value="{{ $screening->pulse }}"
                                                placeholder="cth: 80"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Frek. Pernapasan
                                                (/mnt)</label>
                                            <input type="text" name="respiratory_rate"
                                                value="{{ $screening->respiratory_rate }}" placeholder="cth: 20"
                                                class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Utama</label>
                                    <textarea name="main_complaint" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ $screening->main_complaint }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Riwayat Penyakit</label>
                                    <textarea name="medical_history" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ $screening->medical_history }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Diagnosis Utama</label>
                                    <textarea name="diagnosis_text" rows="2"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 text-sm focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ $screening->diagnosis_text }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                         ICD-10 <span class="text-gray-400 font-normal text-xs">(Opsional)</span>
                                    </label>
                                    <select name="icd10_codes[]" id="icd10SelectEdit{{ $screening->id }}" multiple
                                        style="width:100%">
                                        @foreach($icd10Codes as $code)
                                            <option value="{{ $code->id }}" {{ in_array($code->id, $screening->icd10Codes->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $code->code }} — {{ $code->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 flex-shrink-0">
                        <button @click="openEditModal = false"
                            class="px-5 py-2.5 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition text-sm">Batal</button>
                        <button form="formEditSkrining{{ $screening->id }}" type="submit"
                            class="px-7 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-bold shadow hover:shadow-lg transform hover:-translate-y-0.5 transition text-sm">
                            Perbarui Skrining
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

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

        {{-- Tabel Skrining --}}
        <div class="bg-white rounded-xl shadow overflow-hidden border-t-4 border-rose-500">
            <div class="flex flex-col md:flex-row justify-between items-center px-6 py-4 border-b border-gray-100 gap-3">
                <h2 class="text-lg font-bold text-gray-800">Skrining &amp; Diagnosis</h2>
                <button @click="openModal = true; $nextTick(() => $('#icd10SelectAdd').val(null).trigger('change'))"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-semibold shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Skrining &amp; Diagnosis
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-pink-50 to-rose-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Tanggal
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">TTV
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Diagnosis</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kode
                                ICD-10</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Pemeriksa</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Aksi
                            </th>
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
                                        <div><span class="font-semibold">TD:</span> {{ $screening->blood_pressure }} mmHg</div>
                                    @endif
                                    @if($screening->temperature)
                                    <div><span class="font-semibold">Suhu:</span> {{ $screening->temperature }} °C</div> @endif
                                    @if($screening->pulse)
                                    <div><span class="font-semibold">Nadi:</span> {{ $screening->pulse }} bpm</div> @endif
                                    @if($screening->respiratory_rate)
                                        <div><span class="font-semibold">RR:</span> {{ $screening->respiratory_rate }} /mnt</div>
                                    @endif
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
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700 border border-pink-200">{{ $code->code }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada  ICD-10</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500">{{ $screening->examiner->name ?? '-' }}</td>
                                <td class="px-4 py-4 text-center">
                                    <button
                                        @click="openEditModal = true; editScreeningId = {{ $screening->id }}; $nextTick(() => $('#icd10SelectEdit{{ $screening->id }}').trigger('change'))"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-amber-50 text-amber-700 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data skrining
                                    untuk pasien ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end x-data --}}
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#icd10SelectAdd').select2({
                dropdownParent: $('#icd10SelectAdd').closest('.overflow-y-auto'),
                placeholder: 'Cari kode ICD-10...',
                allowClear: true,
                width: '100%'
            });

            @foreach($screenings as $screening)
                $('#icd10SelectEdit{{ $screening->id }}').select2({
                    dropdownParent: $('#icd10SelectEdit{{ $screening->id }}').closest('.overflow-y-auto'),
                    placeholder: 'Cari kode ICD-10...',
                    allowClear: true,
                    width: '100%'
                });
            @endforeach
        });
    </script>
@endpush