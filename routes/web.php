<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('frontEnd.index');
})->middleware('auth')->name('homeTest');

Route::get('/dashboard', function () {
    return view('backEnd.dashboard.index');
})->middleware('auth')->name('dashboard');

Route::get('/admin', function () {
    return view('backEnd.admin.index');
})->middleware('auth')->name('adminTest');

Route::get('/registration', function(){
   return view('frontEnd.registration');
})->name('regist');
Route::post('/registration', [App\Http\Controllers\UserController::class, 'registrationStore'])->name('regist.store');
Route::get('/test-mail', [App\Http\Controllers\UserController::class, 'email'])->name('email.send');
Route::get('/verification/{id}', [App\Http\Controllers\UserController::class, 'verification'])->name('regist.verification');
Route::get('/verification-success', [App\Http\Controllers\UserController::class, 'verificationSuccess'])->name('regist.verification.success');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
