<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DokterReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $transactions = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $this->startDate)
            ->whereDate('date', '<=', $this->endDate)
            ->oldest()
            ->get();

        $transactions->transform(function ($transaction) {
            if ($transaction->status === 'paid') {
                $serviceSum = $transaction->items->sum('subtotal');
                $transaction->practitioner_income = $serviceSum * 0.5;
            } else {
                $transaction->practitioner_income = 0;
            }
            return $transaction;
        });

        return $transactions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No. Transaksi',
            'Nama Pasien',
            'Layanan Diberikan',
            'Total Jasa Medis',
            'Pendapatan Anda (50%)',
            'Status'
        ];
    }

    public function map($transaction): array
    {
        $services = $transaction->items->map(function ($item) {
            return $item->item_name;
        })->implode(', ');

        return [
            \Carbon\Carbon::parse($transaction->date)->format('d/m/Y'),
            $transaction->transaction_number,
            $transaction->patient->name ?? '-',
            $services ?: '-',
            'Rp ' . number_format($transaction->items->sum('subtotal'), 0, ',', '.'),
            'Rp ' . number_format($transaction->practitioner_income, 0, ',', '.'),
            ucfirst($transaction->status)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
