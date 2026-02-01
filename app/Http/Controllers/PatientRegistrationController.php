<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientRegistrationController extends Controller
{
    public function create()
    {
        $services = \App\Models\Service::all();
        return view('public.register', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'nik' removed from validation as it is not in the form
            'whatsapp_number' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'service_id' => 'required|exists:services,id',
            'bpjs_usage' => 'required|boolean',
        ]);

        try {
            $queue = DB::transaction(function () use ($validated) {
                // Check if patient exists by WA
                $patientData = [
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'dob' => $validated['dob'],
                    'gender' => $validated['gender'],
                ];

                // Only set NIK if not null (to avoid overwriting existing non-null NIK with null if not provided)
                // Actually, public form doesn't send NIK.
                // If migration ran, nik is nullable.

                $patient = Patient::updateOrCreate(
                    [
                        'name' => $validated['name'],
                        'dob' => $validated['dob'],
                    ],
                    [
                        'whatsapp_number' => $validated['whatsapp_number'],
                        'address' => $validated['address'],
                        'gender' => $validated['gender'],
                    ]
                );

                $lastQueue = Queue::where('date', date('Y-m-d'))->max('queue_number') ?? 0;

                return Queue::create([
                    'patient_id' => $patient->id,
                    'service_id' => $validated['service_id'],
                    'bpjs_usage' => $validated['bpjs_usage'],
                    'queue_number' => $lastQueue + 1,
                    'status' => 'waiting',
                    'date' => date('Y-m-d'),
                ]);
            });

            // Redirect to success page with queue object
            return view('public.registration_success', compact('queue'));

        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Registration Error: ' . $e->getMessage());
            // Return back with error message
            return back()->withErrors(['msg' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage()])->withInput();
        }
    }
}
