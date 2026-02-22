<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $paymentMethod = $request->input('payment_method', 'all');
        $status = $request->input('status', 'all');

        // Kolom 'date' di transaksi bertipe DATETIME, gunakan whereDate agar bisa matching per-hari
        $query = Transaction::with(['patient', 'processedBy'])
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
        $totalTransactions = $transactions->count();

        return view('owner.reports.index', compact('transactions', 'startDate', 'endDate', 'paymentMethod', 'status', 'totalRevenue', 'totalTransactions'));
    }
}
