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


        // NUCLEAR DEBUGGING - Write directly to a file in public path
        $logFile = public_path('debug_queue_sync.txt');
        $logData = "\n[" . date('Y-m-d H:i:s') . "] Status Update Request: " . $status . "\n";
        $logData .= "Queue ID: " . $queue->id . "\n";
        $logData .= "User Patient ID: " . ($queue->user_patient_id ?? 'NULL') . "\n";
        $logData .= "Patient ID (Before): " . ($queue->patient_id ?? 'NULL') . "\n";

        file_put_contents($logFile, $logData, FILE_APPEND);

        DB::transaction(function () use ($queue, $status, $logFile) {
            $queue->update(['status' => $status]);

            // Logic 1: When status becomes 'calling' (Button Panggil clicked)
            // Create or Sync Patient Data
            if ($status === 'calling' && $queue->user_patient_id) {
                file_put_contents($logFile, "Condition MET: Calling + UserPatientID\n", FILE_APPEND);

                $userPatient = $queue->userPatient;
                if ($userPatient) {
                    file_put_contents($logFile, "UserPatient Found: " . $userPatient->name . "\n", FILE_APPEND);

                    // Check if patient already exists by NIK
                    $patient = Patient::where('nik', $userPatient->nik)->first();

                    if (!$patient) {
                        file_put_contents($logFile, "Creating NEW Patient...\n", FILE_APPEND);
                        // Create new official patient
                        $patient = Patient::create([
                            'user_id' => $userPatient->user_id,
                            'name' => $userPatient->name,
                            'nik' => $userPatient->nik,
                            'dob' => $userPatient->dob,
                            'gender' => $userPatient->gender,
                            'phone' => $userPatient->phone,
                            'address' => $userPatient->address,
                            'service' => $queue->service_name,
                        ]);
                        file_put_contents($logFile, "Created Patient ID: " . $patient->id . "\n", FILE_APPEND);
                    } else {
                        file_put_contents($logFile, "Updating EXISTING Patient ID: " . $patient->id . "\n", FILE_APPEND);
                        // Update existing patient data
                        $patient->update([
                            'phone' => $userPatient->phone,
                            'service' => $queue->service_name,
                        ]);
                    }
                    // Link queue to patient
                    $queue->update(['patient_id' => $patient->id]);
                    $patient->touch(); // Force update timestamp so it appears in daily list
                    file_put_contents($logFile, "Linked Queue to Patient ID: " . $patient->id . "\n", FILE_APPEND);
                } else {
                    file_put_contents($logFile, "ERROR: UserPatient relation returned NULL\n", FILE_APPEND);
                }
            } else {
                file_put_contents($logFile, "Condition NOT MET. Status: $status, UserPatientID: " . ($queue->user_patient_id ?? 'NULL') . "\n", FILE_APPEND);
            }

            // Logic 2: When status becomes 'cancelled' (Button Batal clicked)
            // Logic 2: When status becomes 'cancelled' (Button Batal clicked)
            // Delete Patient Data (Cleanup master data, but keep queue history)
            if ($status === 'cancelled' && $queue->patient_id) {
                file_put_contents($logFile, "Cancelling... Deleting Patient ID: " . $queue->patient_id . "\n", FILE_APPEND);

                $patient = Patient::find($queue->patient_id);
                if ($patient) {
                    $patient->delete();
                    file_put_contents($logFile, "Deleted Patient ID: " . $patient->id . "\n", FILE_APPEND);
                }

                // Unlink current queue
                $queue->update(['patient_id' => null]);
            }
        });

        return $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Status antrian berhasil diperbarui.', 'status' => $status])
            : redirect()->route('admin.queues.index')->with('success', 'Status antrian berhasil diperbarui.');
    }
}
