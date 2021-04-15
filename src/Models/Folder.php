<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'folder';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_folder';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'folder_nama', 'folder_kategori', 'folder_dir', 'folder_parent', 'folder_icon', 'folder_at', 'folder_up',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
