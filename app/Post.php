<?php

namespace Tugger;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('Tugger\User');
    }


    public function get_date_info()
    {
        return $this->created_at->toDateString();
    }

    public function likes()
    {
        return $this->hasMany('Tugger\Like');
    }
}
