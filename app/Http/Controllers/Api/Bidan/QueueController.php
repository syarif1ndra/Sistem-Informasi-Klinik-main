<?php

namespace App\Http\Controllers\Api\Bidan;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    use ApiResponse;

    /** GET /api/bidan/queues */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $queues = Queue::with([
            'patient:id,name,nik',
            'userPatient:id,name,nik',
            'service:id,name',
            'assignedPractitioner:id,name,role',
        ])
        ->whereDate('date', $date)
        ->orderBy('queue_number')
        ->paginate(20);

        return $this->successResponse($queues, 'Data antrian bidan');
    }

    /** GET /api/bidan/queues/{id} */
    public function show($id)
    {
        $queue = Queue::with(['patient', 'userPatient', 'service', 'assignedPractitioner:id,name'])->findOrFail($id);
        return $this->successResponse($queue, 'Detail antrian');
    }
}
