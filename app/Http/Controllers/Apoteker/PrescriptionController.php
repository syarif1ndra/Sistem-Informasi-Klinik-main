<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $query = Prescription::with(['patient', 'practitioner'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $prescriptions = $query->paginate(15);
        return view('apoteker.prescriptions.index', compact('prescriptions', 'status'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'practitioner', 'items.medicine']);
        return view('apoteker.prescriptions.show', compact('prescription'));
    }

    public function updateStatus(Request $request, Prescription $prescription)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,siap_diambil,selesai',
        ]);

        $newStatus = $request->status;
        $oldStatus = $prescription->status;

        try {
            DB::beginTransaction();

            // If changing from "menunggu" to "diproses", deduct stock
            if ($oldStatus === 'menunggu' && $newStatus === 'diproses') {
                $prescription->load('items.medicine');
                foreach ($prescription->items as $item) {
                    $medicine = $item->medicine;
                    if ($medicine) {
                        if ($medicine->stock < $item->quantity) {
                            throw new \Exception("Stok {$medicine->name} tidak mencukupi (Sisa: {$medicine->stock}, Butuh: {$item->quantity})");
                        }

                        $medicine->decrement('stock', $item->quantity);

                        StockLog::create([
                            'medicine_id' => $medicine->id,
                            'type' => 'keluar',
                            'quantity' => $item->quantity,
                            'description' => "Resep #{$prescription->id} untuk pasien {$prescription->patient->name}"
                        ]);
                    }
                }
            }

            // If rolling back from diproses back to menunggu (optional feature but good to have)
            elseif ($oldStatus !== 'menunggu' && $newStatus === 'menunggu') {
                $prescription->load('items.medicine');
                foreach ($prescription->items as $item) {
                    $medicine = $item->medicine;
                    if ($medicine) {
                        $medicine->increment('stock', $item->quantity);
                        StockLog::create([
                            'medicine_id' => $medicine->id,
                            'type' => 'masuk',
                            'quantity' => $item->quantity,
                            'description' => "Batal Resep #{$prescription->id}"
                        ]);
                    }
                }
            }

            $prescription->update(['status' => $newStatus]);

            DB::commit();
            return back()->with('success', 'Status resep berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function printEtiket(Prescription $prescription, \App\Models\PrescriptionItem $item)
    {
        $prescription->load(['patient', 'practitioner']);
        $item->load('medicine');
        return view('apoteker.prescriptions.etiket', compact('prescription', 'item'));
    }
}
