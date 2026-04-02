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
                
            $staff->net_revenue = \App\Models\Transaction::where('handled_by', $staff->id)
                ->where('status', 'paid')
                ->whereBetween('date', [$startDateTime, $endDateTime])
                ->sum('medical_staff_revenue');
        }

        return view('owner.staff.index', compact('medis', 'startDate', 'endDate'));
    }

    public function updateFee(Request $request, User $user)
    {
        $request->validate([
            'consultation_fee' => 'required|integer|min:0',
            'revenue_percentage' => 'required|integer|min:0|max:100',
        ]);

        $user->update([
            'consultation_fee' => $request->consultation_fee,
            'revenue_percentage' => $request->revenue_percentage,
        ]);

        return back()->with('success', 'Pengaturan fee untuk ' . $user->name . ' berhasil diperbarui.');
    }
}
