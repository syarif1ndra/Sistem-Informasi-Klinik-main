<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffPerformanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::today()->format('Y-m'));

        // Parse month to get start and end dates
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth()->toDateString();

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


        return view('owner.staff.index', compact('medis', 'month', 'startDate', 'endDate'));
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

                // Buat entry di expense (pengeluaran)
                Expense::create([
                    'description' => "Pembayaran gaji {$user->name} ({$user->role}) - Periode " . Carbon::parse($startDate)->format('d/m/Y') . " - " . Carbon::parse($endDate)->format('d/m/Y'),
                    'amount' => $netRevenue,
                    'date' => now()->toDateString(),
                    'user_id' => auth()->id(), // Owner yang melakukan pembayaran
                ]);
            } else {
                $payment->update([
                    'status' => 'dibayar',
                    'paid_at' => now()
                ]);

                // Jika sebelumnya belum ada di expense, buat entry baru
                $existingExpense = Expense::where('description', 'like', "Pembayaran gaji {$user->name}%")
                    ->where('date', now()->toDateString())
                    ->first();

                if (!$existingExpense) {
                    Expense::create([
                        'description' => "Pembayaran gaji {$user->name} ({$user->role}) - Periode " . Carbon::parse($startDate)->format('d/m/Y') . " - " . Carbon::parse($endDate)->format('d/m/Y'),
                        'amount' => $payment->total_gaji,
                        'date' => now()->toDateString(),
                        'user_id' => auth()->id(),
                    ]);
                }
            }
        } else {
            if ($payment) {
                $payment->update([
                    'status' => 'belum',
                    'paid_at' => null
                ]);

                // Hapus entry expense jika ada
                Expense::where('description', 'like', "Pembayaran gaji {$user->name}%")
                    ->where('date', now()->toDateString())
                    ->delete();
            }
        }

        return back()->with('success', 'Status pembayaran gaji berhasil diperbarui dan tercatat dalam rekap keuangan.');
    }
}
