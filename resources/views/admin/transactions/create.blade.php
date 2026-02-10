@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="billingSystem()">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <span class="p-3 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </span>
                Buat Transaksi / Kasir
            </h1>
            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center gap-2 text-gray-500 hover:text-pink-600 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Riwayat
            </a>
        </div>

        <form action="{{ route('admin.transactions.store') }}" method="POST" id="billingForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: Selection -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Patient Selection -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4">
                            <h2 class="text-white text-lg font-bold flex items-center gap-2">
                                <span
                                    class="bg-white text-pink-600 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">1</span>
                                Pilih Pasien
                            </h2>
                        </div>
                        <div class="p-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pasien</label>
                            <select name="patient_id"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-3"
                                required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Item Selection -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4">
                            <h2 class="text-white text-lg font-bold flex items-center gap-2">
                                <span
                                    class="bg-white text-pink-600 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">2</span>
                                Tambah Item (Layanan / Obat)
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-4 mb-6">
                                <div class="w-full md:w-1/3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Item</label>
                                    <select x-model="itemType"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-3">
                                        <option value="service" selected>Layanan</option>
                                        <option value="medicine">Obat</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-2/3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Item</label>

                                    <!-- Service Select -->
                                    <select x-show="itemType === 'service'" x-model="selectedServiceId"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-3">
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Medicine Select -->
                                    <select x-show="itemType === 'medicine'" x-model="selectedMedicineId"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500 shadow-sm transition p-3">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}">
                                                {{ $medicine->name }} (Stok: {{ $medicine->stock }}) (Rp
                                                {{ number_format($medicine->price, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" @click="addItem()"
                                    class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-lg shadow hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah ke Daftar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Ringkasan
                        </h2>

                        <div class="space-y-4 mb-6 min-h-[200px] max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-if="items.length === 0">
                                <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="italic text-sm">Belum ada item ditambahkan.</p>
                                </div>
                            </template>

                            <template x-for="(item, index) in items" :key="index">
                                <div
                                    class="flex justify-between items-start border-b border-gray-50 pb-3 last:border-0 hover:bg-gray-50 p-2 rounded transition">
                                    <div>
                                        <p class="font-bold text-gray-800" x-text="item.name"></p>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span class="bg-gray-200 px-2 py-0.5 rounded text-gray-600 mr-2"
                                                x-text="item.type === 'service' ? 'Layanan' : 'Obat'"></span>
                                            <span><span x-text="item.quantity"></span> x Rp <span
                                                    x-text="formatNumber(item.price)"></span></span>
                                        </div>
                                        <!-- Hidden Inputs -->
                                        <input type="hidden" :name="'items['+index+'][type]'" :value="item.type">
                                        <input type="hidden" :name="'items['+index+'][id]'" :value="item.id">
                                        <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.quantity">
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-pink-600">Rp <span
                                                x-text="formatNumber(item.price * item.quantity)"></span></p>
                                        <button type="button" @click="removeItem(index)"
                                            class="text-red-400 text-xs hover:text-red-600 mt-1 flex items-center gap-1 justify-end ml-auto transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="border-t-2 border-dashed border-gray-200 pt-4 bg-gray-50 -mx-6 -mb-6 p-6 rounded-b-xl">
                            <div class="flex justify-between items-center text-gray-600 mb-2">
                                <span>Total Item</span>
                                <span class="font-semibold" x-text="items.length"></span>
                            </div>
                            <div class="flex justify-between items-center text-2xl font-bold text-gray-800">
                                <span>Total Bayar</span>
                                <span class="text-pink-600">Rp <span x-text="formatNumber(total)"></span></span>
                            </div>

                            <button type="submit" :disabled="items.length === 0"
                                class="w-full mt-6 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white font-bold py-3.5 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-200 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function billingSystem() {
            return {
                itemType: 'service',
                selectedServiceId: '',
                selectedMedicineId: '',
                items: [],

                get total() {
                    return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                addItem() {
                    let id, name, price, type;

                    if (this.itemType === 'service') {
                        if (!this.selectedServiceId) return alert('Pilih layanan terlebih dahulu');
                        const select = document.querySelector('select[x-model="selectedServiceId"]');
                        const option = select.options[select.selectedIndex];
                        id = this.selectedServiceId;
                        name = option.text.split('(')[0].trim();
                        price = option.getAttribute('data-price');
                        type = 'service';
                        this.selectedServiceId = ''; // Reset
                    } else {
                        if (!this.selectedMedicineId) return alert('Pilih obat terlebih dahulu');
                        const select = document.querySelector('select[x-model="selectedMedicineId"]');
                        const option = select.options[select.selectedIndex];
                        id = this.selectedMedicineId;
                        name = option.text.split('(')[0].trim();
                        price = option.getAttribute('data-price');
                        type = 'medicine';
                        this.selectedMedicineId = ''; // Reset
                    }

                    // Cek jika item sudah ada
                    /* 
                    // Jika ingin menggabungkan quantity, uncomment ini
                    let existing = this.items.find(i => i.id === id && i.type === type);
                    if (existing) {
                        existing.quantity++;
                    } else {
                    */
                    this.items.push({
                        type: type,
                        id: id,
                        name: name,
                        price: parseFloat(price),
                        quantity: 1
                    });
                    /* } */
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
@endsection