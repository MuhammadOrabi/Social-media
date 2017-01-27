<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function posts()
    {
        return $this->hasMany('App\post');
    }
    
    
    public function comments()
    {
        return $this->hasMany('App\comment');
    }
    
    public function imgs()
    {
        return $this->hasMany('App\img');
    }
    
    public function info()
    {
        return $this->hasOne('App\info');
    }
    
    public function profile()
    {
        return $this->hasOne('App\profile');
    }
    
    public function follow()
    {
        return $this->hasMany('App\follow');
    }
    
    
}
