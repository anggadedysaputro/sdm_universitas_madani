<?php

namespace App\Http\Controllers\Api\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Applications\Cuti;
use App\Models\Applications\KonfigUmum;
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

class ApiCuti extends Controller
{
    use TraitsLoggerActivity;

    protected $config, $path;

    public function __construct()
    {
        $this->config = tahunAplikasi();
        $this->path = 'public/cuti';
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

            $getLibur = DB::select("select count(1) as jumlah from list_libur(?,?)", [$form['tgl_awal'], $form['tgl_akhir']]);

            if (($selisihHari - $getLibur[0]->jumlah) <= 0) throw new Exception("Anda cuti di hari libur!", 1);

            $selisihHari -= $getLibur[0]->jumlah;
            if ($selisihHari == 0) throw new Exception("Minimal cuti 1 hari", 1);

            $form['jumlah'] = $selisihHari;


            if (!Pegawai::where("nopeg", $form['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            if (Cuti::where('nopeg', $form['nopeg'])->where("tgl_awal", '>=', $form['tgl_awal'])->where('tgl_akhir', '<=', $form['tgl_akhir'])->exists()) throw new Exception("Anda sudah pernah mengajukan cuti di tanggal {$form['tgl_awal']}", 1);

            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);

            $totalCuti = Cuti::where('nopeg', $form['nopeg'])
                ->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")
                ->sum('jumlah');

            $sisaCuti = $this->config->defcuti - ($totalCuti + $form['jumlah']);

            if ($sisaCuti < 0) throw new Exception("Kuota cuti anda sudah habis!", 1);
            $form['sisa'] = $sisaCuti;

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

            Cuti::create($form);

            $deviceToken = request()->input('device_token');
            $title = "Pemberitahuan Cuti";
            $body = "Ada pegawai yang membutuhkan persetujuan anda untuk cuti!";
            $data = ["frg" => "AJUCUTI"];

            FcmService::sendNotification([
                'token' => $deviceToken,
                'title' => $title,
                'body'  => $body,
                'data'  => $data,
            ]);

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
                'message' => message("Cuti gagal diajukan", $th),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }

    public function validateForm($post)
    {

        $validator = Validator::make($post, [
            'nopeg' => 'required',
            'device_token' => 'required',
            'nopeg_atasan' => 'required',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'nullable',
            'lampiran'  => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:1024', // max 1mb
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
            $data = Cuti::select(["*", DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status")])->where("nopeg", $post['nopeg'])->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")->get();
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
            if (empty($post['id'])) throw new Exception("Data cuti tidak ditemukan!", 1);
            if (!Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);

            $cuti = Cuti::where('id', $post['id'])->where('nopeg', $post['nopeg']);
            $cekDiatasnya = Cuti::where('id', '>', $post['id'])->where('nopeg', $post['nopeg']);

            if ($cekDiatasnya->exists()) throw new Exception("Anda memiliki cuti yang lebih baru, batalkan terlebih dahulu!", 1);
            if (!$cuti->exists()) throw new Exception("Data cuti tidak ditemukan", 1);

            $cuti->delete();

            $sisaCuti = Cuti::select("sisa")->where('nopeg', $post['nopeg'])->orderBy('id', 'desc')->first();

            $sisaCuti = empty($sisaCuti) ? 0 : $sisaCuti->sisa;

            $response = [
                'message' => 'Berhasil membatalkan cuti',
                'status' => true,
                'sisa_cuti' => $sisaCuti
            ];

            DB::commit();
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Cancel Cuti [failed]", $th->getMessage());
            $response = [
                'message' => message("gagal membatalkan cuti", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }
}
