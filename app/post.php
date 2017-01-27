<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\user');
    }
    
    public function profile()
    {
        return $this->belongsTo('App\profile');
    }
    
    public function comments()
    {
        return $this->hasMany('App\comment');
    }
    
    public function imgs()
    {
        return $this->hasMany('App\img');
    }
}
