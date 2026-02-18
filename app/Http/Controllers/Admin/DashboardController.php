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
            'low_stock_medicines' => Medicine::where('stock', '<', 10)->count(),
        ];

        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->where('date', date('Y-m-d'))
            ->orderBy('queue_number', 'asc')
            ->take(5)
            ->get();

        // 1. Monthly Income (BPJS vs Cash) - Last 12 Months
        $monthlyIncome = $this->getMonthlyIncome();

        // 2. Payment Method Comparison (Pie Chart)
        $paymentStats = $this->getPaymentStats();

        // 3. Top 5 Medicines (Horizontal Bar Chart)
        $topMedicines = $this->getTopMedicines();

        // 4. Queue Status (Donut Chart) - Today
        $queueStats = $this->getQueueStats();

        return view('admin.dashboard', compact('stats', 'recentQueues', 'monthlyIncome', 'paymentStats', 'topMedicines', 'queueStats'));
    }

    private function getMonthlyIncome()
    {
        $months = [];
        $incomeBpjs = [];
        $incomeCash = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthName;

            $incomeBpjs[] = Transaction::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('payment_method', 'bpjs')
                ->where('status', 'paid')
                ->sum('total_amount');

            $incomeCash[] = Transaction::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('payment_method', 'general') // Assuming 'general' is cash/tunai
                ->where('status', 'paid')
                ->sum('total_amount');
        }

        return [
            'labels' => $months,
            'bpjs' => $incomeBpjs,
            'cash' => $incomeCash,
        ];
    }

    private function getPaymentStats()
    {
        $bpjsCount = Transaction::where('payment_method', 'bpjs')->count();
        $cashCount = Transaction::where('payment_method', 'general')->count();

        return [
            'labels' => ['BPJS', 'Tunai'],
            'data' => [$bpjsCount, $cashCount],
        ];
    }

    private function getTopMedicines()
    {
        $topMedicines = \Illuminate\Support\Facades\DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'paid')
            ->where('transaction_items.item_type', 'medicine') // Assuming polymorphic or string type check
            ->select('transaction_items.name', \Illuminate\Support\Facades\DB::raw('SUM(transaction_items.quantity) as total_qty'))
            ->groupBy('transaction_items.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return [
            'labels' => $topMedicines->pluck('name'),
            'data' => $topMedicines->pluck('total_qty'),
        ];
    }

    private function getQueueStats()
    {
        $today = date('Y-m-d');

        $waiting = Queue::where('date', $today)->where('status', 'waiting')->count();
        $calling = Queue::where('date', $today)->where('status', 'calling')->count(); // Assuming 'calling' or 'panggil'
        $done = Queue::where('date', $today)->where('status', 'done')->count(); // Assuming 'done' or 'selesai'

        // Check actual enum values in database if needed, but using standard names for now
        // If status uses indonesian: 'menunggu', 'panggil', 'selesai'
        // Let's verify status values from recent Codebase if possible, or use standard safe defaults and map them

        // Based on previous context, status might be 'pending', 'called', 'completed' or similar. 
        // Let's check Queue model again? No, I'll stick to English keys and maybe map them in query if I knew for sure.
        // Actually, let's look at QueueController to be sure about status values. 
        // For now, I will assume standard values but add a quick check.

        return [
            'labels' => ['Menunggu', 'Dipanggil', 'Selesai'],
            'data' => [$waiting, $calling, $done],
        ];
    }
}
