<?php

namespace App\Http\Controllers\Settings\ConfigApp;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsConfigApp extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.config_app.index');
    }

    public function data()
    {
        $data = ConfigApp::from("applications.configapp as ca")->select(
            "ca.id",
            "ca.idkonfig",
            "ca.tahun",
            "ca.urai",
            "ca.aktif"
        );
        return DataTables::of($data)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $post['aktif'] = isset($post['aktif']) ? true : false;
            ConfigApp::from("applications.configapp")->update(['aktif' => 'false']);

            ConfigApp::create($post);

            $this->activity("Input data konfig aplikasi [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data konfig aplikasi berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data konfig aplikasi [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data konfig aplikasi gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            ConfigApp::find($post['id'])->delete();

            $this->activity("Hapus data konfig aplikasi [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data konfig aplikasi berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data konfig aplikasi [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data konfig aplikasi gagal", $th)
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
            $post['aktif'] = isset($post['aktif']) ? true : false;
            ConfigApp::find($id)->update($post);

            $this->activity("Edit data konfig aplikasi [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data konfig aplikasi berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data konfig aplikasi [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data konfig aplikasi gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
