<?php

namespace App\Http\Controllers\Select2\Biaya;

use App\Http\Controllers\Controller;
use App\Models\Masters\Biaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Biaya extends Controller
{
    public function data()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;

        $query = Biaya::select("id", "urai as text", DB::raw("sum(1)over() as total"))
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
