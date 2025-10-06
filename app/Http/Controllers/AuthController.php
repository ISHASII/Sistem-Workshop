<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Mews\Captcha\Facades\Captcha;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function captcha()
    {
        // return captcha baru
        return response()->json(['captcha' => Captcha::create('flat')]);
    }

    public function login(LoginRequest $request)
    {
    $credentials = ['username' => $request->username, 'password' => $request->password];

        // Use Auth::attempt to leverage Laravel's authentication (handles hashing and guards)
        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['username' => 'Username atau password salah']);
        }

        // Authentication successful
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }
    // OTP methods removed

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
