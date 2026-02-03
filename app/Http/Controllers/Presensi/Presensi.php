<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Presensi extends Controller
{
    protected $tahunAktif;

    public function __construct()
    {
        $this->tahunAktif = tahunAplikasi()->tahun;
    }

    public function index()
    {
        return view('presensi.index');
    }

    public function detail()
    {
        $post = request()->all();
        $year = $this->tahunAktif;
        $firstDayOfMonth = date('Y-m-d', strtotime($year . "-" . $post['bulan'] . 'first day of this month'));
        $lastDayOfMonth = date('Y-m-d', strtotime($year . "-" . $post['bulan'] . 'last day of this month'));

        $query = DB::select("select *, convertnumericdatetoalphabetical(rettanggal) tg_view from data_presensi(?,?,?) where retambil = 1", [$firstDayOfMonth, $lastDayOfMonth, json_encode([$post['nopeg']])]);

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

        $tahun = (int)$this->tahunAktif;

        $query = DB::table(
            DB::raw("
                (
                   select
                        p.nopeg, p.nama,
                        (fn_rekap_presensi_bulanan($tahun,1,p.nopeg)).persentase_kehadiran  as januari,
                        (fn_rekap_presensi_bulanan($tahun,2,p.nopeg)).persentase_kehadiran as februari,
                        (fn_rekap_presensi_bulanan($tahun,3,p.nopeg)).persentase_kehadiran as maret,
                        (fn_rekap_presensi_bulanan($tahun,4,p.nopeg)).persentase_kehadiran as april,
                        (fn_rekap_presensi_bulanan($tahun,5,p.nopeg)).persentase_kehadiran as mei,
                        (fn_rekap_presensi_bulanan($tahun,6,p.nopeg)).persentase_kehadiran as juni,
                        (fn_rekap_presensi_bulanan($tahun,7,p.nopeg)).persentase_kehadiran as juli,
                        (fn_rekap_presensi_bulanan($tahun,8,p.nopeg)).persentase_kehadiran as agustus,
                        (fn_rekap_presensi_bulanan($tahun,9,p.nopeg)).persentase_kehadiran as september,
                        (fn_rekap_presensi_bulanan($tahun,10,p.nopeg)).persentase_kehadiran as oktober,
                        (fn_rekap_presensi_bulanan($tahun,11,p.nopeg)).persentase_kehadiran as november,
                        (fn_rekap_presensi_bulanan($tahun,12,p.nopeg)).persentase_kehadiran as desember,
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
