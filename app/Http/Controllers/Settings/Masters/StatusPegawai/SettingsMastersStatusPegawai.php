<?php

namespace App\Http\Controllers\Settings\Masters\StatusPegawai;

use App\Http\Controllers\Controller;
use App\Models\Masters\StatusPegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersStatusPegawai extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.status-pegawai.index');
    }

    public function data()
    {
        $statusPegawai = StatusPegawai::query();
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            StatusPegawai::create($post);

            $this->activity("Input data status pegawai [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data status pegawai berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data status pegawai [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data status pegawai gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            StatusPegawai::find($post['idstatuspegawai'])->delete();

            $this->activity("Hapus data status pegawai [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data status pegawai berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data status pegawai [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data status pegawai gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['idstatuspegawai_lama'];

            StatusPegawai::find($id)->update($post);

            $this->activity("Edit data status pegawai [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data status pegawai berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data status pegawai [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data status pegawai gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
