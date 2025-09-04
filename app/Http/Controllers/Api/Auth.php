<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Applications\KonfigUmum;
use App\Models\Applications\Pegawai;
use App\Models\Masters\Kantor;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Auth extends Controller
{
    public function login(Request $request)
    {
        try {
            // md5('username'||md5('password'))
            $deviceToken = $request->input('device_token');
            $credentials = $request->only(['email', 'passwordapi']);
            $user = User::from('users as u')
                ->select(
                    'u.id', // penting untuk relasi
                    'p.nopeg',
                    'p.nama',
                    'p.isreguler'
                )
                ->join('applications.pegawai as p', 'p.nopeg', '=', 'u.nopeg')
                ->leftJoin('masters.jabatanstruktural as js', 'js.kodejabatanstruktural', '=', 'p.kodestruktural')
                ->leftJoin('masters.jabatanfungsional as jf', 'jf.kodejabatanfungsional', '=', 'p.kodejabfung')
                ->leftJoin('masters.kartuidentitas as kitas', 'kitas.id', '=', 'p.idkartuidentitas')
                ->where('u.email', $credentials['email'])
                ->where('u.passwordapi', $credentials['passwordapi'])
                ->with('roles') // ini yang load relasi
                ->first();

            if (empty($user)) throw new Exception("User tidak atau password tidak valid", 1);

            $konfigUmum = tahunAplikasi();
            $kantor = Kantor::select("latlong", "id", "nama as urai")->where('approval', 'Y');
            $pegawai = Pegawai::where('nopeg', $user->nopeg)->first();
            $pegawai->token_id = $deviceToken;
            $pegawai->save();

            $dataKonfigUmum = $konfigUmum->toArray();
            unset($dataKonfigUmum['lokasidef']);

            DB::commit();

            return response()->json([
                'message' => 'login berhasil',
                'status' => true,
                'nopeg' => $user->nopeg,
                'isreguler' => $user->isreguler,
                'konfigumum' => $dataKonfigUmum,
                'lokasi' => $kantor->get(),
                'peran' => $user->roles->pluck('name')->first(),
                'idusers' => $user->id,
                'ispejabat' => ($pegawai->kodestruktural <> 0)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => message("login gagal", $th),
                'status' => false
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
