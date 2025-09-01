<?php

namespace App\Http\Controllers\Jstree\StrukturOrganisasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JstreeStrukturOrganisasi extends Controller
{
    public function data()
    {
        try {
            $query = DB::table(
                DB::raw("masters.jstree_struktur_organisasi(" . tahunAktif() . ")")
            )
                ->orderBy("id")
                ->get();

            $response = [
                'message' => 'berhasil mengambil data organisasi',
                'data' => $query
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Input data organisasi gagal", $th)
            ];
            return response()->json($response, 500);
        }
    }
}
