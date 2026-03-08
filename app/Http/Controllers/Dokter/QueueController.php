<?php

namespace App\Http\Controllers\Dokter;

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
        $queues = Queue::with(['patient', 'service', 'userPatient'])
            ->where('assigned_practitioner_id', auth()->id())
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();

        return view('dokter.queues.index', compact('queues', 'date'));
    }

    public function tableData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $queues = Queue::with(['patient', 'service', 'userPatient'])
            ->where('assigned_practitioner_id', auth()->id())
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();

        return view('dokter.queues.partials.table', compact('queues'));
    }

    public function updateStatus(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting,calling,called,finished,cancelled',
        ]);

        $status = $validated['status'];

        try {
            DB::transaction(function () use ($queue, $status) {
                $dataToUpdate = ['status' => $status];
                if (in_array($status, ['calling', 'called', 'finished'])) {
                    $dataToUpdate['handled_by'] = auth()->id();
                }
                $queue->update($dataToUpdate);
                $queue->touch();

                // Logic 1: When status becomes 'calling' (Button Panggil clicked)
                if ($status === 'calling' && $queue->user_patient_id) {
                    $userPatient = $queue->userPatient;
                    if ($userPatient) {
                        $patientData = [
                            'user_id' => $userPatient->user_id,
                            'name' => $userPatient->name,
                            'nik' => (!empty($userPatient->nik) && strlen($userPatient->nik) === 16 && is_numeric($userPatient->nik)) ? $userPatient->nik : null,
                            'dob' => $userPatient->dob ?? '1900-01-01',
                            'gender' => $userPatient->gender ?? 'L',
                            'phone' => $userPatient->phone,
                            'address' => $userPatient->address ?? '-',
                            'service' => $queue->service_name,
                        ];

                        // Strict NIK Match (Only if valid 16-digit numeric)
                        $patient = null;
                        if (!empty($userPatient->nik) && strlen($userPatient->nik) === 16 && is_numeric($userPatient->nik)) {
                            $patient = Patient::where('nik', $userPatient->nik)->first();
                        }

                        // Fallback 1: Name + DOB
                        if (!$patient) {
                            $patient = Patient::where('name', $userPatient->name)
                                ->where('dob', $userPatient->dob ?? '1900-01-01')
                                ->first();
                        }

                        // Fallback 2: user_id + name
                        if (!$patient && !empty($userPatient->user_id)) {
                            $patient = Patient::where('user_id', $userPatient->user_id)
                                ->where('name', $userPatient->name)
                                ->first();
                        }

                        if (!$patient) {
                            $patient = Patient::create($patientData);
                        } else {
                            $patient->update($patientData);
                        }
                        $queue->update(['patient_id' => $patient->id]);
                        $patient->touch();
                    }
                }

                if ($status === 'cancelled' && $queue->patient_id) {
                    $patient = Patient::find($queue->patient_id);
                    if ($patient) {
                        $patient->delete();
                    }
                    $queue->update(['patient_id' => null]);
                }
            });
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 422)
                : redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }

        return $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Status antrian berhasil diperbarui.', 'status' => $status])
            : redirect()->route('dokter.queues.index')->with('success', 'Status antrian berhasil diperbarui.');
    }
}
