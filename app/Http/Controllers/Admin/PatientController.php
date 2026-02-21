<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Queue; // Add this

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Fetch Queues (Visits) instead of Patients
        // We load patient relationship to display patient details
        $visits = Queue::with('patient')
            ->whereDate('date', $date)
            ->orderBy('queue_number', 'asc')
            ->paginate(10);

        return view('admin.patients.index', compact('visits', 'date'));
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
        if (auth()->user()->isBidan()) {
            abort(403, 'Akses ditolak. Bidan tidak memiliki izin untuk menghapus data pasien.');
        }

        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function editVisit(Queue $queue)
    {
        $queue->load('patient');
        return view('admin.patients.edit', compact('queue'));
    }

    public function updateVisit(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'complaint' => 'nullable|string', // Validating complaint
        ]);

        // Update Patient Data
        $queue->patient->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
        ]);

        // Update Queue Data (Complaint)
        $queue->update([
            'complaint' => $validated['complaint'] ?? null,
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    public function exportExcel(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        return Excel::download(new PatientsExport($date), 'data-pasien-' . $date . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        // Fetch Queues (Visits) instead of Patients
        $visits = Queue::with('patient')
            ->whereDate('date', $date)
            ->orderBy('queue_number', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.patients.pdf', compact('visits', 'date'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('data-pasien-' . $date . '.pdf');
    }
}
