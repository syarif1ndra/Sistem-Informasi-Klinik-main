<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\User;
use App\Models\Transaction;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffPerformanceController extends Controller
{
    use ApiResponse;

    /** GET /api/owner/staff-performance */
    public function index(Request $request)
    {
        $staff = User::whereIn('role', ['dokter', 'bidan'])
            ->get()
            ->map(function (User $user) use ($request) {
                $query = Transaction::where('handled_by', $user->id)->where('status', 'dibayar');

                if ($request->filled('date_from')) $query->whereDate('date', '>=', $request->date_from);
                if ($request->filled('date_to'))   $query->whereDate('date', '<=', $request->date_to);

                $totalRevenue  = (clone $query)->sum('total_amount');
                $staffRevenue  = (clone $query)->sum('medical_staff_revenue');
                $paidRevenue   = (clone $query)->where('staff_payment_status', 'dibayar')->sum('medical_staff_revenue');
                $unpaidRevenue = $staffRevenue - $paidRevenue;

                // Last salary payment
                $lastPayment = SalaryPayment::where('user_id', $user->id)
                    ->orderByDesc('paid_at')->first();

                return [
                    'id'                 => $user->id,
                    'name'               => $user->name,
                    'role'               => $user->role,
                    'consultation_fee'   => $user->consultation_fee,
                    'revenue_percentage' => $user->revenue_percentage,
                    'total_transactions' => (clone $query)->count(),
                    'total_revenue'      => $totalRevenue,
                    'staff_revenue'      => $staffRevenue,
                    'paid_revenue'       => $paidRevenue,
                    'unpaid_revenue'     => $unpaidRevenue,
                    'last_salary_payment'=> $lastPayment,
                ];
            });

        return $this->successResponse($staff, 'Data kinerja staf');
    }

    /** PUT /api/owner/staff/{userId}/fee */
    public function updateFee(Request $request, $userId)
    {
        $user = User::whereIn('role', ['dokter', 'bidan'])->findOrFail($userId);

        $v = Validator::make($request->all(), [
            'consultation_fee'   => 'nullable|numeric|min:0',
            'revenue_percentage' => 'nullable|numeric|min:0|max:100',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $user->update($request->only('consultation_fee', 'revenue_percentage'));
        return $this->successResponse($user, 'Fee staf berhasil diperbarui');
    }

    /** POST /api/owner/staff/{userId}/salary-payment */
    public function toggleSalaryPayment(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $v = Validator::make($request->all(), [
            'periode_start' => 'required|date',
            'periode_end'   => 'required|date|after_or_equal:periode_start',
            'total_gaji'    => 'required|numeric|min:0',
            'status'        => 'required|in:dibayar,unpaid,cancelled',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $payment = SalaryPayment::create([
            'user_id'       => $user->id,
            'periode_start' => $request->periode_start,
            'periode_end'   => $request->periode_end,
            'total_gaji'    => $request->total_gaji,
            'status'        => $request->status,
            'paid_at'       => $request->status === 'dibayar' ? now() : null,
        ]);

        return $this->successResponse($payment, 'Pembayaran gaji berhasil disimpan', 201);
    }
}
