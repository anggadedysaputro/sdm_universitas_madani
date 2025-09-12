<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CutiService
{
    public static function sisa($nopeg)
    {
        $result = DB::selectOne("select * from sisa_cuti(?)", [$nopeg]);

        return $result->sisa_cuti ?? 0;
    }
}
