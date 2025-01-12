<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:web'])->prefix('customer')->group(function () {
    Route::get('/home', function () {
        return view('customer.home');
    })->name('customer.home');

    Route::get('/my_page', [MyPageController::class, 'myPage'])->name('customer.my_page');
    Route::get('/my_page/{id}/edit_page', [MyPageController::class, 'editMyPage'])->name('customer.edit_page');
    Route::put('/my_page/{id}', [MyPageController::class, 'updateMyPage'])->name('customer.update_page');

});
