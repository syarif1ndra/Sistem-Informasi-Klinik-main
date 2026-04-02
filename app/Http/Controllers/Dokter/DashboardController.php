<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Transaction;
use App\Models\TransactionItem;
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

        // 1. Total Pasien (yang pernah antre ke dokter ini)
        $totalHandledPatients = Patient::whereHas('queues', function ($q) {
            $q->where('assigned_practitioner_id', auth()->id());
        })->count();

        // 2. Pendapatan Pribadi dihitung berdasarkan splits dari transaksi yang sudah paid
        $personalRevenue = Transaction::where('handled_by', auth()->id())
            ->where('status', 'paid')
            ->sum('medical_staff_revenue');

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

