<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications.pegawai';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nopeg';

    protected $casts = [
        'nopeg' => 'string', // ini biar Laravel tetep baca nopeg sebagai string
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nopeg',
        'nama',
        'tempatlahir',
        'tgl_lahir',
        'idagama',
        'alamat',
        'telp',
        'noidentitas',
        'gol_darah',
        'rekbank',
        'tgl_masuk',
        'aktif',
        'idstatuspegawai',
        'idstatusnikah',
        'email',
        'jns_kel',
        'npwp',
        'kodejabfung',
        'kodestruktural',
        'kodependidikan',
        'tahun_lulus',
        'namasekolah',
        'prodi',
        'nokk',
        'notelpdarurat',
        'namakeluargadarurat',
        'hubdarurat',
        'nohp',
        'idkartuidentitas',
        'kewarganegaraan',
        'idwarganegara',
        'no_bpjs_ketenagakerjaan',
        'tgl_bpjs_ketenagakerjaan',
        'no_bpjs_kesehatan',
        'tgl_bpjs_kesehatan',
        'fullpath',
        'gambar',
        'idbidang',
        'alamat_domisili',
        'nama_kepala_keluarga',
        'nama_keluarga_darurat',
        'telp_keluarga_darurat',
        'tgl_berakhir_kontrak',
        'masa_bakti',
        'tugas_tambahan',
        'dok_surat_perjanjian_kerja',
        'dok_pakta_integritas',
        'dok_hasil_test',
        'dok_hasil_interview',
        'gelar',
        'dok_ijazah',
        'dok_transkrip_nilai',
        'foto_npwp',
        'foto_bpjs_kesehatan',
        'foto_bpjs_ketenagakerjaan',
        'kompetensi_hard_skill',
        'kompetensi_soft_skill',
        'biaya_tempat_tinggal_pertahun',
        'jumlah_beras_kg',
        'merk_kendaraan',
        'nama_lembaga_beasiswa_pendidikan',
        'biaya_beasiswa_per_semester',
        'tahun_kendaraan',
        'nama_panggilan',
        "isreguler",
        "token_id",
        "isdosen",
        "nuptk"
    ];

    public function getFotoNpwpUrlAttribute()
    {
        if ($this->foto_npwp) {
            return Storage::disk('s3')->url("foto_npwp" . DIRECTORY_SEPARATOR . $this->foto_npwp);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getFotoBpjsKesehatanUrlAttribute()
    {
        if ($this->foto_bpjs_kesehatan) {
            return Storage::disk('s3')->url("foto_bpjs_kesehatan" . DIRECTORY_SEPARATOR . $this->foto_bpjs_kesehatan);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getFotoBpjsKetenagakerjaanUrlAttribute()
    {
        if ($this->foto_bpjs_ketenagakerjaan) {

            return Storage::disk('s3')->url("foto_bpjs_ketenagakerjaan" . DIRECTORY_SEPARATOR . $this->foto_bpjs_ketenagakerjaan);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokSuratPerjanjianKerjaUrlAttribute()
    {
        if ($this->dok_surat_perjanjian_kerja) {
            return Storage::disk('s3')->url("dok_surat_perjanjian_kerja" . DIRECTORY_SEPARATOR . $this->dok_surat_perjanjian_kerja);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokPaktaIntegritasUrlAttribute()
    {
        if ($this->dok_pakta_integritas) {
            return Storage::disk('s3')->url("dok_pakta_integritas" . DIRECTORY_SEPARATOR . $this->dok_pakta_integritas);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokHasilTestUrlAttribute()
    {
        if ($this->dok_hasil_test) {
            return Storage::disk('s3')->url("dok_hasil_test" . DIRECTORY_SEPARATOR . $this->dok_hasil_test);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokHasilInterviewUrlAttribute()
    {
        if ($this->dok_hasil_interview) {
            return Storage::disk('s3')->url("dok_hasil_interview" . DIRECTORY_SEPARATOR . $this->dok_hasil_interview);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokIjazahUrlAttribute()
    {
        if ($this->dok_ijazah) {
            return Storage::disk('s3')->url("dok_ijazah" . DIRECTORY_SEPARATOR . $this->dok_ijazah);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getDokTranskripNilaiUrlAttribute()
    {
        if ($this->dok_transkrip_nilai) {
            return Storage::disk('s3')->url("dok_transkrip_nilai" . DIRECTORY_SEPARATOR . $this->dok_transkrip_nilai);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return Storage::disk('s3')->url("foto_pegawai" . DIRECTORY_SEPARATOR . $this->gambar);
        }

        // Jika kosong, bisa return null atau default image
        return null;
    }
}
