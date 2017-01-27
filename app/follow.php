<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class follow extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function profile()
    {
        return $this->belongsTo('App\profile');
    }
}
