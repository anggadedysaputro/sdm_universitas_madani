<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Karyawan extends Controller
{
    public function index()
    {
        return view('karyawan.index');
    }

    public function data()
    {
        $data = DB::table(DB::raw("
            (
                select 
                    p.nopeg, p.nama, convertnumericdatetoalphabetical(p.tgl_lahir) tanggal_lahir,
                    p.alamat, case when p.jns_kel = 'L' then 'Laki - laki' else 'Perempuan' end as jenis_kelamin,
                    p.gol_darah,p.agama, sn.status as status_nikah, p.kewarganegaraan, ki.keterangan as nama_kartuidentitas,p.noidentitas
                from applications.pegawai p
                join masters.statusnikah sn
                on p.idstatusnikah = sn.idstatusnikah
                join masters.kartuidentitas ki
                on p.idkartuidentitas = ki.id
            ) as p
        "));
        return DataTables::of($data)->toJson();
    }
}
