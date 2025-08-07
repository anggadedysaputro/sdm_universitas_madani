<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications.presensi';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idpresensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "nopeg",
        "tanggal",
        "waktu",
        "tahun",
        "bulan",
        "hari",
        "jam",
        "menit",
        "lokasi",
        "idkantor",
        "fullpath",
        "gambar",
        "isreguler"
    ];
}
