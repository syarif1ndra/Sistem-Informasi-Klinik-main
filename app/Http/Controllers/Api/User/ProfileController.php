<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ApiResponse;

    /** GET /api/user/profile */
    public function show(Request $request)
    {
        return $this->successResponse($request->user(), 'Profil user');
    }

    /** PUT /api/user/profile */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'                  => 'sometimes|required|string|max:255',
            'email'                 => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        if ($request->filled('name'))     $user->name     = $request->name;
        if ($request->filled('email'))    $user->email    = $request->email;
        if ($request->filled('password')) $user->password = Hash::make($request->password);

        $user->save();

        return $this->successResponse($user, 'Profil berhasil diperbarui');
    }
}
