<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\CustomEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration of the user.
     */
    // public function store(Request $request)
    // {
    //     // Validate and create user
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'email_verification_token' => \Illuminate\Support\Str::random(32),
    //     ]);

    //     // Gửi email xác thực
    //     $mailer = new CustomEmailVerification($user);
    //     if (!$mailer->send()) {
    //         return redirect()->back()->with('error', 'Failed to send verification email.');
    //     }

    //     return redirect()->route('login')->with('success', 'Registration successful. Please check your email for verification link.');
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'country' => 'nullable|string',
            'job' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verification_token' => Str::random(32),
            'gender' => $request->gender,
            'country' => $request->country,
            'job' => json_encode($request->job),
        ]);

        $mailer = new CustomEmailVerification($user);
        if (!$mailer->send()) {
            return redirect()->back()->with('error', 'Failed to send verification email.');
        }
        

        return redirect()->route('login')->with('success', 'Registration successful. Please check your email to verify your account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
