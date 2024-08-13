<?php

namespace App\Http\Controllers\Karyawan\Add;

use App\Http\Controllers\Controller;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Masters\Agama;
use App\Models\Masters\Bidang;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Models\User;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KaryawanAdd extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $statusnikah = StatusNikah::all();
        $statuspegawai = StatusPegawai::all();
        $pendidikan = Pendidikan::all();
        $negara = Negara::all();
        $kartuidentitas = KartuIdentitas::all();
        $agama = Agama::all();
        return view('karyawan.add.index', compact('statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas', 'agama'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $bidangColumn = [
                'kodebidang',
                'kodedivisi',
                'kodesubdivisi',
                'kodesubsubdivisi'
            ];
            $bidang = explode(".", substr($post['organisasi'], 0, 7));

            $queryBidang = Bidang::query();
            for ($i = 0; $i < count($bidang); $i++) {
                $queryBidang->where($bidangColumn[$i], $bidang[$i]);
            }

            $dataBidang = $queryBidang->get()->toArray();
            if (empty($dataBidang)) throw new Exception("Bidang tidak ditemukan!", 1);
            $dataBidang = $dataBidang[0];

            if (Pegawai::where('email', $post['email'])->exists()) throw new Exception("Email sudah digunakan !", 1);
            if (array_key_exists("agama", $post)) $post['idagama'] = $post['agama'] ?? 0;
            if (!array_key_exists("kodejabfung", $post)) $post['kodejabfung'] = empty($post['kodejabfung']) ? 0 : $post['kodejabfung'];
            if (!array_key_exists("kodestruktural", $post)) $post['kodestruktural'] = empty($post['kodestruktural']) ? 0 : $post['kodestruktural'];
            $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
            $post['idbidang'] = $dataBidang['id'];

            $path = Storage::putFile('public/pegawai', $post['gambar']);
            unset($post['gambar']);
            $post['fullpath'] = $path;
            $post['gambar'] = basename($path);

            // make user
            $user = [
                "name" => $post['nama'],
                "email" => $post['nopeg'],
                "password" => bcrypt($post['nopeg']),
                "telpon" => $post['nohp'],
                "nopeg" => $post['nopeg'],
                "passwordapi" => md5($post['nopeg'] . md5($post['nopeg'])),
            ];

            Pegawai::create($post);

            $namaKeluarga = isset($post["namakeluarga"]) ? $post["namakeluarga"] : [];
            $hubunganKeluarga = isset($post["hubungankeluarga"]) ? $post["hubungankeluarga"] : [];
            $tempatlahirKeluarga = isset($post["tempatlahirkeluarga"]) ? $post["tempatlahirkeluarga"] : [];
            $tgllahirKeluarga = isset($post["tgllahirkeluarga"]) ? $post["tgllahirkeluarga"] : [];
            $telpKeluarga = isset($post['telpkeluarga']) ? $post['telpkeluarga'] : [];
            $alamatKeluarga = isset($post['alamatkeluarga']) ? $post['alamatkeluarga'] : [];

            Keluarga::where("nopeg", $post['nopeg'])->delete();

            foreach ($namaKeluarga as $key => $value) {
                $insertkeluarga = [
                    'nopeg' => $post['nopeg'],
                    'nama' => $value,
                    'hubungan' => $hubunganKeluarga[$key],
                    'tempatlahir' => $tempatlahirKeluarga[$key],
                    'tgllahir' => $tgllahirKeluarga[$key],
                    'telp' => $telpKeluarga[$key],
                    'alamat' => $alamatKeluarga[$key]
                ];
                Keluarga::create($insertkeluarga);
            }

            $user = User::create($user);
            $user->assignRole('pegawai');

            $this->activity("Input data karyawan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data karyawan gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
