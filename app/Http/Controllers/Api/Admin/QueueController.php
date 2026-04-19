<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use App\Models\Service;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/queues */
    public function index(Request $request)
    {
        $query = Queue::with([
            'patient:id,name,nik',
            'userPatient:id,name,nik',
            'service:id,name',
            'assignedPractitioner:id,name,role',
        ]);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', now()->toDateString());
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $this->successResponse($query->orderBy('queue_number')->paginate(20), 'Data antrian');
    }

    /** POST /api/admin/queues */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'patient_id'              => 'required_without:nik|nullable|exists:patients,id',
            'nik'                     => 'required_without:patient_id|nullable|string|size:16',
            'service_id'              => 'required|exists:services,id',
            'complaint'               => 'required|string',
            'bpjs_usage'              => 'sometimes|boolean',
            'assigned_practitioner_id'=> 'nullable|exists:users,id',
            'date'                    => 'sometimes|date',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $date    = $request->input('date', now()->toDateString());
        $service = Service::findOrFail($request->service_id);
        $lastQueue   = Queue::whereDate('date', $date)->max('queue_number');
        $queueNumber = ($lastQueue ?? 0) + 1;

        $queue = Queue::create([
            'patient_id'               => $request->patient_id,
            'nik'                      => $request->nik ?? optional(Patient::find($request->patient_id))->nik,
            'service_id'               => $service->id,
            'service_name'             => $service->name,
            'bpjs_usage'               => $request->input('bpjs_usage', false),
            'queue_number'             => $queueNumber,
            'status'                   => 'waiting',
            'complaint'                => $request->complaint,
            'date'                     => $date,
            'assigned_practitioner_id' => $request->assigned_practitioner_id,
        ]);

        return $this->successResponse($queue->load(['patient', 'service', 'assignedPractitioner:id,name']), 'Antrian berhasil dibuat', 201);
    }

    /** GET /api/admin/queues/{id} */
    public function show($id)
    {
        $queue = Queue::with(['patient', 'userPatient', 'service', 'assignedPractitioner:id,name,role', 'handledBy:id,name,role'])->findOrFail($id);
        return $this->successResponse($queue, 'Detail antrian');
    }

    /** PUT /api/admin/queues/{id} */
    public function update(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        $v = Validator::make($request->all(), [
            'status'                   => 'sometimes|required|in:waiting,in_progress,done,cancelled',
            'assigned_practitioner_id' => 'nullable|exists:users,id',
            'complaint'                => 'sometimes|required|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $queue->update($request->only('status', 'assigned_practitioner_id', 'complaint'));
        return $this->successResponse($queue, 'Antrian berhasil diperbarui');
    }

    /** PATCH /api/admin/queues/{id}/status */
    public function updateStatus(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        $v = Validator::make($request->all(), [
            'status' => 'required|in:waiting,in_progress,done,cancelled',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $queue->update(['status' => $request->status]);
        return $this->successResponse($queue, 'Status antrian berhasil diperbarui');
    }
}
