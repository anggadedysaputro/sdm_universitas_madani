<?php

namespace App\Http\Controllers\Settings\KonfigUmum;

use App\Http\Controllers\Controller;
use App\Models\Applications\KonfigUmum;
use App\Models\Applications\KonfigUmumKantor;
use App\Models\Masters\Kantor;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsKonfigUmum extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.konfig_umum.index');
    }

    public function data()
    {
        $statusIjin = KonfigUmum::from("applications.konfigumum as ku")->select(
            "idkonfigumum",
            "masuk",
            "pulang",
            "masukpuasa",
            "pulangpuasa",
            DB::raw("TO_CHAR(tanggalawalpuasa, 'dd Monthyyyy') as tanggalawalpuasa"),
            DB::raw("TO_CHAR(tanggalakhirpuasa, 'dd Monthyyyy') as tanggalakhirpuasa"),
            "defcuti",
            "created_at",
            "updated_at",
            "harilibur",
            "radius",
            DB::raw("(select json_agg(json_build_object('id',k.id, 'nama', k.nama)) from applications.konfigumum_kantor kk join masters.kantor k on k.id = kk.idkantor where idkonfigumum = ku.idkonfigumum and k.approval = 'Y') as latlong")
        );
        return DataTables::of($statusIjin)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $idkonfig = KonfigUmum::create($post);

            $this->activity("Input data konfig umum [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data konfig umum berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data konfig umum [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data konfig umum gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            KonfigUmum::find($post['idkonfigumum'])->delete();

            $this->activity("Hapus data konfig umum [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data konfig umum berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data konfig umum [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data konfig umum gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['idkonfigumum'];
            unset($post['idkonfigumum']);
            KonfigUmum::find($id)->update($post);

            $this->activity("Edit data konfig umum [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data konfig umum berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data konfig umum [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data konfig umum gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
