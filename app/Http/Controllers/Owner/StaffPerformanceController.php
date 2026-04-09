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
                
            $payment = \App\Models\SalaryPayment::where('user_id', $staff->id)
                ->where('periode_start', $startDate)
                ->where('periode_end', $endDate)
                ->first();
                
            $staff->salary_status = $payment ? $payment->status : 'belum';
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

    public function togglePayment(Request $request, User $user)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'action' => 'required|in:pay,cancel'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $payment = \App\Models\SalaryPayment::where('user_id', $user->id)
            ->where('periode_start', $startDate)
            ->where('periode_end', $endDate)
            ->first();

        if ($request->action === 'pay') {
            if (!$payment) {
                $startDateTime = Carbon::parse($startDate)->startOfDay();
                $endDateTime = Carbon::parse($endDate)->endOfDay();
                $netRevenue = \App\Models\Transaction::where('handled_by', $user->id)
                    ->where('status', 'paid')
                    ->whereBetween('date', [$startDateTime, $endDateTime])
                    ->sum('medical_staff_revenue');

                \App\Models\SalaryPayment::create([
                    'user_id' => $user->id,
                    'periode_start' => $startDate,
                    'periode_end' => $endDate,
                    'total_gaji' => $netRevenue,
                    'status' => 'dibayar',
                    'paid_at' => now()
                ]);
            } else {
                $payment->update([
                    'status' => 'dibayar',
                    'paid_at' => now()
                ]);
            }
        } else {
            if ($payment) {
                $payment->update([
                    'status' => 'belum',
                    'paid_at' => null
                ]);
            }
        }

        return back()->with('success', 'Status pembayaran gaji berhasil diperbarui.');
    }
}
