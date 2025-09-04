<?php

namespace App\Http\Controllers\Api\Fcm;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use App\Services\FcmService;
use App\Services\FirebaseService;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiFcm extends Controller
{
    use TraitsLoggerActivity;

    public function notification(FirebaseService $firebase)
    {
        try {
            // $deviceToken = "APA91bFYQix5WHlYHaozYx4zyLp_XsvokHAjIGFaDc3CXoyHE7gIjFTkfM1lki1LCD...";
            // $title = "Pemberitahuan Cuti";
            // $body = "Ada pegawai yang membutuhkan persetujuan anda untuk cuti!";
            // $data = ["frg" => "AJUCUTI"];



            $deviceToken = request()->input('device_token');
            $title = request()->input('title');
            $body = request()->input('body');
            $data = request()->input('data');

            // $response = $firebase->sendNotification($deviceToken, $title, $body, $data);


            $response = [
                'message' => 'Berhasil mengirim notifikasi',
                'status' => true,
                'data' => FcmService::sendNotification([
                    'token' => $deviceToken,
                    'title' => $title,
                    'body'  => $body,
                    'data'  => $data,
                ])
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {

            $this->activity("Kirim notifikasi [failed]", $th->getMessage());
            $response = [
                'message' => message("gagal mengirim notifikasi", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function refreshFcmToken(Request $request)
    {
        DB::beginTransaction();
        try {
            $post = $request->input();

            if (empty($post['nopeg']) || !isset($post['nopeg'])) throw new Exception("Nomor pegawai wajib diisi", 1);
            if (empty($post['device_token']) || !isset($post['device_token'])) throw new Exception("Device token wajib diisi", 1);

            // Cari pegawai
            $pegawai = Pegawai::where('nopeg', $post['nopeg'])->first();
            if (!$pegawai) {
                throw new \Exception("Pegawai tidak ditemukan", 1);
            }

            // Update token
            $pegawai->token_id = $post['device_token'];
            $pegawai->save();

            DB::commit();

            return response()->json([
                'message' => "refresh token berhasil",
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("refresh token [failed]", $th->getMessage());

            return response()->json([
                'message' => message("refresh token gagal", $th),
                'status' => false
            ], 200);
        }
    }
}
