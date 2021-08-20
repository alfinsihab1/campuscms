<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platform';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_platform';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipe_platform', 'nama_platform',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
