<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'halaman';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_halaman';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'halaman_title', 'halaman_permalink', 'halaman_tipe', 'konten', 'halaman_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
