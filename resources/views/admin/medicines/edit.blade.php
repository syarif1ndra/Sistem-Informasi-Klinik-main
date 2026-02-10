@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-white text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data Obat
                </h2>
                <a href="{{ route('admin.medicines.index') }}"
                    class="text-white hover:text-pink-100 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Name & Category Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Obat</label>
                                <input type="text" name="name" id="name" value="{{ $medicine->name }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>

                            <div>
                                <label for="category"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                <input type="text" name="category" id="category" value="{{ $medicine->category }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>
                        </div>

                        <!-- Stock & Price Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stok
                                    Tersedia</label>
                                <input type="number" name="stock" id="stock" min="0" value="{{ $medicine->stock }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5"
                                    required>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Satuan
                                    (Rp)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" id="price" min="0" value="{{ $medicine->price }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 pl-10 p-2.5"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                                Obat</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition duration-200 p-2.5">{{ $medicine->description }}</textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.medicines.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-lg font-bold hover:from-pink-600 hover:to-rose-700 shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                            Update Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection