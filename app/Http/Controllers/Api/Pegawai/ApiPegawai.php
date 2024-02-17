<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Illuminate\Http\Request;

class ApiPegawai extends Controller
{
    public function data(Request $request)
    {
        try {
            $idpegawai = $request->input();
            $query = Pegawai::query();
            $data = $query->get()->toArray();
            if (!empty($idpegawai)) {
                $query->where('nopeg', $idpegawai);
            }
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
