<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'komisi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_komisi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_sponsor', 'komisi_hasil', 'komisi_aktivasi', 'komisi_status', 'komisi_proof', 'masuk_ke_saldo', 'komisi_at', 'inv_komisi'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}