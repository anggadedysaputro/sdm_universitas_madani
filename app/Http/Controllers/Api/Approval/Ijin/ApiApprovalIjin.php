<?php

namespace App\Http\Controllers\Api\Approval\Ijin;

use App\Http\Controllers\Controller;
use App\Models\Applications\Ijin;
use App\Models\Applications\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiApprovalIjin extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = tahunAplikasi();
    }
    public function data()
    {
        try {
            $post = request()->all();
            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);
            if (!Pegawai::where("nopeg", $post['nopeg_atasan'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            $data = Ijin::select(
                [
                    "*",
                    DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status")
                ]
            )->where("nopeg_atasan", $post['nopeg_atasan'])
                ->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")
                ->whereNull("approval")
                ->get();

            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data ijin gagal", $th->getMessage()),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }
}
