<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Kelahiran - ' . $birthRecord->baby_name) }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.birth_records.edit', $birthRecord) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('admin.birth_records.generatePdf', $birthRecord) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700" target="_blank">
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Data Bayi -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-pink-500">Data Bayi</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Nama Bayi:</span>
                                <p class="text-gray-900 font-semibold">{{ $birthRecord->baby_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Jenis Kelamin:</span>
                                <p class="text-gray-900">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $birthRecord->gender === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $birthRecord->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Tanggal Lahir:</span>
                                <p class="text-gray-900">{{ $birthRecord->birth_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Waktu Lahir:</span>
                                <p class="text-gray-900">{{ $birthRecord->birth_time }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Tempat Lahir:</span>
                                <p class="text-gray-900">{{ $birthRecord->birth_place }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Berat Bayi:</span>
                                <p class="text-gray-900">{{ $birthRecord->baby_weight ?? '-' }} kg</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Panjang Bayi:</span>
                                <p class="text-gray-900">{{ $birthRecord->baby_length ?? '-' }} cm</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-pink-500">Data Orang Tua</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Nama Ibu:</span>
                                <p class="text-gray-900 font-semibold">{{ $birthRecord->mother_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">NIK Ibu:</span>
                                <p class="text-gray-900">{{ $birthRecord->mother_nik }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Alamat Ibu:</span>
                                <p class="text-gray-900">{{ $birthRecord->mother_address ?? '-' }}</p>
                            </div>
                            <div class="pt-4 border-t">
                                <span class="text-sm font-medium text-gray-600">Nama Ayah:</span>
                                <p class="text-gray-900 font-semibold">{{ $birthRecord->father_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">NIK Ayah:</span>
                                <p class="text-gray-900">{{ $birthRecord->father_nik }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Alamat Ayah:</span>
                                <p class="text-gray-900">{{ $birthRecord->father_address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="mt-8 pt-8 border-t">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Nomor Surat Kelahiran:</span>
                            <p class="text-gray-900">{{ $birthRecord->birth_certificate_number ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Tanggal Input:</span>
                            <p class="text-gray-900">{{ $birthRecord->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($birthRecord->notes)
                        <div class="mt-4">
                            <span class="text-sm font-medium text-gray-600">Catatan:</span>
                            <p class="text-gray-900 mt-2 p-4 bg-gray-50 rounded">{{ $birthRecord->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('admin.birth_records.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
