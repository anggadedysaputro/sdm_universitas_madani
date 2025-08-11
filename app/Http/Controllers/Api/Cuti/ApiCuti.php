<?php

namespace App\Http\Controllers\Api\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Applications\Cuti;
use App\Models\Applications\KonfigUmum;
use App\Models\Applications\Pegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCuti extends Controller
{
    use TraitsLoggerActivity;

    protected $config;

    public function __construct()
    {
        $this->config = ConfigApp::where('aktif', true)->first();
    }


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $form = $this->validateForm($post);
            // Ambil data dari POST
            $tanggalawal  = $form['tgl_awal'];
            $tanggalakhir = $form['tgl_akhir'];

            // Ubah ke objek Carbon
            $start = Carbon::parse($tanggalawal);
            $end   = Carbon::parse($tanggalakhir);

            // Hitung selisih hari
            $selisihHari = $start->diffInDays($end);
            $form['jumlah'] = $selisihHari;

            if ($form instanceof JsonResponse) return $form;
            if (!Pegawai::where("nopeg", $form['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            if (Cuti::where('nopeg', $form['nopeg'])->where("tgl_awal", $form['tgl_awal'])->exists()) throw new Exception("Anda sudah pernah mengajukan cuti di tanggal {$form['tgl_awal']}", 1);

            $konfigUmum = KonfigUmum::from("applications.konfigumum as ku")->select(
                "defcuti",
            )->where('idkonfigumum', $this->config->idkonfig)->orderBy("idkonfigumum", "desc")->first();

            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);

            $totalCuti = Cuti::where('nopeg', $form['nopeg'])
                ->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")
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
                'message' => $th->getCode() == 1 ? $th->getMessage() : message("Cuti gagal diajukan", $th->getMessage()),
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
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'nullable',
        ], []);


        if ($validator->fails()) {
            // Tangani error secara manual
            return response()->json([
                'message' => message("Data yang di kirim tidak sesuai aturan!", "validasi gagal"),
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        // Lanjutkan jika validasi berhasil
        $validatedData = $validator->validated();

        return $validatedData;
    }

    public function data()
    {
        try {
            $post = request()->all();
            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);
            if (!Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            $data = Cuti::select(["*", DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status")])->where("nopeg", $post['nopeg'])->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")->get();
            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data cuti gagal", $th->getMessage()),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }
}
