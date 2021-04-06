<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_course';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cc', 'course_nomor', 'course_judul', 'course_gambar', 'course_caption', 'course_youtube', 'course_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}