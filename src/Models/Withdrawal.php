<?php

namespace Ajifatur\FaturCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'withdrawal';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_withdrawal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_rekening', 'nominal', 'withdrawal_status', 'withdrawal_success_at', 'withdrawal_proof', 'withdrawal_at', 'inv_withdrawal'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}