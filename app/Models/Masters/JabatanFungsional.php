<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanFungsional extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'masters.jabatanfungsional';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kodejabatanfungsional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'urai',
    ];
}
