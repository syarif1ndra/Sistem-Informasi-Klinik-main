<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $queues = Queue::with(['patient', 'service'])
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

        $queue->update(['status' => $validated['status']]);

        return redirect()->route('admin.queues.index')->with('success', 'Status antrian berhasil diperbarui.');
    }
}
