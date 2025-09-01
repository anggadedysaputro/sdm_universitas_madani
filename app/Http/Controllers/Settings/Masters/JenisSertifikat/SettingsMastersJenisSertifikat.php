<?php

namespace App\Http\Controllers\Settings\Masters\JenisSertifikat;

use App\Http\Controllers\Controller;
use App\Models\Masters\JenisSertifikat;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersJenisSertifikat extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.jenis_sertifikat.index');
    }

    public function data()
    {
        $statusPegawai = JenisSertifikat::query();
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            JenisSertifikat::create($post);

            $this->activity("Input data jenis sertifikat [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data jenis sertifikat berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data jenis sertifikat [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data jenis sertifikat gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            JenisSertifikat::find($post['id'])->delete();

            $this->activity("Hapus data jenis sertifikat [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data jenis sertifikat berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data jenis sertifikat [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data jenis sertifikat gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['id'];
            unset($post['id']);

            JenisSertifikat::find($id)->update($post);

            $this->activity("Edit data jenis sertifikat [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data jenis sertifikat berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data jenis sertifikat [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data jenis sertifikat gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
