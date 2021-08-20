<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Deskripsi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deskripsi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_deskripsi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul_deskripsi', 'deskripsi',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}