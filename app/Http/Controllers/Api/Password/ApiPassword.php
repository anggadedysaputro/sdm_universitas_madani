<?php

namespace App\Http\Controllers\Api\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\EasyAES;

class ApiPassword extends Controller
{
    protected $easyAES;

    public function __construct()
    {
        $this->easyAES = new EasyAES(env('EASY_AES_KEY'), 256, env('EASY_AES_KEY_IV'));
    }

    public function ubah(Request $request)
    {

        try {
            $post = $request->all();
            $form = $this->validatePasswordForm($post);

            if ($form instanceof JsonResponse) {
                return $form; // Return jika ada error validasi
            }

            // Ambil user berdasarkan nopeg
            $user = User::where('id', $post['idusers'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan!',
                    'status' => false
                ], 200);
            }

            // Cek password lama
            if ($post['current_password'] != $user->passwordapi) {
                return response()->json([
                    'message' => 'Password lama salah!',
                    'status' => false
                ], 200);
            }

            $kataSandi = $this->easyAES->decrypt($post['new_password']);

            // Update password baru
            $user->password = Hash::make($kataSandi);
            $user->passwordapi = md5(md5($user->email) . md5($kataSandi));
            $user->save();

            return response()->json([
                'message' => 'Password berhasil diubah!',
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'status' => false
            ], 200);
        }
    }

    public function validatePasswordForm($post)
    {
        $validator = Validator::make($post, [
            'idusers' => 'required',
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed', // harus ada new_password_confirmation
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Data yang dikirim tidak sesuai aturan!",
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        return $validator->validated();
    }
}
