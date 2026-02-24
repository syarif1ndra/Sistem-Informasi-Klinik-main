<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Medicine;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $medicines = Medicine::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        })->latest()->paginate(15);

        return view('apoteker.medicines.index', compact('medicines', 'search'));
    }

    // CRUD basic (if pharmacist is allowed to create new entries)
    public function create()
    {
        return view('apoteker.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'expired_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            $medicine = Medicine::create($request->all());

            if ($medicine->stock > 0) {
                StockLog::create([
                    'medicine_id' => $medicine->id,
                    'type' => 'masuk',
                    'quantity' => $medicine->stock,
                    'description' => 'Stok awal saat penambahan obat baru'
                ]);
            }
            DB::commit();
            return redirect()->route('apoteker.medicines.index')->with('success', 'Obat berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan obat: ' . $e->getMessage());
        }
    }

    public function edit(Medicine $medicine)
    {
        return view('apoteker.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'min_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'expired_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $medicine->update($request->except(['stock'])); // Stock is managed separately
        return redirect()->route('apoteker.medicines.index')->with('success', 'Data obat berhasil diperbarui');
    }

    // Specialized Logic for Apoteker
    public function addStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $medicine->increment('stock', $request->quantity);

            StockLog::create([
                'medicine_id' => $medicine->id,
                'type' => 'masuk',
                'quantity' => $request->quantity,
                'description' => $request->description ?? 'Penambahan stok manual'
            ]);

            DB::commit();
            return back()->with('success', 'Stok berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan stok: ' . $e->getMessage());
        }
    }

    public function adjustStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
        ]);

        if ($medicine->stock < $request->quantity) {
            return back()->with('error', 'Jumlah penyesuaian melebihi stok saat ini');
        }

        try {
            DB::beginTransaction();

            $medicine->decrement('stock', $request->quantity);

            StockLog::create([
                'medicine_id' => $medicine->id,
                'type' => 'penyesuaian',
                'quantity' => $request->quantity,
                'description' => $request->description
            ]);

            DB::commit();
            return back()->with('success', 'Stok berhasil disesuaikan (dikurangi).');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyesuaikan stok: ' . $e->getMessage());
        }
    }
}
