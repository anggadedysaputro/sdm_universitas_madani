<?php

namespace App\Http\Controllers\Settings\Masters\StatusIjin;

use App\Http\Controllers\Controller;
use App\Models\Masters\StatusIjin;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersStatusIjin extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.status-ijin.index');
    }

    public function data()
    {
        $statusIjin = StatusIjin::query();
        return DataTables::of($statusIjin)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            StatusIjin::create($post);

            $this->activity("Input data status ijin [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data status ijin berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data status ijin [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data status ijin gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            StatusIjin::find($post['idstatusijin'])->delete();

            $this->activity("Hapus data status ijin [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data status ijin berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data status ijin [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data status ijin gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['idstatusijin_lama'];

            StatusIjin::find($id)->update($post);

            $this->activity("Edit data status ijin [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data status ijin berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data status ijin [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data status ijin gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
