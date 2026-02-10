<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicRegistrationController extends Controller
{
    public function index()
    {
        // Check if user has a verified user patient profile
        if (!Auth::user()->userPatient) {
            return redirect()->route('user.patient.create');
        }

        $registrations = Queue::where('user_patient_id', Auth::user()->userPatient->id)
            ->with(['service', 'patient', 'userPatient'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.registration.index', compact('registrations'));
    }

    public function create()
    {
        // Check if user has a verified user patient profile
        if (!Auth::user()->userPatient) {
            return redirect()->route('user.patient.create');
        }

        $services = [
            'Periksa Kehamilan',
            'Persalinan',
            'Keluarga Berencana',
            'Kesehatan Ibu dan Anak',
            'Imunisasi'
        ];
        return view('user.registration.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|in:Periksa Kehamilan,Persalinan,Keluarga Berencana,Kesehatan Ibu dan Anak,Imunisasi',
            'date' => 'required|date|after_or_equal:today',
        ]);

        // Generate Queue Number (Simple logic: Max for date + 1)
        $date = $request->date;
        $maxQueue = Queue::whereDate('date', $date)->max('queue_number');
        $queueNumber = $maxQueue ? $maxQueue + 1 : 1;

        Queue::create([
            'user_patient_id' => Auth::user()->userPatient->id, // Linked to UserPatient
            'patient_id' => null, // Not yet verified/linked to official Patient
            'nik' => Auth::user()->userPatient->nik,
            'service_name' => $request->service_name,
            'service_id' => null, // No longer linked to dynamic services
            'bpjs_usage' => 0, // Default to 0 as payment method is removed
            'date' => $date,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
        ]);

        return redirect()->route('user.registration.index')->with('success', 'Pendaftaran berhasil dibuat. Nomor Antrian Anda: ' . $queueNumber);
    }
}
