<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\AdminRegistratorController;


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


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

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

Route::middleware(['auth:web'])->prefix('customer')->group(function () {
    Route::get('/home', function () {
        return view('customer.home');
    })->name('customer.home');

    Route::get('/my_page', [MyPageController::class, 'myPage'])->name('customer.my_page');
    Route::get('/my_page/{id}/edit_page', [MyPageController::class, 'editMyPage'])->name('customer.edit_page');
    Route::put('/my_page/{id}', [MyPageController::class, 'updateMyPage'])->name('customer.update_page');
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/home', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/new', [MemberController::class, 'new'])->name('member.new');
    Route::post('/member', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');

    Route::get('/customer', [UserController::class, 'index'])->name('customer.index');
    Route::get('/customer/new', [UserController::class, 'new'])->name('customer.new');
    Route::post('/customer', [UserController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}/edit', [UserController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{id}', [UserController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{id}', [UserController::class, 'destroy'])->name('customer.destroy');

    Route::get('/registrator', [AdminRegistratorController::class, 'index'])->name('registrator.index');
    Route::get('/registrator/create', [AdminRegistratorController::class, 'create'])->name('registrator.create');
    Route::post('/registrator', [AdminRegistratorController::class, 'store'])->name('registrator.store');
});



Route::get('/{any}', function() {
    return redirect()->route('login');
})->where('any', '.*');

