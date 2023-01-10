<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Html\Editor\Fields\Boolean;

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

    public static function updateProfile($payload): void
    {
        User::where('id', auth()->id())
            ->update($payload);
    }

    public static function updatePassword($password): void
    {
        User::where('id', auth()->id())
            ->update(['password' => Hash::make($password)]);
    }

    public static function checkPassword($password): Bool
    {
        $isValid = Hash::check($password, auth()->user()->password);

        return $isValid;
    }
}
