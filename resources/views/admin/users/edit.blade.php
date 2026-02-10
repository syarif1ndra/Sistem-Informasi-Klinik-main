@extends('layouts.admin')

@section('content')
    <div class="h-full flex flex-col">
        <div class="max-w-4xl mx-auto h-full flex flex-col justify-center">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 w-full">
                <!-- Header -->
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-white text-xl font-bold flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Data User
                    </h2>
                    <a href="{{ route('admin.users.index') }}"
                        class="text-white hover:text-pink-100 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>

                <div class="p-8">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-bold">Terjadi Kesalahan!</p>
                                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email
                                    Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password
                                        Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                    <input type="password" name="password" id="password"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                        placeholder="Kosongkan jika tidak ingin mengubah">
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-lg font-bold hover:from-pink-600 hover:to-rose-700 shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection