<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CutiService
{
    public static function sisa($nopeg)
    {
        $result = DB::selectOne("
            SELECT COALESCE(
                (
                    SELECT sisa
                    FROM applications.cuti
                    WHERE nopeg = ?
                    ORDER BY id DESC
                    LIMIT 1
                ),
                COALESCE(
                    (
                        SELECT ku.defcuti
                        FROM applications.configapp AS c
                        JOIN applications.konfigumum AS ku
                            ON c.idkonfig = ku.idkonfigumum
                        WHERE aktif = TRUE
                        LIMIT 1
                    ),
                    0
                )
            ) AS sisa_cuti
        ", [$nopeg]);

        return $result->sisa_cuti ?? 0;
    }
}
