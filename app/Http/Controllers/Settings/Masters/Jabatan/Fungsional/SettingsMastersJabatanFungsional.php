<?php

namespace App\Http\Controllers\Settings\Masters\Jabatan\Fungsional;

use App\Http\Controllers\Controller;
use App\Models\Masters\JabatanFungsional;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersJabatanFungsional extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.jabatan.fungsional.index');
    }

    public function data()
    {
        $jabatan = JabatanFungsional::query();
        return DataTables::of($jabatan)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            unset($post['id']);

            JabatanFungsional::create($post);

            $this->activity("Input data fungsional [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data fungsional berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data fungsional [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data fungsional gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            JabatanFungsional::find($post['kodejabatanfungsional'])->delete();

            $this->activity("Hapus data fungsional [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data fungsional berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data fungsional [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data fungsional gagal", $th->getMessage())
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
            JabatanFungsional::find($id)->update($post);

            $this->activity("Edit data fungsional [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data fungsional berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data fungsional [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data fungsional gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
