<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultRekening extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'default_rekening';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_dr';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_platform', 'nomor', 'atas_nama',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}