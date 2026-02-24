<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'daily'); // daily, monthly, yearly
        $status = $request->input('status', 'all');
        $practitionerId = $request->input('practitioner_id', 'all');

        $practitioners = User::whereIn('role', ['dokter', 'bidan'])->get();

        $query = Transaction::with(['patient', 'processedBy', 'handledBy']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($practitionerId !== 'all') {
            $query->where('handled_by', $practitionerId);
        }

        if ($type === 'monthly') {
            $month = $request->input('month', Carbon::today()->format('Y-m'));

            // Extract Year and Month carefully since SQLite vs MySQL DATE logic differ
            // For Laravel, it's safer to use whereYear and whereMonth
            $date = Carbon::createFromFormat('Y-m', $month);
            $query->whereYear('date', $date->year)->whereMonth('date', $date->month);

            $transactions = $query->orderBy('date', 'asc')->get();

            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            $totalTransactions = $transactions->count();

            if ($request->has('export') && $request->export === 'pdf') {
                $pdf = Pdf::loadView('owner.reports.pdf_monthly', compact('transactions', 'month', 'status', 'practitionerId', 'practitioners', 'type', 'totalRevenue', 'totalTransactions'));
                $pdf->setPaper('A4', 'portrait');
                return $pdf->download('laporan-bulanan-owner-' . $month . '.pdf');
            }

            return view('owner.reports.monthly', compact('transactions', 'month', 'status', 'practitionerId', 'practitioners', 'type', 'totalRevenue', 'totalTransactions'));

        } elseif ($type === 'yearly') {
            $year = $request->input('year', Carbon::today()->format('Y'));

            $query->whereYear('date', $year);

            // Grouping by Month in standard SQL
            $transactions = $query->select(
                DB::raw('MONTH(date) as label_month'),
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN total_amount ELSE 0 END) as total_revenue')
            )
                ->groupBy('label_month')
                ->orderBy('label_month', 'asc')
                ->get();

            $totalRevenue = $transactions->sum('total_revenue');
            $totalTransactions = $transactions->sum('total_count');

            if ($request->has('export') && $request->export === 'pdf') {
                $pdf = Pdf::loadView('owner.reports.pdf_yearly', compact('transactions', 'year', 'status', 'practitionerId', 'practitioners', 'type', 'totalRevenue', 'totalTransactions'));
                $pdf->setPaper('A4', 'portrait');
                return $pdf->download('laporan-tahunan-owner-' . $year . '.pdf');
            }

            return view('owner.reports.yearly', compact('transactions', 'year', 'status', 'practitionerId', 'practitioners', 'type', 'totalRevenue', 'totalTransactions'));

        } else {
            // Default Daily Type Detail Data
            $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
            $endDate = $request->input('end_date', Carbon::today()->toDateString());

            $query->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate);

            $transactions = $query->orderBy('created_at', 'asc')->get();

            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            $totalTransactions = $transactions->count();

            return view('owner.reports.index', compact('transactions', 'startDate', 'endDate', 'status', 'practitionerId', 'practitioners', 'type', 'totalRevenue', 'totalTransactions'));
        }
    }
}
