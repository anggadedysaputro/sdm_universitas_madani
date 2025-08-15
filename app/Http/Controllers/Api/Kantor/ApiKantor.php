<?php

namespace App\Http\Controllers\Api\Kantor;

use App\Http\Controllers\Controller;
use App\Models\Masters\Kantor;
use App\Models\User;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKantor extends Controller
{
    use TraitsLoggerActivity;

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('idusers');
            $nama = $request->input('nama');
            $latlong = $request->input('latlong');

            $user = User::find($id);

            if (!$user) throw new Exception("Pengguna tidak valid!", 1);
            if (empty($nama)) throw new Exception("Nama kantor wajib diisi!", 1);
            if (empty($latlong)) throw new Exception("Lokasi wajib diisi!", 1);

            $kantor = [
                'idusers' => $id,
                'nama' => $nama,
                'latlong' => $latlong
            ];

            $created = Kantor::create($kantor);

            $response = [
                'message' => 'Kantor berhasil diajukan',
                'status' => true,
                'data' => $created
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Kantor [failed]", $th->getMessage());

            $response = [
                'message' => $th->getCode() == 1 ? $th->getMessage() : message("Kantor gagal diajukan", $th->getMessage()),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }
}
