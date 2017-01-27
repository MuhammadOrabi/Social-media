<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    public function user()
    {
        return $this->belongsTo('App\user');
    }
    
    public function img()
    {
        return $this->hasOne('App\img');
    }
    
    
    public function profile()
    {
        return $this->belongsTo('App\profile');
    }
}
