<x-guest-layout>
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
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Masuk Admin</h2>
        <p class="text-gray-600 text-center mb-8">Silakan masukkan kredensial Anda untuk mengakses dashboard</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    id="email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@email.com"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input 
                    id="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500 cursor-pointer" 
                    name="remember"
                >
                <label for="remember_me" class="ms-2 text-sm text-gray-600 cursor-pointer">
                    Ingat saya
                </label>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-rose-600 text-white font-semibold py-2 rounded-lg hover:from-pink-600 hover:to-rose-700 transition duration-200 transform hover:scale-105"
                >
                    Masuk
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-sm text-pink-600 hover:text-pink-700 font-medium"
                        >
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
                <span class="px-2 bg-white text-gray-500">atau</span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-700 font-semibold">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
