<?php

namespace App\Http\Controllers\Jstree\Menu;

use App\Http\Controllers\Controller;
use App\Models\Masters\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JstreeMenu extends Controller
{
    public function data()
    {
        try {
            $query = Menu::select(
                DB::raw("(case when parent = 0 then '#' else parent::text end) as parent"),
                "nama as text",
                "id"
            )->get();

            if ($query->isEmpty()) {
                $query = [
                    [
                        "parent" => "#",
                        "text" => "Menu belum dimasukkan, tekan tombol tambah menu untuk menambahkan data",
                        "id" => 0
                    ]
                ];
            }

            $response = [
                'message' => 'berhasil mengambil data menu',
                'data' => $query
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Input data menu gagal", $th->getMessage())
            ];
            return response()->json($response, 500);
        }
    }
}
