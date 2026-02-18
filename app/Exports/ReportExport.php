<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromView, ShouldAutoSize
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $startDate = "$this->year-$this->month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $transactions = Transaction::with('patient')
            ->whereBetween('date', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('admin.reports.excel', [
            'transactions' => $transactions,
            'month' => $this->month,
            'year' => $this->year
        ]);
    }
}
