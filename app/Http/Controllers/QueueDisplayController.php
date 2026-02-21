<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;

class QueueDisplayController extends Controller
{
    public function index()
    {
        return view('public.queue_display');
    }

    public function data()
    {
        $date = date('Y-m-d');

        $currentQueue = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $date)
            ->where('status', 'calling')
            ->orderBy('updated_at', 'desc')
            ->first();

        $nextQueuesQuery = Queue::with(['patient', 'userPatient'])
            ->whereDate('date', $date)
            ->where('status', 'waiting');

        $nextQueues = $nextQueuesQuery->orderBy('queue_number', 'asc')->take(5)->get();

        $nextQueuesData = $nextQueues->map(function ($queue) {
            return [
                'queue_number' => sprintf('%03d', $queue->queue_number),
                'patient_name' => $queue->patient->name ?? ($queue->userPatient->name ?? '-'),
                'service_name' => $queue->service_name
            ];
        });

        return response()->json([
            'current' => $currentQueue ? [
                'queue_number' => sprintf('%03d', $currentQueue->queue_number),
                'patient_name' => $currentQueue->patient->name ?? ($currentQueue->userPatient->name ?? '-'),
                'service_name' => $currentQueue->service_name,
                'id' => $currentQueue->id,
                'updated_at' => $currentQueue->updated_at->timestamp
            ] : null,
            'next' => $nextQueuesData

        ]);
    }
}
