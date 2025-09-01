<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications.cuti';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nopeg',
        'tgl_awal',
        'tgl_akhir',
        'keterangan',
        'jumlah',
        'sisa',
        'approval',
        'approval_sdm',
        'nopeg_atasan',
        'lampiran',
        'approval_at',
        'approval_sdm_at'
    ];
}
