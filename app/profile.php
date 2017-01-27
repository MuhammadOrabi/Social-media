<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\user');
    }
    
    public function follow()
    {
        return $this->hasMany('App\follow');
    }
    
    public function img()
    {
        return $this->hasOne('App\img');
    }
    
    public function posts()
    {
        return $this->hasMany('App\post');
    }
}
