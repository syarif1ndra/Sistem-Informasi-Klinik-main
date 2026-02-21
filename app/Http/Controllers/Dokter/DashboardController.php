<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Khusus Dokter
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // 1. Total Pasien Hari Ini (Dari Antrian)
        $totalPatientsToday = Queue::whereDate('date', $today)->count();

        // 2. Total Pendapatan Bulan Ini (Dari Transaksi berstatus lunas/selesai)
        $monthlyIncome = Transaction::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->where('status', 'lunas')
            ->sum('total_amount');

        // 3. Data Antrian Hari Ini (Untuk Tabel Real-time)
        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $today)
            ->orderBy('status', 'asc') // Menunggu dulu
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('dokter.dashboard', compact(
            'totalPatientsToday',
            'monthlyIncome',
            'recentQueues'
        ));
    }

    /**
     * Endpoint untuk Polling Tabel Antrian Real-time di Dashboard Dokter
     */
    public function queueTableData()
    {
        $today = Carbon::today();

        $queues = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $today)
            ->orderBy('status', 'asc')
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('dokter.queues.partials.table', compact('queues'));
    }
}
