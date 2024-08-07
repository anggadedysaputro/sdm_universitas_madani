<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Exception;
use Illuminate\Http\Request;

class ApiPegawai extends Controller
{
    public function data()
    {
        try {
            $idpegawai = request('idpegawai');
            $query = Pegawai::from("applications.pegawai as p")->select(
                "p.nopeg",
                "p.nama",
                "p.tempatlahir",
                "p.tgl_lahir",
                "p.idagama",
                "p.alamat",
                "p.telp",
                "p.noidentitas",
                "p.gol_darah",
                "p.rekbank",
                "p.tgl_masuk",
                "p.aktif",
                "p.idstatuspegawai",
                "p.idstatusnikah",
                "p.email",
                "p.jns_kel",
                "p.npwp",
                "p.kodejabfung",
                "jf.urai as jabatanfungsional",
                "p.kodestruktural",
                "js.urai as jabatanstruktural",
                "p.kodependidikan",
                "p.tahun_lulus",
                "p.namasekolah",
                "p.prodi",
                "p.nokk",
                "p.notelpdarurat",
                "p.namakeluargadarurat",
                "p.hubdarurat",
                "p.nohp",
                "p.idkartuidentitas",
                "p.kewarganegaraan",
                "p.idwarganegara",
                "p.no_bpjs_ketenagakerjaan",
                "p.tgl_bpjs_ketenagakerjaan",
                "p.no_bpjs_kesehatan",
                "p.tgl_bpjs_kesehatan",
                "p.created_at",
                "p.updated_at",
                "p.fullpath",
                "p.gambar"
            )
                ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", "=", "p.kodejabfung")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", "=", "p.kodestruktural")
                ->where('nopeg', $idpegawai);
            $data = $query->get()->toArray();

            if (empty($idpegawai)) {
                throw new Exception("Id pegawai harus ada", 1);
            } else if (empty($data)) {
                throw new Exception("Pegawai tidak ditemukan", 1);
            }

            $data[0]["link"] = asset("public/storage/pegawai/" . $data[0]["gambar"]);

            return response()->json([
                'message' => 'Berhasil mengambil data pegawai',
                'data' => $data,
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            $data = [
                'message' => $th->getCode() == 1 ? $th->getMessage() : 'Gagal mengambil data pegawai!',
                'status' => false
            ];

            return response()->json($data, 200);
        }
    }
}
