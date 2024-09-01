<?php

namespace App\Http\Controllers\Select2\Organisasi\SubSubDivisi;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2OrganisasiSubSubDivisi extends Controller
{
    protected $organisasi;

    public function __construct()
    {
        $this->organisasi = [
            'kodebidang',
            'kodedivisi',
            'kodesubdivisi',
            'kodesubsubdivisi'
        ];
    }

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
            ->where("kodesubsubdivisi", '<>', 0)
            ->take($resultCount)->skip($offset);

        if (!empty(request("wherevalue"))) {
            $kode = explode(".", request("wherevalue"));
            for ($i = 0; $i < count($kode); $i++) {
                if ($kode[$i] != 0) $query->where($this->organisasi[$i], $kode[$i]);
            }
        } else {
            $kode = [0, 0, 0, 0];
            for ($i = 0; $i < count($kode); $i++) {
                $query->where($this->organisasi[$i], $kode[$i]);
            }
        };

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
