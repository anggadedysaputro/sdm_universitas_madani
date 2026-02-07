<?php

namespace App\Http\Controllers\Cuti\History;

use App\Http\Controllers\Controller;
use App\Models\Applications\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CutiHistory extends Controller
{
    public function index()
    {
        return view('cuti.history.index');
    }

    public function data(Request $request)
    {
        $nopeg = $request->query('nopeg');

        $query = DB::table('applications.cuti as c')
            ->select(
                'c.keterangan',
                'c.jumlah',
                'c.sisa',
                'c.id',
                'c.approval',
                'c.approval_sdm',
                DB::raw("json_agg(json_build_object('tanggal_cuti',cd.tanggal)) as detail")
            )
            ->join('applications.cuti_detail as cd', 'c.id', '=', 'cd.idcuti')
            ->where('c.nopeg', $nopeg)
            ->groupBy(
                'c.keterangan',
                'c.jumlah',
                'c.sisa',
                'c.id',
                'c.approval',
                'c.approval_sdm'
            );

        return DataTables::of($query)->make(true);
    }
}
