<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Emel atau kata laluan tidak sah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isPPP()) {
            return view('ppp.dashboard');
        } elseif ($user->isPPK()) {
            return view('ppk.dashboard');
        } elseif ($user->isPYD()) {
            return view('pyd.dashboard');
        }
        
        return redirect('/');
    }
}