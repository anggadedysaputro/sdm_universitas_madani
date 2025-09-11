<?php

namespace App\Http\Controllers\Api\Approval\Ijin;

use App\Http\Controllers\Controller;
use App\Models\Applications\Ijin;
use App\Models\Applications\Pegawai;
use App\Services\FcmService;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiApprovalIjin extends Controller
{
    protected $config;

    use TraitsLoggerActivity;

    public function __construct()
    {
        $this->config = tahunAplikasi();
    }
    public function data()
    {
        try {
            $post = request()->all();
            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);
            if (!Pegawai::where("nopeg", $post['nopeg_atasan'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            $data = Ijin::from("applications.ijin as c")->select(
                [
                    "js.urai as nama_jabatan_struktural",
                    "jf.urai as nama_jabatan_fungsional",
                    "c.*",
                    "p.nama",
                    DB::raw("coalesce(b.urai,'#NA') as nama_bidang"),
                    DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status")
                ]
            )
                ->join("applications.pegawai as p", "p.nopeg", '=', "c.nopeg")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", '=', 'p.kodestruktural')
                ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", '=', 'p.kodejabfung')
                ->leftJoin("masters.bidang as b", "b.id", '=', 'p.idbidang')
                ->where("nopeg_atasan", $post['nopeg_atasan'])
                ->whereNull("approval")
                ->whereRaw("extract(year from tgl_awal) = {$this->config->tahun}")
                ->get();

            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data ijin gagal", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            if ($post['isapprove']) {
                $approvalMessage = "disetujui";
            } else {
                $approvalMessage = "ditolak";
            }

            $model = Ijin::find($post['id']);

            $pegawai = Pegawai::where('nopeg', $model->nopeg)->first();
            if (empty($pegawai)) throw new Exception("Pegawai tidak ditemukan", 1);

            if (!$model) throw new Exception("Data ijin tidak ditemukan", 1);

            if (!empty($model->approval)) throw new Exception("Anda sudah pernah melakukan aproval pada data ini!", 1);

            $model->approval = $post['isapprove'];
            $model->approval_at = date('Y-m-d H:i:s');
            $model->save();

            $deviceToken = $pegawai->token_id;
            $title = "Pemberitahuan Ijin";
            $body = "Pengajuan ijin anda sudah diproses oleh atasan, segera cek di History Ijin";
            $data = ["frg" => "SETUJUIJIN"];

            FcmService::sendNotification([
                'token' => $deviceToken,
                'title' => $title,
                'body'  => $body,
                'data'  => $data,
            ]);


            $response = [
                'message' => 'Ijin berhasil ' . $approvalMessage,
                'status' => true,
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Approval Ijin[failed]", $th->getMessage());

            $response = [
                'message' => message("Ijin gagal " . $approvalMessage, $th),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }
}
