<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Exception;
use Illuminate\Http\Request;

class ApiPegawai extends Controller
{
    public function data(Request $request, $idpegawai)
    {
        try {
            $query = Pegawai::query();
            $data = $query->get()->toArray();
            if (!empty($idpegawai)) {
                $query->where('nopeg', $idpegawai);
            } else {
                throw new Exception("Pegawai tidak ditemukan", 1);
            }
            return response()->json([
                'message' => 'Berhasil mengambil data pegawai',
                'data' => $data,
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            $data = [
                'message' => $th->getCode() == 1 ? $th->getMessage() : 'Gagal mengambil data pegawai!',
                'status' => false
            ];

            return response()->json($data, 400);
        }
    }
}
