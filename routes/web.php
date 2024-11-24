<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerHomeController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home',[CustomerHomeController::class,'HomePage'])->name('home');
