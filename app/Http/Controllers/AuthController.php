<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses request login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            // Redirect based on role
            switch ($role) {
                case 'admin':
                case 'superadmin':
                    return redirect()->intended('/dashboard/superadmin');
                case 'operator':
                    return redirect()->intended('/dashboard/operator');
                case 'supplier':
                    return redirect()->intended('/dashboard/supplier');
                case 'konsumen':
                case 'staff':
                default:
                    return redirect()->intended('/dashboard/staff');
            }
        }

        return back()->withErrors([
            'email' => 'email atau kata sandi salah!',
        ])->onlyInput('email');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
