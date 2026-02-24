<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Icd10Code;
use App\Models\Patient;
use App\Models\Screening;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function create(Patient $patient)
    {
        $icd10Codes = Icd10Code::orderBy('code')->get();
        return view('dokter.screenings.create', compact('patient', 'icd10Codes'));
    }

    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'queue_id' => 'nullable|integer|exists:queues,id',
            'examined_at' => 'required|date',
            'height' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'blood_pressure' => 'nullable|string|max:20',
            'temperature' => 'nullable|string|max:20',
            'pulse' => 'nullable|string|max:20',
            'respiratory_rate' => 'nullable|string|max:20',
            'main_complaint' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'diagnosis_text' => 'nullable|string',
            'icd10_codes' => 'nullable|array',
            'icd10_codes.*' => 'integer|exists:icd10_codes,id',
        ]);

        // Enforce 1 screening per queue
        if (!empty($validated['queue_id'])) {
            $exists = Screening::where('queue_id', $validated['queue_id'])->exists();
            if ($exists) {
                return redirect()->route('dokter.patients.show', $patient)
                    ->with('error', 'Antrian ini sudah memiliki data skrining. Silakan edit data yang sudah ada.');
            }
        }

        $screening = Screening::create([
            'patient_id' => $patient->id,
            'queue_id' => $validated['queue_id'] ?? null,
            'examined_by' => auth()->id(),
            'examined_at' => $validated['examined_at'],
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'blood_pressure' => $validated['blood_pressure'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'pulse' => $validated['pulse'] ?? null,
            'respiratory_rate' => $validated['respiratory_rate'] ?? null,
            'main_complaint' => $validated['main_complaint'] ?? null,
            'medical_history' => $validated['medical_history'] ?? null,
            'diagnosis_text' => $validated['diagnosis_text'] ?? null,
        ]);

        if (!empty($validated['icd10_codes'])) {
            $screening->icd10Codes()->sync($validated['icd10_codes']);
        }

        return redirect()->route('dokter.patients.show', $patient)
            ->with('success', 'Data skrining berhasil disimpan.');
    }

    public function edit(Patient $patient, Screening $screening)
    {
        $icd10Codes = Icd10Code::orderBy('code')->get();
        $selectedIds = $screening->icd10Codes->pluck('id')->toArray();
        return view('dokter.screenings.edit', compact('patient', 'screening', 'icd10Codes', 'selectedIds'));
    }

    public function update(Request $request, Patient $patient, Screening $screening)
    {
        $validated = $request->validate([
            'examined_at' => 'required|date',
            'height' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'blood_pressure' => 'nullable|string|max:20',
            'temperature' => 'nullable|string|max:20',
            'pulse' => 'nullable|string|max:20',
            'respiratory_rate' => 'nullable|string|max:20',
            'main_complaint' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'diagnosis_text' => 'nullable|string',
            'icd10_codes' => 'nullable|array',
            'icd10_codes.*' => 'integer|exists:icd10_codes,id',
        ]);

        $screening->update([
            'examined_at' => $validated['examined_at'],
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'blood_pressure' => $validated['blood_pressure'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'pulse' => $validated['pulse'] ?? null,
            'respiratory_rate' => $validated['respiratory_rate'] ?? null,
            'main_complaint' => $validated['main_complaint'] ?? null,
            'medical_history' => $validated['medical_history'] ?? null,
            'diagnosis_text' => $validated['diagnosis_text'] ?? null,
        ]);

        $screening->icd10Codes()->sync($validated['icd10_codes'] ?? []);

        return redirect()->route('dokter.patients.show', $patient)
            ->with('success', 'Data skrining berhasil diperbarui.');
    }
}
