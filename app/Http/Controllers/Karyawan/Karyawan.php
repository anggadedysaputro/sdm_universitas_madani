<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Applications\BiayaPendidikanAnak;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Applications\PengalamanKerja;
use App\Models\Applications\Sertifikat;
use App\Models\Masters\Agama;
use App\Models\Masters\Biaya;
use App\Models\Masters\Bidang;
use App\Models\Masters\GolonganDarah;
use App\Models\Masters\JabatanFungsional;
use App\Models\Masters\JabatanStruktural;
use App\Models\Masters\JenisSertifikat;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Models\User;
use App\Traits\Logger\TraitsLoggerActivity;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use DateTime;
use Exception;
use finfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Mime\MimeTypes;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\map;

class Karyawan extends Controller
{
    protected $hubungan;
    protected $unitKerja;
    protected $subUnitKerja;
    protected $readSheet;
    protected $masters;
    protected $queryBidang;
    protected $tahunCollection;
    protected $mappingFile;
    protected $unikValue;

    use TraitsLoggerActivity;

    public function __construct()
    {
        $this->unikValue = [
            'Email * 📧'
        ];
        $this->hubungan = hubungan();
        $this->tahunCollection = collect(array_combine(listTahun(), listTahun()));
        $this->queryBidang =
            Bidang::from("masters.bidang as b")->select(
                DB::raw("
                concat(kodebidang,'.',kodedivisi,'.',kodesubdivisi,'.',kodesubsubdivisi,' - ',
                '[',(
                    select urai
                    from masters.bidang as b2
                    where b2.kodebidang = b.kodebidang and
                        b2.kodedivisi = 0
                ),']',' ',
                urai
                ) as urai,
                id
            ")
            )->where('kodedivisi', '<>', '0')
            ->orderBy("kodebidang")
            ->orderBy("kodedivisi");

        $this->unitKerja = $this->queryBidang->get()->pluck('urai')->toArray();

        $this->masters = [
            'idkartuidentitas' => [
                'instance' => KartuIdentitas::query(),
                'kolom' => 'keterangan',
            ],
            'jns_kel' => collect(['L' => 'L', 'P' => 'P']),
            'gol_darah' => [
                'instance' => GolonganDarah::query(),
                'kolom' => 'nama'
            ],
            'idagama' => [
                'instance' => Agama::query(),
                'kolom' => 'urai'
            ],
            'idstatusnikah' => [
                'instance' => StatusNikah::query(),
                'kolom' => 'status',
                'primary' => 'idstatusnikah'
            ],
            'idkewarganegaraan' => collect(['WNI' => 'WNI', 'WNA' => 'WNA']),
            'idnegara' => [
                'instance' => Negara::query(),
                'kolom' => 'keterangan'
            ],
            'hubungan' => collect([
                'Suami' => 'Suami',
                'Istri' => 'Istri',
                'Anak' => 'Anak',
                'Ayah' => 'Ayah',
                'Ibu' => 'Ibu',
                'Adik' => 'Adik',
                'Kakak' => 'Kakak',
            ]),
            'idstatuspegawai' => [
                'instance' => StatusPegawai::query(),
                'kolom' => 'keterangan',
                'primary' => 'idstatuspegawai'
            ],
            'idpendidikan' => [
                'instance' => Pendidikan::query(),
                'kolom' => 'keterangan',
                'primary' => 'kodependidikan'
            ],
            'kodependidikan' => [
                'instance' => Pendidikan::query(),
                'kolom' => 'keterangan',
                'primary' => 'kodependidikan'
            ],
            'idbidang' => [
                'instance' => $this->queryBidang,
                'kolom' => "concat(kodebidang,'.',kodedivisi,'.',kodesubdivisi,'.',kodesubsubdivisi,' - ',
                '[',(
                    select urai
                    from masters.bidang as b2
                    where b2.kodebidang = b.kodebidang and
                        b2.kodedivisi = 0
            ),']',' ',
                urai
                )",
            ],
            'idjabatanstruktural' => [
                'instance' => JabatanStruktural::query(),
                'kolom' => 'urai',
                'primary' => 'kodejabatanstruktural'
            ],
            'idjabatanfungsional' => [
                'instance' => JabatanFungsional::query(),
                'kolom' => 'urai',
                'primary' => 'kodejabatanfungsional'
            ],
            'tahun_lulus' => $this->tahunCollection,
            'tahun' => $this->tahunCollection,
            'dari_tahun' => $this->tahunCollection,
            'sampai_tahun' => $this->tahunCollection,
            'tahun_kendaraan' => $this->tahunCollection,
            'idjenissertifikat' => [
                'instance' => JenisSertifikat::query(),
                'kolom' => 'urai',

            ],
            'idjenisbiaya' => [
                'instance' => Biaya::query(),
                'kolom' => 'urai'
            ],
            'idjenjangpendidikan' => [
                'instance' => Pendidikan::query(),
                'kolom' => 'keterangan'
            ]
        ];



        $this->readSheet = [
            'DATA PERSONAL' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Nama lengkap *' => 'nama',
                'Nama panggilan' => 'nama_panggilan',
                'Tipe kartu identitas * 📦' => 'idkartuidentitas',
                'ID kartu identitas * 🔢' => 'noidentitas',
                'Tempat lahir *' => 'tempatlahir',
                'Tanggal lahir * 📆' => 'tgl_lahir',
                'Jenis kelamin * 📦' => 'jns_kel',
                'Golongan darah * 📦' => 'gol_darah',
                'Alamat kartu identitas' => 'alamat',
                'Alamat domisili' => 'alamat_domisili',
                'Agama * 📦' => 'idagama',
                'Status perkawinan * 📦' => 'idstatusnikah',
                'Kewarganegaraan * 📦' => 'idkewarganegaraan',
                'Negara * 📦' => 'idnegara',
                'No. HP * 🔢' => 'nohp',
                'No. telepon 🔢' => 'telp',
                'No. telepon darurat 🔢' => 'notelpdarurat',
                'Email * 📧' => 'email',
                'Foto Diri * 📤' => 'gambar',
                'No NPWP 🔢' => 'npwp',
                'Foto NPWP 📤' => 'foto_npwp',
                'No BPJS kesehatan 🔢' => 'no_bpjs_kesehatan',
                'Tanggal Efektif No BPJS kesehatan 📆' => 'tgl_bpjs_kesehatan',
                'Foto BPJS Kesehatan 📤' => 'foto_bpjs_kesehatan',
                'No. KPJ BPJS ketenagakerjaan 🔢' => 'no_bpjs_ketenagakerjaan',
                'Tanggal Efektif No KPJ BPJS ketenagakerjaan 📆' => 'tgl_bpjs_ketenagakerjaan',
                'Foto BPJS Ketenagakerjaan 📤' => 'foto_bpjs_ketenagakerjaan',
                'No Rekening' => 'rekbank'
            ],
            'DATA KELUARGA' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'No kartu keluarga * 🔢' => 'nokk',
                'Nama kepala keluarga *' => 'nama_kepala_keluarga',
                'Nama keluarga darurat' => 'nama_keluarga_darurat',
                'No. telepon keluarga darurat 🔢' => 'telp_keluarga_darurat',
                'Nama' => 'nama',
                'Hubungan 📦' => 'hubungan',
                'Tempat lahir' => 'tempatlahir',
                'Tanggal lahir 📆' => 'tgllahir',
                'No. telepon 🔢' => 'telp',
                'Alamat' => 'alamat'
            ],
            'DATA PEKERJAAN' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Status karyawan * 📦' => 'idstatuspegawai',
                'Tgl. Masuk Yayasan * 📆' => 'tgl_masuk',
                'Tgl. Berakhir Kontrak 📆' => 'tgl_berakhir_kontrak',
                'Masa Bakti 🔢' => 'masa_bakti',
                'Pilih Organisasi * 📦' => 'idbidang',
                'Jabatan struktural 📦' => 'idjabatanstruktural',
                'Jabatan fungsional 📦' => 'idjabatanfungsional',
                'Tugas tambahan' => 'tugas_tambahan',
                'Dok. Surat Penjanjian Kerja 📤' => 'dok_surat_perjanjian_kerja',
                'Dok. Pakta Integritas 📤' => 'dok_pakta_integritas',
                'Dok. Hasil Test 📤' => 'dok_hasil_test',
                'Dok. Hasil Interview 📤' => 'dok_hasil_interview',
            ],
            'DATA PENDIDIKAN' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Jenjang pendidikan terakhir * 📦' => 'kodependidikan',
                'Tahun lulus * 📦' => 'tahun_lulus',
                'Nama Lembaga Pendidikan *' => 'namasekolah',
                'Program studi' => 'prodi',
                'Dok. Ijazah 📤' => 'dok_ijazah',
                'Dok. Transkrip Nilai 📤' => 'dok_transkrip_nilai',
                'Gelar' => 'gelar'

            ],
            'DATA SERTIFIKAT' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Nomor sertifikat *' => 'nomor_sertifikat',
                'Jenis sertifikat * 📦' => 'idjenissertifikat',
                'Lembaga penyelenggara' => 'lembaga_penyelenggara',
                'Tahun * 📦' => 'tahun',
                'Biaya * 🔢' => 'biaya',
                'Jenis biaya * 📦' => 'idjenisbiaya'
            ],
            'DATA KOMPETENSI' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Kompetensi Hard Skill' => 'kompetensi_hard_skill',
                'Kompetensi Soft Skill' => 'kompetensi_soft_skill',
            ],
            'DATA PENGALAMAN KERJA' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Dari tahun * 📦' => 'dari_tahun',
                'Sampai tahun * 📦' => 'sampai_tahun',
                'Jabatan' => 'jabatan',
                'Paklaring' => 'paklaring'
            ],
            'DATA FASILITAS' => [
                'Nomor pegawai * 🔢' => 'nopeg',
                'Biaya Tempat Tinggal Pertahun 🔢' => 'biaya_tempat_tinggal_pertahun',
                'Jumlah beras Perkg 🔢' => 'jumlah_beras_kg',
                'Merk kendaraan' => 'merk_kendaraan',
                'Tahun kendaraan 📦' => 'tahun_kendaraan',
                'Nama lembaga beasiswa pendidikan' => 'nama_lembaga_beasiswa_pendidikan',
                'Biaya beasiswa per semester 🔢' => 'biaya_beasiswa_per_semester',
                'anak ke 🔢' => 'anak_ke',
                'Jenjang pendidikan 📦' => 'idjenjangpendidikan',
                'Jenis biaya pendidikan' => 'jenis_biaya_pendidikan',
                'Besaran dispensasi 🔢' => 'besaran_dispensasi'
            ]
        ];
    }

    public function index()
    {
        return view('karyawan.index');
    }

    public function data()
    {
        $data = DB::table(DB::raw("
            (
                select
                    p.nopeg, p.nama, convertnumericdatetoalphabetical(p.tgl_lahir) tanggal_lahir,
                    p.alamat, case when p.jns_kel = 'L' then 'Laki - laki' else 'Perempuan' end as jenis_kelamin,
                    gd.nama as gol_darah,a.urai as agama, sn.status as status_nikah, p.kewarganegaraan, ki.keterangan as nama_kartuidentitas,p.noidentitas,
                    p.notelpdarurat, p.email, sp.keterangan as status_pegawai,convertnumericdatetoalphabetical(p.tgl_masuk) as tanggal_bergabung,
                    jb.urai as jabatan_fungsional, js.urai as jabatan_struktural, n.keterangan as negara,
                    case when isdosen then 'Ya' else 'Tidak' end dosen, nuptk
                from applications.pegawai p
                join masters.statusnikah sn
                on p.idstatusnikah = sn.idstatusnikah
                join masters.kartuidentitas ki
                on p.idkartuidentitas = ki.id
                join masters.statuspegawai sp
                on p.idstatuspegawai = sp.idstatuspegawai
                join masters.jabatanfungsional jb
                on jb.kodejabatanfungsional = p.kodejabfung
                join masters.jabatanstruktural js
                on js.kodejabatanstruktural = p.kodestruktural
                join masters.agama a
                on a.id = p.idagama
                join masters.negara n
                on n.id = p.idwarganegara
                join masters.golongan_darah gd
                on gd.id = p.gol_darah
            ) as p
        "));

        $statuspegawai = DB::table('applications.pegawai as p')
            ->join('masters.statuspegawai as sp', 'sp.idstatuspegawai', 'p.idstatuspegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('keterangan AS value, keterangan as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('keterangan')
            ->get();

        $nama = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('nama AS value, nama as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('nama')
            ->get();
        $nomorkartuidentitas = DB::table('applications.pegawai')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('noidentitas AS value, noidentitas as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('noidentitas')
            ->get();
        $agama = DB::table('applications.pegawai as p')
            ->join('masters.agama as a', 'a.id', '=', 'p.idagama')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('a.urai AS value, a.urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('a.urai')
            ->get();

        $jabatanstruktural = DB::table('applications.pegawai as p')
            ->join('masters.jabatanstruktural as sp', 'sp.kodejabatanstruktural', 'p.kodestruktural')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('urai AS value, urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('urai')
            ->get();

        $jabatanfungsional = DB::table('applications.pegawai as p')
            ->join('masters.jabatanfungsional as sp', 'sp.kodejabatanfungsional', 'p.kodejabfung')
            /** I'm unable to make ir work without manually creating a count and total columns */
            ->select(DB::raw('urai AS value, urai as label, count(*) AS count, count(*) as total'))
            ->distinct('value')
            ->groupBy('urai')
            ->get();
        return DataTables::of($data)
            ->searchPane('status_pegawai', $statuspegawai)
            ->searchPane('nama', $nama)
            ->searchPane('noidentitas', $nomorkartuidentitas)
            ->searchPane('agama', $agama)
            ->searchPane('jabatan_struktural', $jabatanstruktural)
            ->searchPane('jabatan_fungsional', $jabatanfungsional)
            ->toJson();
    }

    public function template()
    {
        // 1️⃣ Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();

        $allSheet = $this->buatSheet($spreadsheet);

        $this->templateDataPersonal($allSheet['personal']);
        $this->templateKeluarga($allSheet['keluarga']);
        $this->templatePekerjaan($allSheet['pekerjaan']);
        $this->templatePendidikan($allSheet['pendidikan']);
        $this->templateSertifikat($allSheet['sertifikat']);
        $this->templateKompetensi($allSheet['kompetensi']);
        $this->templatePengalamanKerja($allSheet['pengalamankerja']);
        $this->templateFasilitas($allSheet['fasilitas']);

        foreach ($allSheet as $key => $value) {
            $highestColumn = $value->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $value->getColumnDimension($columnLetter)->setAutoSize(true);
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_upload_karyawan.xlsx"');
        header('Cache-Control: max-age=0');

        // Simpan ke output (php://output)
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function buatSheet($spreadsheet)
    {
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('DATA PERSONAL');

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('DATA KELUARGA');

        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('DATA PEKERJAAN');

        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('DATA PENDIDIKAN');

        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('DATA SERTIFIKAT');

        $sheet6 = $spreadsheet->createSheet();
        $sheet6->setTitle('DATA KOMPETENSI');

        $sheet7 = $spreadsheet->createSheet();
        $sheet7->setTitle('DATA PENGALAMAN KERJA');

        $sheet8 = $spreadsheet->createSheet();
        $sheet8->setTitle('DATA FASILITAS');

        $sheet9 = $spreadsheet->createSheet();
        $sheet9->setTitle('AGAMA');

        $row = 1;
        foreach (Agama::all() as $option) {
            $sheet9->setCellValue('A' . $row, $option->urai);
            $row++;
        }

        $sheet10 = $spreadsheet->createSheet();
        $sheet10->setTitle('KARTU IDENTITAS');

        $row = 1;
        foreach (KartuIdentitas::all() as $option) {
            $sheet10->setCellValue('A' . $row, $option->keterangan);
            $row++;
        }

        $sheet11 = $spreadsheet->createSheet();
        $sheet11->setTitle('JENIS KELAMIN');

        $row = 1;
        foreach (['L', 'P'] as $option) {
            $sheet11->setCellValue('A' . $row, $option);
            $row++;
        }

        $sheet12 = $spreadsheet->createSheet();
        $sheet12->setTitle('GOLONGAN DARAH');

        $row = 1;
        foreach (GolonganDarah::all() as $option) {
            $sheet12->setCellValue('A' . $row, $option->nama);
            $row++;
        }

        $sheet13 = $spreadsheet->createSheet();
        $sheet13->setTitle('KEWARGANEGARAAN');
        $row = 1;
        foreach (['WNI', 'WNA'] as $option) {
            $sheet13->setCellValue('A' . $row, $option);
            $row++;
        }

        $sheet14 = $spreadsheet->createSheet();
        $sheet14->setTitle('NEGARA');
        $row = 1;
        foreach (Negara::all() as $option) {
            $sheet14->setCellValue('A' . $row, $option->keterangan);
            $row++;
        }

        $sheet15 = $spreadsheet->createSheet();
        $sheet15->setTitle('STATUS PERKAWINAN');
        $row = 1;
        foreach (StatusNikah::all() as $option) {
            $sheet15->setCellValue('A' . $row, $option->status);
            $row++;
        }

        $sheet16 = $spreadsheet->createSheet();
        $sheet16->setTitle('HUBUNGAN');
        $row = 1;
        foreach (
            $this->hubungan as $option
        ) {
            $sheet16->setCellValue('A' . $row, $option);
            $row++;
        }

        $sheet17 = $spreadsheet->createSheet();
        $sheet17->setTitle('ORGANISASI');
        $row = 1;
        foreach (
            $this->unitKerja as $option
        ) {
            $sheet17->setCellValue('A' . $row, $option);
            $row++;
        }

        $sheet19 = $spreadsheet->createSheet();
        $sheet19->setTitle('STATUS KARYAWAN');
        $row = 1;
        foreach (StatusPegawai::all() as $option) {
            $sheet19->setCellValue('A' . $row, $option->keterangan);
            $row++;
        }

        $sheet20 = $spreadsheet->createSheet();
        $sheet20->setTitle('JABATAN FUNGSIONAL');
        $row = 1;
        foreach (JabatanFungsional::all() as $option) {
            $sheet20->setCellValue('A' . $row, $option->urai);
            $row++;
        }

        $sheet21 = $spreadsheet->createSheet();
        $sheet21->setTitle('JABATAN STRUKTURAL');
        $row = 1;
        foreach (JabatanStruktural::all() as $option) {
            $sheet21->setCellValue('A' . $row, $option->urai);
            $row++;
        }

        $sheet22 = $spreadsheet->createSheet();
        $sheet22->setTitle('TAHUN');
        $row = 1;
        foreach (
            listTahun() as $option
        ) {
            $sheet22->setCellValue('A' . $row, $option);
            $row++;
        }

        $sheet23 = $spreadsheet->createSheet();
        $sheet23->setTitle('JENJANG PENDIDIKAN');
        $row = 1;
        foreach (Pendidikan::all() as $option) {
            $sheet23->setCellValue('A' . $row, $option->keterangan);
            $row++;
        }

        $sheet24 = $spreadsheet->createSheet();
        $sheet24->setTitle('JENIS SERTIFIKAT');
        $row = 1;
        foreach (JenisSertifikat::all() as $option) {
            $sheet24->setCellValue('A' . $row, $option->urai);
            $row++;
        }

        $sheet25 = $spreadsheet->createSheet();
        $sheet25->setTitle('JENIS BIAYA');
        $row = 1;
        foreach (Biaya::all() as $option) {
            $sheet25->setCellValue('A' . $row, $option->urai);
            $row++;
        }

        return [
            'personal' => $sheet1,
            'keluarga' => $sheet2,
            'pekerjaan' => $sheet3,
            'pendidikan' => $sheet4,
            'sertifikat' => $sheet5,
            'kompetensi' => $sheet6,
            'pengalamankerja' => $sheet7,
            'fasilitas' => $sheet8
        ];
    }

    public function buatDropdown($sheet, $sheetMaster, $cell, $total)
    {
        // 2. Data Validation pakai formula range
        $validation = $sheet->getCell($cell)->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $range = "='" . $sheetMaster . "'!A$1:A$" . $total;
        $validation->setFormula1($range);
    }

    public function templateFasilitas($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Biaya Tempat Tinggal Pertahun 🔢');
        $sheet->setCellValue('C1', 'Jumlah beras Perkg 🔢');
        $sheet->setCellValue('D1', 'Merk kendaraan');
        $sheet->setCellValue('E1', 'Tahun kendaraan 📦');
        $sheet->setCellValue('F1', 'Nama lembaga beasiswa pendidikan');
        $sheet->setCellValue('G1', 'Biaya beasiswa per semester 🔢');

        $sheet->setCellValue('H1', 'anak ke 🔢');
        $sheet->setCellValue('I1', 'Jenjang pendidikan 📦');
        $sheet->setCellValue('J1', 'Jenis biaya pendidikan');
        $sheet->setCellValue('K1', 'Besaran dispensasi 🔢');

        $this->buatDropdown($sheet, "TAHUN", "E2", count(listTahun()));
        $this->buatDropdown($sheet, "JENJANG PENDIDIKAN", "I2", Pendidikan::count());
    }

    public function templatePengalamanKerja($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Dari tahun * 📦');
        $sheet->setCellValue('C1', 'Sampai tahun * 📦');
        $sheet->setCellValue('D1', 'Jabatan');
        $sheet->setCellValue('E1', 'Paklaring');

        $this->buatDropdown($sheet, "TAHUN", "B2", count(listTahun()));
        $this->buatDropdown($sheet, "TAHUN", "C2", count(listTahun()));
    }

    public function templateKompetensi($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Kompetensi Hard Skill');
        $sheet->setCellValue('C1', 'Kompetensi Soft Skill');
    }

    public function templateSertifikat($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Nomor sertifikat *');
        $sheet->setCellValue('C1', 'Jenis sertifikat * 📦');
        $sheet->setCellValue('D1', 'Lembaga penyelenggara');
        $sheet->setCellValue('E1', 'Tahun * 📦');
        $sheet->setCellValue('F1', 'Biaya * 🔢');
        $sheet->setCellValue('G1', 'Jenis biaya * 📦');

        $this->buatDropdown($sheet, "JENIS SERTIFIKAT", "C2", JenisSertifikat::count());
        $this->buatDropdown($sheet, "TAHUN", "E2", count(listTahun()));
        $this->buatDropdown($sheet, "JENIS BIAYA", "G2", Biaya::count());
    }

    public function templatePendidikan($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Jenjang pendidikan terakhir * 📦');
        $sheet->setCellValue('C1', 'Tahun lulus * 📦');
        $sheet->setCellValue('D1', 'Nama Lembaga Pendidikan *');
        $sheet->setCellValue('E1', 'Program studi');
        $sheet->setCellValue('F1', 'Dok. Ijazah 📤');
        $sheet->setCellValue('G1', 'Dok. Transkrip Nilai 📤');
        $sheet->setCellValue('H1', 'Gelar');

        $this->buatDropdown($sheet, "JENJANG PENDIDIKAN", "B2", Pendidikan::count());
        $this->buatDropdown($sheet, "TAHUN", "C2", count(listTahun()));
    }

    public function templatePekerjaan($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Status karyawan * 📦');
        $sheet->setCellValue('C1', 'Tgl. Masuk Yayasan * 📆');
        $sheet->setCellValue('D1', 'Tgl. Berakhir Kontrak 📆');
        $sheet->setCellValue('E1', 'Masa Bakti 🔢');
        $sheet->setCellValue('F1', 'Pilih Organisasi * 📦');
        $sheet->setCellValue('G1', 'Jabatan struktural 📦');
        $sheet->setCellValue('H1', 'Jabatan fungsional 📦');
        $sheet->setCellValue('I1', 'Tugas tambahan');
        $sheet->setCellValue('J1', 'Dok. Surat Penjanjian Kerja 📤');
        $sheet->setCellValue('K1', 'Dok. Pakta Integritas 📤');
        $sheet->setCellValue('L1', 'Dok. Hasil Test 📤');
        $sheet->setCellValue('M1', 'Dok. Hasil Interview 📤');

        $this->buatDropdown($sheet, "STATUS KARYAWAN", "B2", StatusPegawai::count());
        $this->buatTanggal($sheet, 'C2');
        $this->buatTanggal($sheet, 'D2');
        $this->buatDropdown($sheet, "ORGANISASI", "F2", count($this->unitKerja));
        $this->buatDropdown($sheet, "JABATAN STRUKTURAL", "G2", JabatanStruktural::count());
        $this->buatDropdown($sheet, "JABATAN FUNGSIONAL", "H2", JabatanFungsional::count());
    }

    public function templateKeluarga($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'No kartu keluarga * 🔢');
        $sheet->setCellValue('C1', 'Nama kepala keluarga *');
        $sheet->setCellValue('D1', 'Nama keluarga darurat');
        $sheet->setCellValue('E1', 'No. telepon keluarga darurat 🔢');
        $sheet->setCellValue('F1', 'Nama');
        $sheet->setCellValue('G1', 'Hubungan 📦');
        $sheet->setCellValue('H1', 'Tempat lahir');
        $sheet->setCellValue('I1', 'Tanggal lahir 📆');
        $sheet->setCellValue('J1', 'No. telepon 🔢');
        $sheet->setCellValue('K1', 'Alamat');

        $this->buatDropdown($sheet, "HUBUNGAN", "G2", count($this->hubungan));
        $this->buatTanggal($sheet, "I2");
    }

    public function buatTanggal($sheet, $cell)
    {
        // Buat Data Validation
        $validation = $sheet->getCell($cell)->getDataValidation();
        $validation->setType(DataValidation::TYPE_DATE);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true); // Boleh kosong
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Input Salah');
        $validation->setError('Masukkan tanggal yang benar dalam format YYYY-MM-DD!');
        $validation->setPromptTitle('Input Tanggal');
        $validation->setPrompt('Masukkan tanggal dalam format: 2025-07-31');

        $sheet->getStyle($cell)
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');
    }

    public function templateDataPersonal($sheet)
    {
        $sheet->setCellValue('A1', 'Nomor pegawai * 🔢');
        $sheet->setCellValue('B1', 'Nama lengkap *');
        $sheet->setCellValue('C1', 'Nama panggilan');
        $sheet->setCellValue('D1', 'Tipe kartu identitas * 📦');
        $sheet->setCellValue('E1', 'ID kartu identitas * 🔢');
        $sheet->setCellValue('F1', 'Tempat lahir *');
        $sheet->setCellValue('G1', 'Tanggal lahir * 📆');
        $sheet->setCellValue('H1', 'Jenis kelamin * 📦');
        $sheet->setCellValue('I1', 'Golongan darah * 📦');
        $sheet->setCellValue('J1', 'Alamat kartu identitas');
        $sheet->setCellValue('K1', 'Alamat domisili');
        $sheet->setCellValue('L1', 'Agama * 📦');
        $sheet->setCellValue('M1', 'Status perkawinan * 📦');
        $sheet->setCellValue('N1', 'Kewarganegaraan * 📦');
        $sheet->setCellValue('O1', 'Negara * 📦');
        $sheet->setCellValue('P1', 'No. HP * 🔢');
        $sheet->setCellValue('Q1', 'No. telepon 🔢');
        $sheet->setCellValue('R1', 'No. telepon darurat 🔢');
        $sheet->setCellValue('S1', 'Email * 📧');
        $sheet->setCellValue('T1', 'Foto Diri * 📤');
        $sheet->setCellValue('U1', 'No NPWP 🔢');
        $sheet->setCellValue('V1', 'Foto NPWP 📤');
        $sheet->setCellValue('W1', 'No BPJS kesehatan 🔢');
        $sheet->setCellValue('X1', 'Tanggal Efektif No BPJS kesehatan 📆');
        $sheet->setCellValue('Y1', 'Foto BPJS Kesehatan 📤');
        $sheet->setCellValue('Z1', 'No. KPJ BPJS ketenagakerjaan 🔢');
        $sheet->setCellValue('AA1', 'Tanggal Efektif No KPJ BPJS ketenagakerjaan 📆');
        $sheet->setCellValue('AB1', 'Foto BPJS Ketenagakerjaan 📤');
        $sheet->setCellValue('AC1', 'No Rekening');

        $this->buatDropdown($sheet, "KARTU IDENTITAS", "D2", KartuIdentitas::count());
        $this->buatDropdown($sheet, "JENIS KELAMIN", "H2", 2);
        $this->buatDropdown($sheet, "GOLONGAN DARAH", "I2", GolonganDarah::count());
        $this->buatDropdown($sheet, "AGAMA", "L2", Agama::count());
        $this->buatDropdown($sheet, "STATUS PERKAWINAN", "M2", StatusNikah::count());
        $this->buatDropdown($sheet, "KEWARGANEGARAAN", "N2", 2);
        $this->buatDropdown($sheet, "NEGARA", "O2", Negara::count());
        $this->buatTanggal($sheet, "G2");
        $this->buatTanggal($sheet, "X2");
        $this->buatTanggal($sheet, "AA2");
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            // buatkan folder untuk menampun file nya
            buatFolder(storage_path('app/' . 'public/pegawai'));
            buatFolder(storage_path('app/' . 'public/foto_npwp'));
            buatFolder(storage_path('app/' . 'public/foto_bpjs_kesehatan'));
            buatFolder(storage_path('app/' . 'public/foto_bpjs_ketenagakerjaan'));
            buatFolder(storage_path('app/' . 'public/dok_surat_perjanjian_kerja'));
            buatFolder(storage_path('app/' . 'public/dok_pakta_integritas'));
            buatFolder(storage_path('app/' . 'public/dok_hasil_test'));
            buatFolder(storage_path('app/' . 'public/dok_hasil_interview'));
            buatFolder(storage_path('app/' . 'public/dok_ijazah'));
            buatFolder(storage_path('app/' . 'public/dok_transkrip_nilai'));

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Pakai path real file yang diupload
                $filePath = $file->getRealPath();

                // Tangkap hasil dari bacaFileExcel
                $result = $this->bacaFileExcel($filePath);

                // Jika bacaFileExcel mengembalikan response redirect, hentikan dan return
                if ($result instanceof \Illuminate\Http\RedirectResponse) {
                    return $result;
                }
            } else {
                return back()->with('error', 'File tidak ditemukan!');
            }

            $this->activity("Pegawai berhasil dimasukkan [successfully]");

            DB::commit();

            return back()->with('success', 'Pegawai berhasil dimasukkan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Pegawai gagal dimasukkan [failed]", $th->getMessage());

            return back()->with('error', 'Pegawai gagal dimasukkan!');
        }
    }

    public function bacaFileExcel($filePath)
    {
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);

        $allErrors = [];
        $allValid = [];
        $nopegs = [];
        // echo "<pre>";
        foreach ($reader->getSheetIterator() as $sheet) {
            // echo $sheet->getName() . "\n";
            if (isset($this->readSheet[$sheet->getName()])) { // jika sheet nya ketemu eksekusi
                $nomorBaris = 1;
                $mappingKolom = $this->readSheet[$sheet->getName()];
                $kolomIndex = [];
                $sheetErrors = [];
                $sheetValid = [];
                foreach ($sheet->getRowIterator() as $row) {
                    // Ambil data baris (array)
                    $cells = $row->getCells();
                    $rowInsert = [];
                    $errors = [];

                    if ($nomorBaris == 1) {
                        for ($i = 0; $i < count($cells); $i++) {
                            $kolomIndex[$mappingKolom[$cells[$i]->getValue()]] = $i;
                        }
                    } else {
                        // if ($sheet->getName() == 'DATA SERTIFIKAT') dd($kolomIndex);
                        foreach ($kolomIndex as $kunci => $nilai) {
                            $errors[$kunci] = "";
                            $header = array_search($kunci, $mappingKolom);
                            $valueExcel = $row->getCellAtIndex($nilai);
                            $valueExcel = empty($valueExcel) ? null : $valueExcel->getValue();
                            $valueExcel = ((empty($valueExcel) || $valueExcel == "") && $valueExcel != "0" ? null : $valueExcel);

                            // cek nopeg
                            if ($sheet->getName() == "DATA PERSONAL" && $header == "Nomor pegawai * 🔢") {
                                $cekNopeg = Pegawai::where('nopeg', $valueExcel)->exists();
                                if ($cekNopeg) {
                                    $errors[$kunci] = $errors[$kunci] . "Nomor pegawai sudah dipakai !\n";
                                    continue;
                                }

                                if (in_array($valueExcel, $nopegs)) {
                                    $errors[$kunci] = $errors[$kunci] . "Nomor pegawai sudah dipakai !\n";
                                    continue;
                                }
                            }

                            $excludeFotoDiri = ($header != 'Foto Diri * 📤' && env('APP_ENV') == 'production');
                            // jika wajib diisi
                            if (strpos($header, '*') && empty($valueExcel) && $valueExcel != "0" && $excludeFotoDiri) {
                                // if ($sheet->getName() == 'DATA SERTIFIKAT') dd("ada");
                                $errors[$kunci] = $errors[$kunci] . "wajib diisi!\n";
                                continue;
                            }

                            // tidak boleh dobel
                            /* if (strpos($header, '📧')) {
                                $cekEmail = Pegawai::where('email', $valueExcel)->exists();
                                // echo $valueExcel . "\n";
                                if ($cekEmail) {
                                    $errors[$kunci] = $errors[$kunci] . "Email sudah dipakai !\n";
                                    continue;
                                }

                                if (in_array($valueExcel, $emails)) {
                                    $errors[$kunci] = $errors[$kunci] . "Email sudah dipakai !\n";
                                    continue;
                                }
                            } */

                            // angka
                            if (strpos($header, '🔢')) $valueExcel = preg_replace('/[^0-9.]/', '', $valueExcel);
                            // berarti master (dapatkan id dari database)
                            if (strpos($header, '📦')) {
                                if (strpos($header, '*')) {
                                    $instance = (isset($this->masters[$kunci]['instance']) ?  $this->masters[$kunci]['instance'] : $this->masters[$kunci]);

                                    if ($instance instanceof Builder) {

                                        $query = clone $instance;

                                        $data = $query->whereRaw("lower(" . $this->masters[$kunci]['kolom'] . ")= '" . strtolower($valueExcel) . "'");
                                        // if (isset($this->masters[$kunci]['raw'])) {
                                        //     // dd($this->masters[$kunci]['kolom'] . "= '" . $valueExcel . "'");
                                        // } else {
                                        //     $data = $query->where($this->masters[$kunci]['kolom'], strtolower($valueExcel));
                                        // }
                                        if (!$data->exists() && strpos($header, '*')) {
                                            // if ($sheet->getName() == 'DATA PERSONAL' && $header == "Tipe kartu identitas * 📦") {
                                            //     dd(getSql($query));
                                            // };
                                            $errors[$kunci] = $errors[$kunci] . $valueExcel . " tidak ditemukan di database!\n";
                                            continue;
                                        }

                                        if (!$data->exists()) {
                                            $valueExcel = null;
                                        } else {
                                            if (isset($this->masters[$kunci]['primary'])) {
                                                $valueExcel = $data->first()->{$this->masters[$kunci]['primary']};
                                            } else {
                                                $valueExcel = $data->first()->id;
                                            }
                                        }
                                    } else if ($instance instanceof Collection) {
                                        $cekCollection = $this->masters[$kunci]->filter(function ($item) use ($valueExcel) {
                                            return $item === $valueExcel;
                                        });

                                        if ($cekCollection->isEmpty()) {
                                            $errors[$kunci] = $errors[$kunci] . $valueExcel . " tidak ditemukan di database!\n";
                                            continue;
                                        }
                                    }
                                } else {
                                    $valueExcel = null;
                                }
                            }

                            // netralkan dulu semua tanggal
                            if (strpos($header, '📆') !== false && !($valueExcel instanceof DateTime) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $valueExcel)) {
                                $valueExcel = null;
                            }

                            // jika tanggal
                            if (strpos($header, '📆') !== false && strpos($header, '*') !== false) {
                                if (!($valueExcel instanceof DateTime)) {
                                    try {
                                        // Coba konversi jika string valid
                                        $parsedDate = new DateTime($valueExcel);
                                        $valueExcel = $parsedDate;
                                    } catch (Exception $e) {
                                        // Tangkap error jika format tidak valid
                                        $errors[$kunci] = ($errors[$kunci] ?? '') . " format tanggal tidak sesuai!\n";
                                        continue;
                                    }
                                }
                            }


                            // jika gambar upload
                            if (strpos($header, '📤') && !empty($valueExcel)) {
                                $file = makeUploadedFileFromUrl($valueExcel);
                                if ($file) {
                                    $valueExcel = $file;
                                } else {
                                    $valueExcel = null;
                                }
                            }

                            if ($valueExcel == "") $valueExcel = null;
                            // if ($sheet->getName() == 'DATA SERTIFIKAT') dd($valueExcel);
                            $rowInsert[$kunci] = $valueExcel;

                            // masukkan email untuk dilist biar tahu kalau ada email yang duplikat
                            if ($sheet->getName() == "DATA PERSONAL" && $header == "Nomor pegawai * 🔢") array_push($nopegs, $valueExcel);
                        }

                        // if ($sheet->getName() == 'DATA SERTIFIKAT') dd($rowInsert);
                    }

                    // echo $sheet->getName() . " - " . $nomorBaris . "\n";
                    // print_r($rowInsert);
                    // print_r($errors);
                    // echo "========================================";

                    if (!empty($errors) && array_filter($errors, function ($value) {
                        return !empty($value);
                    })) {
                        $errors['nomor_baris'] = $nomorBaris;
                        array_push($sheetErrors, $errors);
                    } else if (!empty($rowInsert)) {
                        array_push($sheetValid, $rowInsert);
                    }

                    $nomorBaris++;
                }
                // if ($sheet->getName() == 'DATA SERTIFIKAT') dd($sheetValid);
                $allErrors[$sheet->getName()] = $sheetErrors;
                $allValid[$sheet->getName()] = $sheetValid;
            }
        }


        $allEmpty = collect(array_values($allErrors))->every(function ($item) {
            return empty($item);
        });

        // baru masukkan datanya
        if (!$allEmpty) {
            // dd($allErrors);
            return redirect()->back()->with([
                'error' => 'Gagal menyimpan data.',
                'error_data' => $allErrors
            ]);
        } else {
            $dataDiri = $allValid['DATA PERSONAL'];
            $dataPekerjaan = $allValid['DATA PEKERJAAN'];
            $dataKeluarga = $allValid['DATA KELUARGA'];
            $dataPendidikan = $allValid['DATA PENDIDIKAN'];
            $dataSertifikat = $allValid['DATA SERTIFIKAT'];
            $dataKompetensi = $allValid['DATA KOMPETENSI'];
            $dataPengalamanKerja = $allValid['DATA PENGALAMAN KERJA'];
            $dataFasilitas = $allValid['DATA FASILITAS'];

            // masukkan pegawai pakai data personal aja
            foreach ($dataDiri as $key => $value) {
                if ($value['gambar']) {
                    $value['gambar'] = $this->saveFile($value, 'public/pegawai/', 'gambar');
                    $value['fullpath'] = 'public/pegawai/' . $value['gambar'];
                }

                if ($value['foto_npwp']) $value['foto_npwp'] = $this->saveFile($value, 'public/pegawai/', 'foto_npwp');
                if ($value['foto_bpjs_kesehatan']) $value['foto_bpjs_kesehatan'] = $this->saveFile($value, 'public/foto_bpjs_kesehatan/', 'foto_bpjs_kesehatan');
                if ($value['foto_bpjs_ketenagakerjaan']) $value['foto_bpjs_ketenagakerjaan'] = $this->saveFile($value, 'public/foto_bpjs_ketenagakerjaan/', 'foto_bpjs_ketenagakerjaan');

                if (empty($value['nama'])) dd($value);
                Pegawai::create($value);

                // make user
                $user = [
                    "name" => $value['nama'],
                    "email" => $value['email'],
                    "password" => bcrypt($value['email']),
                    "telpon" => $value['nohp'],
                    "nopeg" => $value['nopeg'],
                    "passwordapi" => md5($value['email'] . md5($value['email'])),
                ];

                $user = User::create($user);
                $user->assignRole('pegawai');
            }

            // masukkan keluarga
            foreach ($dataKeluarga as $key => $value) {
                $pegawai = [
                    "nopeg" => $value['nopeg'],
                    "nokk" => $value['nokk'],
                    "nama_kepala_keluarga" => $value['nama_kepala_keluarga'],
                    "nama_keluarga_darurat" => $value['nama_keluarga_darurat'],
                    "telp_keluarga_darurat" => $value['telp_keluarga_darurat'],
                ];
                Pegawai::updateOrCreate(['nopeg' => $value['nopeg']], $pegawai);

                if (
                    !empty($value['nama']) && !empty($value['hubungan'])
                ) {
                    Keluarga::create($value);
                }
            }

            // dd($dataPekerjaan);
            // masukkan pekerjaan
            foreach ($dataPekerjaan as $key => $value) {
                if ($value['dok_surat_perjanjian_kerja']) $value['dok_surat_perjanjian_kerja'] = $this->saveFile($value, 'public/dok_surat_perjanjian_kerja/', 'dok_surat_perjanjian_kerja');
                if ($value['dok_pakta_integritas']) $value['dok_pakta_integritas'] = $this->saveFile($value, 'public/dok_pakta_integritas/', 'dok_pakta_integritas');
                if ($value['dok_hasil_test']) $value['dok_hasil_test'] = $this->saveFile($value, 'public/dok_hasil_test/', 'dok_hasil_test');
                if ($value['dok_hasil_interview']) $value['dok_hasil_interview'] = $this->saveFile($value, 'public/dok_hasil_interview/', 'dok_hasil_interview');

                Pegawai::updateOrCreate(['nopeg' => $value['nopeg']], $value);
            }

            // masukkan pendidikan
            foreach ($dataPendidikan as $key => $value) {
                if ($value['dok_ijazah']) $value['dok_ijazah'] = $this->saveFile($value, 'public/dok_ijazah/', 'dok_ijazah');
                if ($value['dok_transkrip_nilai']) $value['dok_transkrip_nilai'] = $this->saveFile($value, 'public/dok_transkrip_nilai/', 'dok_transkrip_nilai');

                Pegawai::updateOrCreate(['nopeg' => $value['nopeg']], $value);
            }

            // masukkan sertifikat
            foreach ($dataSertifikat as $key => $value) Sertifikat::create($value);

            // masukkan kompetensi
            foreach ($dataKompetensi as $key => $value) Pegawai::updateOrCreate(['nopeg' => $value['nopeg']], $value);

            // masukkan pengalaman kerja
            foreach ($dataPengalamanKerja as $key => $value) PengalamanKerja::create($value);

            // masukkan pendidikan
            foreach ($dataFasilitas as $key => $value) {
                $pegawaiUpdate = [
                    "nopeg" => $value['nopeg'],
                    "biaya_tempat_tinggal_pertahun" => $value['biaya_tempat_tinggal_pertahun'],
                    "jumlah_beras_kg" => $value['jumlah_beras_kg'],
                    "merk_kendaraan" => $value['merk_kendaraan'],
                    "tahun_kendaraan" => $value['tahun_kendaraan'],
                    "nama_lembaga_beasiswa_pendidikan" => $value['nama_lembaga_beasiswa_pendidikan'],
                    "biaya_beasiswa_per_semester" => $value['biaya_beasiswa_per_semester'],
                ];
                Pegawai::updateOrCreate(['nopeg' => $value['nopeg']], $pegawaiUpdate);

                if (
                    !empty($value['anake_ke']) ||
                    !empty($value['idjenjangpendidikan']) ||
                    !empty($value['jenis_biaya_pendidikan']) ||
                    !empty($value['besaran_dispensasi'])
                ) {
                    $biayaPendidikanAnak = [
                        "nopeg" => $value['nopeg'],
                        "anak_ke" => $value['anak_ke'],
                        "idjenjangpendidikan" => $value['idjenjangpendidikan'],
                        "jenis_biaya_pendidikan" => $value['jenis_biaya_pendidikan'],
                        "besaran_dispensasi" => $value['besaran_dispensasi'],
                    ];
                    BiayaPendidikanAnak::create($biayaPendidikanAnak);
                }
            }
        }

        $reader->close();
    }

    public function saveFile($value, $path = 'public/pegawai/', $key)
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        // dapatkan MIME type
        $mimeType = $finfo->buffer($value[$key]);

        $mimeTypes = new MimeTypes();
        $extensions = $mimeTypes->getExtensions($mimeType);
        $extension = $extensions[0] ?? 'bin';

        $name = str_replace(".", "-", uniqid("", true)) . "." . $extension;
        $fileName = $path . $name;
        Storage::put($fileName, $value[$key]);

        return $name;
    }
}
