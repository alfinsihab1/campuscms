<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'komentar';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_komentar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_artikel', 'komentar', 'komentar_parent', 'komentar_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
