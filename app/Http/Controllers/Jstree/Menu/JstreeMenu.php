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
            $role = 'is null';
            if (request()->has('role')) {
                $role =  empty(request('role')) ? $role : "=" . request('role');
            };
            $query = Menu::select(
                DB::raw("(case when parent = 0 then '#' else parent::text end) as parent"),
                "nama as text",
                "id",
                DB::raw("exists(select * from role_has_menu where menu_id = menu.id and role_id " . $role . ") as state")
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
