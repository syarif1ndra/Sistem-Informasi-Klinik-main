<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\BirthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BirthRecordController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = BirthRecord::query();
        if ($request->filled('search')) {
            $query->where('baby_name', 'like', '%' . $request->search . '%')
                  ->orWhere('mother_name', 'like', '%' . $request->search . '%');
        }
        return $this->successResponse($query->orderByDesc('birth_date')->paginate(15), 'Data kelahiran');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'baby_name'                => 'required|string|max:255',
            'birth_date'               => 'required|date',
            'birth_time'               => 'nullable|string',
            'birth_place'              => 'nullable|string',
            'gender'                   => 'required|in:male,female',
            'mother_name'              => 'required|string|max:255',
            'mother_nik'               => 'nullable|string',
            'mother_age'               => 'nullable|integer',
            'mother_job'               => 'nullable|string',
            'father_name'              => 'nullable|string|max:255',
            'father_nik'               => 'nullable|string',
            'father_age'               => 'nullable|integer',
            'father_job'               => 'nullable|string',
            'mother_address'           => 'nullable|string',
            'father_address'           => 'nullable|string',
            'phone_number'             => 'nullable|string',
            'child_order'              => 'nullable|integer',
            'attendant_name'           => 'nullable|string',
            'gpa'                      => 'nullable|string',
            'kala_1'                   => 'nullable|string',
            'kala_2'                   => 'nullable|string',
            'kala_3'                   => 'nullable|string',
            'baby_weight'              => 'nullable|numeric',
            'baby_length'              => 'nullable|numeric',
            'head_circumference'       => 'nullable|numeric',
            'chest_circumference'      => 'nullable|numeric',
            'birth_certificate_number' => 'nullable|string',
            'notes'                    => 'nullable|string',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $record = BirthRecord::create($request->all());
        return $this->successResponse($record, 'Data kelahiran berhasil disimpan', 201);
    }

    public function show($id)
    {
        return $this->successResponse(BirthRecord::findOrFail($id), 'Detail kelahiran');
    }

    public function update(Request $request, $id)
    {
        $record = BirthRecord::findOrFail($id);
        $record->update($request->all());
        return $this->successResponse($record, 'Data kelahiran berhasil diperbarui');
    }

    public function destroy($id)
    {
        BirthRecord::findOrFail($id)->delete();
        return $this->successResponse(null, 'Data kelahiran berhasil dihapus');
    }
}
