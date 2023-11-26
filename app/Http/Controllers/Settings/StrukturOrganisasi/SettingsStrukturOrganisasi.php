<?php

namespace App\Http\Controllers\Settings\StrukturOrganisasi;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bidang;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

class SettingsStrukturOrganisasi extends Controller
{
    protected $bidangKolom;

    use TraitsLoggerActivity;

    public function __construct()
    {
        $this->bidangKolom = [
            'kodebidang',
            'kodedivisi',
            'kodesubdivisi',
            'kodesubsubdivisi'
        ];
    }

    public function index()
    {
        return view('settings.struktur-organisasi.index');
    }

    public function bidang()
    {
        try {
            //code...
            $bidang = Bidang::select(
                "kodebidang as id",
                "urai as text",
            )->where('kodedivisi', 0)->get();

            return response()->json(["results" => $bidang], 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Gagal mengambil data bidang", $th->getMessage())
            ];
            return response()->json($response, 500);
        }
    }

    public function simpan()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            if ($post['mode'] == 'tambah anak') {
                $res = $this->tambahAnak($post);
                if (!empty($res)) throw new Exception($res, 1);
            } else {
                $res = $this->tambahSaudara($post);
                if (!empty($res)) throw new Exception($res, 1);
            }

            DB::commit();

            $response = [
                'message' => 'Berhasil menyimpan data'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("Gagal menambah anak", $th->getMessage());

            $response = [
                'message' => message("Gagal menambah data", $th->getMessage())
            ];
            return response()->json($response, 500);
        }
    }

    private function tambahAnak($data)
    {
        try {
            if ($data['id'] == 0) {
                $nomor = Bidang::where('kodedivisi', 0)->max('kodebidang') + 1;
                $bidang = [
                    'kodebidang' => $nomor,
                    'kodedivisi' => 0,
                    'kodesubdivisi' => 0,
                    'kodesubsubdivisi' => 0,
                    'urai' => $data['urai'],
                    'tahun' => tahunAktif(),
                ];
                Bidang::create($bidang);
            } else {
                $bidang = [
                    'kodebidang' => 0,
                    'kodedivisi' => 0,
                    'kodesubdivisi' => 0,
                    'kodesubsubdivisi' => 0,
                    'urai' => $data['urai'],
                    'tahun' => tahunAktif(),
                ];

                $explode = explode(".", $data['id']);

                $whereBidang = Bidang::where('tahun', tahunAktif());

                $getKode = 0;
                for ($i = 0; $i < count($explode); $i++) {
                    if ($explode[$i] != 0) {
                        $getKode++;
                        $whereBidang->where($this->bidangKolom[$i], $explode[$i]);
                        $bidang[$this->bidangKolom[$i]] = $explode[$i];
                    }
                }

                $nomor = $whereBidang->max($this->bidangKolom[$getKode]) + 1;
                $bidang[$this->bidangKolom[$getKode]] = $nomor;

                Bidang::create($bidang);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function tambahSaudara($data)
    {
        try {
            $bidang = [
                'kodebidang' => 0,
                'kodedivisi' => 0,
                'kodesubdivisi' => 0,
                'kodesubsubdivisi' => 0,
                'urai' => $data['urai'],
                'tahun' => tahunAktif(),
            ];

            $explode = explode(".", $data['id']);

            $whereBidang = Bidang::where('tahun', tahunAktif());

            $getMax = 0;
            for ($i = 0; $i < count($explode); $i++) {
                if ($explode[$i] != 0) $getMax = $i;
            }

            for ($i = 0; $i < count($explode); $i++) {
                if ($i < $getMax) {
                    $whereBidang->where($this->bidangKolom[$i], $explode[$i]);
                    $bidang[$this->bidangKolom[$i]] = $explode[$i];
                }
            }

            $nomor = $whereBidang->max($this->bidangKolom[$getMax]) + 1;
            $bidang[$this->bidangKolom[$getMax]] = $nomor;

            Bidang::create($bidang);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
