<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'image' => 'nullable|image|max:2048',
    ]);
    $user = Auth::user();

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('users', 'public');
        $user->image = $path;
    }

    $user->save();

    return redirect()->route('posts.index');
}
}
