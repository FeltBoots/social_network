<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class ExtToken extends Model
{
    protected $table = 'ext_token';

    protected $fillable = [
        'user_id', 'service', 'token',
    ];


    public function user()
    {
        return $this->belongsTo('Tugger\User', 'user_id');
    }
}
