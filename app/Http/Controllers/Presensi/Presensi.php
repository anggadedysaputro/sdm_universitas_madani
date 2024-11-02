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

    public function detail()
    {
        $post = request()->all();
        $year = date('Y');
        $firstDayOfMonth = date('Y-m-d', strtotime($year . "-" . $post['bulan'] . 'first day of this month'));
        $lastDayOfMonth = date('Y-m-d', strtotime($year . "-" . $post['bulan'] . 'last day of this month'));

        $query = DB::select("select *, convertnumericdatetoalphabetical(rettanggal) tg_view from data_presensi(?,?,?)", [$firstDayOfMonth, $lastDayOfMonth, $post['nopeg']]);

        return response()->json($query, 200);
    }

    public function data()
    {
        $post = request()->all();

        $bidang = [
            'kodebidang',
            'kodedivisi',
            'kodesubdivisi',
            'kodesubsubdivisi'
        ];

        $query = DB::table(
            DB::raw("
                (
                    select
                        p.nopeg, p.nama,
                        100 as januari,
                        100 as februari,
                        100 as maret,
                        100 as april,
                        100 as mei,
                        100 as juni,
                        100 as juli,
                        100 as agustus,
                        100 as september,
                        100 as oktober,
                        100 as november,
                        100 as desember,
                        b.kodebidang,
                        b.kodedivisi,
                        b.kodesubdivisi,
                        b.kodesubsubdivisi
                    from applications.pegawai as p
                    join masters.bidang as b on b.id = p.idbidang
                ) as m
            ")
        );

        $kodeFullBidang = "";

        foreach ($bidang as $key => $value) {
            if (array_key_exists($value, $post) && !empty($post[$value])) $kodeFullBidang = $post[$value];
        }
        $arrKodeFullBidang = empty($kodeFullBidang) ? [] : explode(".", $kodeFullBidang);

        foreach ($bidang as $key => $value) {
            if (!empty($arrKodeFullBidang) && $arrKodeFullBidang[$key] != 0) $query->where($value, $arrKodeFullBidang[$key]);
        }


        return DataTables::of($query)->tojson();
    }
}
