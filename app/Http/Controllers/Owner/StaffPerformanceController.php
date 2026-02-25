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
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        // Medis (Dokter, Bidan)
        $medis = User::whereIn('role', ['dokter', 'bidan'])
            ->withCount([
                'handledTransactions as total_pasien' => function ($query) use ($startDateTime, $endDateTime) {
                    $query->whereBetween('date', [$startDateTime, $endDateTime]);
                }
            ])
            ->get();

        // Calculate revenue for each medis
        foreach ($medis as $staff) {
            $staff->revenue = \App\Models\Transaction::where('handled_by', $staff->id)
                ->where('status', 'paid')
                ->whereBetween('date', [$startDateTime, $endDateTime])
                ->sum('total_amount');
        }

        return view('owner.staff.index', compact('medis', 'startDate', 'endDate'));
    }
}
