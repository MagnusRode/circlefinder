<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function index()
    {
        return redirect(route('profile.password.edit'));
    }

    public function edit(Request $request)
    {
        return view('profile.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!(Hash::check($request->get('current_password'), $user->password)))
        {
            return redirect()->back()->withErrors("Provided password does not match with your current password");
        }

        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile.show', $user->uuid)->with("success", "Your password was changed!");
    }
}
