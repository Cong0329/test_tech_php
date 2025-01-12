<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/email/verify', function (Request $request) {
    $token = $request->query('token');

    $user = DB::table('users')->where('email_verification_token', $token)->first();

    if (!$user) {
        return response('Invalid or expired token.', 400);
    }

    DB::table('users')->where('id', $user->id)->update([
        'verified' => true,
        'email_verified_at' => now(),
        'email_verification_token' => null,
    ]);

    return redirect('/login')->with('status', 'Email verified successfully!');
})->name('verification.verify');

Route::get('/login', [LoginController::class, 'index'])->name('login'); 
Route::post('/login', function (Request $request) {
    $credentials = $request->only('id', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::user();

        if (!$user->verified) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Please verify your email before logging in.',
            ]);
        }

        return redirect()->route('customer.home')->with('success', 'Logged in as User');
    }

    if (Auth::guard('member')->attempt($credentials)) {
        return redirect()->route('admin.home')->with('success', 'Logged in as Member');
    }    


    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->route('admin.home')->with('success', 'Logged in as Admin');
    }

    return back()->withErrors([
        'id' => 'The provided credentials do not match our records.',
    ]);
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
