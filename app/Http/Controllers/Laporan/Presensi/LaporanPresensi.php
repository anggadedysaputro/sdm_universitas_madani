<?php

namespace App\Http\Controllers\Laporan\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pembelajaran;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPJasper\PHPJasper;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class LaporanPresensi extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('laporan.presensi.index');
    }

    public function dataTable()
    {
        $query = DB::table('applications.pegawai as p')
            ->select("p.nama as nama_pegawai", "b.urai as nama_organisasi", "ajar", "sks", "terpenuhi", "p.nopeg")
            ->leftJoin("applications.pembelajaran as pb", "p.nopeg", "=", "pb.nopeg")
            ->leftJoin("masters.bidang as b", "b.id", "=", "p.idbidang")
            ->orderBy("p.nama");

        return DataTables::of($query)->make(true);
    }

    public function updatePembelajaran(Request $request)
    {
        DB::beginTransaction();
        try {

            $validated = $request->validate([
                'nopeg' => ['required'],
                'nilai' => ['required', 'integer', 'min:0'],
                'mode'  => ['required', 'in:terpenuhi,ajar,sks'],
            ]);

            // Ambil nama kolom dari mode
            $column = $validated['mode'];

            // Siapkan data update
            $update = [
                $column => $validated['nilai'],
                'nopeg' => $validated['nopeg']
            ];



            Pembelajaran::updateOrCreate(['nopeg' => $update['nopeg']], $update);

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Update pembelajaran [failed]", $th->getMessage());

            $response = [
                'message' => message("Update pembelajaran gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function file(Request $request)
    {
        try {
            $request->validate([
                'bulan'  => 'required|integer',
                'jenis_laporan' => 'required',
                'type'     => 'nullable|in:pdf,xls,xlsx',
            ]);

            $idpeg = $request->input('idpeg', '[]');

            $tahun = konfigAplikasi()->tahun;
            $bulan = (int) $request->bulan;

            // ===============================
            // TANGGAL AWAL
            // ===============================
            $tglawal = sprintf(
                "%d-%02d-%02d",
                $tahun,
                $bulan,
                konfigAplikasi()->tglawalbulan
            );

            // ===============================
            // TANGGAL AKHIR (NORMALISASI)
            // ===============================
            $maxHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

            $hariAkhir = (int) konfigAplikasi()->akhirbulan;

            if ($hariAkhir <= 0 || $hariAkhir > $maxHari) {
                $hariAkhir = $maxHari;
            }

            $tglakhir = sprintf(
                "%d-%02d-%02d",
                $tahun,
                $bulan,
                $hariAkhir
            );


            $type = $request->input('type', 'pdf');
            $preview = (bool) $request->input('preview', false);
            $jenisLaporan = $request->input('jenis_laporan', 'v1');

            $input = $jenisLaporan == 'v1'
                ? public_path('report/header_slip_gaji.jasper')
                : ($type == 'pdf'
                    ? public_path('report/laporan_presensi_pdf.jasper')
                    : public_path('report/laporan_presensi.jasper'));

            $folder = storage_path('app/jasper');
            $filename = 'laporan_presensi_' . $jenisLaporan . Str::uuid();

            $output = $folder . '/' . $filename;
            $outputFile = $output . '.' . $type;

            buatFolder($folder);

            $params = $jenisLaporan == 'v1' ? [
                'P_NOPEG' => $idpeg,
                'P_TANGGALAWAL' => $tglawal,
                'P_TANGGALAKHIR' => $tglakhir,
                'P_SUBREPORT' => public_path('report/slip_gaji.jasper'),
            ] : [
                'idpegawai' => json_encode([]),
                'tanggalawal' => $tglawal,
                'tanggalakhir' => $tglakhir,
            ];

            $options = [
                'format' => [$type],
                'locale' => 'id',
                'params' => $params,
                'db_connection' => jasperConnection(),
            ];

            if (in_array($type, ['xls', 'xlsx'])) {
                $options['options'] = [
                    'xlsx.detect.cell.type' => 'true',
                    'xlsx.ignore.graphics' => 'false',
                    'xlsx.collapse.row.span' => 'false',
                    'xlsx.one.page.per.sheet' => 'false',
                    'xlsx.remove.empty.space.between.rows' => 'true',
                    'xlsx.remove.empty.space.between.columns' => 'true',
                ];
            }

            $jasper = new PHPJasper;
            $jasper->process($input, $output, $options)->execute();

            if (!file_exists($outputFile)) {
                throw new \Exception('File laporan gagal dibuat oleh Jasper');
            }

            $mime = match ($type) {
                'pdf' => 'application/pdf',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                default => 'application/octet-stream',
            };

            $downloadName = 'Laporan_Presensi_' . $jenisLaporan . '.' . $type;

            return response()->streamDownload(function () use ($outputFile) {
                readfile($outputFile);
                @unlink($outputFile);
            }, $downloadName, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $downloadName . '"'
            ]);
        } catch (\Throwable $th) {

            dd($th->getMessage());
            $this->activity("Laporan presensi [failed]", $th->getMessage());

            return response()->json([
                'message' => message("Laporan presensi gagal", $th)
            ], 500);
        }
    }
}
