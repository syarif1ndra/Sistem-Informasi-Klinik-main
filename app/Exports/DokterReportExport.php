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
    protected $paymentMethod;

    public function __construct($startDate, $endDate, $paymentMethod = 'all')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentMethod = $paymentMethod;
    }

    public function collection()
    {
        $query = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ])
            ->where('handled_by', auth()->id())
            ->whereDate('date', '>=', $this->startDate)
            ->whereDate('date', '<=', $this->endDate);

        if ($this->paymentMethod !== 'all') {
            $query->where('payment_method', $this->paymentMethod);
        }

        $transactions = $query->oldest()->get();
        $totalJasaMedis = 0;
        $totalIncome = 0;

        $transactions->transform(function ($transaction) use (&$totalJasaMedis, &$totalIncome) {
            $serviceSum = $transaction->items->sum('subtotal');
            if ($transaction->status === 'paid') {
                $transaction->practitioner_income = $serviceSum * 0.5;
                $totalJasaMedis += $serviceSum;
                $totalIncome += $transaction->practitioner_income;
            } else {
                $transaction->practitioner_income = 0;
            }
            return $transaction;
        });

        $data = $transactions->toArray();

        // Add footer rows
        $results = collect($transactions);
        $results->push([
            '',
            '',
            'TOTAL JASA MEDIS ',
            'Rp ' . number_format($totalJasaMedis, 0, ',', '.'),
            ''
        ]);
        $results->push([
            '',
            '',
            'PENDAPATAN ANDA (50%)',
            'Rp ' . number_format($totalIncome, 0, ',', '.'),
            ''
        ]);
        $results->push(['', '', '', '', '']);
        $results->push(['', '', '', 'Natar, ' . now()->translatedFormat('d F Y'), '']);
        $results->push(['', '', '', 'Dokter Pemeriksa,', '']);
        $results->push(['', '', '', '', '']);
        $results->push(['', '', '', auth()->user()->name, '']);

        return $results;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Pasien',
            'Metode Pembayaran',
            'Jumlah Pendapatan',
            'Pendapatan Anda (50%)'
        ];
    }

    public function map($transaction): array
    {
        if (is_array($transaction)) {
            return $transaction;
        }

        $services = $transaction->items->map(function ($item) {
            return $item->item_name;
        })->implode(', ');

        return [
            \Carbon\Carbon::parse($transaction->date)->format('d/m/Y'),
            $transaction->patient->name ?? '-',
            $transaction->payment_method == 'cash' ? 'UMUM' : strtoupper($transaction->payment_method),
            'Rp ' . number_format($transaction->items->sum('subtotal'), 0, ',', '.'),
            'Rp ' . number_format($transaction->practitioner_income, 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
