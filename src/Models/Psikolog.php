<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'psikolog';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_psikolog';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_psikolog', 'kategori_psikolog', 'kode_psikolog', 'alamat_psikolog', 'nomor_telepon_psikolog', 'instagram_psikolog', 'psikolog_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}