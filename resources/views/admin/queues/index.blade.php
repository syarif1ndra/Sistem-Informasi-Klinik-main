@extends('layouts.admin')

@section('content')
    <div x-data="{ showAddModal: false }">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Antrian</h1>

            <div class="flex items-center gap-4">

                <form action="{{ route('admin.queues.index') }}" method="GET" class="flex items-center">
                    <input type="date" name="date" value="{{ $date }}"
                        class="shadow border border-gray-300 rounded-lg py-2 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent mr-3 transition-colors">
                    <button type="submit"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors mr-3 whitespace-nowrap">
                        Filter
                    </button>
                </form>

                <button @click="showAddModal = true"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-semibold flex items-center gap-2 py-2 px-4 rounded-lg text-sm transition-colors whitespace-nowrap shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Antrian
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <ul class="text-sm text-red-700 font-medium list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="text-gray-500 text-sm uppercase">Total Antrian</div>
                <div class="text-3xl font-bold">{{ $queues->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="text-gray-500 text-sm uppercase">Selesai</div>
                <div class="text-3xl font-bold">{{ $queues->where('status', 'finished')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="text-gray-500 text-sm uppercase">Menunggu</div>
                <div class="text-3xl font-bold">{{ $queues->where('status', 'waiting')->count() }}</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-pink-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-500 to-rose-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">No. Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Praktisi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="queue-table-body" class="bg-white divide-y divide-gray-200">
                    @include('admin.queues.partials.table')
                </tbody>
            </table>
        </div>

        <!-- Add Queue Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 backdrop-blur-sm"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showAddModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-100">

                    <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Antrian Baru
                        </h3>
                        <button @click="showAddModal = false"
                            class="text-white hover:text-pink-200 transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.queues.store') }}" method="POST" class="p-6">
                        @csrf
                        <!-- Gunakan tanggal filter sebagai default -->
                        <input type="hidden" name="date" value="{{ $date }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" required placeholder="Masukkan nama lengkap pasien"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                                <input type="text" name="nik" placeholder="16 digit NIK" maxlength="16"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                                <input type="text" name="phone" placeholder="Contoh: 08123456789"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="dob"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="gender"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="address" rows="2" placeholder="Masukkan alamat domisili pasien"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow"></textarea>
                            </div>

                            <div
                                class="col-span-1 md:col-span-2 border-t border-gray-100 pt-4 mt-2 grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Layanan <span
                                            class="text-red-500">*</span></label>
                                    <select name="service_name" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                                        <option value="" disabled selected hidden>Pilih Layanan</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service }}">{{ $service }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tujuan / Praktisi <span
                                            class="text-red-500">*</span></label>
                                    <select name="assigned_practitioner_id" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">
                                        <option value="" disabled selected hidden>Pilih Praktisi (Dokter/Bidan)</option>
                                        @foreach($practitioners as $practitioner)
                                            <option value="{{ $practitioner->id }}">{{ $practitioner->name }}
                                                ({{ ucfirst($practitioner->role) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Awal</label>
                                <textarea name="complaint" rows="2"
                                    placeholder="Gejala atau keluhan yang dirasakan saat ini"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 bg-gray-50 -mx-6 -mb-6 px-6 py-4 border-t border-gray-100">
                            <button type="button" @click="showAddModal = false"
                                class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-semibold text-white bg-pink-500 rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-1 transition-all shadow-sm">
                                Simpan Antrian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Define the table data route specifically for AJAX
        const tableDataUrl = '{{ route("admin.queues.tableData") }}';

        // Polling functionality for realtime updates
        function fetchQueueTableData() {
            // Include that date filter correctly
            const dateParam = new URLSearchParams(window.location.search).get('date') || '{{ $date }}';
            fetch(`${tableDataUrl}?date=${dateParam}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('queue-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching realtime queue data:', error));
        }

        // Poll every 5 seconds
        setInterval(fetchQueueTableData, 5000);

        function callPatient(queueId, queueNumber, patientName) {
            console.log(`Calling patient: ${queueNumber} - ${patientName}`);
            // Text to Speech
            const text = `Nomor antrian ${queueNumber}, ${patientName}`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID'; // Indonesian
            window.speechSynthesis.speak(utterance);

            // Update Status via AJAX
            fetch(`/admin/queues/${queueId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: 'calling' })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI Status Badge
                        const statusSpan = document.getElementById(`status-${queueId}`);
                        if (statusSpan) {
                            statusSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800';
                            statusSpan.innerText = 'Calling';
                        }
                        // Optional: Update row background
                        const row = document.getElementById(`row-${queueId}`);
                        if (row) {
                            row.classList.add('bg-yellow-50');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection