<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::match(['get','post'],'/login',[AuthController::class,'login'])->name('login');
Route::match(['get','post'],'/register',[AuthController::class,'register'])->name('register');

Route::get('/', function () {
    return view('welcome');
});
