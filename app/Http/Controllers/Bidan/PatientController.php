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

    public function show(Patient $patient)
    {
        $screenings = $patient->screenings()->with(['icd10Codes', 'examiner'])->get();
        $icd10Codes = Icd10Code::orderBy('code')->get();
        return view('bidan.patients.show', compact('patient', 'screenings', 'icd10Codes'));
    }
}

