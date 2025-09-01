<?php

namespace App\Http\Controllers\Karyawan\Add;

use App\Http\Controllers\Controller;
use App\Models\Applications\BiayaPendidikanAnak;
use App\Models\Applications\Keluarga;
use App\Models\Applications\Pegawai;
use App\Models\Applications\PengalamanKerja;
use App\Models\Applications\Sertifikat;
use App\Models\Masters\Agama;
use App\Models\Masters\Bidang;
use App\Models\Masters\GolonganDarah;
use App\Models\Masters\KartuIdentitas;
use App\Models\Masters\Negara;
use App\Models\Masters\Pendidikan;
use App\Models\Masters\StatusNikah;
use App\Models\Masters\StatusPegawai;
use App\Models\User;
use App\Traits\Logger\TraitsLoggerActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class KaryawanAdd extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $statusnikah = StatusNikah::all();
        $statuspegawai = StatusPegawai::all();
        $pendidikan = Pendidikan::all();
        $negara = Negara::all();
        $kartuidentitas = KartuIdentitas::all();
        $agama = Agama::all();
        $golongan_darah = GolonganDarah::all();
        return view('karyawan.add.index', compact('statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas', 'agama', 'golongan_darah'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $post['biaya_beasiswa_per_semester'] = numericFormatToNormalFormat($post['biaya_beasiswa_per_semester']);
            $post['biaya_tempat_tinggal_pertahun'] = numericFormatToNormalFormat($post['biaya_tempat_tinggal_pertahun']);

            if (Pegawai::where("nopeg", $post['nopeg'])->exists()) throw new Exception("Nomor NIPY sudah ada", 1);

            $bidangColumn = [
                'kodebidang',
                'kodedivisi',
                'kodesubdivisi',
                'kodesubsubdivisi'
            ];
            $bidang = explode(".", substr($post['organisasi'], 0, 7));

            $queryBidang = Bidang::query();
            for ($i = 0; $i < count($bidang); $i++) {
                $queryBidang->where($bidangColumn[$i], empty($bidang[$i]) ? 0 : $bidang[$i]);
            }

            $dataBidang = $queryBidang->get()->toArray();
            if (empty($dataBidang)) throw new Exception("Bidang tidak ditemukan!", 1);
            $dataBidang = $dataBidang[0];

            if (Pegawai::where('email', $post['email'])->exists()) throw new Exception("Email sudah digunakan !", 1);
            if (array_key_exists("agama", $post)) $post['idagama'] = $post['agama'] ?? 0;
            if (!array_key_exists("kodejabfung", $post)) $post['kodejabfung'] = empty($post['kodejabfung']) ? 0 : $post['kodejabfung'];
            if (!array_key_exists("kodestruktural", $post)) $post['kodestruktural'] = empty($post['kodestruktural']) ? 0 : $post['kodestruktural'];
            $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
            $post['tgl_masuk'] = convertGeneralDate($post['tgl_masuk']);
            $post['tgl_berakhir_kontrak'] = convertGeneralDate($post['tgl_berakhir_kontrak']);
            $post['idbidang'] = $dataBidang['id'];

            // foto profile
            if ($post['gambar'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/pegawai'));
                $path = Storage::putFile('public/pegawai', $post['gambar']);
                unset($post['gambar']);
                $post['fullpath'] = $path;
                $post['gambar'] = basename($path);
            }

            // foto npwp
            if ($post['foto_npwp'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_npwp'));
                $filename = uniqid() . ".jpg";
                Storage::put('public/foto_npwp/' . $filename, Image::make($post['foto_npwp'])->encode("jpg", 40));
                $post['foto_npwp'] = $filename;
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
            } else {
                unset($post['foto_bpjs_kesehatan']);
            }

            // foto bpjs ketenagakerjaan
            if ($post['foto_bpjs_ketenagakerjaan'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_bpjs_ketenagakerjaan'));
                $filename = uniqid() . ".jpg";
                Storage::put('public/foto_bpjs_ketenagakerjaan/' . $filename, Image::make($post['foto_bpjs_ketenagakerjaan'])->encode("jpg", 40));
                $post['foto_bpjs_ketenagakerjaan'] = $filename;
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

            // make user
            $user = [
                "name" => $post['nama'],
                "email" => $post['nopeg'],
                "password" => bcrypt($post['nopeg']),
                "telpon" => $post['nohp'],
                "nopeg" => $post['nopeg'],
                "passwordapi" => md5($post['nopeg'] . md5($post['nopeg'])),
            ];

            Pegawai::create($post);

            // yang butuh one to many
            $this->insertKeluarga($post);
            $this->insertSertifikat($post);
            $this->insertPengalamanKerja($post);
            $this->insertBiayaPendidikanAnak($post);
            // end yang butuh one to many

            $user = User::create($user);
            $user->assignRole('pegawai');

            $this->activity("Input data karyawan [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data karyawan berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data karyawan [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data karyawan gagal", $th)
            ];

            return response()->json($response, 500);
        }
    }

    public function insertBiayaPendidikanAnak($post)
    {
        $anak_ke = isset($post["anak_ke"]) ? $post["anak_ke"] : [];
        $jenjang_pendidikan = isset($post["idjenjangpendidikan"]) ? $post["idjenjangpendidikan"] : [];
        $jenis_biaya_pendidikan = isset($post["jenis_biaya_pendidikan"]) ? $post["jenis_biaya_pendidikan"] : [];
        $besaran_dispensasi = isset($post["besaran_dispensasi"]) ? $post["besaran_dispensasi"] : [];

        BiayaPendidikanAnak::where("nopeg", $post['nopeg'])->delete();

        foreach ($anak_ke as $key => $value) {
            $insert = [
                'nopeg' => $post['nopeg'],
                'anak_ke' => $value,
                'idjenjangpendidikan' => $jenjang_pendidikan[$key],
                'jenis_biaya_pendidikan' => $jenis_biaya_pendidikan[$key],
                'besaran_dispensasi' => numericFormatToNormalFormat($besaran_dispensasi[$key])
            ];
            BiayaPendidikanAnak::create($insert);
        }
    }

    public function insertKeluarga($post)
    {
        $namaKeluarga = isset($post["namakeluarga"]) ? $post["namakeluarga"] : [];
        $hubunganKeluarga = isset($post["hubungankeluarga"]) ? $post["hubungankeluarga"] : [];
        $tempatlahirKeluarga = isset($post["tempatlahirkeluarga"]) ? $post["tempatlahirkeluarga"] : [];
        $tgllahirKeluarga = isset($post["tgllahirkeluarga"]) ? $post["tgllahirkeluarga"] : [];
        $telpKeluarga = isset($post['telpkeluarga']) ? $post['telpkeluarga'] : [];
        $alamatKeluarga = isset($post['alamatkeluarga']) ? $post['alamatkeluarga'] : [];

        Keluarga::where("nopeg", $post['nopeg'])->delete();

        foreach ($namaKeluarga as $key => $value) {
            $insert = [
                'nopeg' => $post['nopeg'],
                'nama' => $value,
                'hubungan' => $hubunganKeluarga[$key],
                'tempatlahir' => $tempatlahirKeluarga[$key],
                'telp' => $telpKeluarga[$key],
                'alamat' => $alamatKeluarga[$key]
            ];

            if (!empty($tgllahirKeluarga[$key])) $insert['tgllahir'] = $tgllahirKeluarga[$key];

            Keluarga::create($insert);
        }
    }

    public function insertPengalamanKerja($post)
    {
        $dariTahun = isset($post["dari_tahun"]) ? $post["dari_tahun"] : [];
        $sampaiTahun = isset($post["sampai_tahun"]) ? $post["sampai_tahun"] : [];
        $jabatan = isset($post["jabatan"]) ? $post["jabatan"] : [];
        $paklaring = isset($post["paklaring"]) ? $post["paklaring"] : [];

        PengalamanKerja::where("nopeg", $post['nopeg'])->delete();

        foreach ($dariTahun as $key => $value) {
            $insert = [
                'nopeg' => $post['nopeg'],
                'dari_tahun' => $value,
                'sampai_tahun' => $sampaiTahun[$key],
                'jabatan' => $jabatan[$key],
                'paklaring' => $paklaring[$key]
            ];

            PengalamanKerja::create($insert);
        }
    }

    public function insertSertifikat($post)
    {
        $nomorSertifikat = isset($post["nomor_sertifikat"]) ? $post["nomor_sertifikat"] : [];
        $jenisSertifikat = isset($post["idjenissertifikat"]) ? $post["idjenissertifikat"] : [];
        $lembagaPenyelenggara = isset($post["lembaga_penyelenggara"]) ? $post["lembaga_penyelenggara"] : [];
        $tahun = isset($post["tahun"]) ? $post["tahun"] : [];
        $biaya = isset($post['biaya']) ? $post['biaya'] : [];
        $idjenisbiaya = isset($post['idjenisbiaya']) ? $post['idjenisbiaya'] : [];

        Sertifikat::where("nopeg", $post['nopeg'])->delete();

        foreach ($nomorSertifikat as $key => $value) {
            $insert = [
                'nopeg' => $post['nopeg'],
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
}
