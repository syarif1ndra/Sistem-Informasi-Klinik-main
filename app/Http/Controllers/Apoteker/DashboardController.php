<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Prescription;
use App\Models\Medicine;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'prescriptions_today' => Prescription::whereDate('created_at', $today)->count(),
            'prescriptions_waiting' => Prescription::where('status', 'menunggu')->count(),
            'prescriptions_ready' => Prescription::where('status', 'siap_diambil')->count(),
            'medicines_dispensed_today' => \App\Models\StockLog::where('type', 'keluar')
                ->whereDate('created_at', $today)
                ->sum('quantity'),
        ];

        // Get medicines where stock is less than or equal to min_stock
        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->get();

        return view('apoteker.dashboard', compact('stats', 'lowStockMedicines'));
    }
}
