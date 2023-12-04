<?php

namespace App\Http\Controllers\Select2\Jabatan\Struktural;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bidang;
use App\Models\Masters\JabatanStruktural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2JabatanStruktural extends Controller
{
    public function data()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;
        if (empty(request('organisasi'))) {
            $idbidang = (object) array('id' => '0');
        } else {
            $org = explode(".", request('organisasi'));
            $idbidang = Bidang::where('kodebidang', $org[0])
                ->where('kodedivisi', $org[1])
                ->where('kodesubdivisi', $org[2])
                ->where('kodesubsubdivisi', $org[3])
                ->select("id")
                ->first() ??  (object) array('id' => '0');
        }

        $query = JabatanStruktural::select("kodejabatanstruktural as id", "urai as text", DB::raw("sum(1)over() as total"))
            ->where('id_bidang', $idbidang->id)
            ->take($resultCount)->skip($offset);

        $sql = "urai ilike ?";
        if (request('search')) $query->whereRaw($sql, ["%" . request('search') . "%"]);

        $result = $query->get()->toArray();

        $total = 0;
        if (count($result) > 0) $total = $result[0]['total'];


        $morePages = !($resultCount >= $total);

        $response = array(
            "results" => $result,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($response, 200);
    }
}
