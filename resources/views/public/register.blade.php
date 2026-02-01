@extends('layouts.public')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Pendaftaran Pasien</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Silahkan isi form di bawah ini untuk mendapatkan nomor antrian.
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('public.register.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Terjadi Kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input id="dob" name="dob" type="date" required
                                class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select id="gender" name="gender" required
                                class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input id="whatsapp_number" name="whatsapp_number" type="tel" required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="address" name="address" rows="3" required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                    </div>

                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Layanan Kesehatan</label>
                        <select id="service_id" name="service_id" required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
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
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                                <label for="bpjs_yes" class="ml-2 block text-sm text-gray-900">Ya</label>
                            </div>
                            <div class="flex items-center">
                                <input id="bpjs_no" name="bpjs_usage" type="radio" value="0" checked
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                                <label for="bpjs_no" class="ml-2 block text-sm text-gray-900">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('public.home') }}" class="text-sm text-primary-600 hover:text-primary-500">Kembali ke
                        Beranda</a>
                </div>
            </form>
        </div>
    </div>
@endsection