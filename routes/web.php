<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KuponController;
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
    if(auth()->user()->role == "Super Admin" || auth()->user()->role == "Admin") {
        return redirect()->route('dashboard');
    }
    return redirect()->route('events.index');
})->middleware('auth')->name('homeTest');

Route::get('/registration', function(){
   return view('frontEnd.registration');
})->name('regist');

Route::post('/registration', [App\Http\Controllers\UserController::class, 'registrationStore'])->name('regist.store');
Route::get('/test-mail', [App\Http\Controllers\UserController::class, 'email'])->name('email.send');
Route::get('/verification/{id}', [App\Http\Controllers\UserController::class, 'verification'])->name('regist.verification');
Route::get('/verification-success', [App\Http\Controllers\UserController::class, 'verificationSuccess'])->name('regist.verification.success');


// Forget Password Routes
Route::get('/forget-password', [App\Http\Controllers\UserController::class, 'emailForm'])->name('forget.emailForm');
Route::post('/send-reset-password', [App\Http\Controllers\UserController::class, 'sendResetPasswordMail'])->name('forget.send');
Route::get('/forget-password/{email}', [App\Http\Controllers\UserController::class, 'resetForm'])->name('forget.resetForm');
Route::post('/forget-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('forget.reset');

// Resend Email Verification Routes
Route::get('/resend-form', [App\Http\Controllers\UserController::class, 'resendForm'])->name('resend.form');
Route::post('/resend-form', [App\Http\Controllers\UserController::class, 'resendEmailVerification'])->name('resend.emailVerification');



Route::middleware('auth')->group(function() {
    // ==== events route ====
    Route::resource('events', EventController::class);

    Route::middleware('role:Super Admin,Admin')->group(function() {
        // Backend routes
        Route::get('/dashboard', function () {
            $users = \App\Models\User::where('role', 'Member')->count();
            $events = \App\Models\Event::count();
            $tickets = \App\Models\Ticket::count();
            $earnings = \App\Models\Payment::where('status', 'payment_successful')->sum('grand_total');
            return view('backEnd.dashboard.index', compact('users', 'events', 'tickets', 'earnings'));
        })->middleware('auth')->name('dashboard');

        Route::get('/admin', function () {
            return view('backEnd.admin.index');
        })->middleware('auth')->name('adminTest');

        Route::get('/event-list', [App\Http\Controllers\EventController::class, 'indexAdmin'])->name('event.index.admin');
        Route::get('/event-list/{event}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');
        Route::get('/event-batch/{batch}/payment', [App\Http\Controllers\EventController::class, 'payment'])->name('events.payment');
        Route::get('/event-batch/{batch}/ticket', [App\Http\Controllers\EventController::class, 'ticket'])->name('events.ticket');

        // ==== batch route ====
        Route::get('/event-batch', [App\Http\Controllers\EventController::class, 'indexBatch'])->name('batch.index');
        Route::get('/event-batch/create', [App\Http\Controllers\EventController::class, 'createBatch'])->name('batch.create');
        Route::get('/event-batch/{batch}/edit', [App\Http\Controllers\EventController::class, 'editBatch'])->name('batch.edit');
        Route::post('/event-batch', [App\Http\Controllers\EventController::class, 'storeBatch'])->name('batch.store');
        Route::put('/event-batch/{batch}', [App\Http\Controllers\EventController::class, 'updateBatch'])->name('batch.update');

        Route::resource('users', UserController::class);
        
        Route::get('/payment/{code}/approve', [App\Http\Controllers\PaymentController::class, 'approve'])->name('payments.approve');
        Route::get('/payment/{code}/reject', [App\Http\Controllers\PaymentController::class, 'reject'])->name('payments.reject');

        Route::resource('coupons', KuponController::class);
    });

    // Tickets Route
    Route::get('/ticket/{code}/cancel', [App\Http\Controllers\EventController::class, 'cancel'])->name('ticket.cancel');
    Route::resource('ticket', TicketController::class);
    
    // ==== events buy route ====
    Route::get('/event-form/{batch}', [App\Http\Controllers\EventController::class, 'eventForm'])->name('events.form');
    Route::post('/event/{batch}/purchase', [App\Http\Controllers\EventController::class, 'purchase'])->name('events.purchase');
    Route::post('/coupons-check/{batch}', [App\Http\Controllers\EventController::class, 'cekKupon'])->name('events.cekKupon');
    Route::get('/coupons-remove', [App\Http\Controllers\EventController::class, 'removeKupon'])->name('remove.coupons');
    
    // Payment Route
    Route::post('/payment/{code}/upload', [App\Http\Controllers\PaymentController::class, 'upload'])->name('payments.upload');
    Route::get('/payment/{code}/invoice', [App\Http\Controllers\PaymentController::class, 'invoice'])->name('payments.invoice');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
