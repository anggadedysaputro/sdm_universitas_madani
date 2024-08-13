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
        'idbidang'
    ];
}
