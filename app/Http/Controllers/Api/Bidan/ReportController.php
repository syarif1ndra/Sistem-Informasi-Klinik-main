<?php

namespace App\Http\Controllers\Api\Bidan;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    /** GET /api/bidan/reports */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $query  = Transaction::with(['patient:id,name', 'items'])
            ->where('handled_by', $userId)
            ->where('status', 'paid');

        if ($request->filled('date_from')) $query->whereDate('date', '>=', $request->date_from);
        if ($request->filled('date_to'))   $query->whereDate('date', '<=', $request->date_to);

        $transactions = $query->orderByDesc('date')->paginate(15);
        $summary = [
            'total_revenue'         => (clone $query)->sum('total_amount'),
            'medical_staff_revenue' => (clone $query)->sum('medical_staff_revenue'),
            'total_transactions'    => (clone $query)->count(),
        ];

        return $this->successResponse([
            'summary'      => $summary,
            'transactions' => $transactions,
        ], 'Laporan kinerja bidan');
    }
}
