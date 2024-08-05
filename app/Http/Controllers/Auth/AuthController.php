<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended(route('apps.dashboard'));
        } else {
            return view('cms.auth.login');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            Session::put('user', Auth::user());
            return redirect()->intended(route('apps.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Auth::logout();

        if ($user) {
            DB::table('users')->where('id', $user->id)
            ->update(['remember_token' => null, 'last_login_at' => now()]);
        }

        return redirect()->route('apps.login');
    }
}
