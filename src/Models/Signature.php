<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'signature';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_signature';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'signature', 'signature_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
