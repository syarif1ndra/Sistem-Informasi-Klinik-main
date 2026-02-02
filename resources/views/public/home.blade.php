@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-pink-500 via-pink-600 to-rose-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-6">Selamat Datang di Klinik Bidan</h1>
                    <p class="text-xl text-pink-100 mb-8 leading-relaxed">
                        Kami memberikan pelayanan kesehatan terbaik untuk ibu dan anak. Dengan tenaga bidan profesional dan
                        berpengalaman, kami siap mendampingi perjalanan kehamilan hingga persalinan Anda.
                    </p>
                    <a href="#" onclick="openRegistrationModal(event)"
                        class="inline-block bg-white text-pink-600 px-8 py-3 rounded-full font-bold hover:bg-pink-50 transition duration-150">
                        Daftar Sekarang
                    </a>
                </div>
                <div class="text-center">
                    <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl p-12">
                        <div class="text-6xl font-bold mb-4" data-queue-number>
                            {{ $currentQueue ? sprintf('%03d', $currentQueue->queue_number) : '---' }}
                        </div>
                        <p class="text-pink-100 text-lg">Nomor Antrian Saat Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Fitur Unggulan -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Profesional Berpengalaman</h3>
                    <p class="text-gray-600">Tim bidan kami terlatih dan berpengalaman dalam menangani kehamilan dan
                        persalinan.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600">Kami menawarkan layanan kesehatan berkualitas dengan harga yang terjangkau
                        untuk semua kalangan.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Fasilitas Lengkap</h3>
                    <p class="text-gray-600">Dilengkapi dengan peralatan medis modern untuk memberikan pelayanan terbaik.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Kami -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Layanan Kesehatan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Periksa Kehamilan -->
                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Periksa Kehamilan</h3>
                    <p class="text-gray-600 mb-4">Pemeriksaan rutin kehamilan untuk memastikan kesehatan ibu dan janin.</p>
                </div>

                <!-- Persalinan -->
                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Persalinan</h3>
                    <p class="text-gray-600 mb-4">Layanan persalinan dengan tenaga medis profesional dan fasilitas lengkap.
                    </p>
                </div>

                <!-- Keluarga Berencana -->
                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Keluarga Berencana</h3>
                    <p class="text-gray-600 mb-4">Konsultasi dan layanan KB untuk perencanaan keluarga yang sehat.</p>
                </div>

                <!-- Kesehatan Ibu dan Anak -->
                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kesehatan Ibu dan Anak</h3>
                    <p class="text-gray-600 mb-4">Pemeriksaan dan perawatan kesehatan untuk ibu dan anak.</p>
                </div>

                <!-- Imunisasi -->
                <div
                    class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition duration-300">
                    <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Imunisasi</h3>
                    <p class="text-gray-600 mb-4">Program imunisasi lengkap untuk bayi dan anak sesuai jadwal.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Obat Tersedia -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Vaksin & Obat Tersedia</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-[600px] w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-pink-500 to-rose-600">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">
                                    Nama
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">
                                    Kategori</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">
                                    Harga</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">
                                    Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($medicines as $medicine)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $medicine->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
                                            {{ $medicine->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        Rp {{ number_format($medicine->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $medicine->description }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data obat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Pertanyaan yang Sering Diajukan</h2>
            <div class="space-y-6">
                @forelse($faqs as $faq)
                    <div
                        class="bg-white rounded-lg shadow-lg border-l-4 border-pink-500 overflow-hidden hover:shadow-xl transition duration-300">
                        <details class="group cursor-pointer">
                            <summary
                                class="flex items-center justify-between p-6 font-semibold text-gray-800 hover:bg-pink-50 transition duration-150">
                                <span class="flex items-center">
                                    <span class="text-pink-600 mr-3">Q:</span>
                                    {{ $faq->question }}
                                </span>
                                <svg class="w-5 h-5 text-pink-600 group-open:rotate-180 transition duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </summary>
                            <div class="px-6 pb-6 pt-2 text-gray-700 bg-pink-50">
                                <span class="text-pink-600 font-semibold">A:</span> {{ $faq->answer }}
                            </div>
                        </details>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-lg border-l-4 border-pink-500 p-6">
                        <h3 class="text-lg font-bold text-pink-600 mb-2">Q: Apa saja tanda-tanda awal kehamilan?</h3>
                        <p class="text-gray-700">A: Tanda awal kehamilan meliputi telat haid, mual di pagi hari (morning
                            sickness), payudara sensitif, dan kelelahan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Lokasi Kami</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.6565890684574!2d105.19281737398143!3d-5.316152294662252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40cf12cf4f9355%3A0xa51d2b3796b1f411!2sBidan%20Siti%20Hajar!5e0!3m2!1sid!2sid!4v1769923926204!5m2!1sid!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="w-full h-96 md:h-[450px] rounded-lg">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeRegistrationModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Pendaftaran Pasien</h3>
                        <div class="mt-2">
                            <form id="registrationForm" onsubmit="submitRegistration(event)">
                                @csrf
                                <div id="formErrors"
                                    class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                                    role="alert"></div>

                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                            Lengkap</label>
                                        <input id="name" name="name" type="text" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="dob" class="block text-sm font-medium text-gray-700">Tanggal
                                                Lahir</label>
                                            <input id="dob" name="dob" type="date" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis
                                                Kelamin</label>
                                            <select id="gender" name="gender" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">Nomor
                                            WhatsApp</label>
                                        <input id="whatsapp_number" name="whatsapp_number" type="tel" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea id="address" name="address" rows="2" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label for="service_id" class="block text-sm font-medium text-gray-700">Layanan
                                            Kesehatan</label>
                                        <select id="service_id" name="service_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Penggunaan BPJS</label>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center">
                                                <input id="bpjs_yes" name="bpjs_usage" type="radio" value="1"
                                                    class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300">
                                                <label for="bpjs_yes" class="ml-2 block text-sm text-gray-900">Ya</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="bpjs_no" name="bpjs_usage" type="radio" value="0" checked
                                                    class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300">
                                                <label for="bpjs_no" class="ml-2 block text-sm text-gray-900">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:col-start-2 sm:text-sm">
                                        Daftar
                                    </button>
                                    <button type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:col-start-1 sm:text-sm"
                                        onclick="closeRegistrationModal()">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeSuccessModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4" id="registration-proof">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2" id="modal-title">Pendaftaran Berhasil
                        </h3>
                        <p class="text-sm text-gray-500">Simpan bukti ini untuk ditunjukkan kepada petugas.</p>

                        <div class="mt-4 border-t border-b border-gray-200 py-4 text-left">
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="text-gray-500">Nomor Antrian</div>
                                <div class="font-bold text-2xl text-pink-600" id="proof-queue"></div>

                                <div class="text-gray-500">Layanan</div>
                                <div class="font-semibold" id="proof-service"></div>

                                <div class="text-gray-500">Nama Pasien</div>
                                <div class="font-semibold" id="proof-name"></div>

                                <div class="text-gray-500">Tanggal</div>
                                <div class="font-semibold" id="proof-date"></div>

                                <div class="text-gray-500">Pembayaran</div>
                                <div class="font-semibold" id="proof-payment"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" data-html2canvas-ignore>
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="downloadProof()">
                        Download
                    </button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeSuccessModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        const REGISTRATION_KEY = 'clinic_last_registration';
        const REGISTRATION_TIMEOUT_MS = 5 * 60 * 1000; // 5 minutes

        function checkRecentRegistration() {
            const saved = localStorage.getItem(REGISTRATION_KEY);
            if (saved) {
                const data = JSON.parse(saved);
                const now = new Date().getTime();
                if (now - data.timestamp < REGISTRATION_TIMEOUT_MS) {
                    showSuccessModal(data.details);
                    return true;
                } else {
                    localStorage.removeItem(REGISTRATION_KEY);
                }
            }
            return false;
        }

        function openRegistrationModal(e) {
            e.preventDefault();
            if (checkRecentRegistration()) return;

            document.getElementById('registrationModal').classList.remove('hidden');
        }

        function closeRegistrationModal() {
            document.getElementById('registrationModal').classList.add('hidden');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        function showSuccessModal(details) {
            document.getElementById('proof-queue').innerText = details.queue.queue_number;
            document.getElementById('proof-service').innerText = details.queue.service.name;
            document.getElementById('proof-name').innerText = details.queue.patient.name;
            document.getElementById('proof-date').innerText = details.date_formatted;
            document.getElementById('proof-payment').innerText = details.payment_type;

            document.getElementById('successModal').classList.remove('hidden');
        }

        function submitRegistration(e) {
            e.preventDefault();
            const form = document.getElementById('registrationForm');
            const data = new FormData(form);
            const errorDiv = document.getElementById('formErrors');

            errorDiv.classList.add('hidden');
            errorDiv.innerHTML = '';

            fetch('{{ route("public.register.store") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: data
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        closeRegistrationModal();
                        form.reset();

                        // Save to local storage
                        const persistenceData = {
                            timestamp: new Date().getTime(),
                            details: result
                        };
                        localStorage.setItem(REGISTRATION_KEY, JSON.stringify(persistenceData));

                        showSuccessModal(result);
                    } else {
                        throw new Error(result.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerText = error.message;
                });
        }

        function downloadProof() {
            const element = document.getElementById('registration-proof');
            html2canvas(element).then(canvas => {
                const link = document.createElement('a');
                // Use queue number from the displayed text
                const queueNum = document.getElementById('proof-queue').innerText;
                link.download = 'Bukti-Pendaftaran-' + queueNum + '.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script>
    <script>
        function updateQueue() {
            // Since we don't have the API Endpoint yet, this fetch might fail or return 404.
            // I should implement the route /api/current-queue to make this work as requested.
            fetch('{{ url("/api/current-queue") }}')
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    const queueElements = document.querySelectorAll('[data-queue-number]');
                    queueElements.forEach(el => {
                        if (data.queue_number) {
                            el.innerText = data.queue_number.toString().padStart(3, '0');
                        } else {
                            el.innerText = '---';
                        }
                    });
                })
                .catch(error => console.log('Queue update error:', error));
        }
        // Only run if we actually implement the API, but I will put it here as requested.
        setInterval(updateQueue, 5000);
    </script>
@endsection