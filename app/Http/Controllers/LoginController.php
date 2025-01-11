<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('id', $validated['id'])->first();
    
        if ($user && Hash::check($validated['password'], $user->password)) {
            if (!$user->verified) { 
                return redirect()->route('login')->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ]);
            }
    
            Auth::login($user);
            return redirect()->route('home');
        }

        $member = Member::where('id', $validated['id'])->first();

        if ($member && Hash::check($validated['password'], $member->password)) {
            if (!$member->verified) { 
                return redirect()->route('login')->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ]);
            }

            Auth::guard('member')->login($member);
            return redirect()->route('admin.home');
        }

        $admin = Admin::where('id', $validated['id'])->first();

        if ($admin && Hash::check($validated['password'], $admin->password)) {
            if (!$admin->verified) { 
                return redirect()->route('login')->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ]);
            }

            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.home');
        }
    
        return back()->withErrors([
            'id' => 'The provided credentials are incorrect.',
        ]);
    }
    



    /**
     * Display the specified resource.
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Login $login)
    {
        //
    }
}
