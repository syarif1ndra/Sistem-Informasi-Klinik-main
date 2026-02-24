<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
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

        // 1. Total Pasien Ditangani (via handled transactions)
        $totalHandledPatients = Patient::whereHas('transactions', function ($q) {
            $q->where('handled_by', auth()->id());
        })->count();

        // 2. Total Pendapatan Pribadi (dari transaksi yang saya tangani, status paid)
        $personalRevenue = Transaction::where('handled_by', auth()->id())
            ->where('status', 'paid')
            ->sum('total_amount');

        // 3. Data Antrian Hari Ini (Untuk Tabel Real-time) - assigned to this doctor
        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $today)
            ->where('assigned_practitioner_id', auth()->id())
            ->orderBy('status', 'asc')
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('dokter.dashboard', compact(
            'totalHandledPatients',
            'personalRevenue',
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
            ->where('assigned_practitioner_id', auth()->id())
            ->orderBy('status', 'asc')
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('dokter.queues.partials.table', compact('queues'));
    }
}

