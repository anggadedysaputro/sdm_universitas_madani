<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiPegawai extends Controller
{
    use TraitsLoggerActivity;

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
                "p.gambar",
                "p.idbidang",
                "bid.urai as nama_bidang"
            )
                ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", "=", "p.kodejabfung")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", "=", "p.kodestruktural")
                ->join("masters.bidang as bid", "bid.id", "=", "p.idbidang")
                ->where('nopeg', $idpegawai);
            $data = $query->get()->toArray();

            if (empty($idpegawai)) {
                throw new Exception("Id pegawai harus ada", 1);
            } else if (empty($data)) {
                throw new Exception("Pegawai tidak ditemukan", 1);
            }

            $data[0]["link"] = asset("storage/pegawai/" . $data[0]["gambar"]);

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

    public function uploadFoto()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $pegawai = Pegawai::find($post['nopeg']);
            Storage::delete($pegawai->fullpath);

            $path = Storage::putFile('public/pegawai', $post['foto']);

            $id = $post['nopeg'];
            unset($post['nopeg']);
            unset($post['foto']);
            $post['fullpath'] = $path;
            $post['gambar'] = basename($path);

            Pegawai::find($id)->update($post);

            DB::commit();

            $response = [
                'message' => 'Upload foto karyawan berhasil',
                'status' => true
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Upload foto karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Upload foto karyawan gagal", $th->getMessage()),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }
}
