<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminReportExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $type;
    protected $practitionerId;
    protected $startDate;
    protected $endDate;
    protected $month;
    protected $year;

    public function __construct($type, $practitionerId, $startDate, $endDate, $month, $year)
    {
        $this->type = $type;
        $this->practitionerId = $practitionerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $practitioners = User::whereIn('role', ['dokter', 'bidan'])->get();
        $query = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ]);

        if ($this->practitionerId !== 'all') {
            $query->where('handled_by', $this->practitionerId);
        }

        if ($this->type === 'monthly') {
            $date = Carbon::createFromFormat('Y-m', $this->month);
            $query->whereYear('date', $date->year)->whereMonth('date', $date->month);
            $transactions = $query->orderBy('date', 'asc')->get();
            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            $totalTransactions = $transactions->count();

            return view('admin.reports.pdf_monthly', [
                'transactions' => $transactions,
                'month' => $this->month,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalTransactions' => $totalTransactions
            ]);

        } elseif ($this->type === 'yearly') {
            $query->whereYear('date', $this->year);
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

            return view('admin.reports.pdf_yearly', [
                'transactions' => $transactions,
                'year' => $this->year,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalTransactions' => $totalTransactions
            ]);

        } else {
            // Daily Data
            $query->whereDate('date', '>=', $this->startDate)->whereDate('date', '<=', $this->endDate);
            $transactions = $query->orderBy('created_at', 'asc')->get();
            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            $totalTransactions = $transactions->count();

            return view('admin.reports.pdf_monthly', [
                'transactions' => $transactions,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'month' => $this->month,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalTransactions' => $totalTransactions
            ]);
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
        ];
    }
}
