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
                    p.gol_darah,p.agama, sn.status as status_nikah, p.kewarganegaraan, ki.keterangan as nama_kartuidentitas,p.noidentitas,
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
            ) as p
        "));

        $nopeg = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('nopeg AS value, nopeg as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('nopeg')
            ->get();

        $nama = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('nama AS value, nama as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('nama')
            ->get();

        return DataTables::of($data)
            ->searchPane('nopeg', $nopeg)
            ->searchPane('nama', $nama)
            ->toJson();
    }
}
