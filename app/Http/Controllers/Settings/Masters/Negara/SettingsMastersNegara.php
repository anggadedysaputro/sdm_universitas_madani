<?php

namespace App\Http\Controllers\Settings\Masters\Negara;

use App\Http\Controllers\Controller;
use App\Models\Masters\Negara;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersNegara extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.negara.index');
    }

    public function data()
    {
        $statusnegara = Negara::query();
        return DataTables::of($statusnegara)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            Negara::create($post);

            $this->activity("Input data negara [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data negara berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data negara [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data negara gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            Negara::find($post['id'])->delete();

            $this->activity("Hapus data negara [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data negara berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data negara [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data negara gagal", $th->getMessage())
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

            Negara::find($id)->update($post);

            $this->activity("Edit data negara [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data negara berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data negara [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data negara gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
