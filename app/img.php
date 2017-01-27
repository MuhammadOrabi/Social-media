<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class img extends Model
{
    
    public function info()
    {
        return $this->belongsTo('App\info');
    }
    
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
