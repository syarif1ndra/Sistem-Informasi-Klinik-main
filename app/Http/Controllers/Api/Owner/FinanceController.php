<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    use ApiResponse;

    /** GET /api/owner/finance */
    public function index(Request $request)
    {
        $expenseQuery = Expense::with('user:id,name');
        $revenueQuery = Transaction::where('status', 'paid');

        if ($request->filled('date_from')) {
            $expenseQuery->whereDate('date', '>=', $request->date_from);
            $revenueQuery->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $expenseQuery->whereDate('date', '<=', $request->date_to);
            $revenueQuery->whereDate('date', '<=', $request->date_to);
        }

        $totalRevenue  = (clone $revenueQuery)->sum('clinic_revenue');
        $totalExpenses = (clone $expenseQuery)->sum('amount');

        return $this->successResponse([
            'summary' => [
                'total_pemasukan_klinik' => $totalRevenue,
                'total_pengeluaran'      => $totalExpenses,
                'laba_bersih'            => $totalRevenue - $totalExpenses,
            ],
            'expenses' => $expenseQuery->orderByDesc('date')->paginate(15),
        ], 'Data keuangan klinik');
    }

    /** POST /api/owner/finance/expenses */
    public function storeExpense(Request $request)
    {
        $v = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $expense = Expense::create([
            'description' => $request->description,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'user_id'     => $request->user()->id,
        ]);

        return $this->successResponse($expense, 'Pengeluaran berhasil disimpan', 201);
    }

    /** DELETE /api/owner/finance/expenses/{id} */
    public function destroyExpense($id)
    {
        Expense::findOrFail($id)->delete();
        return $this->successResponse(null, 'Pengeluaran berhasil dihapus');
    }
}
