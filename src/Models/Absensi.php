<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'absensi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'instansi', 'jurusan', 'kelas', 'absensi_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
