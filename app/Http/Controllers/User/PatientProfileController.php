<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\UserPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientProfileController extends Controller
{
    public function create()
    {
        // specific check to redirect if already exists
        if (Auth::user()->userPatient) {
            return redirect()->route('user.patient.edit');
        }
        return view('user.patient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ], [
            'nik.digits' => 'NIK harus berjumlah 16 angka.'
        ]);

        $patient = new UserPatient($request->all());
        $patient->user_id = Auth::id();
        $patient->save();

        $this->syncToPatient($patient);

        return redirect()->route('dashboard')->with('success', 'Data Pasien berhasil disimpan.');
    }

    public function edit()
    {
        $patient = Auth::user()->userPatient;
        if (!$patient) {
            return redirect()->route('user.patient.create');
        }
        return view('user.patient.edit', compact('patient'));
    }

    public function update(Request $request)
    {
        $patient = Auth::user()->userPatient;

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ], [
            'nik.digits' => 'NIK harus berjumlah 16 angka.'
        ]);

        $patient->update($request->all());

        $this->syncToPatient($patient);

        return redirect()->route('dashboard')->with('success', 'Data Pasien berhasil diperbarui.');
    }

    protected function syncToPatient(UserPatient $userPatient)
    {
        if (!$userPatient->user_id) {
            return;
        }

        $patient = Patient::where('user_id', $userPatient->user_id)->first();
        if (!$patient) {
            return;
        }

        $patient->update([
            'name' => $userPatient->name,
            'nik' => $userPatient->nik,
            'dob' => $userPatient->dob,
            'gender' => $userPatient->gender,
            'phone' => $userPatient->phone,
            'address' => $userPatient->address,
        ]);
    }
}
