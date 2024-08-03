<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Exception;
use Illuminate\Http\Request;

class ApiPegawai extends Controller
{
    public function data()
    {
        try {
            $idpegawai = request('idpegawai');
            $query = Pegawai::query();
            $query->where('nopeg', $idpegawai);
            $data = $query->get()->toArray();

            if (empty($idpegawai)) {
                throw new Exception("Id pegawai harus ada", 1);
            } else if (empty($data)) {
                throw new Exception("Pegawai tidak ditemukan", 1);
            }

            $data[0]["link"] = asset("storage/pegawai/" . $data[0]["gambar"]);

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
