<?php

namespace App\Http\Controllers\Api\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Applications\Cuti;
use App\Models\Applications\KonfigUmum;
use App\Models\Applications\Pegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCuti extends Controller
{
    use TraitsLoggerActivity;


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $form = $this->validateForm($post);

            if (!Pegawai::where("nopeg", $form['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);

            $config = ConfigApp::where('aktif', true)->first();
            $konfigUmum = KonfigUmum::from("applications.konfigumum as ku")->select(
                "defcuti",
            )->where('idkonfigumum', $config->idkonfig)->orderBy("idkonfigumum", "desc")->first();

            if (!$config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);

            $totalCuti = Cuti::where('nopeg', $form['nopeg'])
                ->whereRaw("extract(year from tgl_awal) = {$config->tahun}")
                ->sum('jumlah');

            $sisaCuti = $konfigUmum->defcuti - ($totalCuti + $form['jumlah']);

            if ($sisaCuti < 0) throw new Exception("Kuota cuti anda sudah habis!", 1);
            $form['sisa'] = $sisaCuti;

            Cuti::create($form);

            $response = [
                'message' => 'Cuti berhasil diajukan',
                'status' => true,
                'data' => $form
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Cuti [failed]", $th->getMessage());

            $response = [
                'message' => message("Cuti gagal diajukan", $th->getMessage()),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }

    public function validateForm($post)
    {

        $validator = Validator::make($post, [
            'nopeg' => 'required',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'keterangan' => 'nullable',
            'jumlah' => 'required|integer',
        ], []);


        if ($validator->fails()) {
            // Tangani error secara manual
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        // Lanjutkan jika validasi berhasil
        $validatedData = $validator->validated();

        return $validatedData;
    }
}
