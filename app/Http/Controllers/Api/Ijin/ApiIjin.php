<?php

namespace App\Http\Controllers\Api\Ijin;

use App\Http\Controllers\Controller;
use App\Models\Applications\Ijin;
use App\Models\Applications\Pegawai;
use App\Services\FcmService;
use App\Traits\Logger\TraitsLoggerActivity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiIjin extends Controller
{
    use TraitsLoggerActivity;

    protected $config, $path;

    public function __construct()
    {
        $this->config = tahunAplikasi();
        $this->path = 'public/ijin';
    }


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $form = $this->validateForm($post);

            if ($form instanceof JsonResponse) return $form;

            // Ambil data dari POST
            $tanggalawal  = $form['tgl_awal'];
            $tanggalakhir = $form['tgl_akhir'];

            // Ubah ke objek Carbon
            $start = Carbon::parse($tanggalawal);
            $end   = Carbon::parse($tanggalakhir);

            // Hitung selisih hari
            $selisihHari = $start->diffInDays($end) + 1;

            if ($selisihHari == 0) throw new Exception("Minimal cuti 1 hari", 1);

            $form['jumlah'] = $selisihHari;

            $atasan = Pegawai::where('nopeg', $post['nopeg_atasan'])->first();
            if (empty($atasan)) throw new Exception("Atasan tidak ditemukan", 1);

            if (!Pegawai::where("nopeg", $form['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            if (Ijin::where('nopeg', $form['nopeg'])->where("tgl_awal", '>=', $form['tgl_awal'])->where('tgl_akhir', '<=', $form['tgl_akhir'])->exists()) throw new Exception("Anda sudah pernah mengajukan ijin di tanggal {$form['tgl_awal']}", 1);

            if (isset($post['lampiran']) && !empty($post['lampiran'])) {
                buatFolder(storage_path('app/' . $this->path));

                // Ambil ekstensi file
                $extension = $post['lampiran']->getClientOriginalExtension();

                // Buat nama unik (timestamp + uniqid)
                $name = uniqid() . '_' . time() . '.' . $extension;

                // Simpan file ke storage
                Storage::putFileAs($this->path, $post['lampiran'], $name);

                // Simpan ke form
                $form['lampiran'] = $name;
            } else {
                $form['lampiran'] = null;
            }

            Ijin::create($form);

            $deviceToken = $atasan->token_id;
            $title = "Pemberitahuan Ijin";
            $body = "Ada pegawai yang membutuhkan persetujuan anda untuk Ijin!";
            $data = ["frg" => "AJUIJIN"];

            FcmService::sendNotification([
                'token' => $deviceToken,
                'title' => $title,
                'body'  => $body,
                'data'  => $data,
            ]);

            $response = [
                'message' => 'Ijin berhasil diajukan',
                'status' => true,
                'data' => $form
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Ijin [failed]", $th->getMessage());

            $response = [
                'message' => message("Ijin gagal diajukan", $th),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }

    public function validateForm($post)
    {

        $validator = Validator::make($post, [
            'nopeg' => 'required',
            'nopeg_atasan' => 'required',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'nullable',
            'lampiran'  => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:1024', // max 1MB
        ], []);

        if ($validator->fails()) {
            // Tangani error secara manual
            return response()->json([
                'message' => message("Data yang di kirim tidak sesuai aturan!"),
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
            $data = Ijin::select(["*", DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status")])->where("nopeg", $post['nopeg'])->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")->get();
            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data cuti gagal", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function cancel()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            if (empty($post['id'])) throw new Exception("Data ijin tidak ditemukan!", 1);
            if (!Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);

            $ijin = Ijin::where('id', $post['id'])->where('nopeg', $post['nopeg']);
            if (!$ijin->exists()) throw new Exception("Data ijin tidak ditemukan", 1);
            $ijin->delete();

            $response = [
                'message' => 'Berhasil membatalkan ijin',
                'status' => true,
            ];

            DB::commit();
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Cancel ijin [failed]", $th->getMessage());
            $response = [
                'message' => message("gagal membatalkan ijin", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }
}
