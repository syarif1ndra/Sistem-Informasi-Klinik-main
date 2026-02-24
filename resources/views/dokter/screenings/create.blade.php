@extends('layouts.dokter')
@section('title', 'Tambah Skrining - ' . $patient->name)

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
    </style>
@endpush

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dokter.patients.show', $patient) }}"
                class="text-sm text-pink-500 hover:underline flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Detail Pasien
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Skrining &amp; Diagnosis</h1>
            <p class="text-sm text-gray-500 mt-1">Pasien: <span
                    class="font-semibold text-gray-700">{{ $patient->name }}</span></p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-rose-50 border border-rose-100 rounded-xl p-4 text-sm text-rose-700">
                <ul class="list-disc pl-5 space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('dokter.patients.screenings.store', $patient) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Tanggal Pemeriksaan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-black uppercase tracking-widest text-pink-500 mb-4">Waktu Pemeriksaan</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal &amp; Waktu Pemeriksaan <span
                            class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="examined_at"
                        value="{{ old('examined_at', now()->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none"
                        required>
                </div>
            </div>

            {{-- Data TTV --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-black uppercase tracking-widest text-pink-500 mb-4">Tanda-Tanda Vital (TTV)</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tinggi Badan (cm)</label>
                        <input type="text" name="height" value="{{ old('height') }}" placeholder="cth: 160"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Berat Badan (kg)</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" placeholder="cth: 55"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tekanan Darah (mmHg)</label>
                        <input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}"
                            placeholder="cth: 120/80"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Suhu Tubuh (°C)</label>
                        <input type="text" name="temperature" value="{{ old('temperature') }}" placeholder="cth: 36.5"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Denyut Nadi (bpm)</label>
                        <input type="text" name="pulse" value="{{ old('pulse') }}" placeholder="cth: 80"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Frekuensi Pernapasan (/mnt)</label>
                        <input type="text" name="respiratory_rate" value="{{ old('respiratory_rate') }}"
                            placeholder="cth: 20"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">
                    </div>
                </div>
            </div>

            {{-- Anamnesis & Diagnosis --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-black uppercase tracking-widest text-pink-500 mb-4">Anamnesis &amp; Diagnosis</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Utama</label>
                    <textarea name="main_complaint" rows="2" placeholder="Keluhan yang disampaikan pasien..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ old('main_complaint') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Riwayat Penyakit</label>
                    <textarea name="medical_history" rows="2" placeholder="Riwayat penyakit terdahulu..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ old('medical_history') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Diagnosis Utama</label>
                    <textarea name="diagnosis_text" rows="2" placeholder="Diagnosis klinis..."
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-gray-700 focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition outline-none">{{ old('diagnosis_text') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                         ICD-10 <span class="text-gray-400 font-normal">(Opsional, bisa pilih lebih dari satu)</span>
                    </label>
                    <select name="icd10_codes[]" id="icd10Select" multiple class="w-full" style="width:100%">
                        @foreach($icd10Codes as $code)
                            <option value="{{ $code->id }}" {{ in_array($code->id, old('icd10_codes', [])) ? 'selected' : '' }}>
                                {{ $code->code }} — {{ $code->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dokter.patients.show', $patient) }}"
                    class="px-6 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-100 transition">Batal</a>
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                    Simpan Skrining
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#icd10Select').select2({
                placeholder: 'Cari kode ICD-10...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush