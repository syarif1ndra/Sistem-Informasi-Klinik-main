<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * POST /api/login
     * Body: email, password
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Email atau password salah', 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('api_token')->plainTextToken;

        return $this->successResponse([
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login berhasil');
    }

    /**
     * POST /api/register
     * Body: name, email, password, password_confirmation
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return $this->successResponse([
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Registrasi berhasil', 201);
    }

    /**
     * POST /api/logout  (auth:sanctum)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logout berhasil');
    }

    /**
     * GET /api/me  (auth:sanctum) — return current user info
     */
    public function me(Request $request)
    {
        return $this->successResponse($request->user());
    }
}
