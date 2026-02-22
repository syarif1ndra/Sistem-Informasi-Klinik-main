<?php

namespace App\Exports;

use App\Models\BirthRecord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BirthRecordsExport implements FromView, ShouldAutoSize
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
        return view('admin.birth_records.excel', [
            'birthRecords' => BirthRecord::whereBetween('birth_date', [$this->startDate, $this->endDate])
                ->orderBy('birth_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
