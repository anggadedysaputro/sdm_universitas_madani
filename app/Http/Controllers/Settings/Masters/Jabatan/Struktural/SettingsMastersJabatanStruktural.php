<?php

namespace App\Http\Controllers\Settings\Masters\Jabatan\Struktural;

use App\Http\Controllers\Controller;
use App\Models\Masters\JabatanStruktural;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersJabatanStruktural extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.jabatan.struktural.index');
    }

    public function data()
    {
        $jabatan = JabatanStruktural::query();
        return DataTables::of($jabatan)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            unset($post['id']);

            JabatanStruktural::create($post);

            $this->activity("Input data struktural [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data struktural berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data struktural [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data struktural gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            JabatanStruktural::find($post['kodejabatanstruktural'])->delete();

            $this->activity("Hapus data struktural [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data struktural berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data struktural [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data struktural gagal", $th->getMessage())
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
            JabatanStruktural::find($id)->update($post);

            $this->activity("Edit data struktural [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data struktural berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data struktural [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data struktural gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
