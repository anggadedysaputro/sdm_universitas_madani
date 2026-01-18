<?php

namespace App\Http\Controllers\Laporan\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Str;

class LaporanPresensi extends Controller
{
    public function index()
    {
        return view('laporan.presensi.index');
    }

    public function file(Request $request)
    {
        try {
            // ===============================
            // VALIDASI INPUT
            // ===============================
            $request->validate([
                'tglawal'  => 'required|date',
                'tglakhir' => 'required|date',
                'type'     => 'nullable|in:pdf,xls,xlsx',
            ]);

            $idpeg    = $request->input('idpeg', '[]');
            $tglawal  = $request->tglawal;
            $tglakhir = $request->tglakhir;
            $type     = $request->input('type', 'pdf');
            $preview  = (bool) $request->input('preview', false);

            // ===============================
            // FILE PATH
            // ===============================
            $input     = public_path('report/header_slip_gaji.jasper');
            $folder    = storage_path('app/jasper');
            $filename  = 'laporan_presensi_' . Str::uuid();
            $output    = $folder . '/' . $filename;
            $outputFile = $output . '.' . $type;

            buatFolder($folder);

            // ===============================
            // JASPER OPTIONS
            // ===============================
            $options = [
                'format' => [$type],
                'locale' => 'id',
                'params' => [
                    'P_NOPEG'        => $idpeg,
                    'P_TANGGALAWAL'  => $tglawal,
                    'P_TANGGALAKHIR' => $tglakhir,
                    'P_SUBREPORT'    => public_path('report/slip_gaji.jasper'),
                ],
                'db_connection' => jasperConnection(),
            ];

            // ===============================
            // OPSI KHUSUS XLS / XLSX
            // ===============================
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

            // ===============================
            // GENERATE REPORT
            // ===============================
            $jasper = new PHPJasper;
            $jasper->process($input, $output, $options)->execute();

            if (!file_exists($outputFile)) {
                throw new \Exception('File laporan gagal dibuat oleh Jasper');
            }

            // ===============================
            // MIME TYPE
            // ===============================
            $mime = match ($type) {
                'pdf'  => 'application/pdf',
                'xls'  => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                default => 'application/octet-stream',
            };

            $downloadName = 'Laporan_Presensi.' . $type;

            // ===============================
            // STREAM + AUTO DELETE
            // ===============================
            return response()->streamDownload(function () use ($outputFile) {
                readfile($outputFile);
                @unlink($outputFile);
            }, $downloadName, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $downloadName . '"'
            ]);
        } catch (\Throwable $e) {

            // LOG INTERNAL (WAJIB biar debug gampang)
            \Log::error('Laporan Presensi Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
