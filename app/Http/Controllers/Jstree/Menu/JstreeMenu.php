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
            $query1 = DB::table(DB::raw("
                (
                    select '#' as parent, 'Root menu' as text, 0 as id, false as state, 'ti ti-category' as icon, true as checkbox_disabled
                ) as w 
            "));
            $query = Menu::from('masters.menu as m')->select(
                DB::raw("(case when parent = 0 then '0' else parent::text end) as parent"),
                "m.nama as text",
                "m.id",
                DB::raw("exists(select * from role_has_menu where menu_id = m.id and role_id " . $role . ") as state"),
                "i.nama as icon",
                DB::raw("true as checkbox_disabled")
            )
                ->join('masters.icon as i', 'i.id', '=', 'm.icon_id')
                ->orderBy("m.id")
                ->union($query1)
                ->get();

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
