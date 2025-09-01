<?php

namespace App\Http\Controllers\Settings\Masters\Pendidikan;

use App\Http\Controllers\Controller;
use App\Models\Masters\Pendidikan;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersPendidikan extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.pendidikan.index');
    }

    public function data()
    {
        $statusPegawai = Pendidikan::query();
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Pendidikan::create($post);

            $this->activity("Input data pendidikan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data pendidikan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data pendidikan [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data pendidikan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Pendidikan::find($post['kodependidikan'])->delete();

            $this->activity("Hapus data pendidikan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data pendidikan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data pendidikan [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data pendidikan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['kodependidikan_lama'];

            Pendidikan::find($id)->update($post);

            $this->activity("Edit data pendidikan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data pendidikan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data pendidikan [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data pendidikan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
