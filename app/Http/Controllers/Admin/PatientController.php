<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Queue;
use App\Models\Screening;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Fetch Queues (Visits) instead of Patients
        // We load patient relationship to display patient details
        $visits = Queue::with('patient')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->orderBy('queue_number', 'asc')
            ->paginate(10);

        // Append query strings so pagination links work with filters
        $visits->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        return view('admin.patients.index', compact('visits', 'startDate', 'endDate'));
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

    public function show(Request $request, Patient $patient)
    {
        $activeQueue = null;
        if ($request->filled('queue_id')) {
            $activeQueue = $patient->queues()
                ->where('id', $request->integer('queue_id'))
                ->first();
        }

        if ($activeQueue) {
            $screenings = Screening::where('queue_id', $activeQueue->id)
                ->with(['icd10Codes', 'examiner'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $screenings = Screening::whereIn('queue_id', $patient->queues()->pluck('id'))
                ->with(['icd10Codes', 'examiner'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.patients.show', compact('patient', 'screenings', 'activeQueue'));
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
        if (auth()->user()->isBidan() || auth()->user()->isDokter()) {
            abort(403, 'Akses ditolak. Bidan dan Dokter tidak memiliki izin untuk menghapus data pasien.');
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
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        return Excel::download(new PatientsExport($startDate, $endDate), 'data-pasien-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Fetch Queues (Visits) instead of Patients
        $visits = Queue::with('patient')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->orderBy('queue_number', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.patients.pdf', compact('visits', 'startDate', 'endDate'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('data-pasien-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
