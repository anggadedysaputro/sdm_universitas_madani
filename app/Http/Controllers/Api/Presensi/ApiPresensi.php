<?php

namespace App\Http\Controllers\Api\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Applications\Presensi;
use App\Traits\Logger\TraitsLoggerActivity;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPresensi extends Controller
{
    use TraitsLoggerActivity;

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $now = new DateTime();
            $current = $now->format('Y-m-d H:i:s');

            $date = explode(" ", $current);
            $post['waktu'] = $date[1];
            $post['tanggal'] = $date[0];
            $post['tahun'] = $now->format("Y");
            $post['bulan'] = $now->format("m");
            $post['hari'] = $now->format("d");
            $post['jam'] = $now->format("H");
            $post['menit'] = $now->format("i");

            Presensi::create($post);

            DB::commit();

            $response = [
                'message' => 'Presensi berhasil',
                'status' => true,
                'data' => $post
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Presensi [failed]", $th->getMessage());

            $response = [
                'message' => message("Presensi gagal", $th->getMessage()),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }
}
