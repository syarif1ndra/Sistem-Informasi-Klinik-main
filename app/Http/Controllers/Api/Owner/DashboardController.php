<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Expense;
use App\Models\User;

class DashboardController extends Controller
{
    use ApiResponse;

    /** GET /api/owner/dashboard */
    public function index()
    {
        $today      = now()->toDateString();
        $thisMonth  = now()->format('Y-m');

        $monthlyRevenue = Transaction::where('status', 'paid')
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('total_amount');

        $monthlyExpenses = Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount');

        return $this->successResponse([
            'today_revenue'        => Transaction::whereDate('date', $today)->where('status', 'paid')->sum('total_amount'),
            'today_transactions'   => Transaction::whereDate('date', $today)->where('status', 'paid')->count(),
            'monthly_revenue'      => $monthlyRevenue,
            'monthly_clinic_revenue' => Transaction::where('status', 'paid')
                ->whereYear('date', now()->year)
                ->whereMonth('date', now()->month)
                ->sum('clinic_revenue'),
            'monthly_expenses'     => $monthlyExpenses,
            'net_profit'           => $monthlyRevenue - $monthlyExpenses,
            'total_patients'       => Patient::count(),
            'total_staff'          => User::whereIn('role', ['dokter', 'bidan'])->count(),
            'queues_today'         => Queue::whereDate('date', $today)->count(),
        ], 'Dashboard owner');
    }
}
