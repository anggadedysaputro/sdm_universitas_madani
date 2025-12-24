<?php

namespace App\Http\Controllers\Api\Cuti;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Applications\Cuti;
use App\Models\Applications\CutiDetail;
use App\Models\Applications\KonfigUmum;
use App\Models\Applications\Pegawai;
use App\Services\CutiService;
use App\Services\FcmService;
use App\Traits\Logger\TraitsLoggerActivity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPJasper\PHPJasper;

class ApiCuti extends Controller
{
    use TraitsLoggerActivity;

    protected $config, $path;
    protected $typeFile;

    public function __construct()
    {
        $this->config = tahunAplikasi();
        $this->path = 'public/cuti';
        $this->typeFile = 'pdf';
    }


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::beginTransaction();
        try {
            $post = request()->all();
            $form = $this->validateForm($post);

            if ($form instanceof JsonResponse) return $form;

            if (empty($form['tgl_cuti'])) throw new Exception("Tanggal cuti wajib diisi!", 1);

            $tglCuti = json_decode($form['tgl_cuti'], true);

            foreach ($tglCuti as $tgl) {
                $tahun = date('Y', strtotime($tgl));

                if ($tahun != $this->config->tahun) {
                    // Tolak cuti
                    throw new Exception("Pengajuan cuti ditolak. Tahun $tahun tidak sesuai konfigurasi.", 1);
                }
            }

            // $isSerial = $this->isSerialTanggal($tglCuti);
            $isSerial = count($tglCuti) > 10;

            $form['isserial'] = $isSerial;

            // Hitung selisih hari
            $selisihHari = count($tglCuti);

            $tgl_awal = min($tglCuti);
            $tgl_akhir = max($tglCuti);


            $getLibur = DB::select("select * from list_libur(?,?)", [$tgl_awal, $tgl_akhir]);

            $filterFromLibur = array_filter($getLibur, function ($value) use ($tglCuti) {
                // cek apakah tanggal ada di array tglCuti
                return in_array($value->rettanggal, $tglCuti);
            });

            $jumlahLibur = count($filterFromLibur);


            if (($selisihHari - $jumlahLibur) <= 0) throw new Exception("Anda cuti di hari libur!", 1);

            $selisihHari -= $jumlahLibur;
            if ($selisihHari == 0) throw new Exception("Minimal cuti 1 hari", 1);

            $form['jumlah'] = $selisihHari;
            $atasan = Pegawai::where('nopeg', $post['nopeg_atasan'])->first();
            if (empty($atasan)) throw new Exception("Atasan tidak ditemukan", 1);
            if (!Pegawai::where("nopeg", $form['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            if (DB::table('applications.cuti as c')->join('applications.cuti_detail as cd', 'cd.idcuti', '=', 'c.id')->where('nopeg', $form['nopeg'])->whereBetween("tanggal", [$tgl_awal, $tgl_akhir])->exists()) throw new Exception("Anda sudah pernah mengajukan cuti di tanggal {$tgl_awal}", 1);

            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);

            $totalCuti = DB::table('applications.cuti as c')->join('applications.cuti_detail as cd', 'cd.idcuti', '=', 'c.id')->where('nopeg', $form['nopeg'])
                ->whereRaw("extract(year from tanggal) = {$this->config->tahun}")
                ->sum('jumlah');


            $sisaCuti = $this->config->defcuti - ($totalCuti + $form['jumlah']);

            if ($sisaCuti < 0) throw new Exception("Kuota cuti anda sudah habis!", 1);
            $form['sisa'] = $sisaCuti;

            if (isset($post['lampiran']) && !empty($post['lampiran'])) {
                buatFolder(storage_path('app/' . $this->path));

                // Ambil ekstensi file
                $extension = $post['lampiran']->getClientOriginalExtension();

                // Buat nama unik (timestamp + uniqid)
                $name = uniqid() . '_' . time() . '.' . $extension;

                // Simpan file ke storage
                Storage::putFileAs($this->path, $post['lampiran'], $name);

                // Simpan ke form
                $form['lampiran'] = $name;
            } else {
                $form['lampiran'] = null;
            }

            $cutiCreated = Cuti::create($form);

            for ($i = 0; $i < count($tglCuti); $i++) {
                $insert = [
                    'idcuti' => $cutiCreated->id,
                    'tanggal' => $tglCuti[$i]
                ];

                CutiDetail::create($insert);
            }

            $deviceToken = $atasan->token_id;
            $title = "Pemberitahuan Cuti";
            $body = "Ada pegawai yang membutuhkan persetujuan anda untuk cuti!";
            $data = ["frg" => "AJUCUTI"];

            FcmService::sendNotification([
                'token' => $deviceToken,
                'title' => $title,
                'body'  => $body,
                'data'  => $data,
            ]);

            $response = [
                'message' => 'Cuti berhasil diajukan',
                'status' => true,
                'data' => $form
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Cuti [failed]", $th->getMessage());
            $response = [
                'message' => ($th->getCode() == 1 ? $th->getMessage() : message("Cuti gagal diajukan", $th)),
                'status' => false
            ];

            return response()->json($response, 200);
        }
    }

    public function validateForm($post)
    {

        $validator = Validator::make($post, [
            'nopeg' => 'required',
            'nopeg_atasan' => 'required',
            'tgl_cuti'     => 'required',
            // 'tgl_awal' => 'required|date',
            // 'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'nullable',
            'lampiran'  => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:1024', // max 1mb
        ], []);

        if ($validator->fails()) {
            // Tangani error secara manual
            return response()->json([
                'message' => "Data yang di kirim tidak sesuai aturan!",
                'errors' => $validator->errors(),
                'status' => false
            ], 200);
        }

        // Lanjutkan jika validasi berhasil
        $validatedData = $validator->validated();

        return $validatedData;
    }

    public function data()
    {
        try {
            $post = request()->all();
            if (!$this->config) throw new Exception("Konfigurasi yang aktif tidak ditemukan", 1);
            if (!Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);
            $data = Cuti::from("applications.cuti as c")->select(
                [
                    "c.id",
                    "js.urai as nama_jabatan_struktural",
                    "jf.urai as nama_jabatan_fungsional",
                    "c.nopeg",
                    "c.keterangan",
                    "c.jumlah",
                    "c.sisa",
                    "c.approval",
                    "c.approval_sdm",
                    "c.nopeg_atasan",
                    "c.lampiran",
                    "c.approval_at",
                    "c.approval_sdm_at",
                    "p.nama",
                    DB::raw("case when c.approval = true then 'Disetujui' when c.approval = false then 'Ditolak' else 'Diajukan' end approval_status"),
                    DB::raw("
                        json_agg(
                            json_build_object(
                                'tanggal', cd.tanggal
                            )
                            order by cd.tanggal
                        ) as list_tanggal
                    "),
                    "c.created_at"

                ]
            )
                ->join('applications.cuti_detail as cd', 'c.id', '=', 'cd.idcuti')
                ->join("applications.pegawai as p", "p.nopeg", '=', "c.nopeg")
                ->join("masters.jabatanstruktural as js", "js.kodejabatanstruktural", '=', 'p.kodestruktural')
                ->join("masters.jabatanfungsional as jf", "jf.kodejabatanfungsional", '=', 'p.kodejabfung')
                ->where("c.nopeg", $post['nopeg'])
                ->whereRaw("extract(year from cd.tanggal) = {$this->config->tahun}")
                ->groupBy(
                    "c.id",
                    "js.urai",
                    "jf.urai",
                    "p.nama",
                    "c.nopeg",
                    "c.keterangan",
                    "c.jumlah",
                    "c.sisa",
                    "c.approval",
                    "c.approval_sdm",
                    "c.nopeg_atasan",
                    "c.lampiran",
                    "c.approval_at",
                    "c.approval_sdm_at",
                    "c.created_at"
                )
                ->get();

            $data = $data->map(function ($item) {
                $item->list_tanggal = json_decode($item->list_tanggal);
                return $item;
            });

            $response = [
                'data' => $data,
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => message("Ambil data cuti gagal", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function cancel()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            if (empty($post['id'])) throw new Exception("Data cuti tidak ditemukan!", 1);
            if (!Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Pegawai tidak ditemukan!", 1);

            $cuti = Cuti::where('id', $post['id'])->where('nopeg', $post['nopeg']);
            $cekDiatasnya = Cuti::where('id', '>', $post['id'])->where('nopeg', $post['nopeg']);

            if ($cekDiatasnya->exists()) throw new Exception("Anda memiliki cuti yang lebih baru, batalkan terlebih dahulu!", 1);
            if (!$cuti->exists()) throw new Exception("Data cuti tidak ditemukan", 1);

            $cuti->delete();

            $response = [
                'message' => 'Berhasil membatalkan cuti',
                'status' => true,
                'sisa_cuti' => CutiService::sisa($post['nopeg'])
            ];

            DB::commit();
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Cancel Cuti [failed]", $th->getMessage());
            $response = [
                'message' => message("gagal membatalkan cuti", $th),
                'status' => false
            ];
            return response()->json($response, 200);
        }
    }

    public function formPersetujuan($idcuti)
    {
        try {
            // $idcuti = request()->post("idcuti");
            if (empty($idcuti)) throw new Exception("Cuti tidak ditemukan", 1);

            $input = public_path('report/persetujuan_cuti_fix.jasper');
            $filename = uniqid("persetujuan_cuti", TRUE);
            $output = storage_path('app/private/jasper/' . $filename);

            buatFolder(storage_path('app/private/jasper'));

            $options = [
                'format' => [$this->typeFile],
                'locale' => 'id',
                'params' => [
                    'xidcuti' => $idcuti,
                    'xttd' => asset('assets/images/ttd_afi.png'),
                    'xheader' => asset('assets/images/atas.png'),
                    'xfooter' => asset('assets/images/bawah.png')
                ],
                'resources' => public_path('report/fonts/times_font.jar'),
                'db_connection' => jasperConnection(),
            ];

            $jasper = new PHPJasper;
            $jasper->process(
                $input,
                $output,
                $options
            )->execute();

            $pdfPath = 'private/jasper/' . $filename . ".pdf";

            if (!Storage::exists($pdfPath)) {
                throw new Exception("File PDF tidak ditemukan setelah proses Jasper", 1);
            }

            // Stream PDF ke browser
            return response()->file(
                storage_path('app/' . $pdfPath),
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="persetujuan_cuti.pdf"'
                ]
            );
        } catch (\Throwable $th) {

            $this->activity("Mencetak form persetujuan cuti [failed]", $th->getMessage());

            return response()->json(
                ($th->getCode() == 1 ? $th->getMessage() : 'Gagal mencetak form persetujuan cuti'),
                500
            );
        }
    }

    function isSerialTanggal(array $dates): bool
    {
        // 0 atau 1 tanggal = dianggap serial
        if (count($dates) <= 1) {
            return true;
        }

        // urutkan tanggal
        sort($dates);

        for ($i = 1; $i < count($dates); $i++) {
            $prev = Carbon::parse($dates[$i - 1]);
            $curr = Carbon::parse($dates[$i]);

            // selisih harus 1 hari
            if ($prev->diffInDays($curr) !== 1) {
                return false;
            }
        }

        return true;
    }
}
