<?php

namespace App\Http\Controllers\Select2\Kantor;

use App\Http\Controllers\Controller;
use App\Models\Masters\Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Kantor extends Controller
{
    public function data()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;

        $query = Kantor::select("id", "nama as text", DB::raw("sum(1)over() as total"))
            ->where("approval", "Y")
            ->take($resultCount)->skip($offset);

        $sql = "nama ilike ?";
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
