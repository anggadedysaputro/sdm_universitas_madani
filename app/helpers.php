<?php

use eiriksm\GitInfo\GitInfo;
use Illuminate\Support\Facades\Route;

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

if (!function_exists('defaultImgUser')) {
    function defaultImgUser()
    {

        return 'data:image/png;base64,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';
    }
}

if (!function_exists('buildMenu')) {
    function buildMenu($array, $mode = 'default')
    {
        if ($mode == 'default') {
            echo '<div class="dropend">';
            foreach ($array as $item) {

                if (!empty($item['children'])) {
                    echo '
                        <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <i class="' . $item['nama_icon'] . '"></i>&nbsp;' . $item['nama'] . '
                        </a>
                        <div class="dropdown-menu">
                    ';
                    buildMenu($item['children']);
                    echo '</div>';
                } else {
                    echo '
                        <a class="dropdown-item" href="' . route($item['link']) . '">
                            <i class="' . $item['nama_icon'] . '"></i>&nbsp;' . $item['nama'] . '
                        </a>
                    ';
                }
            }

            echo '</div>';
        }
    }
}

if (!function_exists('appVersion')) {
    function appVersion()
    {
        $info = new GitInfo();
        return $info->getApplicationVersionString();
    }
}
