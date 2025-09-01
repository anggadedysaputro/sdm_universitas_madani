<?php

namespace App\Http\Controllers\Settings\Masters\Kantor;

use App\Http\Controllers\Controller;
use App\Models\Masters\Kantor;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersKantor extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.kantor.index');
    }

    public function data()
    {
        $query = Kantor::from("masters.kantor as k")->select("k.latlong", "k.approval", "k.nama", "k.id", "u.name")->join("users as u", "u.id", "=", "k.idusers");
        return DataTables::of($query)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $post['idusers'] = session('id');
            unset($post['id']);
            Kantor::create($post);

            $this->activity("Input data kantor [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data kantor berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data kantor [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data kantor gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Kantor::find($post['id'])->delete();

            $this->activity("Hapus data kantor [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data kantor berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data kantor [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data kantor gagal", $th)
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

            Kantor::find($id)->update($post);

            $this->activity("Edit data kantor [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data kantor berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data kantor [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data kantor gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function setujui()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            $update = ['approval' => 'Y'];
            $id = $post['id'];
            unset($post['id']);

            Kantor::find($id)->update($update);

            $this->activity("Setujui data kantor [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Setujui data kantor berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Setujui data kantor [failed]", $th->getMessage());

            $response = [
                'message' => message("Setujui data kantor gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function tolak()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            $update = ['approval' => 'T'];
            $id = $post['id'];
            unset($post['id']);

            Kantor::find($id)->update($update);

            $this->activity("Tolak data kantor [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Tolak data kantor berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Tolak data kantor [failed]", $th->getMessage());

            $response = [
                'message' => message("Tolak data kantor gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
