<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function current()
    {
        $currentQueue = Queue::where('date', date('Y-m-d'))
            ->where('status', 'calling')
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json([
            'id' => $currentQueue ? $currentQueue->id : null,
            'queue_number' => $currentQueue ? $currentQueue->queue_number : null,
            'patient_name' => $currentQueue ? $currentQueue->patient_name : null,
            'service_name' => $currentQueue ? ($currentQueue->service_name ?? '-') : null,
            'updated_at' => $currentQueue ? $currentQueue->updated_at->timestamp : null,
        ]);
    }
}
