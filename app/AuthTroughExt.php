<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class AuthTroughExt extends Model
{
    protected $table = 'authorization_trough_external';

    protected $fillable = [
        'user_id', 'service_id', 'ext_user_id', 'token',
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
