<?php

namespace App\Http\Controllers\Api\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Applications\Presensi;
use App\Traits\Logger\TraitsLoggerActivity;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPJasper\PHPJasper;

class ApiPresensi extends Controller
{
    use TraitsLoggerActivity;
    protected $path;
    protected $config;

    public function __construct()
    {
        $this->path = 'public/presensi';
        $this->config = tahunAplikasi();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $post['isreguler'] = filter_var($post['isreguler'], FILTER_VALIDATE_BOOLEAN);;

            if (!$post['isreguler']) unset($post['idkantor']);

            if (!isset($post['foto'])) throw new Exception("Foto belum dimasukkan!", 1);

            $now = new DateTime();
            $current = $now->format('Y-m-d H:i:s');

            $date = explode(" ", $current);
            $post['waktu'] = $date[1];
            $post['tanggal'] = $date[0];
            $post['tahun'] = $now->format("Y");
            $post['bulan'] = $now->format("m");
            $post['hari'] = $now->format("d");
            $post['jam'] = $now->format("H");
            $post['menit'] = $now->format("i");

            buatFolder(storage_path('app/' . $this->path));
            $name = $post['foto']->getClientOriginalName();

            $path = Storage::putFileAs($this->path, $post['foto'], $name);

            $post['fullpath'] = $path;
            $post['gambar'] = $name;

            Presensi::create($post);

            DB::commit();

            $response = [
                'message' => 'Presensi berhasil',
                'status' => true,
                'data' => $post
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Presensi [failed]", $th->getMessage());

            $response = [
                'message' => message("Presensi gagal", $th->getMessage()),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }

    public function data()
    {
        try {
            $post = request()->all();
            $data = DB::select(
                'select * from data_presensi(?,?,?) where retambil = ?',
                [$post['tglawal'], $post['tglakhir'], $post['nopeg'], 1]
            );
            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data presensi gagal", $th->getMessage()),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function detail()
    {
        try {
            $post = request()->all();

            $queryPresensi = Presensi::select(
                "lokasi",
                "gambar",
                "waktu",
                "tanggal",
                "isreguler"
            )->where('nopeg', $post['nopeg'])
                ->where('tanggal', $post['tanggal']);

            if (strtolower($post['jenis']) == 'masuk') {
                $queryPresensi->orderByRaw("tanggal+waktu asc");
            } else {
                $queryPresensi->orderByRaw("tanggal+waktu desc");
            }

            if ($queryPresensi->exists()) {
                $data = $queryPresensi->first()->toArray();
            } else {
                $data = [];
            }

            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil detail presensi gagal", $th->getMessage()),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function laporan()
    {
        try {
            $post = request()->all();
            $idpeg = $post['idpeg'];
            $tglawal = $post['tglawal'];
            $tglakhir = $post['tglakhir'];
            $type = "pdf";

            $input = public_path('report/slip_gaji.jasper');
            $filename = uniqid("slip_gaji", TRUE);
            $fileForSave = "Laporan Presensi";
            $output = storage_path('app/jasper/' . $filename);
            $outputFile = storage_path('app/jasper/' . $filename . "." . $type);

            buatFolder(storage_path('app/jasper'));

            $options = [
                'format' => [$type],
                'locale' => 'id',
                'params' => [
                    'idpeg' => $idpeg,
                    'tglawal' => $tglawal,
                    'tglakhir' => $tglakhir,
                    'jammasuk' => $this->config->masuk,
                    'jamkeluar' => $this->config->pulang
                ],
                'db_connection' => jasperConnection()
            ];

            $jasper = new PHPJasper;

            $jasper->process(
                $input,
                $output,
                $options
            )->execute();

            return response()->download($outputFile, $fileForSave . "." . $type, [], 'inline')->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
