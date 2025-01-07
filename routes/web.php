<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->get('/', function () {
    return view('home');
})->name('home');


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/login', [LoginController::class, 'index'])->name('login'); 
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->only('id', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
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
