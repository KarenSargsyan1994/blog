<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    protected $fillable = [
        'address', 'Country'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}

