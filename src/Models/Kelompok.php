<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelompok';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kelompok';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kelompok', 'anggota_kelompok', 'kelompok_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
