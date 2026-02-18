<?php

namespace App\Exports;

use App\Models\BirthRecord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BirthRecordsExport implements FromView, ShouldAutoSize
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        return view('admin.birth_records.excel', [
            'birthRecords' => BirthRecord::whereDate('birth_date', $this->date)->latest()->get(),
            'date' => $this->date
        ]);
    }
}
