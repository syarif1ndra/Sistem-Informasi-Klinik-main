<?php

namespace App\Exports;

use App\Models\Patient;
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
            'patients' => Patient::whereDate('updated_at', $this->date)->latest()->get(),
            'date' => $this->date
        ]);
    }
}
