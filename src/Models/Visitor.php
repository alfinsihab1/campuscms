<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visitor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_visitor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'ip_address', 'visit_at', 'device', 'browser', 'platform', 'location'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
