<?php

namespace App\Http\Controllers\Api\Dokter;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    /** GET /api/dokter/reports */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $query = Transaction::with(['patient:id,name', 'items'])
            ->where('handled_by', $userId)
            ->where('status', 'paid');

        if ($request->filled('date_from')) $query->whereDate('date', '>=', $request->date_from);
        if ($request->filled('date_to'))   $query->whereDate('date', '<=', $request->date_to);

        // Clone for summary before pagination
        $summaryQuery = (clone $query);
        $summary = [
            'total_transaksi'       => $summaryQuery->count(),
            'total_pendapatan'      => $summaryQuery->sum('total_amount'),
            'pendapatan_saya'       => $summaryQuery->sum('medical_staff_revenue'),
            'status_pembayaran_gaji'=> Transaction::where('handled_by', $userId)
                ->where('status', 'paid')
                ->where('staff_payment_status', 'unpaid')
                ->count() > 0 ? 'Ada yang belum dibayar' : 'Semua sudah dibayar',
        ];

        return $this->successResponse([
            'summary'      => $summary,
            'transactions' => $query->orderByDesc('date')->paginate(15),
        ], 'Laporan kinerja dokter');
    }
}
