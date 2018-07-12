<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class ExternalSocset extends Model
{
    protected $table = 'external_socseti';

    protected $fillable = [
        'service', 'url',
    ];


//    public function user()
//    {
//        return $this->belongsTo('App\User', 'user_id');
//    }

}