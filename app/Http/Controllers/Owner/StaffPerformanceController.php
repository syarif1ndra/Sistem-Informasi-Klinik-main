<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffPerformanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->endOfDay()->toDateString());

        // Medis (Dokter, Bidan, Perawat)
        $medis = User::whereIn('role', ['dokter', 'bidan', 'perawat'])
            ->withCount([
                'handledQueues as total_pasien' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate])->where('status', 'finished');
                }
            ])
            ->get();

        // Calculate revenue for each medis
        foreach ($medis as $staff) {
            $staff->revenue = \App\Models\Transaction::where('status', 'paid')
                ->whereBetween('date', [$startDate, $endDate])
                ->whereExists(function ($query) use ($staff) {
                    $query->select(DB::raw(1))
                        ->from('queues')
                        ->whereColumn('queues.patient_id', 'transactions.patient_id')
                        ->whereColumn('queues.date', 'transactions.date')
                        ->where('queues.handled_by', $staff->id);
                })->sum('total_amount');
        }

        return view('owner.staff.index', compact('medis', 'startDate', 'endDate'));
    }
}
