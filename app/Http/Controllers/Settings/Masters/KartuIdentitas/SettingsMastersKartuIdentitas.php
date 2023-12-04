<?php

namespace App\Http\Controllers\Settings\Masters\KartuIdentitas;

use App\Http\Controllers\Controller;
use App\Models\Masters\KartuIdentitas;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersKartuIdentitas extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.masters.kartu-identitas.index');
    }

    public function data()
    {
        $data = KartuIdentitas::query();
        return DataTables::of($data)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            unset($post['id']);
            KartuIdentitas::create($post);

            $this->activity("Input data kartu identitas [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data kartu identitas berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data kartu identitas [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data kartu identitas gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            KartuIdentitas::find($post['id'])->delete();

            $this->activity("Hapus data kartu identitas [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Hapus data kartu identitas berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data kartu identitas [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data kartu identitas gagal", $th->getMessage())
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

            KartuIdentitas::find($id)->update($post);

            $this->activity("Edit data kartu identitas [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data kartu identitas berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data kartu identitas [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data kartu identitas gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
