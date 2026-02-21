@extends('layouts.blank')

@section('title', 'Layar Antrian')

@section('content')
    <div class="min-h-[calc(100vh-130px)] bg-gray-50 flex flex-col py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 uppercase tracking-wider">Antrian Pasien Hari Ini</h1>
            <p class="text-lg text-gray-500 mt-2">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:flex-row gap-8">
            <!-- Left: Current Queue -->
            <div class="lg:w-1/2 flex flex-col">
                <div
                    class="bg-white rounded-2xl shadow-xl flex-1 flex flex-col items-center justify-center p-12 border-t-8 border-pink-500 transform transition-all duration-500">
                    <h2 class="text-2xl font-bold text-gray-500 mb-8 uppercase tracking-widest text-center">Nomor Antrian
                        Saat Ini</h2>
                    <div
                        class="bg-pink-50 rounded-full w-64 h-64 flex items-center justify-center mb-8 shadow-inner border-4 border-pink-100">
                        <span id="current-queue-number" class="text-8xl font-black text-pink-600">-</span>
                    </div>
                    <div id="current-patient-name" class="text-4xl font-bold text-gray-800 text-center">-</div>
                </div>
            </div>

            <!-- Right: Next Queues -->
            <div class="lg:w-1/2 flex flex-col">
                <div class="bg-white rounded-2xl shadow-xl flex-1 p-8 border-t-8 border-purple-500">
                    <h2 class="text-2xl font-bold text-gray-700 mb-6 flex items-center border-b pb-4">
                        <svg class="w-8 h-8 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Antrian Selanjutnya
                    </h2>
                    <div id="next-queues-list" class="space-y-4">
                        <!-- Data injected via JS -->
                        <div class="text-center text-gray-500 py-10">Memuat data...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let lastUpdatedTimestamp = null;

        function updateQueueDisplay() {
            fetch('{{ route("public.queue_display.data") }}')
                .then(res => res.json())
                .then(data => {
                    // Update Current Queue
                    if (data.current) {
                        document.getElementById('current-queue-number').innerText = data.current.queue_number;
                        document.getElementById('current-patient-name').innerText = data.current.patient_name;

                        if (lastUpdatedTimestamp !== data.current.updated_at) {
                            lastUpdatedTimestamp = data.current.updated_at;
                            
                            // Visual indicator for re-calling
                            const queueDisplayContainer = document.getElementById('current-queue-number').parentElement;
                            queueDisplayContainer.style.transition = 'all 0.3s ease';
                            queueDisplayContainer.classList.add('scale-110', 'bg-pink-200');
                            setTimeout(() => {
                                queueDisplayContainer.classList.remove('scale-110', 'bg-pink-200');
                            }, 500);
                        }
                    } else {
                        document.getElementById('current-queue-number').innerText = '---';
                        document.getElementById('current-patient-name').innerText = '-';
                    }

                    // Update Next Queues
                    let nextListHTML = '';
                    if (data.next.length > 0) {
                        data.next.forEach(q => {
                            nextListHTML += `
                            <div class="flex items-center p-5 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 shadow-sm mb-4 transform transition hover:scale-[1.02]">
                                <div class="bg-purple-100 text-purple-700 font-bold text-3xl rounded-lg px-6 py-3 mr-6 shadow-sm">
                                    ${q.queue_number}
                                </div>
                                <div class="flex-1">
                                    <div class="text-2xl font-bold text-gray-800">${q.patient_name}</div>
                                    <div class="text-md text-gray-500 mt-1">${q.service_name || '-'}</div>
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        nextListHTML = '<div class="text-center bg-gray-50 rounded-xl p-10 text-gray-500 border border-dashed border-gray-300">Tidak ada antrian selanjutnya.</div>';
                    }
                    document.getElementById('next-queues-list').innerHTML = nextListHTML;
                })
                .catch(err => console.error(err));
        }

        setInterval(updateQueueDisplay, 3000);
        updateQueueDisplay();
    </script>
@endsection