<?php

namespace App\Http\Controllers\Dokter;

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
            ->where('handled_by', auth()->id())
            ->whereDate('created_at', $date)
            ->latest()
            ->paginate(10);

        return view('dokter.transactions.index', compact('transactions', 'date'));
    }

    public function create()
    {
        // Only show patients whose today's queue is assigned to this practitioner
        $patients = Patient::whereHas('queues', function ($query) {
            $query->where('date', date('Y-m-d'))
                ->where('assigned_practitioner_id', auth()->id());
        })->get();
        $services = Service::all();
        $medicines = Medicine::all();
        return view('dokter.transactions.create', compact('patients', 'services', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'required|in:cash,bpjs',
            'items' => 'required|array',
            'items.*.type' => 'required|in:service,medicine',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Authorization: check if logged-in user is the assigned practitioner
            $queue = \App\Models\Queue::where('patient_id', $request->patient_id)
                ->where('date', date('Y-m-d'))
                ->where('assigned_practitioner_id', auth()->id())
                ->first();

            if (!$queue) {
                abort(403, 'Anda bukan praktisi yang ditugaskan untuk pasien ini.');
            }

            $totalAmount = 0;
            $transaction = Transaction::create([
                'patient_id' => $request->patient_id,
                'payment_method' => $request->payment_method,
                'date' => now(),
                'status' => 'unpaid',
                'total_amount' => 0,
                'notes' => $request->notes,
                'handled_by' => auth()->id(),
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

                    // Deduct stock if item is medicine
                    if ($itemData['type'] === 'medicine') {
                        $item->decrement('stock', $itemData['quantity']);
                    }
                }
            }

            // Removed BPJS 0 logic so price remains valid
            $transaction->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('dokter.transactions.index')->with('success', 'Transaction created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating transaction: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['patient', 'items']);
        return view('dokter.transactions.show', compact('transaction'));
    }

    public function printStruk(Transaction $transaction)
    {
        $transaction->load(['patient', 'items', 'patient.medicalRecords']);
        return view('dokter.transactions.print_struk', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $transaction->load(['patient', 'items']);
        $patients = Patient::all();
        $services = Service::all();
        $medicines = Medicine::all();
        return view('dokter.transactions.edit', compact('transaction', 'patients', 'services', 'medicines'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Simple status update logic (fallback)
        if ($request->has('status') && !$request->has('items')) {
            $transaction->update(['status' => $request->status]);
            return back()->with('success', 'Transaction updated.');
        }

        // Full edit update logic
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'required|in:cash,bpjs',
            'items' => 'required|array',
            'items.*.type' => 'required|in:service,medicine',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:unpaid,paid',
        ]);

        try {
            DB::beginTransaction();

            // 1. Restore stock for medicines in the OLD transaction
            $oldItems = TransactionItem::where('transaction_id', $transaction->id)->get();
            foreach ($oldItems as $oldItem) {
                if ($oldItem->item_type == 'App\Models\Medicine') {
                    $medicine = Medicine::find($oldItem->item_id);
                    if ($medicine) {
                        $medicine->increment('stock', $oldItem->quantity);
                    }
                }
            }

            // 2. Delete ALL old items
            TransactionItem::where('transaction_id', $transaction->id)->delete();

            // 3. Process new items and calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $item = null;
                $price = 0;
                $name = '';

                if ($itemData['type'] === 'service' || $itemData['type'] === 'App\Models\Service') {
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

                    // Deduct stock if item is medicine
                    if ($itemData['type'] === 'medicine' || $itemData['type'] === 'App\Models\Medicine') {
                        $item->decrement('stock', $itemData['quantity']);
                    }
                }
            }

            // 4. Update core transaction record
            $transaction->update([
                'patient_id' => $request->patient_id,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('dokter.transactions.index')->with('success', 'Transaction updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating transaction: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('success', 'Transaction deleted.');
    }
}
