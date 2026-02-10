<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $transactions = Transaction::with('patient')
            ->whereDate('created_at', $date)
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions', 'date'));
    }

    public function create()
    {
        // Only get patients who have a queue for TODAY
        $patients = Patient::whereHas('queues', function ($query) {
            $query->where('date', date('Y-m-d'));
        })->get();
        $services = Service::all();
        $medicines = Medicine::all();
        return view('admin.transactions.create', compact('patients', 'services', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'items' => 'required|array',
            'items.*.type' => 'required|in:service,medicine',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $transaction = Transaction::create([
                'patient_id' => $request->patient_id,
                'date' => now(),
                'status' => 'unpaid', // Default
                'total_amount' => 0, // Will update later
            ]);

            foreach ($request->items as $itemData) {
                $item = null;
                $price = 0;
                $name = '';

                if ($itemData['type'] === 'service') {
                    $item = Service::find($itemData['id']);
                } else {
                    $item = Medicine::find($itemData['id']);
                }

                if ($item) {
                    $price = $item->price;
                    $name = $item->name;
                    $subtotal = $price * $itemData['quantity'];
                    $totalAmount += $subtotal;

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'item_type' => get_class($item),
                        'item_id' => $item->id,
                        'name' => $name,
                        'quantity' => $itemData['quantity'],
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            $transaction->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating transaction: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['patient', 'items']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function printStruk(Transaction $transaction)
    {
        $transaction->load(['patient', 'items', 'patient.medicalRecords']);
        return view('admin.transactions.print_struk', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($request->has('status')) {
            $transaction->update(['status' => $request->status]);
        }
        return back()->with('success', 'Transaction updated.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('success', 'Transaction deleted.');
    }
}
