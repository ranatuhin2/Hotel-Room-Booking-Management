<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() 
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request) 
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors(['email' => 'Invalid credentials']); 
        }

        return redirect()->route('dashboard');  
    }

    public function showRegister() 
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) 
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }


    public function dashboard()
    {
        return view('dashboard');
    }


    public function logout() 
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
