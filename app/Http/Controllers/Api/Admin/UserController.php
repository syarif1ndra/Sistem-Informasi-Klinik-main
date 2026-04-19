<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/users */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('name')->paginate(15);
        return $this->successResponse($users, 'Data user');
    }

    /** POST /api/admin/users */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:user,admin,bidan,dokter,owner,apoteker',
            'shift'                => 'nullable|in:pagi,sore',
            'consultation_fee'     => 'nullable|numeric|min:0',
            'revenue_percentage'   => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => $request->role,
            'shift'              => $request->shift,
            'consultation_fee'   => $request->consultation_fee,
            'revenue_percentage' => $request->revenue_percentage,
            'email_verified_at'  => now(),
        ]);

        return $this->successResponse($user, 'User berhasil dibuat', 201);
    }

    /** GET /api/admin/users/{id} */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->successResponse($user, 'Detail user');
    }

    /** PUT /api/admin/users/{id} */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'               => 'sometimes|required|string|max:255',
            'email'              => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password'           => 'nullable|string|min:8',
            'role'               => 'sometimes|required|in:user,admin,bidan,dokter,owner,apoteker',
            'shift'              => 'nullable|in:pagi,sore',
            'consultation_fee'   => 'nullable|numeric|min:0',
            'revenue_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $data = $request->only('name', 'email', 'role', 'shift', 'consultation_fee', 'revenue_percentage');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return $this->successResponse($user, 'User berhasil diperbarui');
    }

    /** DELETE /api/admin/users/{id} */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->successResponse(null, 'User berhasil dihapus');
    }
}
