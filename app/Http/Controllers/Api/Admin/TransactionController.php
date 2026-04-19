<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/transactions */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'patient:id,name,nik',
            'processedBy:id,name',
            'handledBy:id,name',
            'items',
        ]);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $this->successResponse($query->orderByDesc('date')->paginate(15), 'Data transaksi');
    }

    /** POST /api/admin/transactions */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'patient_id'     => 'required|exists:patients,id',
            'payment_method' => 'required|in:umum,bpjs',
            'notes'          => 'nullable|string',
            'handled_by'     => 'nullable|exists:users,id',
            'items'          => 'required|array|min:1',
            'items.*.item_type' => 'required|in:service,medicine',
            'items.*.item_id'   => 'required|integer',
            'items.*.quantity'  => 'required|integer|min:1',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $itemsData   = [];

            foreach ($request->items as $item) {
                if ($item['item_type'] === 'medicine') {
                    $medicine = Medicine::findOrFail($item['item_id']);
                    $price    = $medicine->price;
                    $name     = $medicine->name;

                    if ($medicine->stock < $item['quantity']) {
                        return $this->errorResponse("Stok obat {$medicine->name} tidak mencukupi", 422);
                    }
                    $medicine->decrement('stock', $item['quantity']);
                } else {
                    $service  = \App\Models\Service::findOrFail($item['item_id']);
                    $price    = $service->price;
                    $name     = $service->name;
                }
                $subtotal   = $price * $item['quantity'];
                $totalAmount += $subtotal;
                $itemsData[] = [
                    'item_type' => $item['item_type'],
                    'item_id'   => $item['item_id'],
                    'name'      => $name,
                    'quantity'  => $item['quantity'],
                    'price'     => $price,
                    'subtotal'  => $subtotal,
                ];
            }

            $handledByUser = $request->handled_by ? \App\Models\User::find($request->handled_by) : null;
            $revPct        = $handledByUser ? ($handledByUser->revenue_percentage ?? 0) : 0;
            $medRevenue    = $totalAmount * ($revPct / 100);

            $transaction = Transaction::create([
                'patient_id'           => $request->patient_id,
                'total_amount'         => $totalAmount,
                'medical_staff_revenue'=> $medRevenue,
                'clinic_revenue'       => $totalAmount - $medRevenue,
                'status'               => 'paid',
                'staff_payment_status' => 'unpaid',
                'payment_method'       => $request->payment_method,
                'date'                 => now(),
                'notes'                => $request->notes,
                'processed_by'         => $request->user()->id,
                'handled_by'           => $request->handled_by,
            ]);

            foreach ($itemsData as $row) {
                $transaction->items()->create($row);
            }

            DB::commit();
            return $this->successResponse($transaction->load('items'), 'Transaksi berhasil dibuat', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Gagal membuat transaksi: ' . $e->getMessage(), 500);
        }
    }

    /** GET /api/admin/transactions/{id} */
    public function show($id)
    {
        $t = Transaction::with(['patient', 'processedBy:id,name', 'handledBy:id,name', 'items'])->findOrFail($id);
        return $this->successResponse($t, 'Detail transaksi');
    }

    /** PUT /api/admin/transactions/{id} */
    public function update(Request $request, $id)
    {
        $t = Transaction::findOrFail($id);
        $v = Validator::make($request->all(), [
            'status'         => 'sometimes|required|in:paid,cancelled,pending',
            'payment_method' => 'sometimes|required|in:umum,bpjs',
            'notes'          => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $t->update($request->only('status', 'payment_method', 'notes'));
        return $this->successResponse($t, 'Transaksi berhasil diperbarui');
    }

    /** DELETE /api/admin/transactions/{id} */
    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return $this->successResponse(null, 'Transaksi berhasil dihapus');
    }
}
