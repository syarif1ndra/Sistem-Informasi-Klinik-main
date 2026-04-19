<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(Service::orderBy('name')->get(), 'Data layanan');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $service = Service::create($request->only('name', 'description', 'price'));
        return $this->successResponse($service, 'Layanan berhasil ditambah', 201);
    }

    public function show($id)
    {
        return $this->successResponse(Service::findOrFail($id), 'Detail layanan');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
        ]);
        if ($v->fails()) return $this->errorResponse('Validasi gagal', 422, $v->errors());

        $service->update($request->only('name', 'description', 'price'));
        return $this->successResponse($service, 'Layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return $this->successResponse(null, 'Layanan berhasil dihapus');
    }
}
