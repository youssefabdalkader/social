<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /* SHOW REGISTER */
    public function showRegister()
    {
        return view('auth.register');
    }

    /* REGISTER */
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image' => 'nullable|image|max:2048'
        ]);


        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
        ]);

        // 🔥 assign role user using Spatie
        $user->assignRole('user');

        Auth::login($user);

        return redirect('/');
    }

    /* SHOW LOGIN */
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    /* LOGIN (name + password) */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
        if (!$user->hasRole('User')) {
            return back()->withErrors(['email' => 'you are not allowed to login from here']);
        }


        Auth::login($user);

        return redirect()->route('posts.index');
    }

    /* LOGOUT */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
