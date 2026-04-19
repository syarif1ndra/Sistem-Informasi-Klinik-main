<?php

namespace App\Http\Controllers\Api\Dokter;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{
    use ApiResponse;

    /** GET /api/dokter/queues */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $date   = $request->input('date', now()->toDateString());

        $query = Queue::with(['patient:id,name,nik', 'userPatient:id,name,nik', 'service:id,name'])
            ->whereDate('date', $date)
            ->where('assigned_practitioner_id', $userId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $this->successResponse($query->orderBy('queue_number')->paginate(20), 'Antrian dokter');
    }

    /** PATCH /api/dokter/queues/{id}/status */
    public function updateStatus(Request $request, $id)
    {
        $queue = Queue::where('assigned_practitioner_id', $request->user()->id)->findOrFail($id);
        $v = Validator::make($request->all(), [
            'status' => 'required|in:in_progress,done,cancelled',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $queue->update(['status' => $request->status, 'handled_by' => $request->user()->id]);
        return $this->successResponse($queue, 'Status antrian diperbarui');
    }

    /** GET /api/dokter/queues/{id} */
    public function show(Request $request, $id)
    {
        $queue = Queue::with(['patient', 'userPatient', 'service'])->findOrFail($id);
        return $this->successResponse($queue, 'Detail antrian');
    }
}
