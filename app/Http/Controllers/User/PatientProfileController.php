<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
            'nik' => 'required|string|unique:user_patients,nik',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $patient = new UserPatient($request->all());
        $patient->user_id = Auth::id();
        $patient->save();

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
            'nik' => 'required|string|unique:user_patients,nik,' . $patient->id,
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $patient->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Data Pasien berhasil diperbarui.');
    }
}
