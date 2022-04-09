<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');

// });

    Route::get('/', [AdminAuthController::class,'login'])->name('login')->middleware('alreadyLoggedIn');
    Route::get('/addadmin',[AdminAuthController::class,'addadmin'])->name('addadmin')->middleware('isLoggedIn');
    Route::post('/saveadmin',[AdminAuthController::class,'saveadmin'])->name('saveadmin');
    Route::post('/login-admin',[AdminAuthController::class,'loginAdmin'])->name('loginAdmin');

    Route::get('/dashboard', [AdminAuthController::class,'dashboard'])->name('dashboard')->middleware('isLoggedIn');

    Route::get('/logout', [AdminAuthController::class,'logout'])->name('logout');

    Route::get('/edit/{id}', [AdminAuthController::class,'edit'])->name('edit');
    Route::post('/store/{id}', [AdminAuthController::class,'store'])->name('store');

    Route::get('/delete/{id}', [AdminAuthController::class,'delete'])->name('delete');

 