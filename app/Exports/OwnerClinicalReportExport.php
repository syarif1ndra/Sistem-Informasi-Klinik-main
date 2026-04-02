<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OwnerClinicalReportExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $type;
    protected $practitionerId;
    protected $startDate;
    protected $endDate;
    protected $month;
    protected $year;
    protected $paymentMethod;
    protected $staffPaymentStatus;

    public function __construct($type, $practitionerId, $startDate, $endDate, $month, $year, $paymentMethod = 'all', $staffPaymentStatus = 'all')
    {
        $this->type = $type;
        $this->practitionerId = $practitionerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->month = $month;
        $this->year = $year;
        $this->paymentMethod = $paymentMethod;
        $this->staffPaymentStatus = $staffPaymentStatus;
    }

    public function view(): View
    {
        $practitioners = User::whereIn('role', ['dokter', 'bidan'])->get();
        $query = Transaction::with([
            'patient',
            'items' => function ($q) {
                $q->where('item_type', 'App\Models\Service');
            }
        ]);

        if ($this->practitionerId !== 'all') {
            $query->where('handled_by', $this->practitionerId);
        }

        if ($this->paymentMethod !== 'all') {
            $query->where('payment_method', $this->paymentMethod);
        }

        if ($this->staffPaymentStatus !== 'all') {
            $query->where('staff_payment_status', $this->staffPaymentStatus);
        }

        if ($this->type === 'monthly') {
            $date = Carbon::createFromFormat('Y-m', $this->month);
            $query->whereYear('date', $date->year)->whereMonth('date', $date->month);
            $transactions = $query->orderBy('date', 'asc')->get();
            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            
            $totalClinicRevenue = 0;
            $totalMedicalRevenue = 0;
            foreach ($transactions->where('status', 'paid') as $t) {
                if ($t->medical_staff_revenue > 0 || $t->clinic_revenue > 0) {
                    $totalClinicRevenue += $t->clinic_revenue;
                    $totalMedicalRevenue += $t->medical_staff_revenue;
                } else {
                    $totalClinicRevenue += $t->total_amount;
                }
            }
            
            $totalTransactions = $transactions->count();

            return view('owner.reports.pdf_monthly', [
                'transactions' => $transactions,
                'month' => $this->month,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalClinicRevenue' => $totalClinicRevenue,
                'totalMedicalRevenue' => $totalMedicalRevenue,
                'totalTransactions' => $totalTransactions,
                'paymentMethod' => $this->paymentMethod,
                'staffPaymentStatus' => $this->staffPaymentStatus,
                'isExcel' => true
            ]);

        } elseif ($this->type === 'yearly') {
            $query->whereYear('date', $this->year);
            $rawTransactions = $query->select(
                DB::raw('MONTH(date) as label_month'),
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN total_amount ELSE 0 END) as total_revenue'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN (CASE WHEN clinic_revenue > 0 OR medical_staff_revenue > 0 THEN clinic_revenue ELSE total_amount END) ELSE 0 END) as total_clinic_revenue'),
                DB::raw('SUM(CASE WHEN status = "paid" THEN medical_staff_revenue ELSE 0 END) as total_medical_revenue')
            )
                ->groupBy('label_month')
                ->orderBy('label_month', 'asc')
                ->get()
                ->keyBy('label_month');

            $transactions = collect(range(1, 12))->map(function ($month) use ($rawTransactions) {
                if (isset($rawTransactions[$month])) {
                    return $rawTransactions[$month];
                }
                return (object) [
                    'label_month' => $month,
                    'total_count' => 0,
                    'total_revenue' => 0,
                    'total_clinic_revenue' => 0,
                    'total_medical_revenue' => 0
                ];
            });

            $totalRevenue = $transactions->sum('total_revenue');
            $totalClinicRevenue = $transactions->sum('total_clinic_revenue');
            $totalMedicalRevenue = $transactions->sum('total_medical_revenue');
            $totalTransactions = $transactions->sum('total_count');

            return view('owner.reports.pdf_yearly', [
                'transactions' => $transactions,
                'year' => $this->year,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalClinicRevenue' => $totalClinicRevenue,
                'totalMedicalRevenue' => $totalMedicalRevenue,
                'totalTransactions' => $totalTransactions,
                'paymentMethod' => $this->paymentMethod,
                'staffPaymentStatus' => $this->staffPaymentStatus,
                'isExcel' => true
            ]);

        } else {
            // Daily Data
            $query->whereDate('date', '>=', $this->startDate)->whereDate('date', '<=', $this->endDate);
            $transactions = $query->orderBy('created_at', 'asc')->get();
            $totalRevenue = $transactions->where('status', 'paid')->sum('total_amount');
            
            $totalClinicRevenue = 0;
            $totalMedicalRevenue = 0;
            foreach ($transactions->where('status', 'paid') as $t) {
                if ($t->medical_staff_revenue > 0 || $t->clinic_revenue > 0) {
                    $totalClinicRevenue += $t->clinic_revenue;
                    $totalMedicalRevenue += $t->medical_staff_revenue;
                } else {
                    $totalClinicRevenue += $t->total_amount;
                }
            }
            
            $totalTransactions = $transactions->count();

            return view('owner.reports.pdf_daily', [
                'transactions' => $transactions,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'practitionerId' => $this->practitionerId,
                'practitioners' => $practitioners,
                'type' => $this->type,
                'totalRevenue' => $totalRevenue,
                'totalClinicRevenue' => $totalClinicRevenue,
                'totalMedicalRevenue' => $totalMedicalRevenue,
                'totalTransactions' => $totalTransactions,
                'paymentMethod' => $this->paymentMethod,
                'staffPaymentStatus' => $this->staffPaymentStatus,
                'isExcel' => true
            ]);
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
        ];
    }
}
