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
                    p.gol_darah,a.urai as agama, sn.status as status_nikah, p.kewarganegaraan, ki.keterangan as nama_kartuidentitas,p.noidentitas,
                    p.notelpdarurat, p.email, sp.keterangan as status_pegawai,convertnumericdatetoalphabetical(p.tgl_masuk) as tanggal_bergabung,
                    jb.urai as jabatan_fungsional, js.urai as jabatan_struktural
                from applications.pegawai p
                join masters.statusnikah sn
                on p.idstatusnikah = sn.idstatusnikah
                join masters.kartuidentitas ki
                on p.idkartuidentitas = ki.id
                join masters.statuspegawai sp
                on p.idstatuspegawai = sp.idstatuspegawai
                join masters.jabatanfungsional jb
                on jb.kodejabatanfungsional = p.kodejabfung
                join masters.jabatanstruktural js
                on js.kodejabatanstruktural = p.kodestruktural
                join masters.agama a
                on a.id = p.idagama
            ) as p
        "));

        $statuspegawai = DB::table('applications.pegawai as p')
            ->join('masters.statuspegawai as sp', 'sp.idstatuspegawai', 'p.idstatuspegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('keterangan AS value, keterangan as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('keterangan')
            ->get();

        $nama = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('nama AS value, nama as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('nama')
            ->get();
        $nomorkartuidentitas = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('noidentitas AS value, noidentitas as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('noidentitas')
            ->get();
        $agama = DB::table('applications.pegawai as p')
            ->join('masters.agama as a', 'a.id', '=', 'p.idagama')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('a.urai AS value, a.urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('a.urai')
            ->get();

        $jabatanstruktural = DB::table('applications.pegawai as p')
            ->join('masters.jabatanstruktural as sp', 'sp.kodejabatanstruktural', 'p.kodestruktural')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('urai AS value, urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('urai')
            ->get();

        $jabatanfungsional = DB::table('applications.pegawai as p')
            ->join('masters.jabatanfungsional as sp', 'sp.kodejabatanfungsional', 'p.kodejabfung')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('urai AS value, urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('urai')
            ->get();
        return DataTables::of($data)
            ->searchPane('status_pegawai', $statuspegawai)
            ->searchPane('nama', $nama)
            ->searchPane('noidentitas', $nomorkartuidentitas)
            ->searchPane('agama', $agama)
            ->searchPane('jabatan_struktural', $jabatanstruktural)
            ->searchPane('jabatan_fungsional', $jabatanfungsional)
            ->toJson();
    }
}
