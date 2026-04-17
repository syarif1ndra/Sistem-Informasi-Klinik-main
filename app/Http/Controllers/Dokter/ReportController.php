<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01')); // First day of month
        $endDate = $request->input('end_date', date('Y-m-d'));
        $paymentMethod = $request->input('payment_method', 'all');
        $search = $request->input('search', '');

        // Only transactions handled by this doctor
        $query = Transaction::with('patient')
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        if ($search) {
            $query->whereHas('patient', function ($patientQuery) use ($search) {
                $patientQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        $totalRevenueQuery = Transaction::where('handled_by', auth()->id())
            ->where('status', 'paid')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($paymentMethod !== 'all') {
            $totalRevenueQuery->where('payment_method', $paymentMethod);
        }

        if ($search) {
            $totalRevenueQuery->whereHas('patient', function ($patientQuery) use ($search) {
                $patientQuery->where('name', 'like', '%' . $search . '%');
            });
        }
        
        $totalRevenue = $totalRevenueQuery->sum('medical_staff_revenue');

        $totalTransactions = (clone $query)->count();

        $transactions = (clone $query)->with([
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])->oldest()->paginate(15);

        $transactions->getCollection()->transform(function ($transaction) {
            if ($transaction->status === 'paid') {
                $transaction->practitioner_income = $transaction->medical_staff_revenue;
            } else {
                $transaction->practitioner_income = 0;
            }
            return $transaction;
        });

        $transactions->appends(['start_date' => $startDate, 'end_date' => $endDate, 'payment_method' => $paymentMethod, 'search' => $search]);

        return view('dokter.reports.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate',
            'paymentMethod',
            'search'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $paymentMethod = $request->input('payment_method', 'all');
        $search = $request->input('search', '');

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DokterReportExport($startDate, $endDate, $paymentMethod, $search), 'laporan-keuangan-dokter-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $paymentMethod = $request->input('payment_method', 'all');
        $search = $request->input('search', '');

        // Only transactions handled by this doctor
        $query = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        if ($search) {
            $query->whereHas('patient', function ($patientQuery) use ($search) {
                $patientQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        $totalRevenueQueryPdf = Transaction::where('handled_by', auth()->id())
            ->where('status', 'paid')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($paymentMethod !== 'all') {
            $totalRevenueQueryPdf->where('payment_method', $paymentMethod);
        }

        if ($search) {
            $totalRevenueQueryPdf->whereHas('patient', function ($patientQuery) use ($search) {
                $patientQuery->where('name', 'like', '%' . $search . '%');
            });
        }
        
        $totalRevenue = $totalRevenueQueryPdf->sum('medical_staff_revenue');

        $totalTransactions = (clone $query)->count();
        $transactions = (clone $query)->oldest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dokter.reports.pdf', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-keuangan-dokter-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
