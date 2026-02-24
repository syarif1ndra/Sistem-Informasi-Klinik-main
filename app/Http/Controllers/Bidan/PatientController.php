<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Screening;
use App\Models\Icd10Code;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $patients = Patient::whereHas('queues', function ($q) use ($startDate, $endDate) {
            $q->where('assigned_practitioner_id', auth()->id())
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate);
        })->with([
                    'queues' => function ($q) use ($startDate, $endDate) {
                        $q->where('assigned_practitioner_id', auth()->id())
                            ->whereDate('date', '>=', $startDate)
                            ->whereDate('date', '<=', $endDate)
                            ->orderByDesc('date');
                    }
                ])->paginate(15);

        $patients->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        return view('bidan.patients.index', compact('patients', 'startDate', 'endDate'));
    }

    public function show(Request $request, Patient $patient)
    {
        // Load the specific queue from query string (passed by index page)
        $activeQueue = null;
        if ($request->filled('queue_id')) {
            $activeQueue = $patient->queues()
                ->where('id', $request->integer('queue_id'))
                ->where('assigned_practitioner_id', auth()->id())
                ->first();
        }

        // Fallback: today's latest queue assigned to this practitioner
        if (!$activeQueue) {
            $activeQueue = $patient->queues()
                ->where('assigned_practitioner_id', auth()->id())
                ->whereDate('date', today())
                ->latest()
                ->first();
        }

        // Only show the screening for this specific queue (1 queue = 1 screening)
        $screenings = $activeQueue
            ? \App\Models\Screening::where('queue_id', $activeQueue->id)
                ->with(['icd10Codes', 'examiner'])
                ->get()
            : collect();

        $icd10Codes = \App\Models\Icd10Code::orderBy('code')->get();

        return view('bidan.patients.show', compact('patient', 'screenings', 'icd10Codes', 'activeQueue'));
    }
}

