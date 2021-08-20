<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acara';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_acara';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_acara', 'slug_acara', 'kategori_acara', 'deskripsi_acara', 'gambar_acara', 'tempat_acara', 'tanggal_acara_from', 'tanggal_acara_to', 'acara_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}