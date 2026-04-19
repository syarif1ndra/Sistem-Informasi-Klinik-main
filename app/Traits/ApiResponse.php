<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function errorResponse(string $message, int $code = 400, $errors = null)
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];
        if (!is_null($errors)) {
            $payload['errors'] = $errors;
        }
        return response()->json($payload, $code);
    }
}
