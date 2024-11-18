<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

//Library
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\User;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials['giveAccess'] = true;
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $data = User::where('email', $credentials['email'])->first();
            return redirect()->intended(Auth::user()->role === 'admin' ? '/admin' : '/dashboard');
        }
        return redirect()->back()->with('status', 'Wrong Email or Password !');
    }

    public function postRegis(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => 'user'
        ]);

        $customer = Customer::create([
            'uuid' => \Str::uuid(),
            'user_id' => $user->id,
            'full_name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
        ]);

        return redirect()->route('login')->with('status', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }


}
