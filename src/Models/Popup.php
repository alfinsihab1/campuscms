<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'popup';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_popup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'popup_judul', 'popup_tipe', 'popup', 'popup_konten', 'popup_from', 'popup_to', 'popup_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
