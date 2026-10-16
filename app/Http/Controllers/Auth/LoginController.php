<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect after normal user login.
     */
    protected string $redirectTo = '/home';

    /**
     * Where to redirect after admin login.
     */
    protected string $adminRedirectTo = '/admin/dashboard';

    /* ════════════════════════════════════════════════════════
       STUDENT LOGIN
       ════════════════════════════════════════════════════════ */

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $creds = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($creds['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $creds['login'], 'password' => $creds['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            /* ✅ Redirect everyone to the notice board */
            return redirect()->intended($this->redirectTo)
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()
            ->withErrors(['login' => 'Invalid credentials.'])
            ->onlyInput('login');
    }

    /* ════════════════════════════════════════════════════════
       ADMIN LOGIN
       ════════════════════════════════════════════════════════ */

    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $creds = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($creds['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $creds['login'], 'password' => $creds['password']], $request->boolean('remember'))) {

            /* ── Only allow admins here ── */
            if (Auth::user()->role != 1) {
                Auth::logout();
                return back()
                    ->withErrors(['login' => 'Not an admin account. Use the student login.'])
                    ->onlyInput('login');
            }

            $request->session()->regenerate();

            return redirect()->intended($this->adminRedirectTo)
                ->with('success', 'Welcome, Admin!');
        }

        return back()
            ->withErrors(['login' => 'Invalid admin credentials.'])
            ->onlyInput('login');
    }

    /* ════════════════════════════════════════════════════════
       LOGOUT
       ════════════════════════════════════════════════════════ */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}