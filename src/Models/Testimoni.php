<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testimoni';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_testimoni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_klien', 'profesi_klien', 'foto_klien', 'testimoni', 'order_testimoni',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
