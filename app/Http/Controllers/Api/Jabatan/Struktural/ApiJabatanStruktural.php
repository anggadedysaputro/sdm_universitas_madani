<?php

namespace App\Http\Controllers\Api\Jabatan\Struktural;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Illuminate\Http\Request;

class ApiJabatanStruktural extends Controller
{
    public function data()
    {
        try {
            $query = Pegawai::from("applications.pegawai as p")
                ->select("p.nama", "js.urai as nama_jabatan", "p.nopeg")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", "p.kodestruktural")
                ->where("kodejabatanstruktural", "<>", 0);
            $result = $query->get();

            return response()->json([
                'message' => 'Berhasil mengambil jabatan',
                'status' => true,
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal mengambil jabatan',
                'status' => false,
                'data' => []
            ], 200);
        }
    }
}
