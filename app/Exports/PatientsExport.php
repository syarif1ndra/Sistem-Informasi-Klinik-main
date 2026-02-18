<?php

namespace App\Exports;

use App\Models\Queue; // Add this
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatientsExport implements FromView, ShouldAutoSize
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        return view('admin.patients.excel', [
            'visits' => Queue::with('patient')->whereDate('date', $this->date)->orderBy('queue_number', 'asc')->get(),
            'date' => $this->date
        ]);
    }
}
