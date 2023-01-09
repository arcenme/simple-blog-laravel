<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin,user')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticated()
    {
        request()->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserService::get(request('email'));
        if (!$user || !Hash::check(request('password'), $user->password))
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);

        Auth::guard($user->role->name)->loginUsingId($user->id);

        return redirect()->route('index');
    }
}
