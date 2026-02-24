<x-guest-layout>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Session Status -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Masuk</h2>
        <p class="text-gray-600 text-center mb-8">Silakan masukkan kredensial Anda untuk mengakses dashboard</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input id="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                    type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="nama@email.com" />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500 cursor-pointer"
                    name="remember">
                <label for="remember_me" class="ms-2 text-sm text-gray-600 cursor-pointer">
                    Ingat saya
                </label>
            </div>

            <!-- reCAPTCHA -->
            <div class="flex justify-center mb-4">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>

            @if ($errors->has('g-recaptcha-response'))
                <span class="text-red-600 text-sm block text-center mb-4">
                    {{ $errors->first('g-recaptcha-response') }}
                </span>
            @endif

            <!-- Actions -->
            <div class="space-y-3">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white font-semibold py-2 rounded-lg hover:from-pink-600 hover:to-rose-700 transition duration-200 transform hover:scale-105">
                    Masuk
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                            Lupa Password?
                        </a>
                    </div>
                @endif
            </div>
        </form>

        <!-- Divider -->
        <div class="mt-8 relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">atau masuk dengan</span>
            </div>
        </div>

        <!-- Google Login -->
        <div class="mt-6">
            <a href="{{ route('auth.google') }}"
                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                <svg class="h-5 w-5 mr-2" aria-hidden="true" viewBox="0 0 24 24">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        fill="#4285F4" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        fill="#34A853" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        fill="#EA4335" />
                </svg>
                Google
            </a>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Belum punya akun?
                <a href="{{ route('user.register') }}" class="text-pink-600 hover:text-pink-700 font-semibold">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>