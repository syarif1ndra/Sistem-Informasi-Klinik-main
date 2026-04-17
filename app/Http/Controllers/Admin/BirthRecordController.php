<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BirthRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BirthRecordController extends Controller
{

    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $search = $request->input('search', '');

        $query = BirthRecord::whereBetween('birth_date', [$startDate, $endDate])
            ->orderBy('birth_date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('baby_name', 'like', '%' . $search . '%')
                  ->orWhere('mother_name', 'like', '%' . $search . '%')
                  ->orWhere('father_name', 'like', '%' . $search . '%');
            });
        }

        $birthRecords = $query->paginate(15);

        $birthRecords->appends(['start_date' => $startDate, 'end_date' => $endDate, 'search' => $search]);

        return view('admin.birth_records.index', compact('birthRecords', 'startDate', 'endDate', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.birth_records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'baby_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_time' => 'required|date_format:H:i',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'mother_name' => 'required|string|max:255',
            'mother_nik' => 'required|string|max:16',
            'mother_age' => 'nullable|numeric|min:0|max:120',
            'mother_job' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_nik' => 'required|string|max:16',
            'father_age' => 'nullable|numeric|min:0|max:120',
            'father_job' => 'nullable|string|max:255',
            'mother_address' => 'nullable|string',
            'father_address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'child_order' => 'nullable|numeric|min:1',
            'attendant_name' => 'nullable|string|max:255',

            // Medical Data
            'gpa' => 'nullable|string',
            'kala_1' => 'nullable|date_format:H:i',
            'kala_2' => 'nullable|date_format:H:i',
            'kala_3' => 'nullable|date_format:H:i',

            // Anthropometry
            'baby_weight' => 'nullable|numeric',
            'baby_length' => 'nullable|numeric',
            'head_circumference' => 'nullable|numeric',
            'chest_circumference' => 'nullable|numeric',

            'birth_certificate_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        BirthRecord::create($validated);

        return redirect()->route('admin.birth_records.index')
            ->with('success', 'Data kelahiran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BirthRecord $birthRecord)
    {
        return view('admin.birth_records.show', compact('birthRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BirthRecord $birthRecord)
    {
        return view('admin.birth_records.edit', compact('birthRecord'));
    }

    public function update(Request $request, BirthRecord $birthRecord)
    {
        $validated = $request->validate([
            'baby_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_time' => 'required|date_format:H:i',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'mother_name' => 'required|string|max:255',
            'mother_nik' => 'required|string|max:16',
            'mother_age' => 'nullable|numeric|min:0|max:120',
            'mother_job' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_nik' => 'required|string|max:16',
            'father_age' => 'nullable|numeric|min:0|max:120',
            'father_job' => 'nullable|string|max:255',
            'mother_address' => 'nullable|string',
            'father_address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'child_order' => 'nullable|numeric|min:1',
            'attendant_name' => 'nullable|string|max:255',

            // Medical Data
            'gpa' => 'nullable|string',
            'kala_1' => 'nullable|date_format:H:i',
            'kala_2' => 'nullable|date_format:H:i',
            'kala_3' => 'nullable|date_format:H:i',

            // Anthropometry
            'baby_weight' => 'nullable|numeric',
            'baby_length' => 'nullable|numeric',
            'head_circumference' => 'nullable|numeric',
            'chest_circumference' => 'nullable|numeric',

            'birth_certificate_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $birthRecord->update($validated);

        return redirect()->route('admin.birth_records.index')
            ->with('success', 'Data kelahiran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BirthRecord $birthRecord)
    {
        $birthRecord->delete();

        return redirect()->route('admin.birth_records.index')
            ->with('success', 'Data kelahiran berhasil dihapus.');
    }

    /**
     * Generate and download birth certificate
     */
    public function generatePdf(BirthRecord $birthRecord)
    {
        $html = view('admin.birth_records.certificate', compact('birthRecord'))->render();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Surat_Kelahiran_' . str_replace(' ', '_', $birthRecord->baby_name) . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BirthRecordsExport($startDate, $endDate), 'data-kelahiran-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $birthRecords = BirthRecord::whereBetween('birth_date', [$startDate, $endDate])
            ->orderBy('birth_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.birth_records.pdf', compact('birthRecords', 'startDate', 'endDate'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('data-kelahiran-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
