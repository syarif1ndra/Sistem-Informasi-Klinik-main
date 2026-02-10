@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <span class="p-3 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                Detail Laporan Imunisasi
            </h1>
            <a href="{{ route('admin.immunizations.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-pink-600 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 print:shadow-none print:border-none">
            <!-- Card Header (Certificate Style) -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-8 py-8 flex flex-col items-center justify-center text-white print:bg-white print:text-black">
                <div class="text-center">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 opacity-90 print:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <h2 class="text-3xl font-bold uppercase tracking-widest border-b-2 border-white/30 pb-2 inline-block print:border-pink-600 print:text-gray-900">Kartu Kontrol Imunisasi</h2>
                    <p class="mt-2 text-pink-100 font-medium print:text-gray-500">Sistem Informasi Klinik</p>
                </div>
            </div>

            <div class="p-8 print:p-0">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Child Info -->
                    <div class="bg-pink-50 p-6 rounded-xl border border-pink-100 print:bg-white print:border-gray-200">
                        <h3 class="text-pink-800 font-bold mb-4 uppercase text-sm tracking-wide border-b border-pink-200 pb-2 flex items-center gap-2 print:text-gray-900 print:border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Anak
                        </h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs text-gray-500 uppercase font-semibold">Nama Lengkap</dt>
                                <dd class="text-lg font-bold text-gray-900">{{ $immunization->child_name }}</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase font-semibold">NIK / ID</dt>
                                    <dd class="text-gray-900 font-medium">{{ $immunization->child_nik ?? '-' }}</dd>
                                </div>
                                <div>
                                     <dt class="text-xs text-gray-500 uppercase font-semibold">Tanggal Lahir</dt>
                                     <dd class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($immunization->birth_date)->translatedFormat('d F Y') }}</dd>
                                </div>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 uppercase font-semibold">Tempat Lahir</dt>
                                <dd class="text-gray-900">{{ $immunization->birth_place }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Parent Info -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 print:bg-white print:border-gray-200">
                         <h3 class="text-gray-700 font-bold mb-4 uppercase text-sm tracking-wide border-b border-gray-200 pb-2 flex items-center gap-2 print:text-gray-900 print:border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Data Orang Tua
                        </h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs text-gray-500 uppercase font-semibold">Nama Orang Tua</dt>
                                <dd class="text-lg font-bold text-gray-900">{{ $immunization->parent_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 uppercase font-semibold">Alamat</dt>
                                <dd class="text-gray-900">{{ $immunization->address }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Vaccination Details -->
                <div class="border-t-2 border-dashed border-gray-200 pt-8 print:border-gray-300">
                    <h3 class="text-center text-xl font-bold text-gray-800 mb-6 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Detail Pemberian Vaksin
                    </h3>
                    
                    <div class="bg-white border rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x border-gray-200">
                            <div class="p-4 flex-1 text-center">
                                <span class="block text-xs font-semibold text-gray-500 uppercase">Tanggal Imunisasi</span>
                                <span class="block text-xl font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($immunization->immunization_date)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="p-4 flex-[2] text-center md:text-left">
                                <span class="block text-xs font-semibold text-gray-500 uppercase mb-1">Catatan / Vaksin</span>
                                <p class="text-gray-900 text-lg leading-relaxed">{{ $immunization->notes ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Section (Print Only) -->
                <div class="hidden print:flex mt-16 justify-between px-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-16">Mengetahui Orang Tua</p>
                        <p class="font-bold border-t border-gray-400 px-4 pt-1">{{ $immunization->parent_name }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-16">{{ date('d F Y') }}</p>
                        <p class="font-bold border-t border-gray-400 px-4 pt-1">Petugas Klinik</p>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-8 flex justify-center print:hidden">
                    <button onclick="window.print()" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Kartu Imunisasi
                    </button>
                    <a href="{{ route('admin.immunizations.edit', $immunization) }}" class="ml-4 flex items-center gap-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-bold py-3 px-8 rounded-lg transition">
                        Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
