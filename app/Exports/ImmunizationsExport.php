<?php

namespace App\Exports;

use App\Models\Immunization;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ImmunizationsExport implements FromView, ShouldAutoSize
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
        return view('admin.immunizations.excel', [
            'immunizations' => Immunization::whereBetween('immunization_date', [$this->startDate, $this->endDate])
                ->orderBy('immunization_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
