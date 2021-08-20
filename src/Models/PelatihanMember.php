<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan_member';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pm';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_pelatihan', 'kode_sertifikat', 'status_pelatihan', 'fee', 'fee_bukti', 'fee_status', 'inv_pelatihan', 'pm_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}