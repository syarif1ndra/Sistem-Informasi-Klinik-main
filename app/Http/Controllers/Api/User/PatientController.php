<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\UserPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    use ApiResponse;

    /** GET /api/user/patient */
    public function show(Request $request)
    {
        $patient = UserPatient::where('user_id', $request->user()->id)->first();

        if (!$patient) {
            return $this->errorResponse('Data pasien belum diisi', 404);
        }
        return $this->successResponse($patient, 'Data pasien');
    }

    /** POST /api/user/patient */
    public function store(Request $request)
    {
        $userId = $request->user()->id;

        if (UserPatient::where('user_id', $userId)->exists()) {
            return $this->errorResponse('Data pasien sudah ada, gunakan PUT untuk memperbarui', 409);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'nik'     => 'required|string|size:16|unique:user_patients,nik',
            'dob'     => 'required|date',
            'gender'  => 'required|in:male,female',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $patient = UserPatient::create(array_merge(
            $request->only('name', 'nik', 'dob', 'gender', 'phone', 'address'),
            ['user_id' => $userId]
        ));

        return $this->successResponse($patient, 'Data pasien berhasil disimpan', 201);
    }

    /** PUT /api/user/patient */
    public function update(Request $request)
    {
        $patient = UserPatient::where('user_id', $request->user()->id)->first();

        if (!$patient) {
            return $this->errorResponse('Data pasien belum diisi. Gunakan POST terlebih dahulu', 404);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'sometimes|required|string|max:255',
            'nik'     => 'sometimes|required|string|size:16|unique:user_patients,nik,' . $patient->id,
            'dob'     => 'sometimes|required|date',
            'gender'  => 'sometimes|required|in:male,female',
            'phone'   => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $patient->update($request->only('name', 'nik', 'dob', 'gender', 'phone', 'address'));

        return $this->successResponse($patient, 'Data pasien berhasil diperbarui');
    }
}
