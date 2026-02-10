@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-white text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data Kelahiran
                </h2>
                <a href="{{ route('admin.birth_records.index') }}"
                    class="text-white hover:text-pink-100 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.birth_records.update', $birthRecord) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Section: Data Bayi -->
                        <div class="bg-pink-50 rounded-xl p-6 border border-pink-100">
                            <h3 class="text-lg font-bold text-pink-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Data Bayi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bayi</label>
                                    <input type="text" name="baby_name" value="{{ $birthRecord->baby_name }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                                    <select name="gender"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        required>
                                        <option value="L" {{ $birthRecord->gender == 'L' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="P" {{ $birthRecord->gender == 'P' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir</label>
                                    <input type="text" name="birth_place" value="{{ $birthRecord->birth_place }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="birth_date"
                                        value="{{ $birthRecord->birth_date ? $birthRecord->birth_date->format('Y-m-d') : '' }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Lahir</label>
                                    <input type="time" name="birth_time"
                                        value="{{ \Carbon\Carbon::parse($birthRecord->birth_time)->format('H:i') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Medis & Fisik -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Data Medis & Fisik
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Berat (gram)</label>
                                    <input type="text" name="baby_weight" value="{{ $birthRecord->baby_weight }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Panjang (cm)</label>
                                    <input type="text" name="baby_length" value="{{ $birthRecord->baby_length }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lingkar Kepala
                                        (cm)</label>
                                    <input type="text" name="head_circumference"
                                        value="{{ $birthRecord->head_circumference }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lingkar Dada (cm)</label>
                                    <input type="text" name="chest_circumference"
                                        value="{{ $birthRecord->chest_circumference }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">GPA</label>
                                    <input type="text" name="gpa" value="{{ $birthRecord->gpa }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                        placeholder="G.. P.. A..">
                                </div>
                                <div class="col-span-2 md:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahap Persalinan</label>
                                    <div class="grid grid-cols-3 gap-4">
                                        <input type="text" name="kala_1" value="{{ $birthRecord->kala_1 }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            placeholder="Kala I">
                                        <input type="text" name="kala_2" value="{{ $birthRecord->kala_2 }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            placeholder="Kala II">
                                        <input type="text" name="kala_3" value="{{ $birthRecord->kala_3 }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            placeholder="Kala III">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Orang Tua -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ibu -->
                            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-bold text-pink-600 mb-4 border-b pb-2">Data Ibu</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Nama Lengkap</label>
                                        <input type="text" name="mother_name" value="{{ $birthRecord->mother_name }}"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">NIK</label>
                                        <input type="text" name="mother_nik" value="{{ $birthRecord->mother_nik }}"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Alamat</label>
                                        <textarea name="mother_address" rows="2"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">{{ $birthRecord->mother_address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Ayah -->
                            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">Data Ayah</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Nama Lengkap</label>
                                        <input type="text" name="father_name" value="{{ $birthRecord->father_name }}"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">NIK</label>
                                        <input type="text" name="father_nik" value="{{ $birthRecord->father_nik }}"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Alamat</label>
                                        <textarea name="father_address" rows="2"
                                            class="w-full mt-1 rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">{{ $birthRecord->father_address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lainnya -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">Informasi Tambahan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon /
                                        WhatsApp</label>
                                    <input type="text" name="phone_number" value="{{ $birthRecord->phone_number }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Surat Keterangan
                                        (Opsional)</label>
                                    <input type="text" name="birth_certificate_number"
                                        value="{{ $birthRecord->birth_certificate_number }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-2.5">{{ $birthRecord->notes }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.birth_records.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-lg font-bold hover:from-pink-600 hover:to-rose-700 shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection