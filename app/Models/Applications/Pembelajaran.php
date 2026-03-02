<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    protected $table = 'applications.pembelajaran';

    protected $primaryKey = 'id';

    public $incrementing = false; // karena id BIGINT dan tidak ada auto increment di DDL
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nopeg',
        'ajar',
        'sks',
        'terpenuhi',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'ajar' => 'integer',
        'sks' => 'integer',
        'terpenuhi' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
