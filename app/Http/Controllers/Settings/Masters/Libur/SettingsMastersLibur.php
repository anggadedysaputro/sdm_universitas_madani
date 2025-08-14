<?php

namespace App\Http\Controllers\Settings\Masters\Libur;

use App\Http\Controllers\Controller;
use App\Models\Masters\Libur;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersLibur extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.libur.index');
    }

    public function data()
    {
        $statusPegawai = Libur::select("id", "keterangan", DB::raw("TO_CHAR(tanggal, 'dd Monthyyyy') as tanggal"),);
        return DataTables::of($statusPegawai)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            Libur::create($post);

            $this->activity("Input data libur [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data libur berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data libur [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data libur gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Libur::find($post['id'])->delete();

            $this->activity("Hapus data libur [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data libur berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data libur [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data libur gagal", $th->getMessage())
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

            Libur::find($id)->update($post);

            $this->activity("Edit data libur [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data libur berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data libur [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data libur gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
