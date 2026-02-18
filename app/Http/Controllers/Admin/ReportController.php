<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Transaction;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Http\Request;
use DateTime;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        // Report Data
        $totalPatients = Patient::whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])->count();
        $totalTransactions = Transaction::whereBetween('date', [$startDate, $endDate])->sum('total_amount');
        $totalVisits = Queue::whereBetween('date', [$startDate, $endDate])->count();

        // Detailed Data
        $transactions = Transaction::with('patient')
            ->whereBetween('date', [$startDate, $endDate])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('totalPatients', 'totalTransactions', 'totalVisits', 'transactions', 'month', 'year'));
    }
    public function exportExcel(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ReportExport($month, $year), 'laporan-bulanan-' . $month . '-' . $year . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $transactions = Transaction::with('patient')
            ->whereBetween('date', [$startDate, $endDate])
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact('transactions', 'month', 'year'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-bulanan-' . $month . '-' . $year . '.pdf');
    }
}
