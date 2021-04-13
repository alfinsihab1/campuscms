<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Karir extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'karir';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_karir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'karir_title', 'karir_permalink', 'karir_gambar', 'karir_url', 'konten', 'author', 'karir_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
