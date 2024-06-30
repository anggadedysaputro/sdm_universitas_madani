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
        $user = User::from("users as u")->select(
            "u.id",
            "p.nopeg",
            "p.nama",
            "p.alamat",
            "p.npwp",
            "p.jns_kel",
            "p.nohp",
            "js.urai as jabatanstruktural",
            "jf.urai as jabatanfungsional"
        )
            ->join("applications.pegawai as p", "p.nopeg", "=", "u.nopeg")
            ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", "=", "p.kodestruktural")
            ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", "=", "p.kodejabfung")
            ->where('u.email', $credentials['email'])->where('u.passwordapi', $credentials['passwordapi'])->first();

        if (empty($user)) {
            return response()->json([
                'message' => 'login gagal',
                'status' => false
            ], 400);
        } else {
            return response()->json([
                'message' => 'login berhasil',
                'status' => true,
                'data' => [
                    'id' => $user->id,
                    'nopeg' => $user->nopeg,
                    'nama' => $user->nama,
                    'alamat' => $user->alamat,
                    'npwp' => $user->npwp,
                    'jns_kel' => $user->jns_kel,
                    'nohp' => $user->nohp,
                    'jabatanstruktural' => $user->jabatanstruktural,
                    'jabatanfungsional' => $user->jabatanfungsional
                ]
            ], 200);
        }
    }

    /* public function login(Request $request)
    {
        $credentials = $request->only(['email', 'passwordapi']);
        $user = User::where('email', $credentials['email'])->where('passwordapi', $credentials['passwordapi'])->first();

        if (!$token = auth('api')->login($user)) {
            return response()->json([
                'error' => 'Unauthorized',
                'status' => 'false'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'status' => true
        ]);
    }

    public function me()
    {
        try {
            $user = auth('api')->userOrFail();
            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out', 'status' => true]);
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(auth('api')->refresh(true, true));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => false], 500);
        }
    } */
}
