<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user()
    {
        return $this->belongsTo('Tugger\User');
    }

    public function post()
    {
        return $this->belongsTo('Tugger\Post');
    }
}
