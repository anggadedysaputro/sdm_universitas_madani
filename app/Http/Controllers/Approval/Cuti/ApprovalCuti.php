<?php

namespace App\Http\Controllers\Approval\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\Cuti;
use App\Services\FcmService;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ApprovalCuti extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('approval.cuti.index');
    }

    public function data()
    {
        $query = $this->query();

        return DataTables::of($query)->make(true);
    }

    public function list()
    {
        $query = $this->query();

        return response()->json($query->get(), 200);
    }

    protected function query()
    {
        return Cuti::from("applications.cuti as c")->select(
            "c.id",
            "p.nopeg",
            "c.jumlah",
            "c.keterangan",
            "c.lampiran",
            "p.nama",
            "pa.nama as nama_atasan",
            "c.tgl_awal",
            "c.tgl_akhir"
        )
            ->join("applications.pegawai as p", "p.nopeg", "=", "c.nopeg")
            ->join("applications.pegawai as pa", "pa.nopeg", "=", "c.nopeg_atasan")
            ->where('approval', true)
            ->whereNull('approval_sdm')
            ->orderBy('c.id', 'desc');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'mode' => 'required',
                'data' => 'required|array',
                'data.*' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) {
                        // pakai query builder dengan schema
                        $exists = DB::table('applications.cuti')
                            ->where('id', $value)
                            ->exists();

                        if (! $exists) {
                            $fail("{$attribute} dengan id {$value} tidak ditemukan di schema applications.");
                        }
                    },
                ],
            ]);

            $data = $request->input('data');
            $mode = $request->input('mode');

            Cuti::whereIn('id', $data)->update([
                'approval_sdm' => ($mode == "terima"),
                'approval_sdm_at' => date('Y-m-d H:i:s')
            ]);

            $tokens = Cuti::from("applications.cuti as c")
                ->select("p.token_id")
                ->join("applications.pegawai as p", "p.nopeg", "=", "c.nopeg")
                ->whereIn('id', $data)->get();

            $title = "Pemberitahuan Cuti";
            $body = "Pengajuan persetujuan cuti di " . ($mode == "terima" ? "disetujui" : "ditolak");
            $data = ["frg" => "SETUJUCUTI"];

            foreach ($tokens as $value) {
                $deviceToken = $value->token_id;
                FcmService::sendNotification([
                    'token' => $deviceToken,
                    'title' => $title,
                    'body'  => $body,
                    'data'  => $data,
                ]);
            }

            DB::commit();

            return response()->json(["message" => ($mode == "terima" ? "Berhasil menyetujui cuti" : "Berhasil menolak cuti")], 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("approve cuti [failed]");
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
