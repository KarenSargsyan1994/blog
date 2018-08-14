<?php

namespace App;

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

    public function details()
    {
        return $this->hasOne(Details::class, 'user_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Projects::class, 'user_id', 'id');

    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'user_id', 'id');

    }
}