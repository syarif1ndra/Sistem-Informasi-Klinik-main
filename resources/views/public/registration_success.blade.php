@extends('layouts.public')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg" id="registration-proof">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Bukti Pendaftaran</h2>
                <p class="mt-2 text-sm text-gray-600">Simpan bukti ini untuk ditunjukkan kepada petugas.</p>
            </div>

            <div class="border-t border-b border-gray-200 py-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-gray-500">Nomor Antrian</div>
                    <div class="font-bold text-3xl text-primary-600">{{ $queue->queue_number }}</div>

                    <div class="text-gray-500">Layanan</div>
                    <div class="font-semibold">{{ $queue->service->name ?? '-' }}</div>

                    <div class="text-gray-500">Nama Pasien</div>
                    <div class="font-semibold">{{ $queue->patient->name }}</div>

                    <div class="text-gray-500">Tanggal</div>
                    <div class="font-semibold">{{ \Carbon\Carbon::parse($queue->date)->translatedFormat('d F Y') }}</div>

                    <div class="text-gray-500">Pembayaran</div>
                    <div class="font-semibold">{{ $queue->bpjs_usage ? 'BPJS' : 'Umum' }}</div>
                </div>
            </div>

            <div class="mt-6 text-center" data-html2canvas-ignore>
                <button onclick="downloadProof()"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Download Bukti (PNG)
                </button>
                <a href="{{ route('public.home') }}" class="mt-4 inline-block text-sm text-blue-600 hover:text-blue-500">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadProof() {
            const element = document.getElementById('registration-proof');
            html2canvas(element).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Bukti-Pendaftaran-{{ $queue->queue_number }}.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script>
@endsection