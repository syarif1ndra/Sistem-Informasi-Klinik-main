<?php

namespace App\Http\Controllers\Api\Dokter;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    use ApiResponse;

    /** GET /api/dokter/patients */
    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
        }
        return $this->successResponse($query->orderBy('name')->paginate(15), 'Data pasien');
    }

    /** GET /api/dokter/patients/{id} */
    public function show($id)
    {
        $patient = Patient::with([
            'screenings' => fn($q) => $q->orderByDesc('examined_at')->with('examiner:id,name'),
            'transactions' => fn($q) => $q->orderByDesc('date')->take(10)->with('items'),
            'queues' => fn($q) => $q->orderByDesc('date')->take(10),
        ])->findOrFail($id);

        return $this->successResponse($patient, 'Detail pasien');
    }
}
