<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigUmum extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications.konfigumum';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idkonfigumum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idkonfig',
        'masuk',
        'pulang',
        'lokasidef',
        'masukpuasa',
        'pulangpuasa',
        'tanggalawalpuasa',
        'tanggalakhirpuasa',
        'defcuti',
        'harilibur',
        'radius'
    ];
}
