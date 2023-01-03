<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::get('/registration', function(){
   return view('frontEnd.registration');
})->name('regist');

Route::post('/registration', [App\Http\Controllers\UserController::class, 'registrationStore'])->name('regist.store');
Route::get('/test-mail', [App\Http\Controllers\UserController::class, 'email'])->name('email.send');
Route::get('/verification/{id}', [App\Http\Controllers\UserController::class, 'verification'])->name('regist.verification');
Route::get('/verification-success', [App\Http\Controllers\UserController::class, 'verificationSuccess'])->name('regist.verification.success');

// Backend routes
Route::get('/dashboard', function () {
    return view('backEnd.dashboard.index');
})->middleware('auth')->name('dashboard');

Route::get('/admin', function () {
    return view('backEnd.admin.index');
})->middleware('auth')->name('adminTest');

// ==== events route ====
Route::resource('events', EventController::class);
Route::get('/event-list', [App\Http\Controllers\EventController::class, 'indexAdmin'])->name('event.index.admin');

// ==== events buy route ====
Route::get('/event-form/{batch}', [App\Http\Controllers\EventController::class, 'eventForm'])->name('events.form');

// ==== batch route ====
Route::get('/event-batch', [App\Http\Controllers\EventController::class, 'indexBatch'])->name('batch.index');
Route::get('/event-batch/create', [App\Http\Controllers\EventController::class, 'createBatch'])->name('batch.create');
Route::get('/event-batch/{batch}/edit', [App\Http\Controllers\EventController::class, 'editBatch'])->name('batch.edit');
Route::post('/event-batch', [App\Http\Controllers\EventController::class, 'storeBatch'])->name('batch.store');
Route::put('/event-batch/{batch}', [App\Http\Controllers\EventController::class, 'updateBatch'])->name('batch.update');


Route::resource('users', UserController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
