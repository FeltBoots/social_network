<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class ExtAuthCode extends Model
{
    protected $table = 'ext_auth_code';

    protected $fillable = [
        'user_id', 'service', 'auth_code',
    ];


    public function user()
    {
        return $this->belongsTo('Tugger\User', 'user_id');
    }
}
