<?php

namespace App\Http\Controllers\Settings\Masters\Jabatan\Struktural;

use App\Http\Controllers\Controller;
use App\Models\Masters\JabatanStruktural;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsMastersJabatanStruktural extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $jabatan = JabatanStruktural::all();
        return view('settings.masters.jabatan.struktural.index', compact('jabatan'));
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
}
