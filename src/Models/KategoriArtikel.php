<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriArtikel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kategori_artikel';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ka';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kategori', 'slug'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
