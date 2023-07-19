<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (auth()->attempt($credentials)) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
