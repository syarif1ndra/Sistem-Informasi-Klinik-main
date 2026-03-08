<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $queues = Queue::with(['patient', 'service', 'userPatient', 'assignedPractitioner'])
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();
        $practitioners = User::whereIn('role', ['dokter', 'bidan'])->orderBy('role')->orderBy('name')->get();
        $services = [
            'Periksa Kehamilan',
            'Persalinan',
            'Keluarga Berencana',
            'Kesehatan Ibu dan Anak',
            'Imunisasi'
        ];

        return view('admin.queues.index', compact('queues', 'date', 'practitioners', 'services'));
    }

    public function tableData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $queues = Queue::with(['patient', 'service', 'userPatient', 'assignedPractitioner'])
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();
        $practitioners = User::whereIn('role', ['dokter', 'bidan'])->orderBy('role')->orderBy('name')->get();

        return view('admin.queues.partials.table', compact('queues', 'practitioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|digits:16',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'complaint' => 'nullable|string',
            'assigned_practitioner_id' => 'nullable|exists:users,id',
            'service_name' => 'required|string|in:Periksa Kehamilan,Persalinan,Keluarga Berencana,Kesehatan Ibu dan Anak,Imunisasi',
            'date' => 'required|date',
        ], [
            'nik.digits' => 'NIK harus berjumlah 16 angka.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'dob.required' => 'Tanggal lahir harus diisi.',
            'address.required' => 'Alamat harus diisi.'
        ]);

        $patient = null;
        if (!empty($validated['nik']) && strlen($validated['nik']) === 16 && is_numeric($validated['nik'])) {
            $patient = Patient::where('nik', $validated['nik'])->first();
        }

        if (!$patient) {
            $patient = Patient::where('name', $validated['name'])
                ->where('dob', $validated['dob'])
                ->first();
        }

        if (!$patient) {
            $patient = Patient::create([
                'name' => $validated['name'],
                'nik' => (!empty($validated['nik']) && strlen($validated['nik']) === 16 && is_numeric($validated['nik'])) ? $validated['nik'] : null,
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'],
            ]);
        } else {
            $patient->update([
                'name' => $validated['name'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'] ?? $patient->phone,
                'address' => $validated['address'],
            ]);
        }

        $lastNumber = Queue::whereDate('date', $validated['date'])->max('queue_number') ?? 0;
        $nextNumber = $lastNumber + 1;

        Queue::create([
            'patient_id' => $patient->id,
            'nik' => $patient->nik,
            'queue_number' => $nextNumber,
            'date' => $validated['date'],
            'status' => 'waiting',
            'complaint' => $validated['complaint'] ?? null,
            'assigned_practitioner_id' => $validated['assigned_practitioner_id'] ?? null,
            'service_name' => $validated['service_name'],
            'service_id' => null,
        ]);

        return redirect()->route('admin.queues.index', ['date' => $validated['date']])
            ->with('success', 'Antrian berhasil ditambahkan. No. ' . sprintf('%03d', $nextNumber));
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

                        $patient = null;
                        if (!empty($userPatient->nik) && strlen($userPatient->nik) === 16 && is_numeric($userPatient->nik)) {
                            $patient = Patient::where('nik', $userPatient->nik)->first();
                        }

                        if (!$patient) {
                            $patient = Patient::where('name', $userPatient->name)
                                ->where('dob', $userPatient->dob ?? '1900-01-01')
                                ->first();
                        }

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
            : redirect()->route('admin.queues.index')->with('success', 'Status antrian berhasil diperbarui.');
    }

    public function update(Request $request, Queue $queue)
    {
        $request->validate([
            'assigned_practitioner_id' => 'nullable|exists:users,id',
        ]);

        $queue->update([
            'assigned_practitioner_id' => $request->assigned_practitioner_id ?: null,
        ]);

        return redirect()->route('admin.queues.index')
            ->with('success', 'Praktisi yang ditugaskan berhasil diperbarui.');
    }
}
