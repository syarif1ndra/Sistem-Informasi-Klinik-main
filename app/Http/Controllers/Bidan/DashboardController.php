<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Transaction;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');

        // Personal stats: only patients handled by this bidan
        $totalHandledPatients = Patient::whereHas('queues', function ($q) {
            $q->where('assigned_practitioner_id', auth()->id());
        })->count();

        // Personal revenue
        $personalRevenue = Transaction::where('handled_by', auth()->id())
            ->where('status', 'paid')
            ->sum('total_amount');

        // Queues assigned to this bidan today
        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $today)
            ->where('assigned_practitioner_id', auth()->id())
            ->orderBy('queue_number')
            ->get();

        // Chart Data Extraction
        // 1. Kehamilan (Pregnancy Consultations) per month for the last 12 months
        $pregnancyChart = $this->getMonthlyServiceCount('Poli Kebidanan & Kandungan'); // Or adapt service name

        // 2. Imunisasi (Immunization) per month for the last 12 months
        $immunizationChart = $this->getMonthlyServiceCount('Imunisasi');

        // 3. Persalinan (Births/Labour) per month for the last 12 months
        $birthChart = $this->getMonthlyServiceCount('Persalinan');

        return view('bidan.dashboard', compact(
            'totalHandledPatients',
            'personalRevenue',
            'recentQueues',
            'pregnancyChart',
            'immunizationChart',
            'birthChart',
            'today'
        ));
    }

    private function getMonthlyServiceCount($serviceNameMatch)
    {
        $months = [];
        $counts = [];

        // We want to count from Queue or Patient based on "service" requested.
        // Assuming service in queue refers to the type of visit
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthName;

            $count = Queue::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('service_name', 'like', "%{$serviceNameMatch}%")
                ->count();

            $counts[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }

    public function queueTableData(Request $request)
    {
        $today = date('Y-m-d');
        $recentQueues = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $today)
            ->where('assigned_practitioner_id', auth()->id())
            ->orderBy('queue_number')
            ->get();

        return view('bidan.partials.queue_table', compact('recentQueues'));
    }
}
