<?php

namespace App\Http\Controllers\Api\Libur;

use App\Http\Controllers\Controller;
use App\Models\Masters\Libur;
use Exception;
use Illuminate\Http\Request;

class ApiLibur extends Controller
{
    public function data()
    {
        try {
            $tahun = tahunAplikasi()['tahun'];
            $bulan = request()->input('bulan');

            if (empty($bulan)) throw new Exception("Bulan wajib ada!", 1);

            $query = Libur::select("tanggal", "keterangan")
                ->whereRaw("extract(year from tanggal) = " . $tahun);

            if (!empty($bulan)) $query->whereRaw("extract(month from tanggal) = " . $bulan);

            $result = $query->get();

            return response()->json([
                'message' => 'Berhasil mengambil libur',
                'status' => true,
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => message('Gagal mengambil libur', $th),
                'status' => false,
                'data' => []
            ], 200);
        }
    }
}
