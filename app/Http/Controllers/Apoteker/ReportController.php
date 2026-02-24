<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StockLog;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $logs = StockLog::with('medicine')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->paginate(50);

        return view('apoteker.reports.index', compact('logs', 'startDate', 'endDate'));
    }

    public function exportExcel(Request $request)
    {
        // TODO: Implement excel export if needed
        return back()->with('error', 'Fitur export Excel belum tersedia.');
    }

    public function exportPdf(Request $request)
    {
        // TODO: Implement pdf export if needed
        return back()->with('error', 'Fitur export PDF belum tersedia.');
    }
}
