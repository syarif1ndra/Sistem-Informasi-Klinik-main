<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        // Kas Masuk (Paid Transactions)
        $kasMasuk = Transaction::where('status', 'paid')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->sum('total_amount');

        // Kas Keluar (Expenses)
        $kasKeluar = Expense::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->sum('amount');

        $labaKotor = $kasMasuk - $kasKeluar;

        // Calculate modal obat for net profit (Harga Beli * Quantity Sold)
        $modalObat = \App\Models\TransactionItem::where('item_type', 'App\Models\Medicine')
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->where('status', 'paid');
            })
            ->get()
            ->sum(function ($item) {
                $medicine = \App\Models\Medicine::find($item->item_id);
                // Jika purchase_price null, asumsikan 0 (tidak mengurangi laba)
                return $medicine ? (($medicine->purchase_price ?? 0) * $item->quantity) : 0;
            });

        $labaBersih = $labaKotor - $modalObat;

        // Pending Transactions
        $pendingTrans = Transaction::where('status', 'unpaid')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->sum('total_amount');

        // Expenses List
        $expenses = Expense::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->orderBy('date', 'desc')->get();

        return view('owner.finance.index', compact('startDate', 'endDate', 'kasMasuk', 'kasKeluar', 'labaKotor', 'labaBersih', 'modalObat', 'pendingTrans', 'expenses'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
