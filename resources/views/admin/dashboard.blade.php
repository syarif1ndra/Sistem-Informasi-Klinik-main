@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pasien</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_patients'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Antrian Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['today_queues'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-pink-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-pink-100 text-pink-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Pasien</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_patients'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-rose-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-rose-100 text-rose-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Antrian Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['today_queues'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-purple-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Transaksi Belum Bayar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_transactions'] }}</p>
            </div>
        </div>

        <div
            class="bg-white rounded-lg shadow-lg p-6 flex items-center border-l-4 border-fuchsia-500 transform hover:scale-105 transition duration-300">
            <div class="p-3 rounded-full bg-fuchsia-100 text-fuchsia-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold">Obat Stok Menipis</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['low_stock_medicines'] }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Queues -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Antrian Terbaru Hari Ini</h3>
        </div>
        <div class="px-6 py-4">
            @if($recentQueues->count() > 0)
                <div class="flow-root">
                    <ul class="-my-5 divide-y divide-gray-200">
                        @foreach($recentQueues as $queue)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-800 font-bold">
                                            {{ $queue->queue_number }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $queue->patient->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            Status: <span class="capitalize">{{ $queue->status }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.queues.index') }}"
                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-500">Belum ada antrian hari ini.</p>
            @endif
        </div>
    </div>
@endsection