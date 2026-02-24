<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Service;
use App\Models\User;
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
            'complaint' => 'nullable|string', // Add validation
        ]);

        // Generate Queue Number (Simple logic: Max for date + 1)
        $date = $request->date;
        $maxQueue = Queue::whereDate('date', $date)->max('queue_number');
        $queueNumber = $maxQueue ? $maxQueue + 1 : 1;

        // Find default bidan to assign
        $defaultBidan = User::where('role', 'bidan')->first();

        Queue::create([
            'user_patient_id' => Auth::user()->userPatient->id,
            'patient_id' => null,
            'nik' => Auth::user()->userPatient->nik,
            'service_name' => $request->service_name,
            'service_id' => null,
            'bpjs_usage' => 0,
            'date' => $date,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
            'complaint' => $request->complaint,
            'assigned_practitioner_id' => $defaultBidan?->id,
        ]);

        return redirect()->route('user.registration.index')->with('success', 'Pendaftaran berhasil dibuat. Nomor Antrian Anda: ' . sprintf('%03d', $queueNumber));
    }

    public function cancel(Request $request, Queue $queue)
    {
        // Ensure the queue belongs to the authenticated user's patient profile
        // Also check if the status is waiting to allow cancellation
        if ($queue->user_patient_id !== Auth::user()->userPatient->id) {
            abort(403);
        }

        if ($queue->status !== 'waiting') {
            return redirect()->back()->with('error', 'Pendaftaran tidak dapat dibatalkan karena sudah diproses.');
        }

        $queue->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
