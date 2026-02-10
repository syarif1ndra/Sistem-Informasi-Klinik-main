@extends('layouts.user')

@section('title', 'Pendaftaran Klinik')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-8 py-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pendaftaran Klinik</h2>
                        <p class="text-pink-100 mt-2">Daftar layanan kesehatan secara online.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-pink-100 transition">
                        Kembali ke Dashboard
                    </a>
                </div>

                <form action="{{ route('user.registration.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

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
                        <!-- Informasi Pasien -->
                        <div class="col-span-2 bg-pink-50 rounded-lg p-4 border border-pink-100">
                            <h3 class="text-lg font-semibold text-pink-800 mb-3">Data Pasien</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Pasien</label>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ Auth::user()->userPatient->name }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIK (Nomor Induk
                                        Kependudukan)</label>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">
                                        {{ Auth::user()->userPatient->nik ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal
                                Kunjungan</label>
                            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                            @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Layanan -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="service_name" class="block text-sm font-semibold text-gray-700 mb-1">Pilih
                                Layanan</label>
                            <select name="service_name" id="service_name"
                                class="block w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm"
                                required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service }}" {{ old('service_name') == $service ? 'selected' : '' }}>
                                        {{ $service }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-rose-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:from-pink-600 hover:to-rose-700 transition transform hover:-translate-y-0.5">
                            Daftar Kunjungan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection