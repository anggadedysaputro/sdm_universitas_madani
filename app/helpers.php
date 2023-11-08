<?php
if (!function_exists('message')) {
    function message($notifikasi = "", $sistemNotifikasi = "")
    {
        return (env('APP_DEBUG') == false && env('APP_ENV') == 'production' ? $notifikasi : $sistemNotifikasi);
    }
}

if (!function_exists('dojo')) {
    function dojo()
    {
        dd("dojo");
    }
}

if (!function_exists('getSql')) {
    function getSql($model)
    {
        $replace = function ($sql, $bindings) {
            $needle = '?';
            foreach ($bindings as $replace) {
                $pos = strpos($sql, $needle);
                if (false !== $pos) {
                    if ('string' === gettype($replace)) {
                        $replace = ' "' . addslashes($replace) . '" ';
                    }
                    $sql = substr_replace($sql, $replace, $pos, strlen($needle));
                }
            }

            return $sql;
        };
        $sql = $replace($model->toSql(), $model->getBindings());

        return $sql;
    }
}

if (!function_exists('convertAlphabeticalToNumberDate')) {
    function convertAlphabeticalToNumberDate($stringDate)
    {
        if (null != $stringDate) {
            $number = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            $stringDate = explode(' ', $stringDate);
            switch ($stringDate[1]) {
                case 'Januari':
                    $str = $stringDate[2] . '-' . $number[0] . '-' . $stringDate[0];
                    break;
                case 'Februari':
                    $str = $stringDate[2] . '-' . $number[1] . '-' . $stringDate[0];
                    break;
                case 'Maret':
                    $str = $stringDate[2] . '-' . $number[2] . '-' . $stringDate[0];
                    break;
                case 'April':
                    $str = $stringDate[2] . '-' . $number[3] . '-' . $stringDate[0];
                    break;
                case 'Mei':
                    $str = $stringDate[2] . '-' . $number[4] . '-' . $stringDate[0];
                    break;
                case 'Juni':
                    $str = $stringDate[2] . '-' . $number[5] . '-' . $stringDate[0];
                    break;
                case 'Juli':
                    $str = $stringDate[2] . '-' . $number[6] . '-' . $stringDate[0];
                    break;
                case 'Agustus':
                    $str = $stringDate[2] . '-' . $number[7] . '-' . $stringDate[0];
                    break;
                case 'September':
                    $str = $stringDate[2] . '-' . $number[8] . '-' . $stringDate[0];
                    break;
                case 'Oktober':
                    $str = $stringDate[2] . '-' . $number[9] . '-' . $stringDate[0];
                    break;
                case 'November':
                    $str = $stringDate[2] . '-' . $number[10] . '-' . $stringDate[0];
                    break;
                case 'Desember':
                    $str = $stringDate[2] . '-' . $number[11] . '-' . $stringDate[0];
                    break;
                default:
                    $str = $stringDate[2] . '- not valid -' . $stringDate[0];
                    break;
            }

            return $str;
        } else {
            return $stringDate;
        }
    }
}

if (!function_exists('monthPeriodBefore')) {
    function monthPeriodBefore($monthperiode)
    {
        $date = DateTime::createFromFormat('mY', $monthperiode);
        date_sub($date, date_interval_create_from_date_string("1 month"));
        return date_format($date, "mY");
    }
}

if (!function_exists('normalNumeric')) {
    function normalNumeric($number)
    {
        $string = $number ?? 0;
        $pattern = '/\./';
        $replacement = '';

        return (float)preg_replace($pattern, $replacement, $string);
    }
}

if (!function_exists('nomorInvoice')) {
    function nomorInvoice($flag, $number)
    {
        return $flag . "-" . str_pad($number, 10, "0", STR_PAD_LEFT);
    }
}

if (!function_exists('tahunAjaran')) {
    function tahunAjaran()
    {
        $bulan = (int)date("m");
        $year = (int)date("Y");

        $tahunAjaran = "";
        if ($bulan >= 7 && $bulan <= 12) {
            $startYear = $year;
            $endYear = $year + 1;
        } else {
            $startYear = $year - 1;
            $endYear = $year;
        }

        $tahunAjaran = $startYear . "/" . $endYear;

        return $tahunAjaran;
    }
}

if (!function_exists('tahunAjaranAktif')) {
    function tahunAjaranAktif()
    {
        return session('tahunaktif');
    }
}

if (!function_exists('getChildRecursive')) {
    function getChildRecursive(array $elements, $parentId = 0, $elementID = 'id')
    {
        $branch = [];

        if (1 == count($elements)) {
            $branch[] = (array) $elements[0];
        } else {
            foreach ($elements as $element) {
                $element = (array) $element;

                if ($element['parents'] == $parentId) {
                    $children = getChildRecursive($elements, $element[$elementID]);
                    if ($children) {
                        $element['children'] = $children;
                    }

                    $branch[] = $element;
                }
            }
        }

        return $branch;
    }
}
