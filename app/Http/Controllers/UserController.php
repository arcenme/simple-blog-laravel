<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return redirect()->back();
    }
}
