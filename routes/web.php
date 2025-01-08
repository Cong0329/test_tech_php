<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::middleware(['auth'])->get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Route xác thực email
Route::get('/email/verify', function (Request $request) {
    $token = $request->query('token');

    // Kiểm tra token trong DB
    $user = DB::table('users')->where('email_verification_token', $token)->first();

    if (!$user) {
        return response('Invalid or expired token.', 400);
    }

    // Cập nhật trạng thái xác thực email
    DB::table('users')->where('id', $user->id)->update([
        'verified' => true, // Cập nhật verified thành true
        'email_verified_at' => now(), // Cập nhật thời gian xác thực
        'email_verification_token' => null, // Xóa token sau khi xác thực
    ]);

    return redirect('/login')->with('status', 'Email verified successfully!');
})->name('verification.verify');


// Thêm middleware 'auth' và 'verified' vào các route yêu cầu xác thực email
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
            Auth::logout(); // Đăng xuất nếu email chưa được xác thực
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

Route::middleware(['auth:admin'])->get('/admin/home', function () {
    return view('admin.home');
})->name('admin.home');
