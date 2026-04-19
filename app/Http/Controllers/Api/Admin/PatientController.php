<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/patients */
    public function index(Request $request)
    {
        $query = Patient::with('user:id,name,email');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        return $this->successResponse($query->orderBy('name')->paginate(15), 'Data pasien');
    }

    /** POST /api/admin/patients */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'             => 'required|string|size:16|unique:patients,nik',
            'name'            => 'required|string|max:255',
            'address'         => 'required|string',
            'phone'           => 'required|string|max:20',
            'dob'             => 'required|date',
            'gender'          => 'required|in:male,female',
            'service'         => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $patient = Patient::create($request->only('nik', 'name', 'address', 'phone', 'dob', 'gender', 'service', 'medical_history'));
        return $this->successResponse($patient, 'Pasien berhasil ditambah', 201);
    }

    /** GET /api/admin/patients/{id} */
    public function show($id)
    {
        $patient = Patient::with(['screenings.examiner:id,name', 'transactions', 'queues'])->findOrFail($id);
        return $this->successResponse($patient, 'Detail pasien');
    }

    /** PUT /api/admin/patients/{id} */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik'             => 'sometimes|required|string|size:16|unique:patients,nik,' . $patient->id,
            'name'            => 'sometimes|required|string|max:255',
            'address'         => 'sometimes|required|string',
            'phone'           => 'sometimes|required|string|max:20',
            'dob'             => 'sometimes|required|date',
            'gender'          => 'sometimes|required|in:male,female',
            'service'         => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $patient->update($request->only('nik', 'name', 'address', 'phone', 'dob', 'gender', 'service', 'medical_history'));
        return $this->successResponse($patient, 'Pasien berhasil diperbarui');
    }

    /** DELETE /api/admin/patients/{id} */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return $this->successResponse(null, 'Pasien berhasil dihapus');
    }
}
