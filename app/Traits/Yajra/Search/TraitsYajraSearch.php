<?php

namespace App\Traits\Yajra\Search;

trait TraitsYajraSearch
{
    /**
     * @param mixed $model masukkan model querynya
     * @param array $request masukkan request pencariannya bisa global serach atau column filter based
     * @param array $rules masukkan rules
     * ['mappingcolumn'=>[],'datecolumn'=>[],'numbercolumn'=>[]]
     */
    public function searchYajra($dataTables, $request, $rules = [])
    {
        if (!isset($request['search']['value'])) {
        } else {
            foreach ($request['columns'] as $key => $value) {
                $dataTables->filterColumn($value['data'], function ($query, $keyword) use ($value, $rules) {
                    $keyword = strtolower($keyword);
                    $kolom = isset($rules['mappingcolumn'][$value['data']]) ? $rules['mappingcolumn'][$value['data']] : $value['data'];
                    $ambilNamaTanpaAlias = explode(".", $kolom); // format ke normal tanpa alias dulu agar in arraynya bekerja
                    $kolomNormal = end($ambilNamaTanpaAlias); // ambil value terakhir setelah diexplode karena itu adalah nama asli kolomnya;
                    $sql = $kolom . " ilike ?";
                    if (in_array($kolomNormal, $rules['datecolumn'])) $sql = "convertnumericdatetoalphabetical(" . $kolom . "::date) ilike ?";
                    if (in_array($kolomNormal, $rules['numbercolumn'])) $sql = $kolom . "::text ilike ?";

                    if (isset($rules['renormalvalue'][$kolomNormal])) {
                        foreach ($rules['renormalvalue'] as $keyNormal => $valueNormal) {
                            $keys = array_keys(array_change_key_case($valueNormal, CASE_LOWER));
                            $text = array_filter($keys, function ($item) use ($keyword) {
                                return str_contains($item, $keyword);
                            });

                            foreach ($text as $keyText => $valueText) {
                                $sql = $kolom . "::text ilike ?";
                                $keyword = array_change_key_case($valueNormal, CASE_LOWER)[$valueText];
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            }
                        }
                    } else {
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    }
                });
            }
            // $this->debugYajra($dataTables);
        }

        return $dataTables;
    }

    private function debugYajra($dataTables)
    {        // for debug query
        $dataTables->withQuery('count', function ($filteredQuery) {
            dd(getSql($filteredQuery));
            return true;
        });
    }
}
