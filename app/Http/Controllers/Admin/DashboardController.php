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

        $recentQueues = Queue::with('patient')
            ->where('date', date('Y-m-d'))
            ->orderBy('queue_number', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentQueues'));
    }
}
