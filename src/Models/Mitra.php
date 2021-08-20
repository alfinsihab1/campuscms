<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mitra';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_mitra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_mitra', 'logo_mitra', 'order_mitra',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}