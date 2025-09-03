<?php

namespace App\Http\Controllers\Api\Fcm;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;

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

            $response = $firebase->sendNotification($deviceToken, $title, $body, $data);

            $response = [
                'message' => 'Berhasil mengirim notifikasi',
                'status' => true,
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
}
