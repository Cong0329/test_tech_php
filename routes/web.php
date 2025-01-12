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

require __DIR__.'/auth.php';
// require __DIR__.'/admin.php';
require __DIR__.'/customer.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
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

    Route::get('/member/export', [MemberController::class, 'exportCSV'])->name('member.export');
    Route::get('/customer/export', [UserController::class, 'exportCSV'])->name('customer.export');

});

Route::get('/{any}', function() {
    return redirect()->route('login');
})->where('any', '.*');

