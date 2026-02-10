@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-8 py-10 text-white">
                <h1 class="text-4xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-pink-100 text-lg">Kelola kesehatan Anda dan keluarga dengan mudah.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Profil Pasien</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $patient ? 'Terverifikasi' : 'Belum Lengkap' }}
                    </span>
                </div>
                
                @if($patient)
                    <div class="space-y-3 mb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Nama Lengkap</p>
                            <p class="font-medium text-gray-900">{{ $patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">NIK</p>
                            <p class="font-medium text-gray-900">{{ $patient->nik }}</p>
                        </div>
                    </div>
                    <a href="{{ route('user.patient.edit') }}" class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-200 transition">
                        Edit Profil
                    </a>
                @else
                    <p class="text-gray-600 mb-6">Data diri Anda belum lengkap. Silakan lengkapi data untuk melakukan pendaftaran.</p>
                    <a href="{{ route('user.patient.create') }}" class="block w-full text-center bg-pink-600 text-white py-2 rounded-lg font-bold hover:bg-pink-700 transition shadow-md">
                        Lengkapi Data Sekarang
                    </a>
                @endif
            </div>

            <!-- Registration Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Pendaftaran Klinik</h2>
                    <div class="p-2 bg-pink-100 rounded-lg">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 mb-6">Daftar antrian periksa dokter atau layanan kesehatan lainnya secara online.</p>
                
                @if($patient)
                    <a href="{{ route('user.registration.create') }}" class="block w-full text-center bg-gradient-to-r from-pink-500 to-rose-600 text-white py-3 rounded-lg font-bold hover:from-pink-600 hover:to-rose-700 transition transform hover:-translate-y-0.5 shadow-lg">
                        Daftar Kunjungan Baru
                    </a>
                @else
                    <button disabled class="block w-full text-center bg-gray-300 text-gray-500 py-3 rounded-lg font-bold cursor-not-allowed">
                        Lengkapi Profil Terlebih Dahulu
                    </button>
                @endif
            </div>

            <!-- Recent History Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 col-span-1 md:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Riwayat Terakhir</h2>
                    <a href="{{ route('user.registration.index') }}" class="text-sm text-pink-600 hover:text-pink-700 font-medium">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentRegistrations as $registration)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $registration->service->name ?? 'Layanan' }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($registration->date)->isoFormat('D MMM Y') }}</p>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full 
                                {{ $registration->status == 'waiting' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $registration->status == 'called' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $registration->status == 'finished' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $registration->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $registration->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 text-sm">
                            Belum ada riwayat pendaftaran.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection