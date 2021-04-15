<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_folder', 'id_user', 'file_nama', 'file_kategori', 'file_deskripsi', 'file_konten', 'file_keterangan', 'file_thumbnail', 'file_at', 'file_up',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}