@extends('layouts.bidan')
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
                <div class="overflow-y-auto flex-1 px-6 py-4">
                    <form id="formTambahSkrining" action="{{ route('bidan.patients.screenings.store', $patient) }}"
                        method="POST">
                        @csrf
                        @if($activeQueue)
                            <input type="hidden" name="queue_id" value="{{ $activeQueue->id }}">
                        @endif
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal &amp; Waktu
                                    Pemeriksaan <span class="text-rose-500">*</span></label>
                                <input type="datetime-local" name="examined_at" value="{{ now()->format('Y-m-d\TH:i') }}"
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
                            action="{{ route('bidan.patients.screenings.update', [$patient, $screening]) }}" method="POST">
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
                <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <a href="{{ route('bidan.patients.index') }}"
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
                        <p class="text-sm font-semibold text-gray-700">{{ \Carbon\Carbon::parse($activeQueue->date)->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
            @endif
        </div>

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

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
            <h2 class="text-xl font-black text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Riwayat Skrining &amp; Diagnosis
            </h2>
            <div class="flex items-center gap-3">
                @if($screenings->isNotEmpty())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pasien ini sudah memiliki skrining aktif
                    </span>
                @elseif($activeQueue)
                    <button @click="openModal = true; $nextTick(() => $('#icd10SelectAdd').val(null).trigger('change'))"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Skrining &amp; Diagnosis
                    </button>
                @else
                    <span class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg text-sm italic border border-gray-200 shadow-sm">Tidak ada antrian aktif hari ini</span>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            @forelse($screenings as $screening)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    {{-- Header Card --}}
                    <div class="bg-gradient-to-r from-pink-50/50 to-rose-50/50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-white p-3 rounded-xl shadow-sm border border-pink-100 text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ \Carbon\Carbon::parse($screening->examined_at)->translatedFormat('l, d F Y') }}</h3>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mt-1">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ \Carbon\Carbon::parse($screening->examined_at)->format('H:i') }} WIB
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="flex items-center gap-1 font-medium text-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $screening->examiner->name ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button
                                @click="openEditModal = true; editScreeningId = {{ $screening->id }}; $nextTick(() => $('#icd10SelectEdit{{ $screening->id }}').trigger('change'))"
                                class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-bold bg-white text-amber-600 rounded-xl border-2 border-amber-100 hover:bg-amber-50 hover:border-amber-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Skrining
                            </button>
                        </div>
                    </div>

                    {{-- Body Card --}}
                    <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
                        
                        {{-- Kiri: TTV --}}
                        <div class="space-y-5">
                            <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2 uppercase tracking-wide">
                                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
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
                                        <p class="font-bold text-gray-800">{{ $screening->blood_pressure }} <span class="text-xs font-normal text-gray-500">mmHg</span></p>
                                    </div>
                                    @endif
                                    
                                    @if($screening->temperature)
                                    <div class="bg-orange-50/50 rounded-xl p-3 border border-orange-100/50">
                                        <p class="text-xs text-orange-500 font-semibold mb-1">Suhu Tubuh</p>
                                        <p class="font-bold text-gray-800">{{ $screening->temperature }} <span class="text-xs font-normal text-gray-500">°C</span></p>
                                    </div>
                                    @endif
                                    
                                    @if($screening->pulse)
                                    <div class="bg-rose-50/50 rounded-xl p-3 border border-rose-100/50">
                                        <p class="text-xs text-rose-500 font-semibold mb-1">Denyut Nadi</p>
                                        <p class="font-bold text-gray-800">{{ $screening->pulse }} <span class="text-xs font-normal text-gray-500">bpm</span></p>
                                    </div>
                                    @endif
                                    
                                    @if($screening->respiratory_rate)
                                    <div class="bg-cyan-50/50 rounded-xl p-3 border border-cyan-100/50">
                                        <p class="text-xs text-cyan-500 font-semibold mb-1">Pernapasan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->respiratory_rate }} <span class="text-xs font-normal text-gray-500">/mnt</span></p>
                                    </div>
                                    @endif
                                    
                                    @if($screening->weight)
                                    <div class="bg-emerald-50/50 rounded-xl p-3 border border-emerald-100/50">
                                        <p class="text-xs text-emerald-500 font-semibold mb-1">Berat Badan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->weight }} <span class="text-xs font-normal text-gray-500">kg</span></p>
                                    </div>
                                    @endif
                                    
                                    @if($screening->height)
                                    <div class="bg-purple-50/50 rounded-xl p-3 border border-purple-100/50">
                                        <p class="text-xs text-purple-500 font-semibold mb-1">Tinggi Badan</p>
                                        <p class="font-bold text-gray-800">{{ $screening->height }} <span class="text-xs font-normal text-gray-500">cm</span></p>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        {{-- Kanan: Anamnesis & Diagnosis --}}
                        <div class="space-y-5 lg:pl-6 pt-6 lg:pt-0">
                            <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2 uppercase tracking-wide">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
                                                <p class="text-xs font-bold text-indigo-800 mb-1 uppercase tracking-wider">Riwayat Penyakit</p>
                                                <p class="text-sm text-gray-700 leading-relaxed">{{ $screening->medical_history }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Diagnosis --}}
                                <div class="bg-rose-50/30 rounded-xl p-4 border border-rose-100/50">
                                    <p class="text-xs font-bold text-rose-800 mb-1 uppercase tracking-wider">Diagnosis Medis</p>
                                    @if($screening->diagnosis_text)
                                        <p class="text-sm text-gray-800 font-medium leading-relaxed mb-3">{{ $screening->diagnosis_text }}</p>
                                    @else
                                        <p class="text-sm text-gray-400 italic mb-3">Belum ada catatan diagnosis.</p>
                                    @endif
                                    
                                    {{-- ICD-10 Badges --}}
                                    @if($screening->icd10Codes->isNotEmpty())
                                        <div class="flex flex-wrap gap-2 pt-3 border-t border-rose-100">
                                            @foreach($screening->icd10Codes as $code)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-white text-rose-700 border border-rose-200 shadow-sm" title="{{ $code->name }}">
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
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 mb-4 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Skrining</h3>
                    <p class="text-gray-500 text-sm max-w-sm">Pasien ini belum memiliki catatan skrining dan diagnosis dalam riwayat kunjungannya.</p>
                </div>
            @endforelse
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