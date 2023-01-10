<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.profile.index');
    }

    public function updateProfile()
    {
        $payload =  request()->validate([
            'name' => 'bail|required|max:50',
            'email' => ['bail', 'required', 'email:rfce,dns', Rule::unique('users', 'email')->ignore(auth()->id(), 'id')],
        ]);

        // update
        UserService::updateProfile($payload);

        // return
        return redirect()->back()->with('success_profile', 'Data profile changed successfully');
    }

    public function updatePassword()
    {
        request()->validate([
            'old_password' => ['bail', 'required'],
            'new_password' => ['bail', 'required', 'same:confirm_password', Password::min(6)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'confirm_password' => ['bail', 'required', Password::min(6)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        // check current password
        $isValid =  UserService::checkPassword(request('old_password'));
        if (!$isValid)
            throw ValidationException::withMessages([
                'old_password' => "Old Password Doesn't match!"
            ]);

        // update password
        UserService::updatePassword(request('new_password'));

        // return
        return redirect()->back()->with('success_password', 'Password changed successfully');
    }
}
