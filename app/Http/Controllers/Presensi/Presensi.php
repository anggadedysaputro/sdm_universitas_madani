<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Presensi extends Controller
{
    public function index()
    {
        return view('presensi.index');
    }

    public function data()
    {

        $query = DB::table(
            DB::raw("
                (
                    select retnopeg, retnama
                    from data_presensi(concat(extract(year from CURRENT_DATE),'-01-01')::date,CURRENT_DATE,null)
                    where retambil = 1
                    group by retnopeg, retnama
                ) as m
            ")
        );

        return DataTables::of($query)->tojson();
    }
}
