<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::match(['get','post'],'/login',[AuthController::class,'login'])->name('login');
Route::match(['get','post'],'/register',[AuthController::class,'register'])->name('register');
Route::match(['get'],'/logout',[AuthController::class,'logout'])->name('logout');


Route::middleware('auth')->group(function(){
    Route::get('/',[HomeController::class,'dashboard'])->name('dashboard');
    Route::get('tasks',[TaskController::class,'taskList'])->name('tasks');
    Route::match(['get','post'],'/add-task',[TaskController::class,'add_task'])->name('add_task');
    Route::match(['get','post'],'/edit-task/{id}',[TaskController::class,'edit_task'])->name('edit_task');
    Route::match(['post'],'/delete-task',[TaskController::class,'delete_task'])->name('delete_task');
});