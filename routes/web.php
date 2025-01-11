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

    // if (Auth::guard('web')->attempt($credentials)) {
    //     return redirect()->route('home')->with('success', 'Logged in as User');
    // }
    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::user();

        if (!$user->verified) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Please verify your email before logging in.',
            ]);
        }

        return redirect()->route('home')->with('success', 'Logged in as User');
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

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

// Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
//     Route::get('/home', function () {
//         return view('admin.home');
//     })->name('admin.home');

//     Route::get('/home_child', function () {
//         return view('admin.home_child', ['content' => 'home_child']);
//     })->name('home_child.index');

//     Route::get('/member', [MemberController::class, 'index'])->name('member.index');
//     Route::resource('members', MemberController::class)->only([
//         'index', 'store', 'edit', 'update', 'destroy'
//     ]);
//     Route::get('members/new', [MemberController::class, 'new'])->name('members.new');


//     Route::get('/customer', function () {
//         return view('admin.customer', ['content' => 'customer']);
//     })->name('customer.index');
// });

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/home', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/member', [UserController::class, 'index'])->name('member.index');
    Route::get('/member/new', [UserController::class, 'new'])->name('member.new');
    Route::post('/member', [UserController::class, 'store'])->name('member.store');
    Route::get('/member/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
    Route::put('/member/{id}', [UserController::class, 'update'])->name('member.update');
    Route::delete('/member/{id}', [UserController::class, 'destroy'])->name('member.destroy');

    Route::get('/customer', function () {
        return view('admin.customer', ['content' => 'customer']);
    })->name('customer.index');
});


Route::get('/{any}', function() {
    return redirect()->route('login');
})->where('any', '.*');

