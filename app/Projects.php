<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use Notifiable;


    protected $fillable = ['name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'project_id', 'id');
    }

}

