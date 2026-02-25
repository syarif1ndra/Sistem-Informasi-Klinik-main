<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Only transactions handled by this bidan
        $query = Transaction::with('patient')
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        $totalRevenue = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
            $q->where('handled_by', auth()->id())
                ->where('status', 'paid')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate);
        })
            ->where('item_type', 'App\Models\Service')
            ->sum('subtotal') * 0.4;

        $totalTransactions = (clone $query)->count();

        $transactions = (clone $query)->with([
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])->oldest()->paginate(15);

        $transactions->getCollection()->transform(function ($transaction) {
            if ($transaction->status === 'paid') {
                $serviceSum = $transaction->items->sum('subtotal');
                $transaction->practitioner_income = $serviceSum * 0.4;
            } else {
                $transaction->practitioner_income = 0;
            }
            return $transaction;
        });

        $transactions->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        return view('bidan.reports.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BidanReportExport($startDate, $endDate), 'laporan-keuangan-bidan-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Only transactions handled by this bidan
        $query = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        $totalRevenue = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
            $q->where('handled_by', auth()->id())
                ->where('status', 'paid')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate);
        })
            ->where('item_type', 'App\Models\Service')
            ->sum('subtotal') * 0.4;

        $totalTransactions = (clone $query)->count();
        $transactions = (clone $query)->oldest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bidan.reports.pdf', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-keuangan-bidan-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
