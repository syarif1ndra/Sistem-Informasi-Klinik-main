<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    /** GET /api/owner/reports */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'patient:id,name,nik',
            'handledBy:id,name,role',
            'processedBy:id,name',
            'items',
        ])->where('status', 'paid');

        if ($request->filled('date_from')) $query->whereDate('date', '>=', $request->date_from);
        if ($request->filled('date_to'))   $query->whereDate('date', '<=', $request->date_to);
        if ($request->filled('handled_by')) $query->where('handled_by', $request->handled_by);

        $summaryQuery = (clone $query);
        $summary = [
            'total_transaksi'        => $summaryQuery->count(),
            'total_pendapatan'       => $summaryQuery->sum('total_amount'),
            'pendapatan_klinik'      => $summaryQuery->sum('clinic_revenue'),
            'pendapatan_staf_medis'  => $summaryQuery->sum('medical_staff_revenue'),
        ];

        return $this->successResponse([
            'summary'      => $summary,
            'transactions' => $query->orderByDesc('date')->paginate(20),
        ], 'Laporan keuangan owner');
    }

    /** PATCH /api/owner/reports/toggle-payment/{transactionId} */
    public function togglePayment($id)
    {
        $transaction = Transaction::findOrFail($id);
        $newStatus   = $transaction->staff_payment_status === 'paid' ? 'unpaid' : 'paid';
        $transaction->update(['staff_payment_status' => $newStatus]);

        return $this->successResponse([
            'id'                   => $transaction->id,
            'staff_payment_status' => $transaction->fresh()->staff_payment_status,
        ], 'Status pembayaran staf diperbarui');
    }
}
