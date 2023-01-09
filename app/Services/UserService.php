<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function get($email)
    {
        $user = User::with(['role' => function ($query) {
            return $query->select('id', 'name');
        }])->where('email', $email)
            ->first();

        return $user;
    }
}