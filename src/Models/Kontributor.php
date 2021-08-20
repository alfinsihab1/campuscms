<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Kontributor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontributor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kontributor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kontributor', 'slug'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
