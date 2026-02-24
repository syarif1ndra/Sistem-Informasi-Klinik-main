<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Medicine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->endOfDay()->toDateString());

        // Basic Metrics
        $totalPasienHariIni = Queue::where('date', Carbon::today()->toDateString())->count();
        $totalKunjunganBulanIni = Queue::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)->count();

        $totalPendapatanHariIni = Transaction::where('date', Carbon::today()->toDateString())
            ->where('status', 'paid')->sum('total_amount');

        $totalPendapatanBulanIni = Transaction::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', 'paid')->sum('total_amount');

        $totalTransaksi = Transaction::whereBetween('date', [$startDate, $endDate])->count();
        $totalDokterAktif = User::where('role', 'dokter')->count();

        // Obat Terjual Filtered
        $totalObatTerjual = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate])->where('status', 'paid');
        })->where('item_type', 'App\Models\Medicine')->sum('quantity');

        // Charts Data
        // Pendapatan 12 Bulan Terakhir
        $chartPendapatan = Transaction::select(
            DB::raw('sum(total_amount) as sums'),
            DB::raw("DATE_FORMAT(date,'%Y-%m') as months")
        )
            ->where('status', 'paid')
            ->where('date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('months')
            ->orderBy('months')
            ->get();

        $labelsPendapatan = [];
        $dataPendapatan = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $labelsPendapatan[] = Carbon::now()->subMonths($i)->translatedFormat('M Y');
            $match = $chartPendapatan->firstWhere('months', $month);
            $dataPendapatan[] = $match ? $match->sums : 0;
        }

        // Kunjungan Pasien 7 Hari Terakhir
        $chartPasien = Queue::select(
            DB::raw('count(id) as total'),
            DB::raw('DATE(date) as dates')
        )
            ->where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('dates')
            ->orderBy('dates')
            ->get();

        $labelsPasien = [];
        $dataPasien = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labelsPasien[] = Carbon::now()->subDays($i)->translatedFormat('d M');
            $match = $chartPasien->firstWhere('dates', $date);
            $dataPasien[] = $match ? $match->total : 0;
        }

        // Top Data (Filtered by date)
        // Staf Medis Teraktif (Dokter, Bidan)
        $topStaff = User::whereIn('role', ['dokter', 'bidan'])
            ->withCount([
                'handledQueues as total' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate])->where('status', 'finished');
                }
            ])
            ->get();

        foreach ($topStaff as $staff) {
            $staff->revenue = \App\Models\Transaction::where('status', 'paid')
                ->whereBetween('date', [$startDate, $endDate])
                ->whereExists(function ($query) use ($staff) {
                    $query->select(DB::raw(1))
                        ->from('queues')
                        ->whereColumn('queues.patient_id', 'transactions.patient_id')
                        ->whereColumn('queues.date', 'transactions.date')
                        ->where('queues.handled_by', $staff->id);
                })->sum('total_amount');

            $staff->staff_name = $staff->name;
        }

        $topStaff = $topStaff->sortByDesc('total')->take(5);

        // Layanan paling sering digunakan
        $topServices = TransactionItem::select('name', DB::raw('count(*) as total'))
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->where('item_type', 'App\Models\Service')
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Obat terlaris
        $topMedicines = TransactionItem::select('name', DB::raw('sum(quantity) as total'))
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->where('item_type', 'App\Models\Medicine')
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Monitoring
        $lowStockMedicines = Medicine::where('stock', '<=', 10)->get();
        $expiredMedicines = Medicine::whereNotNull('expired_date')
            ->where('expired_date', '<=', Carbon::now()->addDays(30)->toDateString())
            ->orderBy('expired_date', 'asc')
            ->get();

        // 10 Transaksi Terbaru
        $latestTransactions = Transaction::with('patient')->orderBy('created_at', 'desc')->limit(10)->get();

        return view('owner.dashboard', compact(
            'totalPasienHariIni',
            'totalKunjunganBulanIni',
            'totalPendapatanHariIni',
            'totalPendapatanBulanIni',
            'totalTransaksi',
            'totalDokterAktif',
            'totalObatTerjual',
            'labelsPendapatan',
            'dataPendapatan',
            'labelsPasien',
            'dataPasien',
            'topStaff',
            'topServices',
            'topMedicines',
            'lowStockMedicines',
            'expiredMedicines',
            'latestTransactions',
            'startDate',
            'endDate'
        ));
    }

    private function getExportData(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->endOfDay()->toDateString());

        $totalPasienHariIni = Queue::where('date', Carbon::today()->toDateString())->count();
        $totalKunjunganBulanIni = Queue::whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->count();
        $totalPendapatanHariIni = Transaction::where('date', Carbon::today()->toDateString())->where('status', 'paid')->sum('total_amount');
        $totalPendapatanBulanIni = Transaction::whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->where('status', 'paid')->sum('total_amount');
        $totalTransaksi = Transaction::whereBetween('date', [$startDate, $endDate])->count();
        $totalObatTerjual = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate])->where('status', 'paid');
        })->where('item_type', 'App\Models\Medicine')->sum('quantity');

        $topServices = TransactionItem::select('name', DB::raw('count(*) as total'))
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->where('item_type', 'App\Models\Service')->groupBy('name')->orderByDesc('total')->limit(5)->get();

        $topMedicines = TransactionItem::select('name', DB::raw('sum(quantity) as total'))
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->where('item_type', 'App\Models\Medicine')->groupBy('name')->orderByDesc('total')->limit(5)->get();

        $lowStockMedicines = Medicine::where('stock', '<=', 10)->get();
        $expiredMedicines = Medicine::whereNotNull('expired_date')->where('expired_date', '<=', Carbon::now()->addDays(30)->toDateString())->orderBy('expired_date', 'asc')->get();
        $latestTransactions = Transaction::with('patient')->orderBy('created_at', 'desc')->limit(10)->get();

        return compact(
            'startDate',
            'endDate',
            'totalPasienHariIni',
            'totalKunjunganBulanIni',
            'totalPendapatanHariIni',
            'totalPendapatanBulanIni',
            'totalTransaksi',
            'totalObatTerjual',
            'topServices',
            'topMedicines',
            'lowStockMedicines',
            'expiredMedicines',
            'latestTransactions'
        );
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getExportData($request);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\OwnerReportExport($data), 'Laporan_Klinik_' . date('Ymd') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getExportData($request);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.exports.pdf', $data);
        return $pdf->download('Laporan_Klinik_' . date('Ymd') . '.pdf');
    }
}
