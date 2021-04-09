<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slider';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_slider';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slider', 'slider_url', 'status_slider', 'order_slider'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
