<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('low_stock')) {
            $query->whereColumn('stock', '<=', 'min_stock');
        }

        return $this->successResponse($query->orderBy('name')->paginate(15), 'Data obat');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'category'       => 'nullable|string|max:100',
            'stock'          => 'required|integer|min:0',
            'min_stock'      => 'nullable|integer|min:0',
            'price'          => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'expired_date'   => 'nullable|date',
            'description'    => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $medicine = Medicine::create($request->only('name', 'category', 'stock', 'min_stock', 'price', 'purchase_price', 'expired_date', 'description'));
        return $this->successResponse($medicine, 'Obat berhasil ditambah', 201);
    }

    public function show($id)
    {
        return $this->successResponse(Medicine::findOrFail($id), 'Detail obat');
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name'           => 'sometimes|required|string|max:255',
            'category'       => 'nullable|string|max:100',
            'stock'          => 'sometimes|required|integer|min:0',
            'min_stock'      => 'nullable|integer|min:0',
            'price'          => 'sometimes|required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'expired_date'   => 'nullable|date',
            'description'    => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $medicine->update($request->only('name', 'category', 'stock', 'min_stock', 'price', 'purchase_price', 'expired_date', 'description'));
        return $this->successResponse($medicine, 'Obat berhasil diperbarui');
    }

    public function destroy($id)
    {
        Medicine::findOrFail($id)->delete();
        return $this->successResponse(null, 'Obat berhasil dihapus');
    }
}
