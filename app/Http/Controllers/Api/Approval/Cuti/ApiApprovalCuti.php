<?php

namespace App\Http\Controllers\Api\Approval\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\Cuti;
use App\Models\Applications\Pegawai;
use App\Services\CutiService;
use App\Services\FcmService;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiApprovalCuti extends Controller
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
            $data = Cuti::from("applications.cuti as c")->select(
                [
                    "c.id",
                    "js.urai as nama_jabatan_struktural",
                    "jf.urai as nama_jabatan_fungsional",
                    "c.nopeg",
                    "c.keterangan",
                    "c.jumlah",
                    "c.sisa",
                    "c.approval",
                    "c.approval_sdm",
                    "c.nopeg_atasan",
                    "c.lampiran",
                    "c.approval_at",
                    "c.approval_sdm_at",
                    "p.nama",
                    DB::raw("coalesce(b.urai,'#NA') as nama_bidang"),
                    DB::raw("case when approval = true then 'Disetujui' when approval = false then 'Ditolak' else 'Diajukan' end approval_status"),
                    DB::raw("
                        json_agg(
                            json_build_object(
                                'tanggal', cd.tanggal
                            )
                            order by cd.tanggal
                        ) as list_tanggal
                    "),
                    "c.created_at"
                ]
            )
                ->join('applications.cuti_detail as cd', 'c.id', '=', 'cd.idcuti')
                ->where("nopeg_atasan", $post['nopeg_atasan'])
                ->join("applications.pegawai as p", "p.nopeg", '=', "c.nopeg")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", '=', 'p.kodestruktural')
                ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", '=', 'p.kodejabfung')
                ->leftJoin("masters.bidang as b", "b.id", '=', 'p.idbidang')
                ->whereRaw("extract(year from cd.tanggal) = {$this->config->tahun}")
                ->whereNull("approval")
                ->groupBy(
                    "c.id",
                    "js.urai",
                    "jf.urai",
                    "p.nama",
                    "c.nopeg",
                    "c.keterangan",
                    "c.jumlah",
                    "c.sisa",
                    "c.approval",
                    "c.approval_sdm",
                    "c.nopeg_atasan",
                    "c.lampiran",
                    "c.approval_at",
                    "c.approval_sdm_at",
                    "b.urai",
                    "c.created_at"
                )
                ->get();

            $data = $data->map(function ($item) {
                $item->list_tanggal = json_decode($item->list_tanggal);
                return $item;
            });

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

            $model = Cuti::find($post['id']);

            $pegawai = Pegawai::where('nopeg', $model->nopeg)->first();
            if (empty($pegawai)) throw new Exception("Pegawai tidak ditemukan", 1);

            if (!$model) throw new Exception("Data cuti tidak ditemukan", 1);

            if (is_bool($model->approval)) throw new Exception("Anda sudah pernah melakukan aproval pada data ini!", 1);

            $model->approval = $post['isapprove'];
            $model->approval_at = date('Y-m-d H:i:s');
            $model->save();

            $deviceToken = $pegawai->token_id;
            $title = "Pemberitahuan Cuti";
            $body = "Pengajuan cuti anda sudah diproses oleh atasan, segera cek di History Cuti";
            $data = ["frg" => "SETUJUCUTI"];

            FcmService::sendNotification([
                'token' => $deviceToken,
                'title' => $title,
                'body'  => $body,
                'data'  => $data,
            ]);

            $response = [
                'message' => 'Cuti berhasil ' . $approvalMessage,
                'status' => true,
                'sisa' => CutiService::sisa($model->nopeg)
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Approval Cuti[failed]", $th->getMessage());

            $response = [
                'message' => message("Cuti gagal " . $approvalMessage, $th),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }
}
