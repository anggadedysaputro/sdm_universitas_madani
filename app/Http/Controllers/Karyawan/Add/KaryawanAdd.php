<?php

namespace App\Http\Controllers\Karyawan\Add;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('karyawan.add.index', compact('statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            if (Pegawai::where('email', $post['email'])->exists()) throw new Exception("Email sudah digunakan !", 1);

            if (array_key_exists("kodejabfung", $post)) $post['kodejabfung'] = $post['kodejabfung'] ?? 0;
            if (array_key_exists("kodestruktural", $post)) $post['kodestruktural'] = $post['kodestruktural'] ?? 0;

            Pegawai::create($post);

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
