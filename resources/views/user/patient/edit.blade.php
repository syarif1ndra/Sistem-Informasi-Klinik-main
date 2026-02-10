@extends('layouts.user')

@section('title', 'Edit Data Pasien')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-8 py-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Data Pasien</h2>
                        <p class="text-pink-100 mt-2">Perbarui data diri Anda jika ada perubahan.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-pink-100 transition">
                        Kembali ke Dashboard
                    </a>
                </div>

                <form action="{{ route('user.patient.update') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">Terdapat kesalahan pada input Anda.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $patient->nik) }}"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                            @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="dob" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="dob" id="dob" value="{{ old('dob', $patient->dob) }}"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                            @error('dob') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="gender" id="gender"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                                <option value="L" {{ old('gender', $patient->gender) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('gender', $patient->gender) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- No. HP -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>


                        <!-- Alamat -->
                        <div class="col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Alamat
                                Lengkap</label>
                            <textarea name="address" id="address" rows="3"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>{{ old('address', $patient->address) }}</textarea>
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:from-pink-600 hover:to-rose-700 transition transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection