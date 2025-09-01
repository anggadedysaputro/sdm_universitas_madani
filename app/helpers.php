<?php

use App\Models\Applications\KonfigUmum;
use eiriksm\GitInfo\GitInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

if (!function_exists('message')) {
    function message($pesan, $th = 0)
    {
        if ($th->getCode() == 1) {
            return $th->getMessage();
        } else {
            return $pesan;
        }
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

if (!function_exists('tahunAplikasi')) {
    function tahunAplikasi()
    {
        $query = KonfigUmum::from("applications.konfigumum as ku")
            ->select("ku.*", "capp.tahun", "capp.urai", "capp.idkonfig")
            ->join("applications.configapp as capp", "capp.idkonfig", "=", "ku.idkonfigumum")
            ->where("capp.aktif", true);

        $result = $query->first();

        if (empty($result)) throw new Exception("Tidak ada konfigurasi yang aktif", 1);

        return $result;
    }
}

if (!function_exists('tahunAktif')) {
    function tahunAktif()
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

if (!function_exists('avatar')) {
    function avatar()
    {
        return 'data:image/png;base64,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';
    }
}

if (!function_exists('convertGeneralDate')) {
    function convertGeneralDate($date)
    {
        if ($date == '') {
            return null;
        } else {
            $month = [
                'january',
                'february',
                'march',
                'april',
                'may',
                'june',
                'july',
                'august',
                'september',
                'october',
                'november',
                'december',
            ];

            $exp = explode(" ", $date);
            $tanggal = $exp[0];
            $bulan = $exp[1];

            $bulan = str_pad(array_keys($month, strtolower($bulan))[0] + 1, 2, "0", STR_PAD_LEFT);
            $tahun = $exp[2];

            return $tahun . "-" . $bulan . "-" . $tanggal;
        }
    }
}

if (!function_exists('buatFolder')) {
    function buatFolder($folder)
    {
        // $mkdir = storage_path('app/public/') . $this->folder;

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true);
        }
    }
}

if (!function_exists('numericFormatToNormalFormat')) {
    function numericFormatToNormalFormat($value)
    {
        // Hapus prefix "Rp" dan spasi
        $cleanedValue = preg_replace('/^Rp\.?\s*/', '', $value);
        // Ganti separator ribuan (.) dengan string kosong
        $withoutThousandSeparator = str_replace('.', '', $cleanedValue);
        // Ganti separator desimal (,) dengan titik (.)
        $numberValue = str_replace(',', '.', $withoutThousandSeparator);

        // Konversi string menjadi angka float
        return (float) $numberValue;
    }
}

if (!function_exists('listTahun')) {
    function listTahun()
    {
        $tahunSekarang = (int)date("Y");
        $tahunAwal = $tahunSekarang - 100;

        $listTahun = [0]; // Tahun 0 di awal

        for ($tahun = $tahunSekarang; $tahun >= $tahunAwal; $tahun--) {
            $listTahun[] = $tahun;
        }

        return $listTahun;
    }
}

// if (!function_exists('makeUploadedFileFromUrl')) {
//     function makeUploadedFileFromUrl($url, $filename = 'temp.jpg')
//     {
//         $tempPath = tempnam(sys_get_temp_dir(), 'upload_');
//         $response = Http::get($url);

//         if ($response->successful()) {
//             file_put_contents($tempPath, $response->body());

//             return new UploadedFile(
//                 $tempPath,
//                 $filename,
//                 $response->header('Content-Type'),
//                 null,
//                 true // $testMode = true → agar tidak dicek sebagai upload HTTP sesungguhnya
//             );
//         }

//         return null;
//     }
// }


if (!function_exists('makeUploadedFileFromUrl')) {
    function makeUploadedFileFromUrl(string $driveUrl): ?string
    {
        // Ekstrak file ID dari URL
        if (!preg_match('#/d/([a-zA-Z0-9_-]+)#', $driveUrl, $matches)) {
            return null; // URL tidak valid
        }

        $fileId = $matches[1];
        $url = "https://drive.google.com/uc?export=download&id={$fileId}";

        $response = Http::get($url);

        if (
            $response->successful() &&
            !str_contains($response->header('Content-Type'), 'text/html')
        ) {
            return $response->body(); // ✅ Kembalikan isi file
        }

        return null; // Gagal ambil file
    }
}

if (!function_exists('hubungan')) {
    function hubungan()
    {
        return [
            'Suami' => 'Suami',
            'Istri' => 'Istri',
            'Anak' => 'Anak',
            'Ayah' => 'Ayah',
            'Ibu' => 'Ibu',
            'Adik' => 'Adik',
            'Kakak' => 'Kakak',
            'Keluarga Dekat' => 'Keluarga Dekat',
            'Saudara' => 'Saudara',
        ];
    }
}

if (!function_exists('jasperConnection')) {
    function jasperConnection()
    {
        $mapDriver = [
            'pgsql' => 'postgres',
            'mysql' => 'mysql'
        ];

        $connection = [
            'driver' => $mapDriver[env('DB_CONNECTION')],
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ];

        return $connection;
    }
}
