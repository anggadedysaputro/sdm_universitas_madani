<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'masters.statuspegawai';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idstatuspegawai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idstatuspegawai',
        'keterangan',
    ];
}
