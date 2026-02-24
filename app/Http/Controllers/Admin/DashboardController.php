<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Transaction;
use App\Models\Medicine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_queues' => Queue::where('date', date('Y-m-d'))->count(),
            'pending_transactions' => Transaction::where('status', 'unpaid')->count(),
            'low_stock_medicines' => Medicine::where('stock', '<', 20)->count(),
            'today_revenue' => Transaction::whereDate('created_at', date('Y-m-d'))->where('status', 'paid')->sum('total_amount'),
            'total_revenue' => Transaction::where('status', 'paid')->sum('total_amount'),
        ];

        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->where('date', date('Y-m-d'))
            ->orderBy('queue_number', 'asc')
            ->take(5)
            ->get();

        // 1. Monthly Income (Total) - Last 12 Months
        $monthlyIncome = $this->getMonthlyIncome();

        // 2. Patient Trend (Total) - Last 7 Days
        $patientTrend = $this->getPatientTrend();

        return view('admin.dashboard', compact('stats', 'recentQueues', 'monthlyIncome', 'patientTrend'));
    }

    private function getMonthlyIncome()
    {
        $months = [];
        $income = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M'); // Jan - Des
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthName;

            $income[] = Transaction::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'paid')
                ->sum('total_amount');
        }

        return [
            'labels' => $months,
            'data' => $income,
        ];
    }

    private function getPatientTrend()
    {
        $days = [];
        $patients = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayLabel = $date->format('d M'); // e.g., 18 Feb

            $days[] = $dayLabel;

            $patients[] = Queue::whereDate('date', $dateString)->count();
        }

        return [
            'labels' => $days,
            'data' => $patients,
        ];
    }
}
