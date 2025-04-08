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
        return view('karyawan.add.index', compact('statusnikah', 'statuspegawai', 'pendidikan', 'negara', 'kartuidentitas', 'agama'));
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $post['biaya_per_semester'] = numericFormatToNormalFormat($post['biaya_per_semester']);
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
                $queryBidang->where($bidangColumn[$i], $bidang[$i]);
            }

            $dataBidang = $queryBidang->get()->toArray();
            if (empty($dataBidang)) throw new Exception("Bidang tidak ditemukan!", 1);
            $dataBidang = $dataBidang[0];

            if (Pegawai::where('email', $post['email'])->exists()) throw new Exception("Email sudah digunakan !", 1);
            if (array_key_exists("agama", $post)) $post['idagama'] = $post['agama'] ?? 0;
            if (!array_key_exists("kodejabfung", $post)) $post['kodejabfung'] = empty($post['kodejabfung']) ? 0 : $post['kodejabfung'];
            if (!array_key_exists("kodestruktural", $post)) $post['kodestruktural'] = empty($post['kodestruktural']) ? 0 : $post['kodestruktural'];
            $post['tgl_lahir'] = convertGeneralDate($post['tgl_lahir']);
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
                $foto_npwp = Storage::put('public/foto_npwp/' . $filename, Image::make($post['foto_npwp'])->encode("jpg", 40));
                unset($post['foto_npwp']);
                $post['foto_npwp'] = basename($foto_npwp);
            }

            // foto bpjs kesehatan
            if ($post['foto_bpjs_kesehatan'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_bpjs_kesehatan'));
                $filename = uniqid() . ".jpg";
                $foto_bpjs_kesehatan = Storage::put('public/foto_bpjs_kesehatan/' . $filename, Image::make($post['foto_bpjs_kesehatan'])->encode("jpg", 40));
                unset($post['foto_bpjs_kesehatan']);
                $post['foto_bpjs_kesehatan'] = basename($foto_bpjs_kesehatan);
            }

            // foto bpjs ketenagakerjaan
            if ($post['foto_bpjs_ketenagakerjaan'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/foto_bpjs_ketenagakerjaan'));
                $filename = uniqid() . ".jpg";
                $foto_bpjs_ketenagakerjaan = Storage::put('public/foto_bpjs_ketenagakerjaan/' . $filename, Image::make($post['foto_bpjs_ketenagakerjaan'])->encode("jpg", 40));
                unset($post['foto_bpjs_ketenagakerjaan']);
                $post['foto_bpjs_ketenagakerjaan'] = basename($foto_bpjs_ketenagakerjaan);
            }


            // Dok. Surat Penjanjian Kerja
            if ($post['dok_surat_perjanjian_kerja'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_surat_perjanjian_kerja'));
                $extension = $post['dok_surat_perjanjian_kerja']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_surat_perjanjian_kerja = Storage::put('public/dok_surat_perjanjian_kerja/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_surat_perjanjian_kerja'])->encode($extension, 40) : $post['dok_surat_perjanjian_kerja']));
                unset($post['dok_surat_perjanjian_kerja']);
                $post['dok_surat_perjanjian_kerja'] = basename($dok_surat_perjanjian_kerja);
            }

            // Dok. Pakta Integritas
            if ($post['dok_pakta_integritas'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_pakta_integritas'));
                $extension = $post['dok_pakta_integritas']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_pakta_integritas = Storage::put('public/dok_pakta_integritas/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_pakta_integritas'])->encode($extension, 40) : $post['dok_pakta_integritas']));
                unset($post['dok_pakta_integritas']);
                $post['dok_pakta_integritas'] = basename($dok_pakta_integritas);
            }

            // Dok. Hasil Test
            if ($post['dok_hasil_test'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_hasil_test'));
                $extension = $post['dok_hasil_test']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_hasil_test = Storage::put('public/dok_hasil_test/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_hasil_test'])->encode($extension, 40) : $post['dok_hasil_test']));
                unset($post['dok_hasil_test']);
                $post['dok_hasil_test'] = basename($dok_hasil_test);
            }

            // Dok. Hasil Interview
            if ($post['dok_hasil_interview'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_hasil_interview'));
                $extension = $post['dok_hasil_interview']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_hasil_interview = Storage::put('public/dok_hasil_interview/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_hasil_interview'])->encode($extension, 40) : $post['dok_hasil_interview']));
                unset($post['dok_hasil_interview']);
                $post['dok_hasil_interview'] = basename($dok_hasil_interview);
            }

            // Dok. Ijazah
            if ($post['dok_ijazah'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_ijazah'));
                $extension = $post['dok_ijazah']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_ijazah = Storage::put('public/dok_ijazah/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_ijazah'])->encode($extension, 40) : $post['dok_ijazah']));
                unset($post['dok_ijazah']);
                $post['dok_ijazah'] = basename($dok_ijazah);
            }

            // Dok. Transkrip Nilai
            if ($post['dok_transkrip_nilai'] != "undefined") {
                buatFolder(storage_path('app/' . 'public/dok_transkrip_nilai'));
                $extension = $post['dok_transkrip_nilai']->getClientOriginalExtension();
                $filename = uniqid() . "." . $extension;
                $dok_transkrip_nilai = Storage::put('public/dok_transkrip_nilai/' . $filename, ($extension == in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']) ? Image::make($post['dok_transkrip_nilai'])->encode($extension, 40) : $post['dok_transkrip_nilai']));
                unset($post['dok_transkrip_nilai']);
                $post['dok_transkrip_nilai'] = basename($dok_transkrip_nilai);
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
                'message' => message("Input data karyawan gagal", $th->getMessage())
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
                'tgllahir' => $tgllahirKeluarga[$key],
                'telp' => $telpKeluarga[$key],
                'alamat' => $alamatKeluarga[$key]
            ];
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
