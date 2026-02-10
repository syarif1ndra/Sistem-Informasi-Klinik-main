<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        // Load both patient (official) and userPatient (from user profile)
        $queues = Queue::with(['patient', 'service', 'userPatient'])
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();

        return view('admin.queues.index', compact('queues', 'date'));
    }

    public function updateStatus(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting,calling,called,finished,cancelled',
        ]);

        $status = $validated['status'];

        DB::transaction(function () use ($queue, $status) {
            $queue->update(['status' => $status]);

            // Synchronization Logic: If finished, valid user_patient, and no official patient linked yet
            if ($status === 'finished' && $queue->user_patient_id && !$queue->patient_id) {
                $userPatient = $queue->userPatient;

                if ($userPatient) {
                    // Check if patient already exists by NIK
                    $patient = Patient::where('nik', $userPatient->nik)->first();

                    if (!$patient) {
                        // Create new official patient
                        // Note: whatsapp_number is removed from Patient model
                        $patient = Patient::create([
                            'user_id' => $userPatient->user_id,
                            'name' => $userPatient->name,
                            'nik' => $userPatient->nik,
                            'dob' => $userPatient->dob,
                            'gender' => $userPatient->gender,
                            'phone' => $userPatient->phone, // Ensure phone is synced
                            'address' => $userPatient->address,
                            'service' => $queue->service_name, // Sync service from queue
                        ]);
                    } else {
                        // Update existing patient phone and service
                        $updates = [];
                        if ($patient->phone !== $userPatient->phone) {
                            $updates['phone'] = $userPatient->phone;
                        }
                        // Always update service to the latest one
                        $updates['service'] = $queue->service_name;

                        if (!empty($updates)) {
                            $patient->update($updates);
                        }
                    }

                    // Link the queue to the official patient
                    $queue->update(['patient_id' => $patient->id]);
                }
            }
        });

        return redirect()->route('admin.queues.index')->with('success', 'Status antrian berhasil diperbarui.');
    }
}
