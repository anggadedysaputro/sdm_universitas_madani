<?php

namespace App\Http\Controllers\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\Cuti as ApplicationsCuti;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Cuti extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $sisacuti = session('konfigumum')['defcuti'] - ApplicationsCuti::where('nopeg', session('nopeg'))->sum("jumlah");

        return view('cuti.index', compact('sisacuti'));
    }

    public function data()
    {
        $query = ApplicationsCuti::select(
            "id",
            "nopeg",
            DB::raw("TO_CHAR(tgl_awal, 'dd Monthyyyy') as tgl_awal"),
            DB::raw("TO_CHAR(tgl_akhir, 'dd Monthyyyy') as tgl_akhir"),
            "jumlah",
            "sisa",
            "keterangan"
        )->where("nopeg", session('nopeg'))->orderBy("tgl_awal", "desc");
        return DataTables::of($query)->toJson();
    }


    public function store()
    {
        DB::beginTransaction();
        try {

            $post = request()->all();
            $sisacuti = session('konfigumum')['defcuti'] - ApplicationsCuti::where('nopeg', session('nopeg'))->sum("jumlah");
            $post['sisa'] = $sisacuti - $post['jumlah'];
            $post['nopeg'] = session('nopeg');

            if ($post['jumlah'] > $sisacuti) throw new Exception("Jumlah cuti melebihi sisa cuti!, maksimal : " . $sisacuti, 1);

            ApplicationsCuti::create($post);

            $this->activity("Input cuti karyawan [successfully]");


            DB::commit();

            $response = [
                'message' => 'Input cuti karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input cuti karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Input cuti karyawan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {

            $post = request()->all();

            ApplicationsCuti::find($post['id'])->delete();

            DB::commit();

            $response = [
                'message' => 'Hapus cuti karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus cuti karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus cuti karyawan gagal", $th)
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
            $sisacuti = session('konfigumum')['defcuti'] - ApplicationsCuti::where('nopeg', session('nopeg'))->sum("jumlah");
            $post['sisa'] = $sisacuti - $post['jumlah'];
            $post['nopeg'] = session('nopeg');

            if ($post['jumlah'] > $sisacuti) throw new Exception("Jumlah cuti melebihi sisa cuti!, maksimal : " . $sisacuti, 1);

            ApplicationsCuti::find($id)->update($post);

            $this->activity("Update cuti karyawan [successfully]");


            DB::commit();

            $response = [
                'message' => 'Update cuti karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Update cuti karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Update cuti karyawan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
