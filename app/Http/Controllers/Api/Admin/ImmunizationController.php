<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Immunization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImmunizationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Immunization::query();
        if ($request->filled('search')) {
            $query->where('child_name', 'like', '%' . $request->search . '%')
                  ->orWhere('parent_name', 'like', '%' . $request->search . '%');
        }
        return $this->successResponse($query->orderByDesc('immunization_date')->paginate(15), 'Data imunisasi');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'child_name'       => 'required|string|max:255',
            'child_nik'        => 'nullable|string',
            'child_phone'      => 'nullable|string',
            'birth_place'      => 'nullable|string',
            'birth_date'       => 'nullable|date',
            'parent_name'      => 'required|string|max:255',
            'address'          => 'nullable|string',
            'notes'            => 'nullable|string',
            'immunization_date'=> 'required|date',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $imm = Immunization::create($request->all());
        return $this->successResponse($imm, 'Data imunisasi berhasil disimpan', 201);
    }

    public function show($id)
    {
        return $this->successResponse(Immunization::findOrFail($id), 'Detail imunisasi');
    }

    public function update(Request $request, $id)
    {
        $imm = Immunization::findOrFail($id);
        $imm->update($request->all());
        return $this->successResponse($imm, 'Data imunisasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        Immunization::findOrFail($id)->delete();
        return $this->successResponse(null, 'Data imunisasi berhasil dihapus');
    }
}
