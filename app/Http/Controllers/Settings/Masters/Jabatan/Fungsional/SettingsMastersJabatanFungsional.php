<?php

namespace App\Http\Controllers\Settings\Masters\Jabatan\Fungsional;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bidang;
use App\Models\Masters\JabatanFungsional;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingsMastersJabatanFungsional extends Controller
{
    protected $bidangKolom;

    use TraitsLoggerActivity;

    public function __construct()
    {
        $this->bidangKolom = [
            'kodebidang',
            'kodedivisi',
            'kodesubdivisi',
            'kodesubsubdivisi'
        ];
    }

    public function index()
    {
        return view('settings.masters.jabatan.fungsional.index');
    }

    public function data()
    {
        $jabatan = DB::table(
            DB::raw("
                (
                    select kodejabatanfungsional, js.urai --, concat(b.kodebidang, '.', b.kodedivisi, '.', b.kodesubdivisi, '.', b.kodesubsubdivisi) as id
                    from masters.jabatanfungsional js
                    -- join masters.bidang b
                    -- on js.id_bidang = b.id
                ) as w
            ")
        );
        return DataTables::of($jabatan)->toJson();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            unset($post['id']);

            // $query = Bidang::query();
            // foreach (explode(".", $post['id_bidang']) as $key => $value) {
            //     $query->where($this->bidangKolom[$key], $value);
            // }

            // $id_bidang = $query->first()->id;
            // $post['id_bidang'] = $id_bidang;

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
                'message' => message("Input data fungsional gagal", $th)
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
                'message' => message("Hapus data fungsional gagal", $th)
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

            // $query = Bidang::query();
            // foreach (explode(".", $post['id_bidang']) as $key => $value) {
            //     $query->where($this->bidangKolom[$key], $value);
            // }

            // $id_bidang = $query->first()->id;
            // $post['id_bidang'] = $id_bidang;

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
                'message' => message("Edit data fungsional gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }
}
