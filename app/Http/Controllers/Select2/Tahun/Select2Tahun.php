<?php

namespace App\Http\Controllers\Select2\Tahun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Tahun extends Controller
{
    public function data()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;

        $query = DB::table(
            DB::raw("
                (
                    select tahun as id,
                        tahun::text as text,
                        count(1) over() as total
                    from generate_series(0, EXTRACT(YEAR from now())) as x(tahun)
                    where tahun >= 1900 or tahun = 0
                    order by text desc
                ) as x
            ")
        )
            ->take($resultCount)->skip($offset);

        $sql = "text ilike ?";
        if (request('search')) $query->whereRaw($sql, ["%" . request('search') . "%"]);

        $result = $query->get();

        $total = 0;
        if (count($result) > 0) $total = $result[0]->total;


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
