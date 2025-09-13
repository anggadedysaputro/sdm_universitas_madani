<?php

namespace App\Http\Controllers\Approval\Ijin;

use App\Http\Controllers\Controller;
use App\Models\Applications\Cuti;
use App\Models\Applications\Ijin;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ApprovalIjin extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('approval.ijin.index');
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
        return Ijin::from("applications.ijin as c")->select(
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
                        $exists = DB::table('applications.ijin')
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

            Ijin::whereIn('id', $data)->update([
                'approval_sdm' => ($mode == "terima")
            ]);

            DB::commit();

            return response()->json(["message" => ($mode == "terima" ? "Berhasil menyetujui ijin" : "Berhasil menolak ijin")], 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("approve ijin [failed]");
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
