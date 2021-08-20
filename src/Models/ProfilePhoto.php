<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_photo';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'photo_name', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}