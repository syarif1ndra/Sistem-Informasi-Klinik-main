<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Filter by patients who have a visit (queue) on the selected date
        $patients = Patient::whereHas('queues', function ($query) use ($date) {
            $query->whereDate('date', $date);
        })->latest()->paginate(10);

        return view('admin.patients.index', compact('patients', 'date'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'medical_history' => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'medical_history' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        return Excel::download(new PatientsExport($date), 'data-pasien-' . $date . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $patients = Patient::whereDate('updated_at', $date)->latest()->get();

        $pdf = Pdf::loadView('admin.patients.pdf', compact('patients', 'date'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('data-pasien-' . $date . '.pdf');
    }
}
