<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekening';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_rekening';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_platform', 'nomor', 'atas_nama',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}