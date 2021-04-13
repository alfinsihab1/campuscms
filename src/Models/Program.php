<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_program';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_title', 'program_permalink', 'program_gambar', 'program_kategori', 'konten', 'author', 'program_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
