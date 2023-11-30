<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusIjin extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'masters.statusijin';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idstatusijin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idstatusijin',
        'keterangan',
    ];
}
