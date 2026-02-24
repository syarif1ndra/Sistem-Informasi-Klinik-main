<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Only transactions handled by this bidan
        $query = Transaction::with('patient')
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        $totalRevenue = (clone $query)->where('status', 'paid')->sum('total_amount');
        $totalTransactions = (clone $query)->count();

        $transactions = (clone $query)->latest()->paginate(15);
        $transactions->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        return view('bidan.reports.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate'
        ));
    }
}
