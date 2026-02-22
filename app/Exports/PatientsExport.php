<?php

namespace App\Exports;

use App\Models\Queue; // Add this
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatientsExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('admin.patients.excel', [
            'visits' => Queue::with('patient')
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->orderBy('date', 'desc')
                ->orderBy('queue_number', 'asc')
                ->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
