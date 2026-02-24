<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01')); // default: awal bulan ini
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Pasien yang antriannya ditugaskan ke dokter ini (by assigned_practitioner_id)
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

        return view('dokter.patients.index', compact('patients', 'startDate', 'endDate'));
    }
}
