@extends('layouts.user')

@section('title', 'Edit Data Pasien')

@section('content')
<div class="min-h-screen bg-slate-50/50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-br from-pink-500 via-rose-500 to-rose-600 px-8 py-10 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>

                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-white tracking-tight">Edit Data Pasien</h2>
                        <p class="text-pink-100 mt-1 font-medium italic opacity-90">Perbarui informasi profil kesehatan Anda.</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md border border-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('user.patient.update') }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center space-x-3 animate-pulse">
                        <svg class="h-6 w-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-rose-700 font-semibold">Terdapat beberapa kesalahan input.</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-2 space-y-2">
                        <label for="name" class="block text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}"
                            class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                            placeholder="Contoh: Syafiq" required>
                        @error('name') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="nik" class="block text-sm font-bold text-gray-700 ml-1">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik', $patient->nik) }}"
                            class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none font-mono tracking-wider"
                            required>
                        @error('nik') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="dob" class="block text-sm font-bold text-gray-700 ml-1">Tanggal Lahir</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $patient->dob) }}"
                            class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                            required>
                        @error('dob') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="gender" class="block text-sm font-bold text-gray-700 ml-1">Jenis Kelamin</label>
                        <div class="relative group">
                            <select name="gender" id="gender"
                                class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold appearance-none focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                                required>
                                <option value="L" {{ old('gender', $patient->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $patient->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                        @error('gender') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-bold text-gray-700 ml-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}"
                            class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none"
                            placeholder="0812..." required>
                        @error('phone') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 space-y-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 ml-1">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-4 py-3.5 bg-white rounded-xl border-2 border-gray-100 text-gray-700 font-semibold focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all outline-none resize-none"
                            placeholder="Tuliskan alamat domisili saat ini..." required>{{ old('address', $patient->address) }}</textarea>
                        @error('address') <p class="text-xs text-rose-500 font-medium ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse md:flex-row md:items-center justify-between gap-4 pt-6 border-t border-gray-50">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-center px-6 py-3.5 rounded-xl text-gray-500 font-bold hover:bg-gray-100 hover:text-gray-700 transition-all active:scale-95 group">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>

                    <button type="submit"
                        class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-2xl font-black shadow-xl shadow-rose-200 hover:shadow-2xl hover:shadow-rose-300 transform hover:-translate-y-1 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
