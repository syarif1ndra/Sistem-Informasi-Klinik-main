<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;

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

        return view('bidan.queues.index', compact('queues', 'date'));
    }

    public function tableData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $queues = Queue::with(['patient', 'service', 'userPatient'])
            ->where('assigned_practitioner_id', auth()->id())
            ->whereDate('date', $date)
            ->orderBy('queue_number')
            ->get();

        return view('bidan.queues.partials.table', compact('queues'));
    }
}
