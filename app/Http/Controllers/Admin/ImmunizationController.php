<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Immunization;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $immunizations = Immunization::whereDate('immunization_date', $date)
            ->latest()
            ->paginate(10);

        return view('admin.immunizations.index', compact('immunizations', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.immunizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_nik' => 'nullable|string|max:20',
            'child_phone' => 'nullable|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'parent_name' => 'required|string|max:255',
            'address' => 'required|string',
            'immunization_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Immunization::create($validated);

        return redirect()->route('admin.immunizations.index')->with('success', 'Immunization record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Immunization $immunization)
    {
        return view('admin.immunizations.show', compact('immunization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Immunization $immunization)
    {
        return view('admin.immunizations.edit', compact('immunization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Immunization $immunization)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_nik' => 'nullable|string|max:20',
            'child_phone' => 'nullable|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'parent_name' => 'required|string|max:255',
            'address' => 'required|string',
            'immunization_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $immunization->update($validated);

        return redirect()->route('admin.immunizations.index')->with('success', 'Immunization record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Immunization $immunization)
    {
        $immunization->delete();

        return redirect()->route('admin.immunizations.index')->with('success', 'Immunization record deleted successfully.');
    }
}
