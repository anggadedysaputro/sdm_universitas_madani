<?php

namespace App\Http\Controllers\Karyawan\Edit;

use App\Http\Controllers\Controller;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Masters\Agama;
use App\Models\Masters\Bidang;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KaryawanEdit extends Controller
{
    use TraitsLoggerActivity;

    public function index($id)
    {
        $pegawai = Pegawai::from("applications.pegawai as p")
            ->select(
                "nopeg",
                "nama",
                DB::raw("convertnumericdatetoalphabetical(tgl_lahir) as tanggal_lahir"),
                "tgl_lahir",
                "jns_kel",
                DB::raw("case when jns_kel = 'L' then 'Laki-laki' else 'Perempuan' end as jenis_kelamin"),
                "gol_darah",
                "a.urai as agama",
                "p.idagama",
                "sn.status as status_nikah",
                "p.idstatusnikah",
                "p.kewarganegaraan",
                "n.keterangan as negara",
                "p.gelar",
                "p.idwarganegara",
                "p.tempatlahir",
                "p.nokk",
                "p.email",
                "ki.keterangan as kartu_identitas",
                "p.idkartuidentitas",
                "p.noidentitas",
                "p.alamat",
                "p.notelpdarurat",
                "p.nohp",
                "p.telp",
                "p.idstatuspegawai",
                "sp.keterangan as status_pegawai",
                DB::raw("convertnumericdatetoalphabetical(tgl_masuk) as tanggal_masuk"),
                "p.tgl_masuk",
                DB::raw("convertnumericdatetoalphabetical(tgl_berakhir_kontrak) as tgl_berakhir_kontrak"),
                "p.tgl_berakhir_kontrak",
                "p.kodejabfung",
                "p.tugas_tambahan",
                "jf.urai as jabatan_fungsional",
                "p.kodestruktural",
                "js.urai as jabatan_struktural",
                "p.prodi",
                "p.namasekolah",
                "p.tahun_lulus",
                "p.kodependidikan",
                "pen.keterangan as pendidikan",
                "p.fullpath",
                "p.gambar",
                "p.foto_npwp",
                "p.foto_bpjs_kesehatan",
                "p.foto_bpjs_ketenagakerjaan",
                "p.dok_pakta_integritas",
                "p.dok_surat_perjanjian_kerja",
                "p.dok_hasil_test",
                "p.dok_hasil_interview",
                "p.dok_ijazah",
                "p.dok_transkrip_nilai",
                "p.nama_kepala_keluarga",
                "p.nama_keluarga_darurat",
                "p.telp_keluarga_darurat",
                DB::raw("
                    (
                        select
                            json_agg(
                                json_build_object(
                                    'nama',nama,
                                    'hubungan', hubungan,
                                    'tempatlahir', tempatlahir,
                                    'tgllahir',tgllahir,
                                    'tgllahir_view',convertnumericdatetoalphabetical(tgllahir),
                                    'telp',telp,
                                    'alamat',alamat
                                )
                            )
                        from applications.keluarga k
                        where nopeg = p.nopeg
                    ) keluarga
                "),
                DB::raw("
                    (
                        select
                            json_agg(
                                json_build_object(
                                    'nomor_sertifikat',nomor_sertifikat,
                                    'idjenissertifikat',idjenissertifikat,
                                    'jenissertifikat',j.urai,
                                    'lembaga_penyelenggara',lembaga_penyelenggara,
                                    'tahun',tahun,
                                    'biaya',biaya,
                                    'jenisbiaya', b.urai
                                )
                            )
                        from applications.sertifikat k
                        join masters.jenis_sertifikat as j on j.id = k.idjenissertifikat
                        join masters.biaya as b on b.id = k.idjenisbiaya
                        where nopeg = p.nopeg
                    ) cert
                "),
                DB::raw("
                    (
                        select
                            json_agg(
                                json_build_object(
                                    'dari_tahun',dari_tahun,
                                    'sampai_tahun',sampai_tahun,
                                    'jabatan',jabatan,
                                    'paklaring',paklaring
                                )
                            )
                        from applications.pengalaman_kerja k
                        where nopeg = p.nopeg
                    ) data_pengalaman_kerja
                "),
                DB::raw("
                    (
                        select
                            json_agg(
                                json_build_object(
                                    'anak_ke',anak_ke,
                                    'jenjangpendidikan', pen.keterangan,
                                    'jenis_biaya_pendidikan',jenis_biaya_pendidikan,
                                    'besaran_dispensasi',besaran_dispensasi
                                )
                            )
                        from applications.biaya_pendidikan_anak k
                        join masters.pendidikan as pen on k.idjenjangpendidikan = pen.kodependidikan
                        where nopeg = p.nopeg
                    ) data_biaya_pendidikan_anak
                "),
                DB::raw("concat(concat_ws('.',bid.kodebidang,bid.kodedivisi,bid.kodesubdivisi,bid.kodesubsubdivisi), ' - ', bid.urai) as organisasi"),
                'kompetensi_hard_skill',
                'kompetensi_soft_skill',
                'biaya_tempat_tinggal_pertahun',
                'jumlah_beras_kg',
                'merk_kendaraan',
                'biaya_beasiswa_per_semester',
                'tahun_kendaraan'
            )->where('nopeg', $id)
            ->join('masters.agama as a', 'a.id', '=', 'p.idagama')
            ->join('masters.statusnikah as sn', 'sn.idstatusnikah', '=', 'p.idstatusnikah')
            ->join('masters.negara as n', 'n.id', '=', 'p.idwarganegara')
            ->join('masters.kartuidentitas as ki', 'ki.id', '=', 'p.idkartuidentitas')
            ->join('masters.statuspegawai as sp', 'sp.idstatuspegawai', '=', 'p.idstatuspegawai')
            ->join('masters.jabatanfungsional as jf', 'jf.kodejabatanfungsional', '=', 'p.kodejabfung')
            ->join('masters.jabatanstruktural as js', 'js.kodejabatanstruktural', '=', 'p.kodestruktural')
            ->join('masters.pendidikan as pen', 'pen.kodependidikan', '=', 'p.kodependidikan')
            ->join('masters.bidang as bid', 'bid.id', '=', 'p.idbidang')
            ->first();

        if (empty($pegawai)) return redirect()->route('karyawan.index');

        $statusnikah = StatusNikah::all();
        $statuspegawai = StatusPegawai::all();
        $pendidikan = Pendidikan::all();
        $negara = Negara::all();
        $kartuidentitas = KartuIdentitas::all();
        $agama = Agama::all();

        $keluarga = empty($pegawai->keluarga) ? [] : json_decode($pegawai->keluarga);
        $sertifikat = empty($pegawai->cert) ? [] : json_decode($pegawai->cert);
        $pengalamankerja = empty($pegawai->data_pengalaman_kerja) ? [] : json_decode($pegawai->data_pengalaman_kerja);
        $biayapendidikananak = empty($pegawai->data_biaya_pendidikan_anak) ? [] : json_decode($pegawai->data_biaya_pendidikan_anak);

        return view('karyawan.edit.index', compact('id', 'biayapendidikananak', 'pengalamankerja', 'sertifikat', 'keluarga', 'pegawai', 'statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas', 'agama'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {

            $post = request()->all();

            $id = $post['nopeg_lama'];
            unset($post['nopeg_lama']);
            if (array_key_exists("tgl_lahir", $post)) $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
            if (!array_key_exists("kodestruktural", $post) || empty($post['kodestruktural'])) $post['kodestruktural'] = 0;
            if (!array_key_exists("kodejabfung", $post) || empty($post['kodejabfung'])) $post['kodejabfung'] = 0;

            if (array_key_exists("organisasi", $post)) {
                $bidangColumn = [
                    'kodebidang',
                    'kodedivisi',
                    'kodesubdivisi',
                    'kodesubsubdivisi'
                ];
                $bidang = explode(".", substr($post['organisasi'], 0, 7));

                $queryBidang = Bidang::query();
                for ($i = 0; $i < count($bidang); $i++) {
                    $queryBidang->where($bidangColumn[$i], $bidang[$i]);
                }

                $dataBidang = $queryBidang->get()->toArray();
                if (empty($dataBidang)) throw new Exception("Bidang tidak ditemukan!", 1);
                $dataBidang = $dataBidang[0];

                $post['idbidang'] = $dataBidang['id'];
            }

            if (isset($post['namakeluarga'])) {
                Keluarga::where('nopeg', $id)->delete();
                foreach ($post['namakeluarga'] as $key => $value) {
                    $insertkeluarga = [
                        'nopeg' => $id,
                        'nama' => $value,
                        'hubungan' => $post['hubungankeluarga'][$key],
                        'tempatlahir' => $post['tempatlahirkeluarga'][$key],
                        'tgllahir' => $post['tgllahirkeluarga'][$key],
                        'telp' => $post['telpkeluarga'][$key],
                        'alamat' => $post['alamatkeluarga'][$key]
                    ];
                    Keluarga::create($insertkeluarga);
                }
            } else {
                Pegawai::find($id)->update($post);
            }

            $this->activity("Edit data karyawan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data karyawan gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function upload()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $pegawai = Pegawai::find($post['idpegawai']);
            Storage::delete($pegawai->fullpath);

            $path = Storage::putFile('public/pegawai', $post['gambar']);

            $id = $post['idpegawai'];
            unset($post['idpegawai']);
            unset($post['gambar']);
            $post['fullpath'] = $path;
            $post['gambar'] = basename($path);

            Pegawai::find($id)->update($post);

            DB::commit();

            $response = [
                'message' => 'Upload foto karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Upload foto karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Upload foto karyawan gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
