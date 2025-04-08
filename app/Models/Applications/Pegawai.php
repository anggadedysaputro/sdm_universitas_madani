<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'nama_panggilan',
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
    ];
}
