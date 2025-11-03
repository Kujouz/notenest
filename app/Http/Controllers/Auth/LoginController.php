<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/dashboard';

    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return '/admin'; // ✅ Admin dashboard
        } elseif ($user->role === 'teacher') {
            return '/dashboard'; // ✅ Teacher page
        } else {
            return '/dashboard'; // ✅ Student page
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    public function logout(Request $request)
{
    Auth::logout(); //kill session
    $request->session()->invalidate(); //invalidate session
    $request->session()->regenerateToken(); //csrf token

    return redirect('/login'); //go to login page
}
}
