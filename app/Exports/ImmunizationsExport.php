<?php

namespace App\Exports;

use App\Models\Immunization;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ImmunizationsExport implements FromView, ShouldAutoSize
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        return view('admin.immunizations.excel', [
            'immunizations' => Immunization::whereDate('immunization_date', $this->date)->latest()->get(),
            'date' => $this->date
        ]);
    }
}
