<?php

namespace Tugger;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'date_of_birth', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifyUser()
    {
        return $this->hasOne('Tugger\VerifyUser');
    }

    public function posts()
    {
        return $this->hasMany('Tugger\Post');
    }

    public function likes()
    {
        return $this->hasMany('Tugger\Like');
    }

}
