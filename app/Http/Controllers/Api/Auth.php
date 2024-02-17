<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Auth extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'passwordapi']);
        $user = User::where('email', $credentials['email'])->where('passwordapi', $credentials['passwordapi'])->first();

        if (!$token = auth('api')->login($user)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    public function me()
    {
        try {
            $user = auth('api')->userOrFail();
            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(auth('api')->refresh(true, true));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
