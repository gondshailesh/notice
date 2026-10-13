<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return [$field => $request->login, 'password' => $request->password];
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * After login: admin → /admin/dashboard, student → /dashboard
     */
    protected function redirectTo()
    {
        if (Auth::user()->isAdmin()) {
            return '/admin/dashboard';
        }
        return '/dashboard';
    }

    /**
     * After logout: go to welcome page.
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('welcome');
    }
}