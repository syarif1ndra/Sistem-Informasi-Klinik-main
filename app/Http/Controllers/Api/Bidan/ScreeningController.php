<?php

namespace App\Http\Controllers\Api\Bidan;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Screening;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScreeningController extends Controller
{
    use ApiResponse;

    /** GET /api/bidan/patients/{patientId}/screenings */
    public function index($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $screenings = Screening::where('patient_id', $patientId)
            ->with('examiner:id,name', 'icd10Codes')
            ->orderByDesc('examined_at')
            ->paginate(10);
        return $this->successResponse($screenings, 'Data screening pasien');
    }

    /** POST /api/bidan/patients/{patientId}/screenings */
    public function store(Request $request, $patientId)
    {
        Patient::findOrFail($patientId); // ensure patient exists

        $v = Validator::make($request->all(), [
            'queue_id'         => 'nullable|exists:queues,id',
            'examined_at'      => 'nullable|date',
            'height'           => 'nullable|numeric',
            'weight'           => 'nullable|numeric',
            'blood_pressure'   => 'nullable|string',
            'temperature'      => 'nullable|numeric',
            'pulse'            => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'main_complaint'   => 'required|string',
            'medical_history'  => 'nullable|string',
            'diagnosis_text'   => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $screening = Screening::create(array_merge(
            $request->only('queue_id', 'height', 'weight', 'blood_pressure', 'temperature',
                           'pulse', 'respiratory_rate', 'main_complaint', 'medical_history', 'diagnosis_text'),
            [
                'patient_id'  => $patientId,
                'examined_by' => $request->user()->id,
                'examined_at' => $request->input('examined_at', now()),
            ]
        ));

        return $this->successResponse($screening->load('examiner:id,name'), 'Screening berhasil disimpan', 201);
    }

    /** GET /api/bidan/patients/{patientId}/screenings/{id} */
    public function show($patientId, $id)
    {
        $screening = Screening::where('patient_id', $patientId)->with('examiner:id,name', 'icd10Codes')->findOrFail($id);
        return $this->successResponse($screening, 'Detail screening');
    }

    /** PUT /api/bidan/patients/{patientId}/screenings/{id} */
    public function update(Request $request, $patientId, $id)
    {
        $screening = Screening::where('patient_id', $patientId)->findOrFail($id);

        $v = Validator::make($request->all(), [
            'height'           => 'nullable|numeric',
            'weight'           => 'nullable|numeric',
            'blood_pressure'   => 'nullable|string',
            'temperature'      => 'nullable|numeric',
            'pulse'            => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'main_complaint'   => 'sometimes|required|string',
            'medical_history'  => 'nullable|string',
            'diagnosis_text'   => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $screening->update($request->only('height', 'weight', 'blood_pressure', 'temperature',
                                          'pulse', 'respiratory_rate', 'main_complaint', 'medical_history', 'diagnosis_text'));
        return $this->successResponse($screening, 'Screening berhasil diperbarui');
    }
}
