<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    // realtion
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
