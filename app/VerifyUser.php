<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Tugger\User', 'user_id');
    }

}
