<?php

namespace App\Http\Controllers\Karyawan\Edit;

use App\Http\Controllers\Controller;
use App\Models\Applications\BiayaPendidikanAnak;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Applications\PengalamanKerja;
use App\Models\Applications\Sertifikat;
use App\Models\Masters\Agama;
use App\Models\Masters\Bidang;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

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
                DB::raw("convertnumericdatetoalphabetical(tgl_berakhir_kontrak) as tgl_berakhir_kontrak_view"),
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
                                    'idjenisbiaya',idjenisbiaya,
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
                                    'idjenjangpendidikan',coalesce(idjenjangpendidikan,'0'),
                                    'jenjangpendidikan', coalesce(pen.keterangan,'Belum dipilih'),
                                    'jenis_biaya_pendidikan',jenis_biaya_pendidikan,
                                    'besaran_dispensasi',besaran_dispensasi
                                )
                            )
                        from applications.biaya_pendidikan_anak k
                        left join masters.pendidikan as pen on k.idjenjangpendidikan = pen.kodependidikan
                        where nopeg = p.nopeg
                    ) data_biaya_pendidikan_anak
                "),
                DB::raw("concat(concat_ws('.',bid.kodebidang,bid.kodedivisi,bid.kodesubdivisi,bid.kodesubsubdivisi), ' - ', bid.urai) as organisasi"),
                DB::raw("concat_ws('.',bid.kodebidang,bid.kodedivisi,bid.kodesubdivisi,bid.kodesubsubdivisi) as kodeorg"),
                'kompetensi_hard_skill',
                'kompetensi_soft_skill',
                'biaya_tempat_tinggal_pertahun',
                'jumlah_beras_kg',
                'merk_kendaraan',
                'biaya_beasiswa_per_semester',
                'tahun_kendaraan',
                "masa_bakti",
                "tugas_tambahan",
                "nama_lembaga_beasiswa_pendidikan"
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

            // dd($post);

            $id = $post['nopeg_lama'];
            unset($post['nopeg_lama']);

            $pegawaiLama = Pegawai::find($id);
            if (!$pegawaiLama) throw new Exception("Pegawai tidak ditemukan", 1);

            if (array_key_exists("tgl_lahir", $post)) $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
            if (isset($post['kodestruktural']) && (!array_key_exists("kodestruktural", $post) || empty($post['kodestruktural']))) $post['kodestruktural'] = 0;
            if (isset($post['kodejabfung']) && (!array_key_exists("kodejabfung", $post) || empty($post['kodejabfung']))) $post['kodejabfung'] = 0;
            if (isset($post['biaya_beasiswa_per_semester'])) $post['biaya_beasiswa_per_semester'] = numericFormatToNormalFormat($post['biaya_beasiswa_per_semester']);
            if (isset($post['biaya_tempat_tinggal_pertahun'])) $post['biaya_tempat_tinggal_pertahun'] = numericFormatToNormalFormat($post['biaya_tempat_tinggal_pertahun']);
            if (isset($post['jumlah_beras_kg'])) $post['jumlah_beras_kg'] = numericFormatToNormalFormat($post['jumlah_beras_kg']);

            if (array_key_exists("organisasi", $post) && !empty($post['organisasi'])) {
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

            $this->insertKeluarga($post, $id);
            $this->insertSertifikat($post, $id);
            $this->insertPengalamanKerja($post, $id);
            $this->insertBiayaPendidikanAnak($post, $id);

            // foto npwp
            if ($post['foto_npwp'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_npwp'));
                $filename = uniqid() . ".jpg";
                Storage::put('public/foto_npwp/' . $filename, Image::make($post['foto_npwp'])->encode("jpg", 40));
                $post['foto_npwp'] = $filename;
                Storage::delete('public/foto_npwp/' . $pegawaiLama->foto_npwp);
            } else {
                unset($post['foto_npwp']);
            }

            // foto bpjs kesehatan
            if ($post['foto_bpjs_kesehatan'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_bpjs_kesehatan'));
                $filename = uniqid() . ".jpg";
                Storage::put('public/foto_bpjs_kesehatan/' . $filename, Image::make($post['foto_bpjs_kesehatan'])->encode("jpg", 40));
                unset($post['foto_bpjs_kesehatan']);
                $post['foto_bpjs_kesehatan'] = $filename;
                Storage::delete('public/foto_npwp/' . $pegawaiLama->foto_bpjs_kesehatan);
            } else {
                unset($post['foto_bpjs_kesehatan']);
            }

            // foto bpjs ketenagakerjaan
            if ($post['foto_bpjs_ketenagakerjaan'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_bpjs_ketenagakerjaan'));
                $filename = uniqid() . ".jpg";
                Storage::put('public/foto_bpjs_ketenagakerjaan/' . $filename, Image::make($post['foto_bpjs_ketenagakerjaan'])->encode("jpg", 40));
                $post['foto_bpjs_ketenagakerjaan'] = $filename;
                Storage::delete('public/foto_npwp/' . $pegawaiLama->foto_bpjs_ketenagakerjaan);
            } else {
                unset($post['foto_bpjs_ketenagakerjaan']);
            }

            // Dok. Surat Penjanjian Kerja
            if ($post['dok_surat_perjanjian_kerja'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_surat_perjanjian_kerja'));
                $extension = $post['dok_surat_perjanjian_kerja']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_surat_perjanjian_kerja/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_surat_perjanjian_kerja'])->encode($extension, 40) : $post['dok_surat_perjanjian_kerja']->get()));
                $post['dok_surat_perjanjian_kerja'] = $filename;
            } else {
                unset($post['dok_surat_perjanjian_kerja']);
            }

            // Dok. Pakta Integritas
            if ($post['dok_pakta_integritas'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_pakta_integritas'));
                $extension = $post['dok_pakta_integritas']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_pakta_integritas/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_pakta_integritas'])->encode($extension, 40) : $post['dok_pakta_integritas']->get()));
                $post['dok_pakta_integritas'] = $filename;
            } else {
                unset($post['dok_pakta_integritas']);
            }

            // Dok. Hasil Test
            if ($post['dok_hasil_test'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_hasil_test'));
                $extension = $post['dok_hasil_test']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_hasil_test/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_hasil_test'])->encode($extension, 40) : $post['dok_hasil_test']->get()));
                $post['dok_hasil_test'] = $filename;
            } else {
                unset($post['dok_hasil_test']);
            }

            // Dok. Hasil Interview
            if ($post['dok_hasil_interview'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_hasil_interview'));
                $extension = $post['dok_hasil_interview']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_hasil_interview/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_hasil_interview'])->encode($extension, 40) : $post['dok_hasil_interview']->get()));
                $post['dok_hasil_interview'] = $filename;
            } else {
                unset($post['dok_hasil_interview']);
            }

            // Dok. Ijazah
            if ($post['dok_ijazah'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_ijazah'));
                $extension = $post['dok_ijazah']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_ijazah/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_ijazah'])->encode($extension, 40) : $post['dok_ijazah']->get()));
                $post['dok_ijazah'] = $filename;
            } else {
                unset($post['dok_ijazah']);
            }

            // Dok. Transkrip Nilai
            if ($post['dok_transkrip_nilai'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_transkrip_nilai'));
                $extension = $post['dok_transkrip_nilai']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                Storage::put('public/dok_transkrip_nilai/' . $filename, (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_transkrip_nilai'])->encode($extension, 40) : $post['dok_transkrip_nilai']->get()));
                $post['dok_transkrip_nilai'] = basename($filename);
            } else {
                unset($post['dok_transkrip_nilai']);
            }

            Pegawai::find($id)->update($post);

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

    public function insertKeluarga($post, $nopeg)
    {
        $namaKeluarga = isset($post["namakeluarga"]) ? $post["namakeluarga"] : [];
        $hubunganKeluarga = isset($post["hubungankeluarga"]) ? $post["hubungankeluarga"] : [];
        $tempatlahirKeluarga = isset($post["tempatlahirkeluarga"]) ? $post["tempatlahirkeluarga"] : [];
        $tgllahirKeluarga = isset($post["tgllahirkeluarga"]) ? $post["tgllahirkeluarga"] : [];
        $telpKeluarga = isset($post['telpkeluarga']) ? $post['telpkeluarga'] : [];
        $alamatKeluarga = isset($post['alamatkeluarga']) ? $post['alamatkeluarga'] : [];

        if (isset($post["namakeluarga"])) Keluarga::where("nopeg", $nopeg)->delete();

        foreach ($namaKeluarga as $key => $value) {
            $insert = [
                'nopeg' => $nopeg,
                'nama' => $value,
                'hubungan' => $hubunganKeluarga[$key],
                'tempatlahir' => $tempatlahirKeluarga[$key],
                'tgllahir' => $tgllahirKeluarga[$key],
                'telp' => $telpKeluarga[$key],
                'alamat' => $alamatKeluarga[$key]
            ];
            Keluarga::create($insert);
        }
    }

    public function insertSertifikat($post, $nopeg)
    {
        $nomorSertifikat = isset($post["nomor_sertifikat"]) ? $post["nomor_sertifikat"] : [];
        $jenisSertifikat = isset($post["idjenissertifikat"]) ? $post["idjenissertifikat"] : [];
        $lembagaPenyelenggara = isset($post["lembaga_penyelenggara"]) ? $post["lembaga_penyelenggara"] : [];
        $tahun = isset($post["tahun"]) ? $post["tahun"] : [];
        $biaya = isset($post['biaya']) ? $post['biaya'] : [];
        $idjenisbiaya = isset($post['idjenisbiaya']) ? $post['idjenisbiaya'] : [];

        if (isset($post["nomor_sertifikat"])) Sertifikat::where("nopeg", $nopeg)->delete();

        foreach ($nomorSertifikat as $key => $value) {
            $insert = [
                'nopeg' => $nopeg,
                'nomor_sertifikat' => $value,
                'idjenissertifikat' => $jenisSertifikat[$key],
                'lembaga_penyelenggara' => $lembagaPenyelenggara[$key],
                'tahun' => $tahun[$key],
                'biaya' => numericFormatToNormalFormat($biaya[$key]),
                'idjenisbiaya' => $idjenisbiaya[$key]
            ];
            Sertifikat::create($insert);
        }
    }

    public function insertPengalamanKerja($post, $id)
    {
        $dariTahun = isset($post["dari_tahun"]) ? $post["dari_tahun"] : [];
        $sampaiTahun = isset($post["sampai_tahun"]) ? $post["sampai_tahun"] : [];
        $jabatan = isset($post["jabatan"]) ? $post["jabatan"] : [];
        $paklaring = isset($post["paklaring"]) ? $post["paklaring"] : [];

        if (isset($post["dari_tahun"])) PengalamanKerja::where("nopeg", $id)->delete();

        foreach ($dariTahun as $key => $value) {
            $insert = [
                'nopeg' => $id,
                'dari_tahun' => $value,
                'sampai_tahun' => $sampaiTahun[$key],
                'jabatan' => $jabatan[$key],
                'paklaring' => $paklaring[$key]
            ];

            PengalamanKerja::create($insert);
        }
    }

    public function insertBiayaPendidikanAnak($post, $id)
    {
        $anak_ke = isset($post["anak_ke"]) ? $post["anak_ke"] : [];
        $jenjang_pendidikan = isset($post["idjenjangpendidikan"]) ? $post["idjenjangpendidikan"] : [];
        $jenis_biaya_pendidikan = isset($post["jenis_biaya_pendidikan"]) ? $post["jenis_biaya_pendidikan"] : [];
        $besaran_dispensasi = isset($post["besaran_dispensasi"]) ? $post["besaran_dispensasi"] : [];

        if (isset($post["anak_ke"])) BiayaPendidikanAnak::where("nopeg", $id)->delete();

        foreach ($anak_ke as $key => $value) {
            $insert = [
                'nopeg' => $id,
                'anak_ke' => $value,
                'idjenjangpendidikan' => $jenjang_pendidikan[$key],
                'jenis_biaya_pendidikan' => $jenis_biaya_pendidikan[$key],
                'besaran_dispensasi' => numericFormatToNormalFormat($besaran_dispensasi[$key])
            ];

            BiayaPendidikanAnak::create($insert);
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
