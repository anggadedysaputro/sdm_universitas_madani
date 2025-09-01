<?php

namespace App\Http\Controllers\Settings\Masters\Pekerjaan;

use App\Http\Controllers\Controller;
use App\Models\Masters\Pekerjaan;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersPekerjaan extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.pekerjaan.index');
    }

    public function data()
    {
        $statusPegawai = Pekerjaan::query();
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            Pekerjaan::create($post);

            $this->activity("Input data pekerjaan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data pekerjaan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data pekerjaan [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data pekerjaan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Pekerjaan::find($post['id'])->delete();

            $this->activity("Hapus data pekerjaan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data pekerjaan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data pekerjaan [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data pekerjaan gagal", $th)
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

            Pekerjaan::find($id)->update($post);

            $this->activity("Edit data pekerjaan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data pekerjaan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data pekerjaan [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data pekerjaan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
