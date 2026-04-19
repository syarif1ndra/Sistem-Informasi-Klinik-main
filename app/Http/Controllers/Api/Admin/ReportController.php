<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/reports?date_from=&date_to= */
    public function index(Request $request)
    {
        $query = Transaction::with(['patient:id,name,nik', 'handledBy:id,name,role', 'items'])
            ->where('status', 'paid');

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $transactions = $query->orderByDesc('date')->paginate(20);

        $summary = [
            'total_revenue'         => $query->sum('total_amount'),
            'total_medical_revenue' => $query->sum('medical_staff_revenue'),
            'total_clinic_revenue'  => $query->sum('clinic_revenue'),
            'total_transactions'    => $query->count(),
        ];

        return $this->successResponse([
            'summary'      => $summary,
            'transactions' => $transactions,
        ], 'Laporan transaksi admin');
    }
}
