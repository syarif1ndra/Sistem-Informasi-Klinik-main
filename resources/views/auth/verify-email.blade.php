<x-guest-layout>
    <div class="mb-8">
        <div class="flex items-center justify-center w-16 h-16 bg-pink-100 rounded-full mb-6 mx-auto">
            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Verifikasi Email Anda</h2>
        <p class="text-gray-600 text-center">
            Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan
            yang baru saja kami kirimkan ke email Anda.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div
            class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm font-medium rounded-r-lg animate-pulse">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full inline-flex justify-center items-center py-3 px-4 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Kirim Ulang Email Verifikasi
            </button>
        </form>
    </div>
</x-guest-layout>