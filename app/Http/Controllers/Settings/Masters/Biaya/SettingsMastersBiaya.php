<?php

namespace App\Http\Controllers\Settings\Masters\Biaya;

use App\Http\Controllers\Controller;
use App\Models\Masters\Biaya;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersBiaya extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.biaya.index');
    }

    public function data()
    {
        $statusPegawai = Biaya::query();
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            Biaya::create($post);

            $this->activity("Input data biaya [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data biaya berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data biaya [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data biaya gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Biaya::find($post['id'])->delete();

            $this->activity("Hapus data biaya [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data biaya berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data biaya [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data biaya gagal", $th->getMessage())
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

            Biaya::find($id)->update($post);

            $this->activity("Edit data biaya [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data biaya berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data biaya [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data biaya gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
