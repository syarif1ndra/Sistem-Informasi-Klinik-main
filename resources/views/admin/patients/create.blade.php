@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-white text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Pasien Baru
                </h2>
                <a href="{{ route('admin.patients.index') }}"
                    class="text-white hover:text-pink-100 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Primary Info -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                placeholder="Masukkan nama lengkap pasien" required>
                        </div>

                        <!-- Secondary Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal
                                    Lahir</label>
                                <input type="date" name="dob" id="dob"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                                    Kelamin</label>
                                <select name="gender" id="gender"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon
                                / WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="phone" id="phone"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 pl-10 p-2.5"
                                    placeholder="Contoh: 081234567890" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat
                                Lengkap</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                placeholder="Masukkan alamat lengkap pasien" required></textarea>
                        </div>

                        <!-- Medical History -->
                        <div>
                            <label for="medical_history" class="block text-sm font-semibold text-gray-700 mb-2">Riwayat
                                Penyakit / Keluhan</label>
                            <textarea name="medical_history" id="medical_history" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                placeholder="Masukkan riwayat penyakit atau keluhan pasien (opsional)"></textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.patients.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-lg font-bold hover:from-pink-600 hover:to-rose-700 shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection