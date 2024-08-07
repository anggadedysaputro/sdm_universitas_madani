<?php

namespace App\Http\Controllers\Karyawan\Edit;

use App\Http\Controllers\Controller;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Masters\Agama;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KaryawanEdit extends Controller
{
    use TraitsLoggerActivity;

    public function index($id)
    {
        $pegawai = Pegawai::from("applications.pegawai as p")
            ->select(
                "nopeg",
                "nama",
                DB::raw("convertnumericdatetoalphabetical(tgl_lahir) as tanggal_lahir"),
                "tgl_lahir",
                "jns_kel",
                DB::raw("case when jns_kel = 'L' then 'Laki-laki' else 'Perempuan' end as jenis_kelamin"),
                "gol_darah",
                "a.urai as agama",
                "p.idagama",
                "sn.status as status_nikah",
                "p.idstatusnikah",
                "p.kewarganegaraan",
                "n.keterangan as negara",
                "p.idwarganegara",
                "p.tempatlahir",
                "p.nokk",
                "p.email",
                "ki.keterangan as kartu_identitas",
                "p.idkartuidentitas",
                "p.noidentitas",
                "p.alamat",
                "p.notelpdarurat",
                "p.nohp",
                "p.telp",
                "p.idstatuspegawai",
                "sp.keterangan as status_pegawai",
                DB::raw("convertnumericdatetoalphabetical(tgl_masuk) as tanggal_masuk"),
                "p.tgl_masuk",
                "p.kodejabfung",
                "jf.urai as jabatan_fungsional",
                "p.kodestruktural",
                "js.urai as jabatan_struktural",
                "p.prodi",
                "p.namasekolah",
                "p.tahun_lulus",
                "p.kodependidikan",
                "pen.keterangan as pendidikan",
                "p.fullpath",
                "p.gambar",
                DB::raw("
                    (
                        select json_agg(k.*)
                        from applications.keluarga k
                        where nopeg = p.nopeg
                    ) keluarga
                ")
            )->where('nopeg', $id)
            ->join('masters.agama as a', 'a.id', '=', 'p.idagama')
            ->join('masters.statusnikah as sn', 'sn.idstatusnikah', '=', 'p.idstatusnikah')
            ->join('masters.negara as n', 'n.id', '=', 'p.idwarganegara')
            ->join('masters.kartuidentitas as ki', 'ki.id', '=', 'p.idkartuidentitas')
            ->join('masters.statuspegawai as sp', 'sp.idstatuspegawai', '=', 'p.idstatuspegawai')
            ->join('masters.jabatanfungsional as jf', 'jf.kodejabatanfungsional', '=', 'p.kodejabfung')
            ->join('masters.jabatanstruktural as js', 'js.kodejabatanstruktural', '=', 'p.kodestruktural')
            ->join('masters.pendidikan as pen', 'pen.kodependidikan', '=', 'p.kodependidikan')
            ->first();

        if (empty($pegawai)) return redirect()->route('karyawan.index');

        $statusnikah = StatusNikah::all();
        $statuspegawai = StatusPegawai::all();
        $pendidikan = Pendidikan::all();
        $negara = Negara::all();
        $kartuidentitas = KartuIdentitas::all();
        $agama = Agama::all();

        $keluarga = empty($pegawai->keluarga) ? [] : json_decode($pegawai->keluarga);

        return view('karyawan.edit.index', compact('id', 'keluarga', 'pegawai', 'statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas', 'agama'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {

            $post = request()->all();

            $id = $post['nopeg_lama'];
            unset($post['nopeg_lama']);
            if (array_key_exists("tgl_lahir", $post)) $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
            if (!array_key_exists("kodestruktural", $post)) $post['kodestruktural'] = 0;
            if (!array_key_exists("kodejabfung", $post)) $post['kodejabfung'] = 0;

            if (isset($post['namakeluarga'])) {
                Keluarga::where('nopeg', $id)->delete();
                foreach ($post['namakeluarga'] as $key => $value) {
                    $insertkeluarga = [
                        'nopeg' => $id,
                        'nama' => $value,
                        'hubungan' => $post['hubungankeluarga'][$key],
                        'tempatlahir' => $post['tempatlahirkeluarga'][$key],
                        'tgllahir' => $post['tgllahirkeluarga'][$key],
                        'telp' => $post['telpkeluarga'][$key],
                        'alamat' => $post['alamatkeluarga'][$key]
                    ];
                    Keluarga::create($insertkeluarga);
                }
            } else {
                Pegawai::find($id)->update($post);
            }

            $this->activity("Edit data karyawan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data karyawan gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function upload()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $pegawai = Pegawai::find($post['idpegawai']);
            Storage::delete($pegawai->fullpath);

            $path = Storage::putFile('public/pegawai', $post['gambar']);

            $id = $post['idpegawai'];
            unset($post['idpegawai']);
            unset($post['gambar']);
            $post['fullpath'] = $path;
            $post['gambar'] = basename($path);

            Pegawai::find($id)->update($post);

            DB::commit();

            $response = [
                'message' => 'Upload foto karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Upload foto karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Upload foto karyawan gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
