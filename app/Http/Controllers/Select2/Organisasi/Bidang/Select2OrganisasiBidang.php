<?php

namespace App\Http\Controllers\Select2\Organisasi\Bidang;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2OrganisasiBidang extends Controller
{
    public function data()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;

        $query = Bidang::select(
            DB::raw("concat(kodebidang,'.',kodedivisi,'.',kodesubdivisi,'.',kodesubsubdivisi) kode"),
            "urai as text",
            DB::raw("sum(1)over() as total")
        )
            ->where("kodedivisi", 0)
            ->where("kodebidang", '<>', 0)
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
